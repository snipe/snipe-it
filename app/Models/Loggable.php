<?php

namespace App\Models;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\CheckoutRequest;
use App\Models\User;
use App\Notifications\CheckinNotification;
use App\Notifications\AuditNotification;
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
    public function logCheckout($note, $target /* What are we checking out to? */)
    {
        $log = new Actionlog;
        $log = $this->determineLogItemType($log);
        $log->user_id = Auth::user()->id;

        if (!isset($target)) {
            throw new Exception('All checkout logs require a target');
            return;
        }
        $log->target_type = get_class($target);
        $log->target_id = $target->id;

        $target_class = get_class($target);

        // Figure out what the target is
        if ($target_class == Location::class) {
            // We can checkout to a location
            $log->location_id = $target->id;
        } elseif ($target_class== Asset::class) {
            $log->location_id = $target->rtd_location_id;
        } else {
            $log->location_id = $target->location_id;
        }

        $log->note = $note;
        $log->logaction('checkout');

        $params = [
            'item' => $log->item,
            'target' => $target,
            'admin' => $log->user,
            'note' => $note,
            'log_id' => $log->id
        ];

        if ($settings = Setting::getSettings()) {
            $settings->notify(new CheckoutNotification($params));
        }

        if (method_exists($target, 'notify')) {
            $target->notify(new CheckoutNotification($params));
        }

        return $log;
    }

    /**
    * Helper method to determine the log item type
    */
    private function determineLogItemType($log)
    {
        // We need to special case licenses because of license_seat vs license.  So much for clean polymorphism :
        if (static::class == LicenseSeat::class) {
            $log->item_type = License::class;
            $log->item_id = $this->license_id;
        } else {
            $log->item_type = static::class;
            $log->item_id = $this->id;
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
     * @author  A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return \App\Models\Actionlog
     */
    public function logAudit($note, $location_id)
    {
        $log = new Actionlog;
        $location = Location::find($location_id);
        if (static::class == LicenseSeat::class) {
            $log->item_type = License::class;
            $log->item_id = $this->license_id;
        } else {
            $log->item_type = static::class;
            $log->item_id = $this->id;
        }
        $log->location_id = ($location_id) ? $location_id : null;
        $log->note = $note;
        $log->user_id = Auth::user()->id;
        $log->logaction('audit');

        $params = [
            'item' => $log->item,
            'admin' => $log->user,
            'location' => ($location) ? $location->name : '',
            'note' => $note
        ];
        Setting::getSettings()->notify(new AuditNotification($params));

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
