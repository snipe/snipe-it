<?php

namespace App\Models\Traits;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Setting;
use App\Notifications\AuditNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Osama\LaravelTeamsNotification\TeamsNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use stdClass;

trait Loggable
{
    // an attribute for setting whether or not the item was imported
    public ?bool $imported = false;

    // These are private variables that handle the actual creation of the log
    private ?string $log_action = null;
    private ?Model $log_item = null; //TODO - is this unused? log_item might always be 'this'?
    private array $log_meta = [];
    private Model|stdClass|null $log_target = null; //FIXME I HATE THIS THIS SUCKS SO BAD!!!!!
    private ?string $log_note = null;
    private ?Carbon $log_date = null;
    private ?int $log_quantity = null;
    private ?string $log_filename = null;

    private ?Location $location_override = null; //FIXME - possibly delete if truly unused

    //public static array $hide_changes = [];

    public static function bootLoggable()
    {
        //these tiny methods just set up what the log message is going to be
        // it looks like 'restoring' fires *BEFORE* 'updating' - so we need to handle that
        static::restoring(function ($model) {
            \Log::error("Restor*ing* callback firing...");
            $model->setLogAction(ActionType::Restore);
        });

        static::updating(function ($model) {
            //\Log::error("Updating is fired, current log message is: ".$model->log_action);
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
            \Log::error("DELETING TRIGGER HAS FIRED!!!!!!!!!!!!!!! for id: ".$model->id." old log_action was: ".$model->log_action);
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
                \Log::error("LOG MESSAGE IS BLANK, ****AND**** log_meta is blank! Not sure what that means though...");
                return;
            }
            if (!$model->log_action) {
                throw new \Exception("Log Message was unset, but log_meta *does* exist - it's: ".print_r($model->log_meta, true));
            }
            $model->logWithoutSave();
            // DO COMMIT HERE? TODO FIXME
        });
        static::deleted(function ($model) {
            \Log::error("Deleted callback has fired!!!!!!!!!!! I guess that means do stuff here? For id: ".$model->id);
            $results = $model->logWithoutSave(); //TODO - if we do commits up there, we should do them here too?
            \Log::error("result of logging without save? ".($results ? 'true' : 'false'));
        });
        static::restored(function ($model) {
            \Log::error("RestorED callback firing.");
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
    private function logWithoutSave(?ActionType $log_action = null): bool //FIXME - this is named dumb. It should be "createLog()" I think?
    {
        if ($log_action) {
            $this->setLogAction($log_action);
        }
        $logAction = new Actionlog();
        //$logAction->item_type = self::class;
        //$logAction->item_id = $this->id;

        // LicenseSeat->License transformation - blech
        if (static::class == LicenseSeat::class) {
            $logAction->item_type = License::class;
            $logAction->item_id = $this->license_id;
        } else {
            $logAction->item_type = static::class;
            $logAction->item_id = $this->id;
        }
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->log_meta = $this->log_meta ? json_encode($this->log_meta) : null;
        if ($this->log_target) {
            $logAction->target_type = $this->log_target::class;
            $logAction->target_id = $this->log_target->id;

            //logic to set the location_id of the ActionLog based on the Target
            if ($logAction->target_type == Location::class) {
                $logAction->location_id = $this->log_target->id;
            } elseif ($logAction->target_type == Asset::class) { //TODO - these branches might be able to be folded together?
                $logAction->location_id = $this->log_target->location_id;
            } else {
                $logAction->location_id = $this->log_target->location_id;
            }
        }


        if ($this->log_note) {
            \Log::error("Got a note, so we're using it for the logaction - ".$this->log_note);
            $logAction->note = $this->log_note;
        } else {
            \Log::error("NO LOG NOTE!");
        }
        //if ($this->location_override) {
        //    $logAction->location_id = $this->location->id;
        //}


        if ($this->log_date) { //FIXME - there's _something_ wrong with this; I'm just not sure _what_ - see the various Asset checkin tests that are failing
            \Log::error("Setting EXPLICIT log_date of: ".$this->log_date);
            $logAction->action_date = $this->log_date;
        } else {
            \Log::error("using Carbon::now for action_date");
            $logAction->action_date = Carbon::now(); //date('Y-m-d H:i:s'); //TODO - this is right?
        }

        if ($this->log_filename) {
            $logAction->filename = $this->log_filename;
        }

        //\Log::error("Here is the logaction BEFORE we save it ($this->log_action)...".print_r($logAction->toArray(), true));
        //return $logAction->logaction();
        $logAction->action_type = $this->log_action;
        $logAction->remote_ip = request()->ip();
        $logAction->user_agent = request()->header('User-Agent');
        //$logAction->action_source = $this->determineActionSource();
        if ($this->imported) {
            $logAction->action_source = 'importer';
            //}
            //if ($this->source) { //FIXME I think I got this wrong.
            //    // This is a manually set source
            //    $logAction->source = $this->source;
        } else {
            if (((request()->header('content-type') && (request()->header('accept')) == 'application/json'))
                && (starts_with(request()->header('authorization'), 'Bearer '))) {
                // This is an API call
                $logAction->action_source = 'api';
            } else {
                if (request()->filled('_token')) {
                    $logAction->action_source = 'gui';
                } else {
                    // We're not sure, probably cli
                    $logAction->action_source = 'cli/unknown';
                }
            }
        }

        \Log::error("About to really 'logaction' - date is: ".$this->action_date);
        if ($logAction->save()) {
            \Log::error("SAVE SUCCESSFUL!!!!! Action date *really* is: ".$this->fresh()->action_date);
            return true;
        } else {
            return false;
        }
    }

    // This is the main interface we should be using, most of the time
    // if the object is dirty, save it and let the save hooks fire. If it's not, then just
    // add the log.
    public function logAndSaveIfNeeded(?ActionType $log_action = null)
    {
        if ($this->isDirty()) {
            //\Log::error("Doing REAL save because this is dirty");
            if ($log_action) {
                $this->setLogAction($log_action);
            }
            return $this->save(); //save will do what you need
        } else {
            //transact this? We won't have the 'saving'/'saved' entries - but it generally is just one insert anyway, so it either works or doesn't.
            //\Log::error("just doing log without save because this is not dirty");
            return $this->logWithoutSave($log_action);
        }
    }

    // setter functions for private variables
    public function setLogAction(ActionType $message)
    {
        $this->log_action = $message->value;
    }

    public function setLogMeta(array $changed)
    {
        $this->log_meta = $changed;
    }

    public function setLogTarget(Model|stdClass|null $target) //FIXME I HATE THIS!!!!!
    {
        //might want to do our weird logic about LicenseSeats->Licenses _here_ ? Then we don't have to worry about it anymore?
        // or maybe somewhere else, since we'll lose 'resolution' - the license seat will 'go away'
        $this->log_target = $target;
    }

    public function setLogNote(?string $note)
    {
        $this->log_note = $note;
    }

    public function setLogDate(?Carbon $date)
    {
        $this->log_date = $date;
    }

    public function setLogQuantity(?int $quantity)
    {
        $this->log_quantity = $quantity;
    }

    public function setLogFilename(?string $filename)
    {
        $this->log_filename = $filename;
    }

    // getter functions for private variables
    public function getLogTarget(): mixed //?Model FIXME!!!!!!!
    {
        return $this->log_target;
    }

    public function getLogDate(): ?Carbon
    {
        \Log::error("Getting log date. From \$this it's: ".$this->log_date." but from Carbon::now it's: ".Carbon::now());
        if (!$this->log_date) {
            $this->log_date = Carbon::now();
        }
        return $this->log_date;
    }

    public function getLogNote(): ?string
    {
        return $this->log_note;
    }

    public function getLogQuantity(): ?int
    {
        return $this->log_quantity;
    }

    // relationships
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

    // This is weird, as most of the checkinAndSave logic isn't here, it's in the various classes
    // which all have their own weird behavior
    // but audits are all the same, regardless, and there's nothing asset-specific in here, so
    // might as well make it available to everyone?

    public function AuditAndSave(): bool
    {
        if ($this->logAndSaveIfNeeded(ActionType::Audit)) {
            $params = [
                'item'     => $this,
                'filename' => $this->log_filename,
                'admin'    => Auth::user(), //I mean, I _guess_?
                'location' => ($this->wasChanged('location_id')) ? $this->location?->name : '', //?? this is the overridden location, right? And it's blank otherwise?
                'note'     => $this->getLogNote(),
            ];
            if (Setting::getSettings()->webhook_selected === 'microsoft' && Str::contains(Setting::getSettings()->webhook_endpoint, 'workflows')) {
                $message = AuditNotification::toMicrosoftTeams($params);
                $notification = new TeamsNotification(Setting::getSettings()->webhook_endpoint);
                $notification->success()->sendMessage($message[0], $message[1]);
            } else {
                Setting::getSettings()->notify(new AuditNotification($params));
            }
            return true;
        } else {
            return false;
        }
    }

}
