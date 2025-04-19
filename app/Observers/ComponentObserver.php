<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Component;

class ComponentObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  Component  $component
     * @return void
     */
    public function updated(Component $component)
    {
        $attributes = $component->getAttributes();
        $attributesOriginal = $component->getRawOriginal();
        $restoring_or_deleting = false;

        // This is a gross hack to prevent the double logging when restoring an asset
        if (array_key_exists('deleted_at', $attributes)  && array_key_exists('deleted_at', $attributesOriginal)){
            $restoring_or_deleting = (($attributes['deleted_at'] != $attributesOriginal['deleted_at']));
        }

        if (!$restoring_or_deleting) {
            $changed = [];
            foreach ($component->getRawOriginal() as $key => $value) {
                if ((array_key_exists($key, $component->getAttributes())) && ($component->getRawOriginal()[$key] != $component->getAttributes()[$key])) {
                    $changed[$key]['old'] = $component->getRawOriginal()[$key];
                    $changed[$key]['new'] = $component->getAttributes()[$key];
                }
            }
        }


        if (empty($changed)){
            return;
        }

        $logAction = new Actionlog();
        $logAction->item_type = Component::class;
        $logAction->item_id = $component->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->log_meta = json_encode($changed);
        $logAction->logaction('update');
    }

    /**
     * Listen to the Component created event when
     * a new component is created.
     *
     * @param  Component  $component
     * @return void
     */
    public function created(Component $component)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Component::class;
        $logAction->item_id = $component->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->action_date = date('Y-m-d H:i:s');
        if($component->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->logaction('create');
    }

    /**
     * Listen to the Component deleting event.
     *
     * @param  Component  $component
     * @return void
     */
    public function deleting(Component $component)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Component::class;
        $logAction->item_id = $component->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->logaction('delete');
    }
}
