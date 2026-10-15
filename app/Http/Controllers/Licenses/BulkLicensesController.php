<?php

namespace App\Http\Controllers\Licenses;

use App\Http\Controllers\Controller;
use App\Models\License;
use App\Models\LicenseSeat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BulkLicensesController extends Controller
{
    public function destroy(Request $request)
    {
        $this->authorize('delete', License::class);

        $action = $request->input('bulk_actions', 'delete');
        $errors = [];
        $success_count = 0;
        $checked_in_count = 0;

        foreach ($request->input('ids', []) as $id) {
            $license = License::find($id);

            if (is_null($license)) {
                $errors[] = trans('admin/licenses/message.does_not_exist');

                continue;
            }

            if (! Gate::allows('delete', $license)) {
                $errors[] = trans('general.insufficient_permissions');

                continue;
            }

            if ($action === 'delete_with_checkin') {
                if (! Gate::allows('checkin', $license)) {
                    $errors[] = trans('general.insufficient_permissions');

                    continue;
                }

                $checked_in_count += $this->checkinAssignedSeats($license);
                $this->hardResetAndDelete($license);
                $success_count++;

                continue;
            }

            if ($license->assigned_seats_count > 0) {
                $errors[] = trans('admin/licenses/message.delete.bulk_checkout_warning', ['license_name' => $license->name]);

                continue;
            }

            $this->hardResetAndDelete($license);
            $success_count++;
        }

        if (count($errors) > 0) {
            if ($success_count > 0) {
                return redirect()->route('licenses.index')
                    ->with('success', $this->partialSuccessMessage($action, $success_count, $checked_in_count))
                    ->with('multi_error_messages', $errors);
            }

            return redirect()->route('licenses.index')->with('multi_error_messages', $errors);
        }

        return redirect()->route('licenses.index')
            ->with('success', $this->fullSuccessMessage($action, $success_count, $checked_in_count));
    }

    private function checkinAssignedSeats(License $license): int
    {
        $count = 0;
        $note = trans('admin/licenses/general.bulk.delete_with_checkin.log_msg');

        LicenseSeat::where('license_id', $license->id)
            ->where(function ($query) {
                $query->whereNotNull('assigned_to')->orWhereNotNull('asset_id');
            })
            ->chunkById(100, function ($seats) use ($license, $note, &$count) {
                foreach ($seats as $seat) {
                    $target = $seat->user ?? $seat->asset;
                    $seat->assigned_to = null;
                    $seat->asset_id = null;
                    if (! $license->reassignable) {
                        $seat->unreassignable_seat = true;
                    }
                    if ($seat->save()) {
                        Log::debug('Checking in '.$license->name.' seat '.$seat->id.' via bulk delete_with_checkin');
                        $seat->logCheckin($target, $note);
                        $count++;
                    }
                }
            });

        return $count;
    }

    private function hardResetAndDelete(License $license): void
    {
        // Any residual seat rows are wiped in one statement (assigned_to/asset_id already null
        // for anything we care about). Bypassing Eloquent here is intentional and safe; check-in
        // history for seats is preserved in action_log keyed by LicenseSeat item_type/item_id.
        DB::table('license_seats')
            ->where('license_id', $license->id)
            ->update(['assigned_to' => null, 'asset_id' => null]);

        $license->licenseseats()->delete();
        $license->delete();
    }

    private function fullSuccessMessage(string $action, int $success_count, int $checked_in_count): string
    {
        if ($action === 'delete_with_checkin') {
            return trans('admin/licenses/message.delete_with_checkin.bulk_success', [
                'count' => $success_count,
                'seats' => $checked_in_count,
            ]);
        }

        return trans('admin/licenses/message.delete.bulk_success');
    }

    private function partialSuccessMessage(string $action, int $success_count, int $checked_in_count): string
    {
        if ($action === 'delete_with_checkin') {
            return trans('admin/licenses/message.delete_with_checkin.partial_success', [
                'count' => $success_count,
                'seats' => $checked_in_count,
            ]);
        }

        return trans_choice('admin/licenses/message.delete.partial_success', $success_count, ['count' => $success_count]);
    }
}
