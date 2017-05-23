<?php
namespace App\Http\Transformers;

use App\Models\Actionlog;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class ActionlogsTransformer
{

    public function transformActionlogs (Collection $actionlogs, $total)
    {
        $array = array();
        foreach ($actionlogs as $actionlog) {
            $array[] = self::transformActionlog($actionlog);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformActionlog (Actionlog $actionlog)
    {
        $array = [
            'icon'          => $actionlog->present()->icon(),
            'item' => ($actionlog->item) ? [
                'id' => (int) $actionlog->item->id,
                'name' => e($actionlog->item->getDisplayNameAttribute()),
                'type' => e($actionlog->itemType()),
            ] : null,
            'created_at'    => Helper::getFormattedDateObject($actionlog->created_at, 'datetime'),
            'updated_at'    => Helper::getFormattedDateObject($actionlog->updated_at, 'datetime'),
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

            'note'          => e($actionlog->note),


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
