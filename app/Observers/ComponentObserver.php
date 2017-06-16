<?php

namespace App\Observers;

use App\Models\Component;
use App\Models\Setting;
use App\Models\Actionlog;
use Auth;

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

        $logAction = new Actionlog();
        $logAction->item_type = Component::class;
        $logAction->item_id = $component->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::user()->id;
        $logAction->logaction('update');


    }


    /**
     * Listen to the Component created event, and increment
     * the next_auto_tag_base value in the settings table when i
     * a new component is created.
     *
     * @param  Component  $component
     * @return void
     */
    public function created(Component $component)
    {
        $settings = Setting::first();
        $settings->increment('next_auto_tag_base');
        \Log::debug('Setting new next_auto_tag_base value');

        $logAction = new Actionlog();
        $logAction->item_type = Component::class;
        $logAction->item_id = $component->id;
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::user()->id;
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
        $logAction->created_at =  date("Y-m-d H:i:s");
        $logAction->user_id = Auth::user()->id;
        $logAction->logaction('delete');
    }
}
