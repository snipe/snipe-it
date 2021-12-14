<?php

namespace App\Http\Transformers;

use App\Models\PredefinedKit;
use App\Models\SnipeModel;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * transforms collection of models to array with simple typres
 *
 * @author [D. Minaev] [<dmitriy.minaev.v@gmail.com>]
 * @return array
 */
class PredefinedKitsTransformer
{
    public function transformPredefinedKits(Collection $kits, $total)
    {
        $array = [];
        foreach ($kits as $kit) {
            $array[] = self::transformPredefinedKit($kit);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformPredefinedKit(PredefinedKit $kit)
    {
        $array = [
            'id' => (int) $kit->id,
            'name' => e($kit->name),
        ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('update', PredefinedKit::class),
            'delete' => Gate::allows('delete', PredefinedKit::class),
            'checkout' => Gate::allows('checkout', PredefinedKit::class),
            // 'clone' => Gate::allows('create', PredefinedKit::class),
            // 'restore' => Gate::allows('create', PredefinedKit::class),
        ];
        $array['user_can_checkout'] = true;
        $array += $permissions_array;

        $numGroups = $kit->groups->count();
        if($numGroups > 0)
        {
            $groups["total"] = $numGroups; 
            
            foreach($kit->groups as $group)
            {
                if(!Auth::user()->isSuperUser()){
                    $user_groups = Auth::user()->groups;
                    if($user_groups->contains('id',$group->id)){
                        $groups["rows"][] = [
                            'id' => (int) $group->id,
                            'name' => e($group->name)
                        ];
                    }
                }else{
                    $groups["rows"][] = [
                        'id' => (int) $group->id,
                        'name' => e($group->name)
                    ];
                }
            }
            $array["groups"] = $groups;
        }
        else {
            $array["groups"] = null;
        }

        return $array;
    }

    /**
     * transform collection of any elemets attached to kit
     * @return array
     */
    public function transformElements(Collection $elements, $total)
    {
        $array = [];
        foreach ($elements as $element) {
            $array[] = self::transformElement($element);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformElement(SnipeModel $element)
    {
        $array = [
            'id' => (int) $element->id,
            'pivot_id' => (int) $element->pivot->id,
            'owner_id' => (int) $element->pivot->kit_id,
            'quantity' => (int) $element->pivot->quantity,
            'name' => e($element->name),
        ];

        $permissions_array['available_actions'] = [
            'update' => Gate::allows('update', PredefinedKit::class),
            'delete' => Gate::allows('delete', PredefinedKit::class),
        ];

        $array += $permissions_array;

        return $array;
    }

    public function transformPredefinedKitsDatatable($kits)
    {
        return (new DatatablesTransformer)->transformDatatables($kits);
    }
}
