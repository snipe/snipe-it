<?php
namespace App\Http\Transformers;

use App\Models\Actionlog;
use App\Models\Setting;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class ActionlogsTransformer
{

    public function transformActionlogs (Collection $actionlogs, $total)
    {
        $array = array();
        $settings = Setting::getSettings();
        foreach ($actionlogs as $actionlog) {
            $array[] = self::transformActionlog($actionlog, $settings);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformActionlog (Actionlog $actionlog, $settings = null)
    {
        $icon = $actionlog->present()->icon();
        if ($actionlog->filename!='') {
            $icon =  e(\App\Helpers\Helper::filetype_icon($actionlog->filename));
        }

        // This is necessary since we can't escape special characters within a JSON object
        if (($actionlog->log_meta) && ($actionlog->log_meta!='')) {
            $meta_array = json_decode($actionlog->log_meta);

            if ($meta_array) {
                foreach ($meta_array as $key => $value) {
                    foreach ($value as $meta_key => $meta_value) {

                        if (is_array($meta_value)) {
                            foreach ($meta_value as $meta_value_key => $meta_value_value) {
                                $clean_meta[$key][$meta_value_key] = e($meta_value_value);
                            }
                        } else {

                            // This object stuff is weird, and is used to make up for the fact that
                            // older data can get strangely formatted if an asset existed,
                            // then a new custom field is added, and the asset is saved again.
                            // It can result in funnily-formatted strings like:
                            //
                            // {"_snipeit_right_sized_fault_tolerant_localareanetwo_1":
                            // {"old":null,"new":{"value":"1579490695972","_snipeit_new_field_2":2,"_snipeit_new_field_3":"Monday, 20 January 2020 2:24:55 PM"}}
                            // so we have to walk down that next level

                            if (is_object($meta_value)) {

                                foreach ($meta_value as $meta_value_key => $meta_value_value) {

                                    if ($meta_value_key == 'value') {
                                        $clean_meta[$key]['old'] = null;
                                        $clean_meta[$key]['new'] = e($meta_value->value);
                                    } else {
                                        $clean_meta[$meta_value_key]['old'] = null;
                                        $clean_meta[$meta_value_key]['new'] = e($meta_value_value);
                                    }
                                }



                            } else {
                                $clean_meta[$key][$meta_key] = e($meta_value);
                            }
                        }

                    }
                }

            }
        }


        $array = [
            'id'          => (int) $actionlog->id,
            'icon'          => $icon,
            'file' => ($actionlog->filename!='') ?
                [
                    'url' => route('show/assetfile', ['assetId' => $actionlog->item->id, 'fileId' => $actionlog->id]),
                    'filename' => $actionlog->filename,
                    'inlineable' => (bool) \App\Helpers\Helper::show_file_inline($actionlog->filename),
                ] : null,

            'item' => ($actionlog->item) ? [
                'id' => (int) $actionlog->item->id,
                'name' => ($actionlog->itemType()=='user') ? $actionlog->filename : e($actionlog->item->getDisplayNameAttribute()),
                'type' => e($actionlog->itemType()),
            ] : null,
            'location' => ($actionlog->location) ? [
                'id' => (int) $actionlog->location->id,
                'name' => e($actionlog->location->name)
            ] : null,
            'created_at'    => Helper::getFormattedDateObject($actionlog->created_at, 'datetime'),
            'updated_at'    => Helper::getFormattedDateObject($actionlog->updated_at, 'datetime'),
            'next_audit_date' => ($actionlog->itemType()=='asset') ? Helper::getFormattedDateObject($actionlog->calcNextAuditDate(null, $actionlog->item), 'date'): null,
            'days_to_next_audit' => $actionlog->daysUntilNextAudit($settings->audit_interval, $actionlog->item),
            'action_type'   => $actionlog->present()->actionType(),
            'admin' => ($actionlog->user) ? [
                'id' => (int) $actionlog->user->id,
                'name' => e($actionlog->user->getFullNameAttribute()),
                'first_name'=> e($actionlog->user->first_name),
                'last_name'=> e($actionlog->user->last_name)
            ] : null,
            'target' => ($actionlog->target) ? [
                'id' => (int) $actionlog->target->id,
                'name' => ($actionlog->targetType()=='user') ? e($actionlog->target->getFullNameAttribute()) : e($actionlog->target->getDisplayNameAttribute()),
                'type' => e($actionlog->targetType()),
            ] : null,

            'note'          => ($actionlog->note) ? e($actionlog->note): null,
            'signature_file'   => ($actionlog->accept_signature) ? route('log.signature.view', ['filename' => $actionlog->accept_signature ]) : null,
            'log_meta'          => ((isset($clean_meta)) && (is_array($clean_meta))) ? $clean_meta: null,


        ];

        return $array;
    }



    public function transformCheckedoutActionlog (Collection $accessories_users, $total)
    {

        $array = array();
        foreach ($accessories_users as $user) {
            $array[] = (new UsersTransformer)->transformUser($user);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }



}
