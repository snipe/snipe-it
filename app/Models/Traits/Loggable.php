<?php

namespace App\Models\Traits;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\AuditNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait Loggable
{
    // an attribute for setting whether or not the item was imported
    public ?bool $imported = false;
    private ?string $log_action = null;
    private array $log_meta = [];
    private ?Model $log_target = null;
    private ?string $log_note = null;

    private ?Location $log_location_override = null;
    private ?string $log_filename = null;
    private ?string $log_action_date = null;
    private ?int $log_quantity = null;

    //public static array $hide_changes = [];

    // FIXME - if we save() a non-dirty object, will it still fire the right events? If so this gets even simpler.
    public static function bootLoggable()
    {
        //these tiny methods just set up what the log message is going to be
        // it looks like 'restoring' fires *BEFORE* 'updating' - so we need to handle that
        static::restoring(function ($model) {
            $model->setLogAction(ActionType::Restore);
        });

        static::updating(function ($model) {
            // if we're doing a restore, this 'updating' hook fires *after* the restoring hook
            // so we make sure not to overwrite the log_action
            if (!$model->log_action) {
                $model->setLogAction(ActionType::Update);
            }
        });

        static::creating(function ($model) {
            $model->setLogAction(ActionType::Create);
        });

        static::deleting(function ($model) { //TODO - is this only for 'hard' delete? Or soft?
            if (self::class == \App\Models\User::class) { //FIXME - Janky AF!
                $model->setLogTarget($model); //FIXME - this makes *NO* sense!!!!
            }
            $model->setLogAction(ActionType::Delete);
        });

        //static::trashing(function ($model) { //TODO - is *this* the right one?
        //    $model->setLogAction(ActionType::Delete); // No, no it is very much not. there is 'trashed' but not 'trashING'
        //});

        // THIS sets up the transaction, and gets the 'diff' between the original for the model,
        // and the way it's about to get saved to.
        // note that this may run *BEFORE* the more specific events, above? I don't know why that is though.
        // OPEN QUESTION - does this run on soft-delete? I don't know.
        static::saving(function ($model) {
            //possibly consider a "$this->saveWithoutTransaction" thing you can invoke?
            // use "BEGIN" here?! TODO FIXME
            $changed = [];

            // something here with custom fields is needed? or will getRawOriginal et al just do that for us?
            foreach ($model->getRawOriginal() as $key => $value) {
                if ($model->getRawOriginal()[$key] != $model->getAttributes()[$key]) {
                    $changed[$key]['old'] = $model->getRawOriginal()[$key];
                    $changed[$key]['new'] = $model->getAttributes()[$key];

                    if (property_exists(self::class, 'hide_changes') && in_array($key, self::$hide_changes)) {
                        $changed[$key]['old'] = '*************';
                        $changed[$key]['new'] = '*************';
                    }
                }
            }

            $model->setLogMeta($changed);
        });

        // THIS is the whole enchilada, the MAIN thing that you've got to do to make things work.
        //if we've set everything up correctly, this should pretty much do everything we want, all in one place
        static::saved(function ($model) {
            if (!$model->log_action && !$model->log_meta) {
                //nothing was changed, nothing was saved, nothing happened. So there should be no log message.
                //FIXME if we do the transaction thing!!!!
                return;
            }
            if (!$model->log_action) {
                throw new \Exception("Log Message was unset, but log_meta *does* exist - it's: ".print_r($model->log_meta, true));
            }
            $model->logWithoutSave();
            // DO COMMIT HERE? TODO FIXME
        });
        static::deleted(function ($model) {
            $results = $model->logWithoutSave(); //TODO - if we do commits up there, we should do them here too?
        });
        static::restored(function ($model) {
            $model->logWithoutSave(); //TODO - this is getting duplicative.
        });

        // CRAP.
        //static::trashed(function ($model) {
        //    $model->logWithoutSave(ActionType::Delete);
        //});

    }

