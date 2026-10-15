<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Helpers\Helper;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Maintenance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Handles bulk actions from the maintenances index table. The single POST
 * endpoint branches on the bulk_actions form field so the same dropdown
 * can grow additional actions later without a new route per verb.
 */
class BulkMaintenancesController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // Top-level gate mirrors MaintenancesController::complete()/destroy(),
        // because maintenance keys on the asset edit permission (see
        // MaintenancePolicy). This blocks users without any assets.edit rights
        // from hitting the endpoint at all; per-row policy still runs below.
        // FMCS company scoping is applied automatically on the Maintenance
        // lookups further down via the model's CompanyableChildTrait global
        // scope, so a scoped user can't reach maintenance rows for assets
        // outside their company set even if they submit those ids directly.
        // We should probably consider making maintenances their own permission though
        $this->authorize('update', Asset::class);

        $action = $request->input('bulk_actions');
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $request->input('ids', [])))));

        // Prefer the Referer header (rather than a hidden form field,
        // which clients can forge freely) so the user lands back on the
        // surface they submitted from, whether that was the standalone
        // index with its ?completed=true filter or the asset-detail
        // maintenance tab. Helper::sameOriginUrl() rejects off-host and
        // non-http(s) schemes; fall back to the plain index on rejection.
        $backUrl = Helper::sameOriginUrl($request->headers->get('referer')) ?? route('maintenances.index');

        if (empty($ids)) {
            return redirect($backUrl)
                ->with('warning', trans('general.bulk_checkin_delete.nothing_selected', ['object_type' => trans('general.maintenances')]));
        }

        return match ($action) {
            'delete' => $this->bulkDelete($ids, $backUrl),
            'complete' => $this->bulkComplete($ids, $backUrl),
            default => redirect($backUrl)->with('error', trans('general.something_went_wrong')),
        };
    }

    /**
     * Soft-delete the selected maintenance records after per-row policy check.
     * Silently skips already-deleted rows and any the actor can't touch.
     */
    private function bulkDelete(array $ids, string $backUrl): RedirectResponse
    {
        $success = 0;
        $skipped = 0;

        Maintenance::whereIn('id', $ids)->with('asset')->get()->each(function (Maintenance $maintenance) use (&$success, &$skipped) {
            if (! auth()->user()->can('delete', $maintenance)) {
                $skipped++;

                return;
            }
            $maintenance->delete();
            $success++;
        });

        return redirect($backUrl)->with(
            $success > 0 ? 'success' : 'warning',
            trans_choice('admin/maintenances/message.bulk_delete', $success, ['count' => $success, 'skipped' => $skipped])
        );
    }

    /**
     * Mark the selected maintenance records complete. Skips rows that are
     * already completed (idempotent) and any the actor can't update.
     */
    private function bulkComplete(array $ids, string $backUrl): RedirectResponse
    {
        $success = 0;
        $skipped = 0;

        Maintenance::whereIn('id', $ids)->whereNull('completed_at')->with('asset')->get()->each(function (Maintenance $maintenance) use (&$success, &$skipped) {
            if (! auth()->user()->can('update', $maintenance)) {
                $skipped++;

                return;
            }

            $maintenance->completed_at = now();
            $maintenance->completed_by = auth()->id();
            $maintenance->asset_maintenance_time = (int) $maintenance->created_at->diffInDays(now(), true);
            $maintenance->saveQuietly();

            $log = new Actionlog;
            $log->item_type = Maintenance::class;
            $log->item_id = $maintenance->id;
            $log->target_type = Asset::class;
            $log->target_id = $maintenance->asset_id;
            $log->created_by = auth()->id();
            $log->logaction(ActionType::MaintenanceComplete);

            $success++;
        });

        return redirect($backUrl)->with(
            $success > 0 ? 'success' : 'warning',
            trans_choice('admin/maintenances/message.bulk_complete', $success, ['count' => $success, 'skipped' => $skipped])
        );
    }
}
