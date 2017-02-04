<?php
namespace App\Http\Controllers;

use App\Http\Requests\AssetFileRequest;
use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\LicenseSeat;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Group;
use App\Models\Company;
use App\Models\Location;
use App\Models\License;
use App\Models\Setting;
use App\Models\Statuslabel;
use App\Http\Requests\SaveUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\User;
use App\Models\Ldap;
use Auth;
use Config;
use Crypt;
use DB;
use HTML;
use Illuminate\Support\Facades\Log;
use Input;
use Lang;
use League\Csv\Reader;
use Mail;
use Redirect;
use Response;
use Str;
use Symfony\Component\HttpFoundation\JsonResponse;
use URL;
use View;
use Illuminate\Http\Request;
use Gate;

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
     */
    public function index()
    {
        $this->authorize('index', User::class);
        return View::make('users/index');
    }

    /**
    * Returns a view that displays the user creation form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $groups = Group::pluck('name', 'id');

        if (Input::old('groups')) {
            $userGroups = Group::whereIn('id', Input::old('groups'))->pluck('name', 'id');
        } else {
            $userGroups = collect();
        }

        $permissions = config('permissions');
        $userPermissions = Helper::selectedPermissionsArray($permissions, Input::old('permissions', array()));
        $permissions = $this->filterDisplayable($permissions);

        return View::make('users/edit', compact('groups', 'userGroups', 'permissions', 'userPermissions'))
        ->with('location_list', Helper::locationsList())
        ->with('manager_list', Helper::managerList())
        ->with('company_list', Helper::companyList())
        ->with('user', new User);
    }

    /**
    * Validate and store the new user data, or return an error.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveUserRequest $request)
    {
        $this->authorize('create', User::class);
        $user = new User;
        //Username, email, and password need to be handled specially because the need to respect config values on an edit.
        $user->email = $data['email'] = e($request->input('email'));
        $user->username = $data['username'] = e($request->input('username'));
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
            $data['password'] =  $request->input('password');
        }
        // Update the user
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->locale = $request->input('locale');
        $user->employee_num = $request->input('employee_num');
        $user->activated = $request->input('activated', $user->activated);
        $user->jobtitle = $request->input('jobtitle');
        $user->phone = $request->input('phone');
        $user->location_id = $request->input('location_id', null);
        $user->company_id = Company::getIdForUser($request->input('company_id', null));
        $user->manager_id = $request->input('manager_id', null);
        $user->notes = $request->input('notes');

        // Strip out the superuser permission if the user isn't a superadmin
        $permissions_array = $request->input('permission');

        if (!Auth::user()->isSuperUser()) {
            unset($permissions_array['superuser']);
        }
        $user->permissions =  json_encode($permissions_array);

        if ($user->save()) {

            if ($request->has('groups')) {
                $user->groups()->sync($request->input('groups'));
            } else {
                $user->groups()->sync(array());
            }

            if (($request->input('email_user') == 1) && ($request->has('email'))) {
              // Send the credentials through email
                $data = array();
                $data['email'] = e($request->input('email'));
                $data['username'] = e($request->input('username'));
                $data['first_name'] = e($request->input('first_name'));
                $data['password'] = e($request->input('password'));

                Mail::send('emails.send-login', $data, function ($m) use ($user) {
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.welcome', ['name' => $user->first_name]));
                });
            }
            return redirect::route('users.index')->with('success', trans('admin/users/message.success.create'));
        }
        return redirect()->back()->withInput()->withErrors($user->getErrors());
    }

    /**
    * JSON handler for creating a user through a modal popup
    *
    * @todo Handle validation more graciously
    * @author [B. Wetherington] [<uberbrady@gmail.com>]
    * @since [v1.8]
    * @return string JSON
    */
    public function apiStore()
    {
        $this->authorize('create', User::class);

        $user = new User;
        $inputs = Input::except('csrf_token', 'password_confirm', 'groups', 'email_user');
        $inputs['activated'] = true;

        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        if (Input::has('password')) {
            $user->password = bcrypt(Input::get('password'));
        }
        $user->activated = true;

        // Was the user created?
        if ($user->save()) {

            if (Input::get('email_user') == 1) {
                // Send the credentials through email
                $data = array();
                $data['email'] = e(Input::get('email'));
                $data['first_name'] = e(Input::get('first_name'));
                $data['last_name'] = e(Input::get('last_name'));
                $data['password'] = e(Input::get('password'));

                Mail::send('emails.send-login', $data, function ($m) use ($user) {
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.welcome', ['name' => $user->first_name]));
                });
            }

            return JsonResponse::create($user);

        }
        return JsonResponse::create(["error" => "Failed validation: " . print_r($user->getErrors(), true)], 500);
    }

    /**
     * Returns a view that displays the edit user form
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param $permissions
     * @return View
     * @internal param int $id
     */

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

    public function edit($id = null)
    {
        try {
            // Get the user information
            $user = User::find($id);
            $this->authorize('update', $user);
            $permissions = config('permissions');

            $groups = Group::pluck('name', 'id');

            $userGroups = $user->groups()->pluck('name', 'id');
            $user->permissions = $user->decodePermissions();
            $userPermissions = Helper::selectedPermissionsArray($permissions, $user->permissions);
            $permissions = $this->filterDisplayable($permissions);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return redirect()->route('users.index')->with('error', $error);
        }

        // Show the page
        return View::make('users/edit', compact('user', 'groups', 'userGroups', 'permissions', 'userPermissions'))
                        ->with('location_list', Helper::locationsList())
                        ->with('company_list', Helper::companyList())
                        ->with('manager_list', Helper::managerList());
    }

    /**
     * Validate and save edited user data from edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param UpdateUserRequest $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, $id = null)
    {
        // We need to reverse the UI specific logic for our
        // permissions here before we update the user.
        $permissions = $request->input('permissions', array());
        app('request')->request->set('permissions', $permissions);
        // Only update the email address if locking is set to false
        if (config('app.lock_passwords')) {
            return redirect()->route('users.index')->with('error', 'Denied! You cannot update user information on the demo.');
        }

        try {

            $user = User::find($id);
            $this->authorize('update', $user);
            // Figure out of this user was an admin before this edit
            $orig_permissions_array = $user->decodePermissions();
            $orig_superuser = '0';
            if (is_array($orig_permissions_array)) {
                if (array_key_exists('superuser', $orig_permissions_array)) {
                    $orig_superuser = $orig_permissions_array['superuser'];
                }
            }

        } catch (UserNotFoundException $e) {
            $error = trans('admin/users/message.user_not_found', compact('id'));
            return redirect()->route('users.index')->with('error', $error);
        }


        // Only save groups if the user is a super user
        if (Auth::user()->isSuperUser()) {
            if ($request->has('groups')) {
                $user->groups()->sync($request->input('groups'));
            } else {
                $user->groups()->sync(array());
            }
        }

        // Do we want to update the user password?
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        if ($request->has('username')) {
            $user->username = e($request->input('username'));
        }
        $user->email = e($request->input('email'));


       // Update the user
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->two_factor_optin = $request->input('two_factor_optin') ?: 0;
        $user->locale = $request->input('locale');
        $user->employee_num = $request->input('employee_num');
        $user->activated = $request->input('activated', $user->activated);
        $user->jobtitle = $request->input('jobtitle');
        $user->phone = $request->input('phone');
        $user->location_id = $request->input('location_id', null);
        $user->company_id = Company::getIdForUser($request->input('company_id', null));
        $user->manager_id = $request->input('manager_id', null);
        $user->notes = $request->input('notes');

        // Strip out the superuser permission if the user isn't a superadmin
        $permissions_array = $request->input('permission');

        if (!Auth::user()->isSuperUser()) {
            unset($permissions_array['superuser']);
            $permissions_array['superuser'] = $orig_superuser;
        }

        $user->permissions =  json_encode($permissions_array);

        // Was the user updated?
        if ($user->save()) {
            // Prepare the success message
            $success = trans('admin/users/message.success.update');
            // Redirect to the user page
            return redirect()->route('users.index')->with('success', $success);
        }
        return redirect()->back()->withInput()->withErrors($user->getErrors());
    }

    /**
    * Delete a user
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param  int  $id
    * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id = null)
    {
        try {
            // Get user information
            $user = User::find($id);
            // Authorize takes care of many of our logic checks now.
            $this->authorize('delete', User::class);

            if ($user->assets()->count() > 0) {
                // Redirect to the user management page
                return redirect()->route('users.index')->with('error', 'This user still has ' . $user->assets()->count() . ' assets associated with them.');
            }

            if ($user->licenses()->count() > 0) {

                // Redirect to the user management page
                return redirect()->route('users.index')->with('error', 'This user still has ' . $user->licenses()->count() . ' licenses associated with them.');
            }

            if ($user->accessories()->count() > 0) {
                // Redirect to the user management page
                return redirect()->route('users.index')->with('error', 'This user still has ' . $user->accessories()->count() . ' accessories associated with them.');
            }

            // Delete the user
            $user->delete();

            // Prepare the success message
            $success = trans('admin/users/message.success.delete');

            // Redirect to the user management page
            return redirect()->route('users.index')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('users.index')->with('error', $error);
        }
    }

    /**
    * Returns a view that confirms the user's a bulk delete will be applied to.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.7]
    * @return \Illuminate\Contracts\View\View
     */
    public function postBulkEdit()
    {
        $this->authorize('update', User::class);
        if ((!Input::has('ids')) || (count(Input::has('ids')) == 0)) {
            return redirect()->back()->with('error', 'No users selected');
        } else {
            $statuslabel_list = Helper::statusLabelList();
            $user_raw_array = array_keys(Input::get('ids'));
            $licenses = DB::table('license_seats')->whereIn('assigned_to', $user_raw_array)->get();

            $users = User::whereIn('id', $user_raw_array)->with('groups', 'assignedAssets', 'licenses', 'accessories')->get();
           // $users = Company::scopeCompanyables($users)->get();

            return View::make('users/confirm-bulk-delete', compact('users', 'statuslabel_list'));
        }
    }

    /**
    * Soft-delete bulk users
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function postBulkSave()
    {
        $this->authorize('update', User::class);

        if ((!Input::has('ids')) || (count(Input::has('ids')) == 0)) {
            return redirect()->back()->with('error', 'No users selected');
        } elseif ((!Input::has('status_id')) || (count(Input::has('status_id')) == 0)) {
            return redirect()->route('users.index')->with('error', 'No status selected');
        } else {

            $user_raw_array = Input::get('ids');
            $asset_array = array();

            if (($key = array_search(Auth::user()->id, $user_raw_array)) !== false) {
                unset($user_raw_array[$key]);
            }

            if (!Auth::user()->isSuperUser()) {
                return redirect()->route('users.index')->with('error', trans('admin/users/message.insufficient_permissions'));
            }

            if (!config('app.lock_passwords')) {

                $users = User::whereIn('id', $user_raw_array)->get();
                $assets = Asset::whereIn('assigned_to', $user_raw_array)->get();
                $accessories = DB::table('accessories_users')->whereIn('assigned_to', $user_raw_array)->get();
                $licenses = DB::table('license_seats')->whereIn('assigned_to', $user_raw_array)->get();
                $license_array = array();
                $accessory_array = array();

                foreach ($assets as $asset) {

                    $asset_array[] = $asset->id;

                    // Update the asset log
                    $logAction = new Actionlog();
                    $logAction->item_id = $asset->id;
                    $logAction->item_type = Asset::class;
                    $logAction->target_id = $asset->assigned_to;
                    $logAction->target_type = User::class;
                    $logAction->user_id = Auth::user()->id;
                    $logAction->note = 'Bulk checkin asset and delete user';
                    $logAction->logaction('checkin from');

                    Asset::whereIn('id', $asset_array)->update([
                                'status_id' => e(Input::get('status_id')),
                                'assigned_to' => null,
                    ]);
                }

                foreach ($accessories as $accessory) {
                    $accessory_array[] = $accessory->accessory_id;
                    // Update the asset log
                    $logAction = new Actionlog();
                    $logAction->item_id = $accessory->id;
                    $logAction->item_type = Accessory::class;
                    $logAction->target_id = $accessory->assigned_to;
                    $logAction->target_type = User::class;
                    $logAction->user_id = Auth::user()->id;
                    $logAction->note = 'Bulk checkin accessory and delete user';
                    $logAction->logaction('checkin from');
                }

                foreach ($licenses as $license) {
                    $license_array[] = $license->id;
                    // Update the asset log
                    $logAction = new Actionlog();
                    $logAction->item_id = $license->id;
                    $logAction->item_type = License::class;
                    $logAction->target_id = $license->assigned_to;
                    $logAction->target_type = User::class;
                    $logAction->user_id = Auth::user()->id;
                    $logAction->note = 'Bulk checkin license and delete user';
                    $logAction->logaction('checkin from');
                }

                LicenseSeat::whereIn('id', $license_array)->update(['assigned_to' => null]);

                foreach ($users as $user) {
                    $user->accessories()->sync(array());
                    $user->delete();
                }

                return redirect()->route('users.index')->with('success', 'Your selected users have been deleted and their assets have been updated.');
            }
            return redirect()->route('users.index')->with('error', 'Bulk delete is not enabled in this installation');
        }
    }

    /**
    * Restore a deleted user
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param  int  $id
    * @return \Illuminate\Http\RedirectResponse
     */
    public function getRestore($id = null)
    {
        $this->authorize('edit', User::class);
            // Get user information
        if (!$user = User::onlyTrashed()->find($id)) {
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
    * @param  int  $userId
    * @return \Illuminate\Contracts\View\View
     */
    public function show($userId = null)
    {
        if(!$user = User::with('assignedAssets', 'assignedAssets.model', 'consumables', 'accessories', 'licenses', 'userloc')->withTrashed()->find($userId)) {
            $error = trans('admin/users/message.user_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('users.index')->with('error', $error);
        }

        $userlog = $user->userlog->load('item');

        if (isset($user->id)) {
            $this->authorize('view', $user);
            return View::make('users/view', compact('user', 'userlog'));
        }
    }

    /**
    * Unsuspend a user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param  int  $id
    * @return Redirect
    */
    public function getUnsuspend($id = null)
    {
        try {
            // Get user information
            $user = User::find($id);
            $this->authorize('edit', $user);

            // Check if we are not trying to unsuspend ourselves
            if ($user->id === Auth::user()->id) {
                // Prepare the error message
                $error = trans('admin/users/message.error.unsuspend');
                // Redirect to the user management page
                return redirect()->route('users.index')->with('error', $error);
            }

            // Do we have permission to unsuspend this user?
            if ($user->isSuperUser() && !Auth::user()->isSuperUser()) {
                // Redirect to the user management page
                return redirect()->route('users.index')->with('error', 'Insufficient permissions!');
            }

            // Prepare the success message
            $success = trans('admin/users/message.success.unsuspend');
            // Redirect to the user management page
            return redirect()->route('users.index')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('users.index')->with('error', $error);
        }
    }


    /**
    * Return a view containing a pre-populated new user form,
    * populated with some fields from an existing user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param  int  $id
    * @return \Illuminate\Contracts\View\View
     */
    public function getClone($id = null)
    {
        $this->authorize('create', User::class);
        // We need to reverse the UI specific logic for our
        // permissions here before we update the user.
        $permissions = Input::get('permissions', array());
        //$this->decodePermissions($permissions);
        app('request')->request->set('permissions', $permissions);


        try {
            // Get the user information
            $user_to_clone = User::withTrashed()->find($id);
            $user = clone $user_to_clone;
            $user->first_name = '';
            $user->last_name = '';
            $user->email = substr($user->email, ($pos = strpos($user->email, '@')) !== false ? $pos : 0);
            ;
            $user->id = null;

            // Get this user groups
            $userGroups = $user_to_clone->groups()->lists('name', 'id');
            // Get all the available permissions
            $permissions = config('permissions');
            $clonedPermissions = $user_to_clone->decodePermissions();

            $userPermissions =Helper::selectedPermissionsArray($permissions, $clonedPermissions);

            // Show the page
            return View::make('users/edit', compact('permissions', 'userPermissions'))
                            ->with('location_list', Helper::locationsList())
                            ->with('company_list', Helper::companyList())
                            ->with('manager_list', Helper::managerList())
                            ->with('user', $user)
                            ->with('groups', Group::pluck('name', 'id'))
                            ->with('userGroups', $userGroups)
                            ->with('clone_user', $user_to_clone);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = trans('admin/users/message.user_not_found', compact('id'));
            // Redirect to the user management page
            return redirect()->route('users.index')->with('error', $error);
        }
    }

    /**
    * Return user import view
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function getImport()
    {
        $this->authorize('update', User::class);
        // Selected groups
        $selectedGroups = Input::old('groups', array());
        // Get all the available permissions
        $permissions = config('permissions');
        $selectedPermissions = Input::old('permissions', array('superuser' => -1));
        // Show the page
        return View::make('users/import', compact('selectedGroups', 'permissions', 'selectedPermissions'));
    }

    /**
    * Handle user import file
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function postImport()
    {
        $this->authorize('update', User::class);
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $csv = Reader::createFromPath(Input::file('user_import_csv'));
        $csv->setNewline("\r\n");

        if (Input::get('has_headers') == 1) {
            $csv->setOffset(1);
        }

        $duplicates = '';

        $nbInsert = $csv->each(function ($row) use ($duplicates) {

            if (array_key_exists(2, $row)) {

                if (Input::get('activate') == 1) {
                    $activated = '1';
                } else {
                    $activated = '0';
                }

                $pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15);

                // Location
                if (array_key_exists('4', $row)) {
                    $user_location_id = trim($row[4]);
                    if ($user_location_id=='') {
                        $user_location_id = null;
                    }
                }



                try {
                    // Check if this email already exists in the system
                    $user = User::where('username', $row[2])->first();
                    if ($user) {
                        $duplicates .= $row[2] . ', ';
                    } else {

                        $newuser = array(
                            'first_name' => trim(e($row[0])),
                            'last_name' => trim(e($row[1])),
                            'username' => trim(e($row[2])),
                            'email' => trim(e($row[3])),
                            'password' => bcrypt($pass),
                            'activated' => $activated,
                            'location_id' => trim(e($user_location_id)),
                            'phone' => trim(e($row[5])),
                            'jobtitle' => trim(e($row[6])),
                            'employee_num' => trim(e($row[7])),
                            'company_id' => Company::getIdForUser($row[8]),
                            'permissions' => '{"user":1}',
                            'notes' => 'Imported user'
                        );
                        //dd($newuser);

                        DB::table('users')->insert($newuser);


                        if (((Input::get('email_user') == 1) && !config('app.lock_passwords'))) {
                            // Send the credentials through email
                            if ($row[3] != '') {
                                $data = array();
                                $data['username'] = trim(e($row[2]));
                                $data['first_name'] = trim(e($row[0]));
                                $data['password'] = $pass;

                                if ($newuser['email']) {
                                    Mail::send('emails.send-login', $data, function ($m) use ($newuser) {
                                        $m->to($newuser['email'], $newuser['first_name'] . ' ' . $newuser['last_name']);
                                        $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                                        $m->subject(trans('mail.welcome', ['name' => $newuser['first_name']]));
                                    });
                                }
                            }
                        }
                    }
                } catch (Exception $e) {
                    echo 'Caught exception: ', $e->getMessage(), "\n";
                }
                return true;
            }
        });
        return redirect()->route('users.index')->with('duplicates', $duplicates)->with('success', 'Success');
    }


    /**
     * Return JSON response with a list of user details for the getIndex() view.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.6]
     * @param AssetFileRequest $request
     * @param int $userId
     * @return string JSON
     */
    public function postUpload(AssetFileRequest $request, $userId = null)
    {

        $user = User::find($userId);
        $destinationPath = config('app.private_uploads') . '/users';

        if (isset($user->id)) {
            $this->authorize('update', $user);

            foreach (Input::file('file') as $file) {

                $extension = $file->getClientOriginalExtension();
                $filename = 'user-' . $user->id . '-' . str_random(8);
                $filename .= '-' . str_slug($file->getClientOriginalName()) . '.' . $extension;
                $upload_success = $file->move($destinationPath, $filename);

                //Log the uploaded file to the log
                $logAction = new Actionlog();
                $logAction->item_id = $user->id;
                $logAction->item_type = User::class;
                $logAction->user_id = Auth::user()->id;
                $logAction->note = e(Input::get('notes'));
                $logAction->target_id = null;
                $logAction->created_at = date("Y-m-d H:i:s");
                $logAction->filename = $filename;
                $logAction->action_type = 'uploaded';
                $logAction->save();

            }
            return JsonResponse::create($logAction);

        }
        return JsonResponse::create(["error" => "Failed validation: ".print_r($logAction->getErrors(), true)], 500);
    }


    /**
    * Delete file
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.6]
    * @param  int  $userId
    * @param  int  $fileId
    * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeleteFile($userId = null, $fileId = null)
    {
        $user = User::find($userId);
        $destinationPath = config('app.private_uploads').'/users';

        // the license is valid
        if (isset($user->id)) {
            $this->authorize('update', $user);
            $log = Actionlog::find($fileId);
            $full_filename = $destinationPath . '/' . $log->filename;
            if (file_exists($full_filename)) {
                unlink($destinationPath . '/' . $log->filename);
            }
            $log->delete();
            return redirect()->back()->with('success', trans('admin/users/message.deletefile.success'));
        }
        // Prepare the error message
        $error = trans('admin/users/message.does_not_exist', compact('id'));
        // Redirect to the licence management page
        return redirect()->route('users.index')->with('error', $error);

    }

    /**
    * Display/download the uploaded file
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.6]
    * @param  int  $userId
    * @param  int  $fileId
    * @return mixed
    */
    public function displayFile($userId = null, $fileId = null)
    {
        $user = User::find($userId);

        // the license is valid
        if (isset($user->id)) {
            $this->authorize('view', $user);

            $log = Actionlog::find($fileId);
            $file = $log->get_src('users');
            return Response::download($file);
        }
        // Prepare the error message
        $error = trans('admin/users/message.does_not_exist', compact('id'));

        // Redirect to the licence management page
        return redirect()->route('users.index')->with('error', $error);
    }

    /**
    * Return view for LDAP import
    *
    * @author Aladin Alaily
    * @since [v1.8]
    * @return \Illuminate\Contracts\View\View
     */
    public function getLDAP()
    {
        $this->authorize('update', User::class);
        try {
            $ldapconn = Ldap::connectToLdap();
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }

        try {
            Ldap::bindAdminToLdap($ldapconn);
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', $e->getMessage());
        }

        return View::make('users/ldap')
              ->with('location_list', Helper::locationsList());
    }


    /**
    * Declare the rules for the ldap fields validation.
    *
    * @author Aladin Alaily
    * @since [v1.8]
    * @var array
    * @deprecated 3.0
    * @todo remove this method in favor of other validation
    * @var array
    */

    protected $ldapValidationRules = array(
        'firstname' => 'required|string|min:2',
        'employee_number' => 'string',
        'username' => 'required|min:2|unique:users,username',
        'email' => 'email|unique:users,email',
    );

    /**
    * LDAP form processing.
    *
    * @author Aladin Alaily
    * @since [v1.8]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function postLDAP(Request $request)
    {
        $this->authorize('update', User::class);
        ini_set('max_execution_time', 600); //600 seconds = 10 minutes
        ini_set('memory_limit', '500M');

        $ldap_result_username = Setting::getSettings()->ldap_username_field;
        $ldap_result_last_name = Setting::getSettings()->ldap_lname_field;
        $ldap_result_first_name = Setting::getSettings()->ldap_fname_field;

        $ldap_result_active_flag = Setting::getSettings()->ldap_active_flag_field;
        $ldap_result_emp_num = Setting::getSettings()->ldap_emp_num;
        $ldap_result_email = Setting::getSettings()->ldap_email;

        try {
            $ldapconn = Ldap::connectToLdap();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        try {
            Ldap::bindAdminToLdap($ldapconn);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $summary = array();

        $ldap_ou_locations = Location::whereNotNull('ldap_ou')->get();

        $results = Ldap::findLdapUsers();

        // Inject location information fields
        for ($i = 0; $i < $results["count"]; $i++) {
            $results[$i]["ldap_location_override"] = false;
            $results[$i]["location_id"] = 0;
        }

        // Grab subsets based on location-specific DNs, and overwrite location for these users.
        foreach ($ldap_ou_locations as $ldap_loc) {
            $location_users = Ldap::findLdapUsers($ldap_loc->ldap_ou);
            $usernames = array();
            for ($i = 0; $i < $location_users["count"]; $i++) {
                $location_users[$i]["ldap_location_override"] = true;
                $location_users[$i]["location_id"] = $ldap_loc->id;
                $usernames[] = $location_users[$i][$ldap_result_username][0];
            }

            // Delete located users from the general group.
            foreach ($results as $key => $generic_entry) {
                if (in_array($generic_entry[$ldap_result_username][0], $location_users)) {
                    unset($results[$key]);
                }
            }

            $global_count = $results['count'];
            $results = array_merge($location_users, $results);
            $results['count'] = $global_count;
        }

        $tmp_pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
        $pass = bcrypt($tmp_pass);

        for ($i = 0; $i < $results["count"]; $i++) {
            if (empty($ldap_result_active_flag) || $results[$i][$ldap_result_active_flag][0] == "TRUE") {

                $item = array();
                $item["username"] = isset($results[$i][$ldap_result_username][0]) ? $results[$i][$ldap_result_username][0] : "";
                $item["employee_number"] = isset($results[$i][$ldap_result_emp_num][0]) ? $results[$i][$ldap_result_emp_num][0] : "";
                $item["lastname"] = isset($results[$i][$ldap_result_last_name][0]) ? $results[$i][$ldap_result_last_name][0] : "";
                $item["firstname"] = isset($results[$i][$ldap_result_first_name][0]) ? $results[$i][$ldap_result_first_name][0] : "";
                $item["email"] = isset($results[$i][$ldap_result_email][0]) ? $results[$i][$ldap_result_email][0] : "" ;
                $item["ldap_location_override"] = isset($results[$i]["ldap_location_override"]) ? $results[$i]["ldap_location_override"]:"";
                $item["location_id"] = isset($results[$i]["location_id"]) ? $results[$i]["location_id"]:"";

                // User exists
                $item["createorupdate"] = 'updated';
                if (!$user = User::where('username', $item["username"])->first()) {
                    $user = new User;
                    $user->password = $pass;
                    $item["createorupdate"] = 'created';
                }

                 // Create the user if they don't exist.
                $user->first_name = e($item["firstname"]);
                $user->last_name = e($item["lastname"]);
                $user->username = e($item["username"]);
                $user->email = e($item["email"]);
                $user->employee_num = e($item["employee_number"]);
                $user->activated = 1;
                if ($item['ldap_location_override'] == true) {
                    $user->location_id = $item['location_id'];
                } else if ($request->input('location_id')!='') {
                    $user->location_id = e($request->input('location_id'));
                }
                $user->notes = 'Imported from LDAP';
                $user->ldap_import = 1;

                $errors = '';

                if ($user->save()) {
                    $item["note"] = $item["createorupdate"];
                    $item["status"]='success';
                } else {
                    foreach ($user->getErrors()->getMessages() as $key => $err) {
                        $errors .='<li>'.$err[0];
                    }
                    $item["note"] = $errors;
                    $item["status"]='error';
                }
                array_push($summary, $item);
            }
        }
        return redirect()->route('ldap/user')->with('success', "LDAP Import successful.")->with('summary', $summary);
    }

    /**
     * Return JSON containing a list of assets assigned to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param $userId
     * @return string JSON
     */
    public function getAssetList($userId)
    {
        $this->authorize('view', User::class);
        $assets = Asset::where('assigned_to', '=', $userId)->with('model')->get();
        return response()->json($assets);
    }

    /**
     * Exports users to CSV
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.5]
     * @return StreamedResponse
     */
    public function getExportUserCsv()
    {
        $this->authorize('view', User::class);
        \Debugbar::disable();

        $response = new StreamedResponse(function () {
            // Open output stream
            $handle = fopen('php://output', 'w');

            User::with('assignedAssets', 'accessories', 'consumables', 'licenses', 'manager', 'groups', 'userloc', 'company','throttle')->orderBy('created_at', 'DESC')->chunk(500, function($users) use($handle) {
                $headers=[
                    // strtolower to prevent Excel from trying to open it as a SYLK file
                    strtolower(trans('general.id')),
                    trans('admin/companies/table.title'),
                    trans('admin/users/table.title'),
                    trans('admin/users/table.employee_num'),
                    trans('admin/users/table.name'),
                    trans('admin/users/table.username'),
                    trans('admin/users/table.email'),
                    trans('admin/users/table.manager'),
                    trans('admin/users/table.location'),
                    trans('general.assets'),
                    trans('general.licenses'),
                    trans('general.accessories'),
                    trans('general.consumables'),
                    trans('admin/users/table.groups'),
                    trans('general.notes'),
                    trans('admin/users/table.activated'),
                    trans('general.created_at')
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
                        $user->assets->count(),
                        $user->licenses->count(),
                        $user->accessories->count(),
                        $user->consumables->count(),
                        $user_groups,
                        $user->notes,
                        ($user->activated=='1') ?  trans('general.yes') : trans('general.no'),
                        $user->created_at,

                    ];

                    fputcsv($handle, $values);
                }
            });

            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users-'.date('Y-m-d-his').'.csv"',
        ]);

        return $response;

    }

    public function postTwoFactorReset(Request $request)
    {
        if (Gate::denies('users.edit')) {
            return response()->json(['message' => trans('general.insufficient_permissions')], 500);
        }

        try {
            $user = User::find($request->get('id'));
            $user->two_factor_secret = null;
            $user->two_factor_enrolled = 0;
            $user->save();
            return response()->json(['message' => trans('admin/settings/general.two_factor_reset_success')], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => trans('admin/settings/general.two_factor_reset_error')], 500);
        }
    }
}