    // and THIS is the main, primary logging system
    // it *can* be called on its own, but in *general* you should let it trigger from the 'save'
    // I think direct usage of it is probably, generally wrong - you should be using logAndSaveIfNeeded
    // 99% of the time, unless a save got triggered somehow else. And if it was, you should probably
    // rejigger it so it isn't.
    private function logWithoutSave(ActionType $log_action = null): bool
    {
        if ($log_action) {
            $this->setLogAction($log_action);
        }
        $logAction = new Actionlog();
        //$logAction->item_type = self::class; //FIXME - going to fail on Licenses (see other notes)
        //$logAction->item_id = $this->id;
        $logAction = $this->determineLogItemType($logAction); //TODO - inline this if it becomes the only usage?
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        if ($this->imported) {
            $logAction->action_source = 'importer';
        }
        $logAction->log_meta = $this->log_meta ? json_encode($this->log_meta) : null;
        if ($this->log_target) {
            $logAction->target_type = $this->log_target::class;
            $logAction->target_id = $this->log_target->id;
        }
        if ($this->log_note) {
            $logAction->note = $this->log_note;
        }
        if ($this->log_location_override) { // TODO - this is a weird feature and we shouldn't need it.
            $logAction->location_id = $this->log_location_override->id;
        }
        if ($this->log_filename) {
            $logAction->filename = $this->log_filename;
        }

        $logAction->action_type = $this->log_action;
        $logAction->remote_ip = request()->ip();
        $logAction->user_agent = request()->header('User-Agent');
        if ($this->log_action_date) {
            $logAction->action_date = $this->log_action_date;
        } else {
            $logAction->action_date = Carbon::now();
        }

        //determine action source if we don't have one
        if (!$logAction->action_source) {
            if (((request()->header('content-type') && (request()->header('accept')) == 'application/json'))
                && (starts_with(request()->header('authorization'), 'Bearer '))) {
                // This is an API call

                $logAction->action_source = 'api';
            } else if (request()->filled('_token')) {
                // This is probably NOT an API call
                $logAction->action_source = 'gui';
            } else {
                $logAction->action_source = 'cli/unknown';
            }
        }

        if ($logAction->save()) {
            return true;
        } else {
            return false;
        }
    }

    // EXPERIMENTAL - this 'feels' like the main interface we should be using, most of the time
    // if the object is dirty, save it and let the save hooks fire. If it's not, then just
    // enter the log.
    public function logAndSaveIfNeeded(?ActionType $log_action = null): bool
    {
        if ($this->isDirty()) {
            if ($log_action) {
                $this->setLogAction($log_action);
            }
            return $this->save(); //save will do what you need
        } else {
            //transact this? We won't have the 'saving'/'saved' entries - but it generally is just one insert anyway, so it either works or doesn't.
            return $this->logWithoutSave($log_action);
        }
    }

    // PUBLIC SETTER METHODS for private values
    public function setLogAction(ActionType $message)
    {
        $this->log_action = $message->value;
    }

    public function setLogMeta(array $changed)
    {
        $this->log_meta = $changed;
    }

    public function setLogTarget(Model $target)
    {
        $this->log_target = $target;
    }

    public function setLogNote(?string $note)
    {
        $this->log_note = $note;
    }

    public function setLogFilename(?string $filename)
    {
        $this->log_filename = $filename;
    }

    public function setLogActionDate(?string $date)
    {
        $this->log_action_date = $date;
    }

    public function setLogQuantity(?int $quantity)
    {
        $this->log_quantity = $quantity;
    }

    public function setLogLocationOverride(?Location $location)
    {
        $this->log_location_override = $location;
    }

    // PUBLIC GETTERS WHEN NEEDED

    public function getLogTarget()
    {
        return $this->log_target;
    }

    public function getLogQuantity()
    {
        return $this->log_quantity;
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

    public function setImported(bool $bool): void
    {
        $this->imported = $bool;
    }

    /**
     * We _might_ be able to handle this in setTarget? Or maybe embed this into
     * logWithoutSave.
     */

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
     * Get latest signature from a specific user
     *
     * This just makes the print view a bit cleaner
     * Returns the latest acceptance ActionLog that contains a signature
     * from $user or null if there is none
     *
     * @param User $user
     * @return null|Actionlog
     **/
    public function getLatestSignedAcceptance(User $user)
    {
        return $this->log->where('target_type', User::class)
            ->where('target_id', $user->id)
            ->where('action_type', 'accepted')
            ->where('accept_signature', '!=', null)
            ->sortByDesc('created_at')
            ->first();
    }

}
