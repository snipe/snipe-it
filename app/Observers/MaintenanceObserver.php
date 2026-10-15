<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Maintenance;
use App\Models\MaintenanceType;

class MaintenanceObserver
{
    /**
     * Capture the asset's current checkout state before the maintenance record is saved.
     */
    public function creating(Maintenance $maintenance): void
    {
        if ($maintenance->asset_id && $asset = Asset::find($maintenance->asset_id)) {
            $maintenance->checked_out_to_id = $asset->assigned_to;
            $maintenance->checked_out_to_type = $asset->assigned_type;
        }

        $this->syncLegacyMaintenanceType($maintenance);
    }

    /**
     * Listen to the User created event.
     *
     * @return void
     */
    public function updating(Maintenance $maintenance)
    {
        $this->syncLegacyMaintenanceType($maintenance);

        $changed = [];

        foreach ($maintenance->getRawOriginal() as $key => $value) {
            if (array_key_exists($key, $maintenance->getAttributes())
                && $maintenance->getRawOriginal()[$key] != $maintenance->getAttributes()[$key]
            ) {
                $changed[$key] = [
                    'old' => $maintenance->getRawOriginal()[$key],
                    'new' => $maintenance->getAttributes()[$key],
                ];
            }
        }

        if (empty($changed)) {
            return;
        }

        $logAction = new Actionlog;
        $logAction->item_type = Maintenance::class;
        $logAction->item_id = $maintenance->id;
        $logAction->target_type = Asset::class;
        $logAction->target_id = $maintenance->asset_id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->log_meta = json_encode($changed);
        if ($maintenance->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->logaction('update');
    }

    private function syncLegacyMaintenanceType(Maintenance $maintenance): void
    {
        if ($maintenance->maintenance_type_id && ! $maintenance->asset_maintenance_type) {
            $type = MaintenanceType::find($maintenance->maintenance_type_id);
            if ($type) {
                $maintenance->asset_maintenance_type = $type->name;
            }
        }
    }

    /**
     * Listen to the Component created event when
     * a new component is created.
     *
     * @return void
     */
    public function created(Maintenance $maintenance)
    {
        $logAction = new Actionlog;
        $logAction->item_type = Maintenance::class;
        $logAction->item_id = $maintenance->id;
        $logAction->target_type = Asset::class;
        $logAction->target_id = $maintenance->asset_id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->note = $maintenance->notes;
        if ($maintenance->imported) {
            $logAction->setActionSource('importer');
        }
        $logAction->logaction('create');
    }

    /**
     * Listen to the Component deleting event.
     *
     * @return void
     */
    public function deleting(Maintenance $maintenance)
    {
        $logAction = new Actionlog;
        $logAction->item_type = Maintenance::class;
        $logAction->item_id = $maintenance->id;
        $logAction->target_type = Asset::class;
        $logAction->target_id = $maintenance->asset_id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->action_date = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->note = $maintenance->notes;
        $logAction->logaction('delete');
    }
}
