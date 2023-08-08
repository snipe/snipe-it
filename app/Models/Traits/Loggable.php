<?php

namespace App\Models\Traits;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\AdminLog;
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\AuditNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;
use ReflectionMethod;

trait Loggable
{
    public static function bootLoggable() { 
        //loops through the events to be recorded (defined in the model)
        //and then calls the proper method for each model 
        static::eventsToBeRecorded()->each(function ($event) {
            static::$event(function ($model) use ($event) {
                switch (static::class) {
                    case Setting::class:
                        $model->logAdmin(actionType: $event, note: 'settings trait');  
                        break; 
                    case User::class:
                        $model->logAdmin(actionType: $event, note: 'user trait'); 
                        break; 
                    case Asset::class:
                        $model->logCreate(event: $event, note: 'asset trait boot method');
                        break; 
                    case Accessory::class:
                        // accessory seems to not fire eloquent events??? 
                        $model->logCreate(event: $event, note: 'accessory trait boot method'); 
                        break; 
                    case License::class:
                        $model->logCreate(event: $event, note: 'license trait boot method'); 
                        break; 
                        // should be able to listen for the checkin and checkout events here as well 
                        // as long as they're manually declared in the model $recordEvents property 
                        // etc... 
                        default:
                        //do nothing for now
                        break;
                    } 
            });
        }); 
    }
   
    protected static function eventsToBeRecorded(): Collection
    {
        
        //returns the events to be recorded - uses the $recordEvents property defined in each model 
        $events = collect(); 
        if (isset(static::$recordEvents)) {
            $events = collect(static::$recordEvents);
        } 

        if (collect(class_uses_recursive(static::class))->contains(SoftDeletes::class)) {
            $events->push('restored');
        }
       
        return $events;
    }

    
    /**
     * @author  Daniel Meltzer <dmeltzer.devel@gmail.com>
     * @since [v3.4]
     * @return \App\Models\Actionlog
     */
    public function log()
    {
        return $this->morphMany(Actionlog::class, 'item');
    }
   
    public function adminLog()
    {
        return $this->morphMany(Adminlog::class, 'item');
    }

    /**
     * @author  Daniel Meltzer <dmeltzer.devel@gmail.com>
     * @since [v3.4]
     * @return \App\Models\Actionlog
     */
    public function logCheckout($note, $target, $action_date = null)
    {
        $log = new Actionlog;
        $log = $this->determineLogItemType($log);
        if (Auth::user()) {
            $log->user_id = Auth::user()->id;
        }

        if (! isset($target)) {
            throw new \Exception('All checkout logs require a target.');

            return;
        }

        if (! isset($target->id)) {
            throw new \Exception('That target seems invalid (no target ID available).');

            return;
        }

        $log->target_type = get_class($target);
        $log->target_id = $target->id;

        // Figure out what the target is
        if ($log->target_type == Location::class) {
            $log->location_id = $target->id;
        } elseif ($log->target_type == Asset::class) {
            $log->location_id = $target->location_id;
        } else {
            $log->location_id = $target->location_id;
        }

        $log->note = $note;
        $log->action_date = $action_date;

        if (! $log->action_date) {
            $log->action_date = date('Y-m-d H:i:s');
        }

        $log->logaction('checkout');

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
     * @author  Daniel Meltzer <dmeltzer.devel@gmail.com>
     * @since [v3.4]
     * @return \App\Models\Actionlog
     */
    public function logCheckin($target, $note, $action_date = null)
    {
        $settings = Setting::getSettings();
        $log = new Actionlog;

        if($target != null){
            $log->target_type = get_class($target);
            $log->target_id = $target->id;

        }

        if (static::class == LicenseSeat::class) {
            $log->item_type = License::class;
            $log->item_id = $this->license_id;
        } else {
            $log->item_type = static::class;
            $log->item_id = $this->id;

            if (static::class == Asset::class) {
                if ($asset = Asset::find($log->item_id)) {
                    $asset->increment('checkin_counter', 1);
                }
            }
        }


        $log->location_id = null;
        $log->note = $note;
        $log->action_date = $action_date;
        if (! $log->action_date) {
            $log->action_date = date('Y-m-d H:i:s');
        }

        if (! $log->action_date) {
            $log->action_date = date('Y-m-d H:i:s');
        }

        if (Auth::user()) {
            $log->user_id = Auth::user()->id;
        }

        $log->logaction('checkin from');

//        $params = [
//            'target' => $target,
//            'item' => $log->item,
//            'admin' => $log->user,
//            'note' => $note,
//            'target_type' => $log->target_type,
//            'settings' => $settings,
//        ];
//
//
//        $checkinClass = null;
//
//        if (method_exists($target, 'notify')) {
//            try {
//                $target->notify(new static::$checkinClass($params));
//            } catch (\Exception $e) {
//                \Log::debug($e);
//            }
//
//        }
//
//        // Send to the admin, if settings dictate
//        $recipient = new \App\Models\Recipients\AdminRecipient();
//
//        if (($settings->admin_cc_email!='') && (static::$checkinClass!='')) {
//            try {
//                $recipient->notify(new static::$checkinClass($params));
//            } catch (\Exception $e) {
//                \Log::debug($e);
//            }
//
//        }

        return $log;
    }

    /**
     * @author  A. Gianotto <snipe@snipe.net>
     * @since [v4.0]
     * @return \App\Models\Actionlog
     */
    public function logAudit($note, $location_id, $filename = null)
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
        $log->filename = $filename;
        $log->logaction('audit');

        $params = [
            'item' => $log->item,
            'filename' => $log->filename,
            'admin' => $log->admin,
            'location' => ($location) ? $location->name : '',
            'note' => $note,
        ];
        Setting::getSettings()->notify(new AuditNotification($params));

        return $log;
    }

    /**
     * @author  Daniel Meltzer <dmeltzer.devel@gmail.com>
     * @since [v3.5]
     * @return \App\Models\Actionlog
     */
    public function logCreate($note = null, $event = 'poop')
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
        $log->logaction($event);
        $log->save();

        return $log;
    }

    /**
     * @author  Daniel Meltzer <dmeltzer.devel@gmail.com>
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
        $log->target_id = null;
        $log->created_at = date('Y-m-d H:i:s');
        $log->filename = $filename;
        $log->logaction('uploaded');

        return $log;
    }
   
    public function logAdmin($actionType = null, $note = null, $providedValue = null) {
       if($this->isDirty()) { 
            $changed = []; 
            $new = $this->getDirty();
            $old = $this->getRawOriginal();       
            if ($this->isDirty('password')) {
                $changed['new']['password'] = '********';
                $changed['old']['password'] = '********';
            } else {
                foreach ($new as $key => $value) {
                    if (array_key_exists($key, $old) && is_null($providedValue)) {
                        $changed['new'][$key] = $new[$key];
                        $changed['old'][$key] = $old[$key];
                    } else {
                        $changed = $providedValue;
                    } 
                }
            }
           if (is_null($providedValue)) { 
            unset($changed['new']['updated_at'], $changed['old']['updated_at']);
           } 

            $user = Auth::user(); 
            
            $log = new Adminlog();
            $log->user_id = $user->id ?? 1;
            $log->action_type = $actionType ? $actionType : null; 
            $log->item_type = static::class; 
            $log->item_id = $this->id; 
            $log->note = $note ? $note : null; 
            $log->log_meta = json_encode($changed); 
        
            $log->save();
       } else {
            return;
       } 
    }
   
    
}
