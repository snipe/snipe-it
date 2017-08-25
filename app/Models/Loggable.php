<?php

namespace App\Models;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\CheckoutRequest;
use App\Models\User;
use App\Notifications\CheckinNotification;
use App\Notifications\CheckoutNotification;
use Illuminate\Support\Facades\Auth;

trait Loggable
{

    /**
     * @author  Daniel Meltzer <parallelgrapefruit@gmail.com
     * @since [v3.4]
     * @return \App\Models\Actionlog
     */

    public function log()
    {
        return $this->morphMany(Actionlog::class, 'item');
    }

    /**
     * @author  Daniel Meltzer <parallelgrapefruit@gmail.com
     * @since [v3.4]
     * @return \App\Models\Actionlog
     */
    public function logCheckout($note, $target = null /*target is overridable for components*/)
    {
        $log = new Actionlog;

        // We need to special case licenses because of license_seat vs license.  So much for clean polymorphism :)
        if (static::class == LicenseSeat::class) {
            $log->item_type = License::class;
            $log->item_id = $this->license_id;
        } else {
            $log->item_type = static::class;
            $log->item_id = $this->id;
        }

        $log->user_id = Auth::user()->id;

        // @FIXME This needs to be generalized with new asset checkout.
        if(isset($target)) {
            $log->target_type = get_class($target);
            $log->target_id = $target->id;
        } else {
            if (!is_null($this->asset_id)) {
                $log->target_type = Asset::class;
                $log->target_id = $this->asset_id;
            } elseif (!is_null($this->assigned_to)) {
                $log->target_type = User::class;
                $log->target_id = $this->assigned_to;
            }
        }

        $item = call_user_func(array($log->target_type, 'find'), $log->target_id);
        if($this->assignedTo) {
            $item = $this->assignedTo;
        }
        $class = get_class($item);
        if($class == Location::class) {
            // We can checkout to a location
            $log->location_id = $item->id;
        } else if ($class== Asset::class) {
            $log->location_id = $item->rtd_location_id;
        } else {
            $log->location_id = $item->location_id;
        }
        $log->note = $note;
        $log->logaction('checkout');

        $params = [
            'item' => $log->item,
            'target' => $log->target,
            'admin' => $log->user,
            'note' => $note
        ];

        if ($settings = Setting::getSettings()) {
            $settings->notify(new CheckoutNotification($params));
        }
        
        return $log;
    }

    /**
     * @author  Daniel Meltzer <parallelgrapefruit@gmail.com
     * @since [v3.4]
     * @return \App\Models\Actionlog
     */
    public function logCheckin($target, $note)
    {
        $log = new Actionlog;
        $log->target_type = get_class($target);
        $log->target_id = $target->id;
        if (static::class == LicenseSeat::class) {
            $log->item_type = License::class;
            $log->item_id = $this->license_id;
        } else {
            $log->item_type = static::class;
            $log->item_id = $this->id;
        }
        $log->location_id = null;
        $log->note = $note;
        $log->user_id = Auth::user()->id;
        $log->logaction('checkin from');

        $params = [
            'item' => $log->item,
            'admin' => $log->user,
            'note' => $note
        ];
        Setting::getSettings()->notify(new CheckinNotification($params));

        return $log;
    }

    /**
     * @author  Daniel Meltzer <parallelgrapefruit@gmail.com
     * @since [v3.5]
     * @return \App\Models\Actionlog
     */
    public function logCreate($note = null)
    {
        $user_id = -1;
        if (Auth::user()) {
            $user_id = Auth::user()->id;
        }
        $log = new Actionlog;
        if (static::class == LicenseSeat::class) {
            $log->item_type = License::class;
            $log->item_id = $this->license_id;
        } else {
            $log->item_type = static::class;
            $log->item_id = $this->id;
        }
        $log->location_id = null;
        $log->note = $note;
        $log->user_id = $user_id;
        $log->logaction('created');
        $log->save();
        return $log;
    }

    /**
     * @author  Daniel Meltzer <parallelgrapefruit@gmail.com
     * @since [v3.4]
     * @return \App\Models\Actionlog
     */
    public function logUpload($filename, $note)
    {
        $log = new Actionlog;
        if (static::class == LicenseSeat::class) {
            $log->item_type = License::class;
            $log->item_id = $this->license_id;
        } else {
            $log->item_type = static::class;
            $log->item_id = $this->id;
        }
        $log->user_id = Auth::user()->id;
        $log->note = $note;
        $log->target_id =  null;
        $log->created_at =  date("Y-m-d H:i:s");
        $log->filename =  $filename;
        $log->logaction('uploaded');

        return $log;
    }
}
