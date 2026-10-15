<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\MaintenanceType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class MaintenanceTypesTransformer
{
    public function transformMaintenanceTypes(Collection $types, int $total): array
    {
        $array = [];
        foreach ($types as $type) {
            $array[] = self::transformMaintenanceType($type);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformMaintenanceType(MaintenanceType $type): array
    {
        return [
            'id' => (int) $type->id,
            'name' => e($type->name),
            'tag_color' => $type->tag_color ? e($type->tag_color) : null,
            // withCount('maintenances as maintenances_count') on the
            // index query populates the count column, so the frontend
            // can display it inline and can tell at a glance which
            // types are unsafe to delete. show() paths that don't run
            // withCount fall back to a live count query.
            'maintenances_count' => (int) ($type->maintenances_count ?? $type->maintenances()->count()),
            'created_by' => ($type->adminuser) ? [
                'id' => (int) $type->adminuser->id,
                'name' => e($type->adminuser->display_name),
            ] : null,
            'created_at' => Helper::getFormattedDateObject($type->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($type->updated_at, 'datetime'),
            'deleted_at' => Helper::getFormattedDateObject($type->deleted_at, 'datetime'),
            'available_actions' => [
                'update' => Gate::allows('update', $type),
                'delete' => $type->isDeletable(),
                // Restore is only meaningful for a soft-deleted row.
                // Emitting restore=true on active rows made every row
                // render a restore button (and, in combination with a
                // false delete flag, made the actions column look like
                // a live row could be "restored" back to itself).
                // Match the ManufacturersTransformer / LocationsTransformer
                // pattern: gate on trashed-and-permitted.
                'restore' => $type->trashed() && Gate::allows('delete', $type),
            ],
        ];
    }
}
