<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Consumable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConsumableObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  Consumable  $consumable
     * @return void
     */
    public function updated(Consumable $consumable)
    {

        $attributes = $consumable->getAttributes();
        $attributesOriginal = $consumable->getRawOriginal();
        $restoring_or_deleting = false;

        // This is a gross hack to prevent the double logging when restoring an asset
        if (array_key_exists('deleted_at', $attributes)  && array_key_exists('deleted_at', $attributesOriginal)){
            $restoring_or_deleting = (($attributes['deleted_at'] != $attributesOriginal['deleted_at']));
        }

        if (!$restoring_or_deleting) {
            $changed = [];
            foreach ($consumable->getRawOriginal() as $key => $value) {
                if ((array_key_exists($key, $consumable->getAttributes())) && ($consumable->getRawOriginal()[$key] != $consumable->getAttributes()[$key])) {
                    $changed[$key]['old'] = $consumable->getRawOriginal()[$key];
                    $changed[$key]['new'] = $consumable->getAttributes()[$key];
                }
            }
        }


        if (empty($changed)){
            return;
        }

        $logAction = new Actionlog();
        $logAction->item_type = Consumable::class;
        $logAction->item_id = $consumable->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->log_meta = json_encode($changed);
        $logAction->logaction('update');
    }

    /**
     * Listen to the Consumable created event when
     * a new consumable is created.
     *
     * @param  Consumable  $consumable
     * @return void
     */
    public function created(Consumable $consumable)
    {
        $logAction = new Actionlog();
        $logAction->item_type = Consumable::class;
        $logAction->item_id = $consumable->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        if($consumable->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->logaction('create');
    }

    /**
     * Listen to the Consumable deleting event.
     *
     * @param  Consumable  $consumable
     * @return void
     */
    public function deleting(Consumable $consumable)
    {

        $consumable->users()->detach();
        $uploads = $consumable->uploads;

        foreach ($uploads as $file) {
            try {
                Storage::delete('private_uploads/consumables/'.$file->filename);
                $file->delete();
            } catch (\Exception $e) {
                Log::info($e);
            }
        }



        try {
            Storage::disk('public')->delete('consumables/'.$consumable->image);
        } catch (\Exception $e) {
            Log::info($e);
        }

        $consumable->image = null;
        $consumable->save();



        $logAction = new Actionlog();
        $logAction->item_type = Consumable::class;
        $logAction->item_id = $consumable->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->logaction('delete');
    }
}
