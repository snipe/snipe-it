<?php

namespace App\Http\Controllers\Users;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserNotFoundException;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\SaveUserRequest;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Group;
use App\Models\Ldap;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Input;
use Redirect;
use Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use View;
use App\Notifications\CurrentInventory;

/**
 * This controller handles all actions related to Users for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class UsersController extends Controller
{
    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the users listing, which is generated in getDatatable().
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see UsersController::getDatatable() method that generates the JSON response
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', User::class);

        return view('users/index');
    }

    /**
     * Returns a view that displays the user creation form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('create', User::class);
        $groups = Group::pluck('name', 'id');

        $userGroups = collect();

        if ($request->old('groups')) {
            $userGroups = Group::whereIn('id', $request->old('groups'))->pluck('name', 'id');
        }

        $permissions = config('permissions');
        $userPermissions = Helper::selectedPermissionsArray($permissions, $request->old('permissions', []));
        $permissions = $this->filterDisplayable($permissions);

        $user = new User;

        return view('users/edit', compact('groups', 'userGroups', 'permissions', 'userPermissions'))
            ->with('user', $user);
    }

    /**
     * Validate and store the new user data, or return an error.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param SaveUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(SaveUserRequest $request)
    {
        $this->authorize('create', User::class);
        $user = new User;
        //Username, email, and password need to be handled specially because the need to respect config values on an edit.
        $user->email = trim($request->input('email'));
        $user->username = trim($request->input('username'));
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->locale = $request->input('locale');
        $user->employee_num = $request->input('employee_num');
        $user->activated = $request->input('activated', 0);
        $user->jobtitle = $request->input('jobtitle');
        $user->phone = $request->input('phone');
        $user->location_id = $request->input('location_id', null);
        $user->department_id = $request->input('department_id', null);
        $user->company_id = Company::getIdForUser($request->input('company_id', null));
        $user->manager_id = $request->input('manager_id', null);
        $user->notes = $request->input('notes');
        $user->address = $request->input('address', null);
        $user->city = $request->input('city', null);
        $user->state = $request->input('state', null);
        $user->country = $request->input('country', null);
        $user->zip = $request->input('zip', null);
        $user->remote = $request->input('remote', 0);
        $user->website = $request->input('website', null);
        $user->created_by = Auth::user()->id;
        $user->start_date = $request->input('start_date', null);
        $user->end_date = $request->input('end_date', null);
        $user->autoassign_licenses = $request->input('autoassign_licenses', 0);

        // Strip out the superuser permission if the user isn't a superadmin
        $permissions_array = $request->input('permission');

        if (! Auth::user()->isSuperUser()) {
            unset($permissions_array['superuser']);
        }
        $user->permissions = json_encode($permissions_array);

        // we have to invoke the
        app(ImageUploadRequest::class)->handleImages($user, 600, 'avatar', 'avatars', 'avatar');

        if ($user->save()) {
            if ($request->filled('groups')) {
                $user->groups()->sync($request->input('groups'));
            } else {
                $user->groups()->sync([]);
            }

            if (($request->input('email_user') == 1) && ($request->filled('email'))) {
                // Send the credentials through email
                $data = [];
                $data['email'] = e($request->input('email'));
                $data['username'] = e($request->input('username'));
                $data['first_name'] = e($request->input('first_name'));
                $data['last_name'] = e($request->input('last_name'));
                $data['password'] = e($request->input('password'));

                $user->notify(new WelcomeNotification($data));
            }

            return redirect::route('users.index')->with('success', trans('admin/users/message.success.create'));
        }

        return redirect()->back()->withInput()->withErrors($user->getErrors());
    }

    private function filterDisplayable($permissions)
    {
        $output = null;
        foreach ($permissions as $key => $permission) {
            $output[$key] = array_filter($permission, function ($p) {
                return $p['display'] === true;
            });
        }

        return $output;
    }

    /**
     * Returns a view that displays the edit user form
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param $permissions
     * @return View
     * @internal param int $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        if ($user = User::find($id)) {
            $this->authorize('update', $user);
            $permissions = config('permissions');
            $groups = Group::pluck('name', 'id');

            $userGroups = $user->groups()->pluck('name', 'id');
            $user->permissions = $user->decodePermissions();
            $userPermissions = Helper::selectedPermissionsArray($permissions, $user->permissions);
            $permissions = $this->filterDisplayable($permissions);

            return view('users/edit', compact('user', 'groups', 'userGroups', 'permissions', 'userPermissions'))->with('item', $user);
        }

        return redirect()->route('users.index')->with('error', trans('admin/users/message.user_not_found', compact('id')));
    }

    /**
     * Validate and save edited user data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param SaveUserRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(SaveUserRequest $request, $id = null)
    {
        // We need to reverse the UI specific logic for our
        // permissions here before we update the user.
        $permissions = $request->input('permissions', []);
        app('request')->request->set('permissions', $permissions);

        // This is a janky hack to prevent people from changing admin demo user data on the public demo.
        // The $ids 1 and 2 are special since they are seeded as superadmins in the demo seeder.
        // Thanks, jerks. You are why we can't have nice things. - snipe

        if ((($id == 1) || ($id == 2)) && (config('app.lock_passwords'))) {
            return redirect()->route('users.index')->with('error', 'Permission denied. You cannot update user information for superadmins on the demo.');
        }

        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')
                ->with('error', trans('admin/users/message.user_not_found', compact('id')));
        }

        $this->authorize('update', $user);
        // Figure out of this user was an admin before this edit
        $orig_permissions_array = $user->decodePermissions();
        $orig_superuser = '0';
        if (is_array($orig_permissions_array)) {
            if (array_key_exists('superuser', $orig_permissions_array)) {
                $orig_superuser = $orig_permissions_array['superuser'];
            }
        }

        // Only save groups if the user is a super user
        if (Auth::user()->isSuperUser()) {
            $user->groups()->sync($request->input('groups'));
        }

        // Update the user
        if ($request->filled('username')) {
            $user->username = trim($request->input('username'));
        }
        $user->email = trim($request->input('email'));
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->two_factor_optin = $request->input('two_factor_optin') ?: 0;
        $user->locale = $request->input('locale');
        $user->employee_num = $request->input('employee_num');
        $user->activated = $request->input('activated', 0);
        $user->jobtitle = $request->input('jobtitle', null);
        $user->phone = $request->input('phone');
        $user->location_id = $request->input('location_id', null);
        $user->company_id = Company::getIdForUser($request->input('company_id', null));
        $user->manager_id = $request->input('manager_id', null);
        $user->notes = $request->input('notes');
        $user->department_id = $request->input('department_id', null);
        $user->address = $request->input('address', null);
        $user->city = $request->input('city', null);
        $user->state = $request->input('state', null);
        $user->country = $request->input('country', null);
        // if a user is editing themselves we should always keep activated true
        $user->activated = $request->input('activated', $request->user()->is($user) ? 1 : 0);
        $user->zip = $request->input('zip', null);
        $user->remote = $request->input('remote', 0);
        $user->vip = $request->input('vip', 0);
        $user->website = $request->input('website', null);
        $user->start_date = $request->input('start_date', null);
        $user->end_date = $request->input('end_date', null);
        $user->autoassign_licenses = $request->input('autoassign_licenses', 0);

        // Update the location of any assets checked out to this user
        Asset::where('assigned_type', User::class)
            ->where('assigned_to', $user->id)
            ->update(['location_id' => $request->input('location_id', null)]);

        // Do we want to update the user password?
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $permissions_array = $request->input('permission');

        // Strip out the superuser permission if the user isn't a superadmin
        if (! Auth::user()->isSuperUser()) {
            unset($permissions_array['superuser']);
            $permissions_array['superuser'] = $orig_superuser;
        }

        $user->permissions = json_encode($permissions_array);

        // Handle uploaded avatar
        app(ImageUploadRequest::class)->handleImages($user, 600, 'avatar', 'avatars', 'avatar');

        //\Log::debug(print_r($user, true));

        // Was the user updated?
        if ($user->save()) {
            // Redirect to the user page
            return redirect()->route('users.index')
                ->with('success', trans('admin/users/message.success.update'));
        }

        return redirect()->back()->withInput()->withErrors($user->getErrors());
    }

    /**
     * Delete a user
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id = null)
    {
        try {
            // Get user information
            $user = User::findOrFail($id);
            // Authorize takes care of many of our logic checks now.
            $this->authorize('delete', User::class);

            // Check if we are not trying to delete ourselves
            if ($user->id === Auth::id()) {
                // Redirect to the user management page
                return redirect()->route('users.index')
                    ->with('error', 'We would feel really bad if you deleted yourself, please reconsider.');
            }

            if (($user->assets()) && (($assetsCount = $user->assets()->count()) > 0)) {
                // Redirect to the user management page
                return redirect()->route('users.index')
                    ->with('error', 'This user still has '.$assetsCount.' assets associated with them.');
            }

            if (($user->licenses()) && (($licensesCount = $user->licenses()->count())) > 0) {
                // Redirect to the user management page
                return redirect()->route('users.index')
                    ->with('error', 'This user still has '.$licensesCount.' licenses associated with them.');
            }

            if (($user->accessories()) && (($accessoriesCount = $user->accessories()->count()) > 0)) {
                // Redirect to the user management page
                return redirect()->route('users.index')
                    ->with('error', 'This user still has '.$accessoriesCount.' accessories associated with them.');
            }

            if (($user->managedLocations()) && (($managedLocationsCount = $user->managedLocations()->count())) > 0) {
                // Redirect to the user management page
                return redirect()->route('users.index')
                    ->with('error', 'This user still has '.$managedLocationsCount.' locations that they manage.');
            }

            // Delete the user
            $user->delete();

            // Prepare the success message
            // Redirect to the user management page
            return redirect()->route('users.index')->with('success', trans('admin/users/message.success.delete'));
        } catch (ModelNotFoundException $e) {
            // Prepare the error message
            // Redirect to the user management page
            return redirect()->route('users.index')
                ->with('error', trans('admin/users/message.user_not_found', compact('id')));
        }
    }

    /**
     * Restore a deleted user
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getRestore($id = null)
    {
        $this->authorize('update', User::class);
        // Get user information
        if (! User::onlyTrashed()->find($id)) {
            return redirect()->route('users.index')->with('error', trans('admin/users/messages.user_not_found'));
        }

        // Restore the user
        if (User::withTrashed()->where('id', $id)->restore()) {
            return redirect()->route('users.index')->with('success', trans('admin/users/message.success.restored'));
        }

        return redirect()->route('users.index')->with('error', 'User could not be restored.');
    }

    /**
     * Return a view with user detail
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param  int $userId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($userId = null)
    {
        if (! $user = User::with('assets', 'assets.model', 'consumables', 'accessories', 'licenses', 'userloc')->withTrashed()->find($userId)) {
            // Redirect to the user management page
            return redirect()->route('users.index')
                ->with('error', trans('admin/users/message.user_not_found', ['id' => $userId]));
        }

        $userlog = $user->userlog->load('item');

        $this->authorize('view', $user);

        return view('users/view', compact('user', 'userlog'))
            ->with('settings', Setting::getSettings());
    }

    /**
     * Unsuspend a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param  int $id
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getUnsuspend($id = null)
    {
        try {
            // Get user information
            $user = User::findOrFail($id);
            $this->authorize('update', $user);

            // Check if we are not trying to unsuspend ourselves
            if ($user->id === Auth::id()) {
                // Prepare the error message
                $error = trans('admin/users/message.error.unsuspend');
                // Redirect to the user management page
                return redirect()->route('users.index')->with('error', $error);
            }

            // Do we have permission to unsuspend this user?
            if ($user->isSuperUser() && ! Auth::user()->isSuperUser()) {
                // Redirect to the user management page
                return redirect()->route('users.index')->with('error', 'Insufficient permissions!');
            }

            // Redirect to the user management page
            return redirect()->route('users.index')->with('success', trans('admin/users/message.success.unsuspend'));
        } catch (ModelNotFoundException $e) {
            // Redirect to the user management page
            return redirect()->route('users.index')
                ->with('error', trans('admin/users/message.user_not_found', compact('id')));
        }
    }

    /**
     * Return a view containing a pre-populated new user form,
     * populated with some fields from an existing user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getClone(Request $request, $id = null)
    {
        $this->authorize('create', User::class);
        // We need to reverse the UI specific logic for our
        // permissions here before we update the user.
        $permissions = $request->input('permissions', []);
        app('request')->request->set('permissions', $permissions);

        try {
            // Get the user information
            $user_to_clone = User::withTrashed()->find($id);
            $user = clone $user_to_clone;
            $user->first_name = '';
            $user->last_name = '';
            $user->email = substr($user->email, ($pos = strpos($user->email, '@')) !== false ? $pos : 0);
            $user->id = null;

            // Get this user groups
            $userGroups = $user_to_clone->groups()->pluck('name', 'id');
            // Get all the available permissions
            $permissions = config('permissions');
            $clonedPermissions = $user_to_clone->decodePermissions();

            $userPermissions = Helper::selectedPermissionsArray($permissions, $clonedPermissions);

            // Show the page
            return view('users/edit', compact('permissions', 'userPermissions'))
                            ->with('user', $user)
                            ->with('groups', Group::pluck('name', 'id'))
                            ->with('userGroups', $userGroups)
                            ->with('clone_user', $user_to_clone);
        } catch (ModelNotFoundException $e) {
            // Prepare the error message
            // Redirect to the user management page
            return redirect()->route('users.index')
                ->with('error', trans('admin/users/message.user_not_found', compact('id')));
        }
    }

    /**
     * Exports users to CSV
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.5]
     * @return StreamedResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getExportUserCsv()
    {
        $this->authorize('view', User::class);
        \Debugbar::disable();

        $response = new StreamedResponse(function () {
            // Open output stream
            $handle = fopen('php://output', 'w');

            User::with('assets', 'accessories', 'consumables', 'department', 'licenses', 'manager', 'groups', 'userloc', 'company')
                ->orderBy('created_at', 'DESC')
                ->chunk(500, function ($users) use ($handle) {
                    $headers = [
                        // strtolower to prevent Excel from trying to open it as a SYLK file
                        strtolower(trans('general.id')),
                        trans('admin/companies/table.title'),
                        trans('admin/users/table.title'),
                        trans('general.employee_number'),
                        trans('admin/users/table.name'),
                        trans('admin/users/table.username'),
                        trans('admin/users/table.email'),
                        trans('admin/users/table.manager'),
                        trans('admin/users/table.location'),
                        trans('general.department'),
                        trans('general.assets'),
                        trans('general.licenses'),
                        trans('general.accessories'),
                        trans('general.consumables'),
                        trans('admin/users/table.groups'),
                        trans('general.notes'),
                        trans('admin/users/table.activated'),
                        trans('general.created_at'),
                    ];

                    fputcsv($handle, $headers);

                    foreach ($users as $user) {
                        $user_groups = '';

                        foreach ($user->groups as $user_group) {
                            $user_groups .= $user_group->name.', ';
                        }

                        // Add a new row with data
                        $values = [
                            $user->id,
                            ($user->company) ? $user->company->name : '',
                            $user->jobtitle,
                            $user->employee_num,
                            $user->present()->fullName(),
                            $user->username,
                            $user->email,
                            ($user->manager) ? $user->manager->present()->fullName() : '',
                            ($user->userloc) ? $user->userloc->name : '',
                            ($user->department) ? $user->department->name : '',
                            $user->assets->count(),
                            $user->licenses->count(),
                            $user->accessories->count(),
                            $user->consumables->count(),
                            $user_groups,
                            $user->notes,
                            ($user->activated == '1') ? trans('general.yes') : trans('general.no'),
                            $user->created_at,
                        ];

                        fputcsv($handle, $values);
                    }
                });

            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="users-'.date('Y-m-d-his').'.csv"',
        ]);

        return $response;
    }

    /**
     * Print inventory
     *
     * @author Aladin Alaily
     * @since [v1.8]
     * @return \Illuminate\Http\RedirectResponse
     */
    public function printInventory($id)
    {
        $this->authorize('view', User::class);
        $show_user = User::where('id', $id)->withTrashed()->first();
        $assets = Asset::where('assigned_to', $id)->where('assigned_type', User::class)->with('model', 'model.category')->get();
        $accessories = $show_user->accessories()->get();
        $consumables = $show_user->consumables()->get();

        return view('users/print')->with('assets', $assets)
            ->with('licenses', $show_user->licenses()->get())
            ->with('accessories', $accessories)
            ->with('consumables', $consumables)
            ->with('show_user', $show_user)
            ->with('settings', Setting::getSettings());
    }

    /**
     * Emails user a list of assigned assets
     *
     * @author [G. Martinez] [<godmartinz@gmail.com>]
     * @since [v6.0.5]
     * @param  \App\Http\Controllers\Users\UsersController  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function emailAssetList($id)
    {
        $this->authorize('view', User::class);

        if (!$user = User::find($id)) {
            return redirect()->back()
                ->with('error', trans('admin/users/message.user_not_found', ['id' => $id]));
        }
        if (empty($user->email)) {
            return redirect()->back()->with('error', trans('admin/users/message.user_has_no_email'));
        }

        $user->notify((new CurrentInventory($user)));
        return redirect()->back()->with('success', trans('admin/users/general.user_notified'));
    }

    /**
     * Send individual password reset email
     *
     * @author A. Gianotto
     * @since [v5.0.15]
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendPasswordReset($id)
    {
        if (($user = User::find($id)) && ($user->activated == '1') && ($user->email != '') && ($user->ldap_import == '0')) {
            $credentials = ['email' => trim($user->email)];

            try {

                Password::sendResetLink($credentials);

                return redirect()->back()->with('success', trans('admin/users/message.password_reset_sent', ['email' => $user->email]));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', ' Error sending email. :( ');
            }
        }

        return redirect()->back()->with('error', 'User is not activated, is LDAP synced, or does not have an email address ');
    }
}
