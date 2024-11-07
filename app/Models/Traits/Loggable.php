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
use Illuminate\Database\Eloquent\Model;

trait Loggable
{
    // an attribute for setting whether or not the item was imported
    public ?bool $imported = false;
    private ?string $log_message = null;
    private ?Model $item = null;
    private array $log_meta = [];
    private ?Model $target = null;
    private ?string $note = null;

    private ?Location $location = null;

    static array $hide_changes = [];

    public static function bootLoggable()
    {
        \Log::error("LOGGABLE IS BOOTING!!!!!!!!!!!");

        //these tiny methods just set up what the log message is going to be
        static::updating(function ($model) {
            $model->logMessage('update');
        });

        static::creating(function ($model) {
            $model->logMessage('create');
        });

        static::deleting(function ($model) {
            $model->logMessage("delete");
        });

        static::restoring(function ($model) {
            $model->logMessage("restore");
        });

        // THIS sets up the transaction, and gets the 'diff' between the original for the model,
        // and the way it's about to get saved to.
        static::saving(function ($model) {
            //possibly consider a "$this->saveWithoutTransaction" thing you can invoke?
            // use "BEGIN" here?! TODO FIXME

            foreach ($model->getRawOriginal() as $key => $value) {
                if ($model->getRawOriginal()[$key] != $model->getAttributes()[$key]) {
                    $changed[$key]['old'] = $model->getRawOriginal()[$key];
                    $changed[$key]['new'] = $model->getAttributes()[$key];
                }
                if (in_array($key, self::$hide_changes)) {
                    $changed[$key]['old'] = '*************';
                    $changed[$key]['new'] = '*************';
                }
            }

            $this->setLogMeta($changed);
        });

        // THIS is the whole enchilada, the MAIN thing that you've got to do to make things work.
        //if we've set everything up correctly, this should pretty much do everything we want, all in one place
        static::saved(function ($model) {
            $model->logWithoutSave();
            // DO COMMIT HERE? TODO FIXME
        });

    }

    // and THIS is the main, primary logging system
    // it *can* be called on its own, but in *general* you should let it trigger from the 'save'
    public function logWithoutSave(ActionType $logaction = null)
    {
        if ($logaction) {
            $this->setLogMessage($logaction);
        }
        $logAction = new Actionlog();
        $logAction->item_type = self::class;
        $logAction->item_id = $this->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        if ($this->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->log_meta = $this->log_meta ? json_encode($this->log_meta) : null;
        if ($this->target) {
            $logAction->target_type = $this->target::class;
            $logAction->target_id = $this->target->id;
        }
        if ($this->note) {
            $logAction->note = $this->note;
        }
        if ($this->location) {
            $logAction->location_id = $this->location->id;
        }
        $logAction->logaction($this->log_message);
    }

    public function setLogMessage(ActionType $message)
    {
        $this->log_message = $message->value;
    }

    public function setLogMeta(array $changed)
    {
        $this->log_meta = $changed;
    }

    public function setTarget(Model $target)
    {
        $this->target = $target;
    }

    public function setNote(string $note)
    {
        $this->note = $note;
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
     * @author  Daniel Meltzer <dmeltzer.devel@gmail.com>
     * @since [v3.4]
     * @return \App\Models\Actionlog
     */
    public function logCheckout($note, $target, $action_date = null, $originalValues = [])
    {

        $log = new Actionlog;

        $fields_array = [];

        $log = $this->determineLogItemType($log);
        if (auth()->user()) {
            $log->created_by = auth()->id();
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

        if (static::class == Asset::class) {
            if ($asset = Asset::find($log->item_id)) {

                // add the custom fields that were changed
                if ($asset->model->fieldset) {
                    $fields_array = [];
                    foreach ($asset->model->fieldset->fields as $field) {
                        if ($field->display_checkout == 1) {
                            $fields_array[$field->db_column] = $asset->{$field->db_column};
                        }
                    }
                }
            }
        }

        $log->note = $note;
        $log->action_date = $action_date;

        if (! $log->action_date) {
            $log->action_date = date('Y-m-d H:i:s');
        }

        $changed = [];
        $array_to_flip = array_keys($fields_array);
        $array_to_flip = array_merge($array_to_flip, ['action_date','name','status_id','location_id','expected_checkin']);
        $originalValues = array_intersect_key($originalValues, array_flip($array_to_flip));


        foreach ($originalValues as $key => $value) {
            if ($key == 'action_date' && $value != $action_date) {
                $changed[$key]['old'] = $value;
                $changed[$key]['new'] = is_string($action_date) ? $action_date : $action_date->format('Y-m-d H:i:s');
            } elseif ($value != $this->getAttributes()[$key]) {
                $changed[$key]['old'] = $value;
                $changed[$key]['new'] = $this->getAttributes()[$key];
            }
        }

        if (!empty($changed)){
            $log->log_meta = json_encode($changed);
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
    public function logCheckin($target, $note, $action_date = null, $originalValues = [])
    {
        $log = new Actionlog;

        $fields_array = [];

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

                    // add the custom fields that were changed
                    if ($asset->model->fieldset) {
                        $fields_array = [];
                        foreach ($asset->model->fieldset->fields as $field) {
                            if ($field->display_checkin == 1) {
                                $fields_array[$field->db_column] = $asset->{$field->db_column};
                            }
                        }
                    }
                }
            }
        }

        $log->location_id = null;
        $log->note = $note;
        $log->action_date = $action_date;

        if (! $log->action_date) {
            $log->action_date = date('Y-m-d H:i:s');
        }

        if (auth()->user()) {
            $log->created_by = auth()->id();
        }

        $changed = [];

        $array_to_flip = array_keys($fields_array);
        $array_to_flip = array_merge($array_to_flip, ['action_date','name','status_id','location_id','expected_checkin']);

        $originalValues = array_intersect_key($originalValues, array_flip($array_to_flip));

        foreach ($originalValues as $key => $value) {

            if ($key == 'action_date' && $value != $action_date) {
                $changed[$key]['old'] = $value;
                $changed[$key]['new'] = is_string($action_date) ? $action_date : $action_date->format('Y-m-d H:i:s');
            } elseif ($value != $this->getAttributes()[$key]) {
                $changed[$key]['old'] = $value;
                $changed[$key]['new'] = $this->getAttributes()[$key];
            }
        }

        if (!empty($changed)){
            $log->log_meta = json_encode($changed);
        }

        $log->logaction('checkin from');

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
        $log->created_by = auth()->id();
        $log->filename = $filename;
        $log->logaction('audit');

        $params = [
            'item' => $log->item,
            'filename' => $log->filename,
            'admin' => $log->adminuser,
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
    public function logCreate($note = null)
    {
        $created_by = -1;
        if (auth()->user()) {
            $created_by = auth()->id();
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
        $log->created_by = $created_by;
        $log->logaction('create');
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
        $log->created_by = auth()->id();
        $log->note = $note;
        $log->target_id = null;
        $log->created_at = date('Y-m-d H:i:s');
        $log->filename = $filename;
        $log->logaction('uploaded');

        return $log;
    }
}
