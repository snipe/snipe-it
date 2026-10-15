<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceType;
use Illuminate\Http\Request;

/**
 * Bulk delete for MaintenanceType. Same shape as
 * BulkManufacturersController / BulkDepreciationsController: authorize
 * once at the class level via the policy's delete gate, then walk each
 * requested id and guard per-row on the model's isDeletable() check
 * (which refuses when the type still has referring maintenances).
 * Aggregates per-row skips into a multi_error_messages flash so a
 * partial batch still applies the safe deletes and surfaces the reason
 * on the ones it couldn't touch.
 */
class BulkMaintenanceTypesController extends Controller
{
    public function destroy(Request $request)
    {
        $this->authorize('delete', MaintenanceType::class);

        $errors = [];
        $success_count = 0;

        foreach ($request->ids ?? [] as $id) {
            $type = MaintenanceType::find($id);
            if (is_null($type)) {
                $errors[] = trans('admin/maintenance_types/message.not_found');

                continue;
            }

            if (! $type->isDeletable()) {
                $errors[] = trans('general.bulk_delete_associations.assoc_maintenances_no_count', [
                    'item_name' => $type->name,
                    'item' => trans('admin/maintenance_types/general.maintenance_type'),
                ]);

                continue;
            }

            try {
                $type->delete();
                $success_count++;
            } catch (\Exception $e) {
                report($e);
                $errors[] = trans('general.something_went_wrong');
            }
        }

        if (count($errors) > 0) {
            if ($success_count > 0) {
                return redirect()->route('maintenance-types.index')
                    ->with('success', trans_choice('admin/maintenance_types/message.delete.partial_success', $success_count, ['count' => $success_count]))
                    ->with('multi_error_messages', $errors);
            }

            return redirect()->route('maintenance-types.index')->with('multi_error_messages', $errors);
        }

        return redirect()->route('maintenance-types.index')
            ->with('success', trans_choice('admin/maintenance_types/message.delete.bulk_success', $success_count, ['count' => $success_count]));
    }
}
