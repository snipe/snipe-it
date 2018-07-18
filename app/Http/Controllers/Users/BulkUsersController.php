<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Group;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BulkUsersController extends Controller
{

    /**
     * Returns a view that confirms the user's a bulk delete will be applied to.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.7]
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request)
    {
        $this->authorize('update', User::class);

        if (($request->has('ids')) && (count($request->input('ids')) > 0)) {
            $statuslabel_list = Helper::statusLabelList();
            $users = User::whereIn('id', array_keys(request('ids')))
                ->with('groups', 'assets', 'licenses', 'accessories')->get();
            if ($request->input('bulk_actions') == 'edit') {
                return view('users/bulk-edit', compact('users'))
                    ->with('groups', Group::pluck('name', 'id'));
            }
            return view('users/confirm-bulk-delete', compact('users', 'statuslabel_list'));
        }

        return redirect()->back()->with('error', 'No users selected');
    }


    /**
     * Save bulk-edited users
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        $this->authorize('update', User::class);

        if (($request->has('ids')) && (count($request->input('ids')) > 0)) {

            $user_raw_array = $request->input('ids');
            $update_array = array();
            $manager_conflict = false;
            $users = User::whereIn('id', $user_raw_array)->where('id', '!=', Auth::user()->id)->get();

            if ($request->has('location_id')) {
                $update_array['location_id'] = $request->input('location_id');
            }
            if ($request->has('department_id')) {
                $update_array['department_id'] = $request->input('department_id');
            }
            if ($request->has('company_id')) {
                $update_array['company_id'] = $request->input('company_id');
            }
            if ($request->has('locale')) {
                $update_array['locale'] = $request->input('locale');
            }


            if ($request->has('manager_id')) {

                // Do not allow a manager update if the selected manager is one of the users being
                // edited.
                if (!array_key_exists($request->input('manager_id'), $user_raw_array)) {
                    $update_array['manager_id'] = $request->input('manager_id');
                } else {
                    $manager_conflict = true;
                }

            }
            if ($request->has('activated')) {
                $update_array['activated'] = $request->input('activated');
            }

            // Save the updated info
            if (count($update_array) > 0) {
                User::whereIn('id', $user_raw_array)->where('id', '!=', Auth::user()->id)->update($update_array);
            }

            // Only sync groups if groups were selected
            if ($request->has('groups')) {
                foreach ($users as $user) {
                    $user->groups()->sync($request->input('groups'));
                }
            }

            // The users will be updated with everything but the manager.  This might be unintuitive and may need to be rethought
            if ($manager_conflict) {
                return redirect()->route('users.index')
                    ->with('warning', trans('admin/users/message.bulk_manager_warn'));
            }

            return redirect()->route('users.index')
                ->with('success', trans('admin/users/message.success.update_bulk'));
        }

        return redirect()->back()->with('error', 'No users selected');



    }

    /**
     * Soft-delete bulk users
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $this->authorize('update', User::class);

        if ((!$request->has('ids')) || (count($request->input('ids')) == 0)) {
            return redirect()->back()->with('error', 'No users selected');
        }
        if ((!$request->has('status_id')) || ($request->input('status_id')=='')) {
            return redirect()->route('users.index')->with('error', 'No status selected');
        }

        if (config('app.lock_passwords')) {
            return redirect()->route('users.index')->with('error', 'Bulk delete is not enabled in this installation');
        }
        $user_raw_array = request('ids');

        if (($key = array_search(Auth::id(), $user_raw_array)) !== false) {
            unset($user_raw_array[$key]);
        }

        $users = User::whereIn('id', $user_raw_array)->get();
        $assets = Asset::whereIn('assigned_to', $user_raw_array)->get();
        $accessories = DB::table('accessories_users')->whereIn('assigned_to', $user_raw_array)->get();
        $licenses = DB::table('license_seats')->whereIn('assigned_to', $user_raw_array)->get();


        $this->logItemCheckinAndDelete($assets, Asset::class);
        $this->logItemCheckinAndDelete($accessories, Accessory::class);
        $this->logItemCheckinAndDelete($licenses, LicenseSeat::class);

        Asset::whereIn('id', $assets->pluck('id'))->update([
            'status_id'     => e(request('status_id')),
            'assigned_to'   => null,
            'assigned_type' => null,
        ]);


        LicenseSeat::whereIn('id', $licenses->pluck('id'))->update(['assigned_to' => null]);

        foreach ($users as $user) {
            $user->accessories()->sync([]);
            $user->delete();
        }

        return redirect()->route('users.index')->with('success', 'Your selected users have been deleted and their assets have been updated.');
    }

    /**
     * Generate an action log entry for each of a group of items.
     * @param $items
     * @param $itemType string name of items being passed.
     */
    protected function logItemCheckinAndDelete($items, $itemType) {

        foreach($items as $item) {
            $logAction = new Actionlog();
            $logAction->item_id = $item->id;
            // We can't rely on get_class here because the licenses/accessories fetched above are not eloquent models, but simply arrays.
            $logAction->item_type = $itemType;
            $logAction->target_id = $item->assigned_to;
            $logAction->target_type = User::class;
            $logAction->user_id = Auth::id();
            $logAction->note = 'Bulk checkin items and delete user';
            $logAction->logaction('checkin from');
        }
    }

}
