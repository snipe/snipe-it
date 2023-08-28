<?php
namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Actionlog;
use App\Models\Setting;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\Location;
use App\Models\AssetModel;
use Illuminate\Database\Eloquent\Collection;

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

    private function clean_field($value)
    {
        // This object stuff is weird, and is used to make up for the fact that
        // older data can get strangely formatted if an asset existed,
        // then a new custom field is added, and the asset is saved again.
        // It can result in funnily-formatted strings like:
        //
        // {"_snipeit_right_sized_fault_tolerant_localareanetwo_1":
        // {"old":null,"new":{"value":"1579490695972","_snipeit_new_field_2":2,"_snipeit_new_field_3":"Monday, 20 January 2020 2:24:55 PM"}}
        // so we have to walk down that next level
        if(is_object($value) && isset($value->value)) {
            return $this->clean_field($value->value);
        }
        return is_scalar($value) || is_null($value) ? e($value) : e(json_encode($value));
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

            $clean_meta = [];

            if ($meta_array) {
                foreach ($meta_array as $fieldname => $fieldata) {
                    $clean_meta[$fieldname]['old'] = $this->clean_field($fieldata->old);
                    $clean_meta[$fieldname]['new'] = $this->clean_field($fieldata->new);
                }
            }

            $clean_meta= $this->changedInfo($clean_meta);
        }

        $file_url = '';
        if($actionlog->filename!='') {
            if ($actionlog->action_type == 'accepted') {
                $file_url = route('log.storedeula.download', ['filename' => $actionlog->filename]);
            } else {
                if ($actionlog->item) {
                    if ($actionlog->itemType() == 'asset') {
                        $file_url = route('show/assetfile', ['assetId' => $actionlog->item->id, 'fileId' => $actionlog->id]);
                    } elseif ($actionlog->itemType() == 'license') {
                        $file_url = route('show.licensefile', ['licenseId' => $actionlog->item->id, 'fileId' => $actionlog->id]);
                    } elseif ($actionlog->itemType() == 'user') {
                        $file_url = route('show/userfile', ['userId' => $actionlog->item->id, 'fileId' => $actionlog->id]);
                    }
                }
            }
        }

        $array = [
            'id'          => (int) $actionlog->id,
            'icon'          => $icon,
            'file' => ($actionlog->filename!='')
                ?
                [
                    'url' => $file_url,
                    'filename' => $actionlog->filename,
                    'inlineable' => (bool) Helper::show_file_inline($actionlog->filename),
                ] : null,

            'item' => ($actionlog->item) ? [
                'id' => (int) $actionlog->item->id,
                'name' => ($actionlog->itemType()=='user') ? e($actionlog->item->getFullNameAttribute()) : e($actionlog->item->getDisplayNameAttribute()),
                'type' => e($actionlog->itemType()),
                'serial' =>e($actionlog->item->serial) ? e($actionlog->item->serial) : null
            ] : null,
            'location' => ($actionlog->location) ? [
                'id' => (int) $actionlog->location->id,
                'name' => e($actionlog->location->name),
            ] : null,
            'created_at'    => Helper::getFormattedDateObject($actionlog->created_at, 'datetime'),
            'updated_at'    => Helper::getFormattedDateObject($actionlog->updated_at, 'datetime'),
            'next_audit_date' => ($actionlog->itemType()=='asset') ? Helper::getFormattedDateObject($actionlog->calcNextAuditDate(null, $actionlog->item), 'date'): null,
            'days_to_next_audit' => $actionlog->daysUntilNextAudit($settings->audit_interval, $actionlog->item),
            'action_type'   => $actionlog->present()->actionType(),
            'admin' => ($actionlog->admin) ? [
                'id' => (int) $actionlog->admin->id,
                'name' => e($actionlog->admin->getFullNameAttribute()),
                'first_name'=> e($actionlog->admin->first_name),
                'last_name'=> e($actionlog->admin->last_name)
            ] : null,
            'target' => ($actionlog->target) ? [
                'id' => (int) $actionlog->target->id,
                'name' => ($actionlog->targetType()=='user') ? e($actionlog->target->getFullNameAttribute()) : e($actionlog->target->getDisplayNameAttribute()),
                'type' => e($actionlog->targetType()),
            ] : null,

            'note'          => ($actionlog->note) ? Helper::parseEscapedMarkedownInline($actionlog->note): null,
            'signature_file'   => ($actionlog->accept_signature) ? route('log.signature.view', ['filename' => $actionlog->accept_signature ]) : null,
            'log_meta'          => ((isset($clean_meta)) && (is_array($clean_meta))) ? $clean_meta: null,
            'action_date'   => ($actionlog->action_date) ? Helper::getFormattedDateObject($actionlog->action_date, 'datetime'): Helper::getFormattedDateObject($actionlog->created_at, 'datetime'),
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
    /**
     * This takes the ids of the changed attributes and returns the names instead for the history view of an Asset
     *
     * @param  array $clean_meta
     * @return array
     */
    public function changedInfo(array $clean_meta)
    {

        if(array_key_exists('rtd_location_id',$clean_meta)) {
            $clean_meta['rtd_location_id']['old'] = $clean_meta['rtd_location_id']['old'] ? "[id: ".$clean_meta['rtd_location_id']['old']."] ". Location::find($clean_meta['rtd_location_id']['old'])->name : trans('general.unassigned');
            $clean_meta['rtd_location_id']['new'] = $clean_meta['rtd_location_id']['new'] ? "[id: ".$clean_meta['rtd_location_id']['new']."] ". Location::find($clean_meta['rtd_location_id']['new'])->name : trans('general.unassigned');
            $clean_meta['Default Location'] = $clean_meta['rtd_location_id'];
            unset($clean_meta['rtd_location_id']);
        }
        if(array_key_exists('location_id', $clean_meta)) {
            $clean_meta['location_id']['old'] = $clean_meta['location_id']['old'] ? "[id: ".$clean_meta['location_id']['old']."] ".Location::find($clean_meta['location_id']['old'])->name : trans('general.unassigned');
            $clean_meta['location_id']['new'] = $clean_meta['location_id']['new'] ? "[id: ".$clean_meta['location_id']['new']."] ".Location::find($clean_meta['location_id']['new'])->name : trans('general.unassigned');
            $clean_meta['Current Location'] = $clean_meta['location_id'];
            unset($clean_meta['location_id']);
        }
        if(array_key_exists('model_id', $clean_meta)) {
            $clean_meta['model_id']['old'] = "[id: ".$clean_meta['model_id']['old']."] ".AssetModel::withTrashed()->find($clean_meta['model_id']['old'])->name;
            $clean_meta['model_id']['new'] = "[id: ".$clean_meta['model_id']['new']."] ".AssetModel::withTrashed()->find($clean_meta['model_id']['new'])->name; /* model is required at asset creation */
            $clean_meta['Model'] = $clean_meta['model_id'];
            unset($clean_meta['model_id']);
        }
        if(array_key_exists('company_id', $clean_meta)) {
            $clean_meta['company_id']['old'] = $clean_meta['company_id']['old'] ? "[id: ".$clean_meta['company_id']['old']."]".Company::find($clean_meta['company_id']['old'])->name : trans('general.unassigned');
            $clean_meta['company_id']['new'] = $clean_meta['company_id']['new'] ? "[id: ".$clean_meta['company_id']['new']."] ".Company::find($clean_meta['company_id']['new'])->name : trans('general.unassigned');
            $clean_meta['Company'] = $clean_meta['company_id'];
            unset($clean_meta['company_id']);
        }
        if(array_key_exists('supplier_id', $clean_meta)) {
            $clean_meta['supplier_id']['old'] = $clean_meta['supplier_id']['old'] ? "[id: ".$clean_meta['supplier_id']['old']."] ".Supplier::find($clean_meta['supplier_id']['old'])->name : trans('general.unassigned');
            $clean_meta['supplier_id']['new'] = $clean_meta['supplier_id']['new'] ? "[id: ".$clean_meta['supplier_id']['new']."] ".Supplier::find($clean_meta['supplier_id']['new'])->name : trans('general.unassigned');
            $clean_meta['Supplier'] = $clean_meta['supplier_id'];
            unset($clean_meta['supplier_id']);
        }

        return $clean_meta;

    }



}
