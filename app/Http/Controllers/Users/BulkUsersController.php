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
use Illuminate\Support\Facades\Password;

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

        // Make sure there were users selected
        if (($request->filled('ids')) && (count($request->input('ids')) > 0)) {
            // Get the list of affected users
            $user_raw_array = request('ids');
            $users = User::whereIn('id', $user_raw_array)
                ->with('groups', 'assets', 'licenses', 'accessories')->get();

            if ($request->input('bulk_actions') == 'edit') {
                return view('users/bulk-edit', compact('users'))
                    ->with('groups', Group::pluck('name', 'id'));
            } elseif ($request->input('bulk_actions') == 'delete') {
                return view('users/confirm-bulk-delete')->with('users', $users)->with('statuslabel_list', Helper::statusLabelList());
            } elseif ($request->input('bulk_actions') == 'bulkpasswordreset') {
                foreach ($users as $user) {
                    if (($user->activated == '1') && ($user->email != '')) {
                        $credentials = ['email' => $user->email];
                        Password::sendResetLink($credentials/* , function (Message $message) {
                        $message->subject($this->getEmailSubject()); // TODO - I'm not sure if we still need this, but this second parameter is no longer accepted in later Laravel versions.
                        } */ );                                      // TODO - so hopefully this doesn't give us generic password reset messages? But it at least _works_
                    }
                }
                return redirect()->back()->with('success', trans('admin/users/message.password_resets_sent'));

            }
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

        if ((! $request->filled('ids')) || $request->input('ids') <= 0) {
            return redirect()->back()->with('error', 'No users selected');
        }
        $user_raw_array = $request->input('ids');

        // Remove the user from any updates.
        $user_raw_array = array_diff($user_raw_array, [Auth::id()]);
        $manager_conflict = false;
        $users = User::whereIn('id', $user_raw_array)->where('id', '!=', Auth::user()->id)->get();

        $return_array = [
            'success' => trans('admin/users/message.success.update_bulk'),
        ];

        $this->conditionallyAddItem('location_id')
            ->conditionallyAddItem('department_id')
            ->conditionallyAddItem('company_id')
            ->conditionallyAddItem('locale')
            ->conditionallyAddItem('remote')
            ->conditionallyAddItem('ldap_import')
            ->conditionallyAddItem('activated');


        // If the manager_id is one of the users being updated, generate a warning.
        if (array_search($request->input('manager_id'), $user_raw_array)) {
            $manager_conflict = true;
            $return_array = [
                'warning' => trans('admin/users/message.bulk_manager_warn'),
            ];
        }
        if (! $manager_conflict) {
            $this->conditionallyAddItem('manager_id');
        }
        // Save the updated info
        User::whereIn('id', $user_raw_array)
            ->where('id', '!=', Auth::id())->update($this->update_array);

        if (array_key_exists('location_id', $this->update_array)){
            Asset::where('assigned_type', User::class)
                ->whereIn('assigned_to', $user_raw_array)
                ->update(['location_id' => $this->update_array['location_id']]);
        }

        // Only sync groups if groups were selected
        if ($request->filled('groups')) {
            foreach ($users as $user) {
                $user->groups()->sync($request->input('groups'));
            }
        }

        return redirect()->route('users.index')
            ->with($return_array);
    }

    /**
     * Array to store update data per item
     * @var array
     */
    private $update_array = [];

    /**
     * Adds parameter to update array for an item if it exists in request
     * @param  string $field field name
     * @return BulkUsersController Model for Chaining
     */
    protected function conditionallyAddItem($field)
    {
        if (request()->filled($field)) {
            $this->update_array[$field] = request()->input($field);
        }

        return $this;
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

        if ((! $request->filled('ids')) || (count($request->input('ids')) == 0)) {
            return redirect()->back()->with('error', 'No users selected');
        }
        if ((! $request->filled('status_id')) || ($request->input('status_id') == '')) {
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
        $assets = Asset::whereIn('assigned_to', $user_raw_array)->where('assigned_type', \App\Models\User::class)->get();
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
    protected function logItemCheckinAndDelete($items, $itemType)
    {
        foreach ($items as $item) {
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
