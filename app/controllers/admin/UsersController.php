<?php

namespace Controllers\Admin;

use AdminController;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use HTML;
use URL;
use Config;
use DB;
use Input;
use User;
use Asset;
use Company;
use Lang;
use Actionlog;
use Location;
use Setting;
use Redirect;
use Response;
use Sentry;
use Str;
use Validator;
use Statuslabel;
use View;
use Datatable;
use League\Csv\Reader;
use Mail;
use Accessory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Log;
use Crypt;


class UsersController extends AdminController {

    /**
     * Declare the rules for the form validation
     *
     * @var array
     */
    protected $validationRules = array(
      'first_name' => 'required|alpha_space|min:1',
      'last_name' => 'required|alpha_space|min:1',
      'location_id' => 'numeric',
      'username' => 'required|min:2|unique:users,deleted_at,NULL',
      'email' => 'email|unique:users,email',
      'password' => 'required|min:6',
      'password_confirm' => 'required|same:password',
      'company_id' => 'integer',
    );

    /**
     * Show a list of all the users.
     *
     * @return View
     */
    public function getIndex() {

        // Show the page
        return View::make('backend/users/index');
    }

    /**
     * User create.
     *
     * @return View
     */
    public function getCreate() {
        // Get all the available groups
        $groups = Sentry::getGroupProvider()->findAll();

        // Selected groups
        $userGroups = Input::old('groups', array());

        // Get all the available permissions
        $permissions = Config::get('permissions');
        $this->encodeAllPermissions($permissions);

        // Selected permissions
        $userPermissions = Input::old('permissions', array('superuser' => -1));
        $this->encodePermissions($userPermissions);

        $location_list = locationsList();
        $manager_list = managerList();
        $company_list = companyList();

        /* echo '<pre>';
          print_r($userPermissions);
          echo '</pre>';
          exit;
         */

        // Show the page
        return View::make('backend/users/edit', compact('groups', 'userGroups', 'permissions', 'userPermissions'))
                        ->with('location_list', $location_list)
                        ->with('manager_list', $manager_list)
                        ->with('company_list', $company_list)
                        ->with('user', new User);
    }

    /**
     * User create form processing.
     *
     * @return Redirect
     */
    public function postCreate() {

        // echo '<pre>';
        // print_r($this->validationRules);
        // echo '</pre>';
        // exit;

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $this->validationRules);
        $permissions = Input::get('permissions', array());
        $this->decodePermissions($permissions);
        app('request')->request->set('permissions', $permissions);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator)->with('permissions', $permissions);
        }

        try {
            // We need to reverse the UI specific logic for our
            // permissions here before we create the user.
            // Get the inputs, with some exceptions
            $inputs = Input::except('csrf_token', 'password_confirm', 'groups', 'email_user');

            $inputs['company_id'] = Company::getIdForUser(Input::get('company_id'));

            // @TODO: Figure out WTF I need to do this.
            if ($inputs['manager_id'] == '') {
                unset($inputs['manager_id']);
            }

            if ($inputs['location_id'] == '') {
                unset($inputs['location_id']);
            }

            // Was the user created?
            if ($user = Sentry::getUserProvider()->create($inputs)) {

                // Assign the selected groups to this user
                foreach (Input::get('groups', array()) as $groupId) {
                    $group = Sentry::getGroupProvider()->findById($groupId);
                    $user->addGroup($group);
                }

                // Prepare the success message
                $success = Lang::get('admin/users/message.success.create');

                // Redirect to the new user page
                //return Redirect::route('update/user', $user->id)->with('success', $success);

                if ((Input::get('email_user') == 1) && (Input::has('email'))) {
                    // Send the credentials through email

                    $data = array();
                    $data['email'] = e(Input::get('email'));
                    $data['username'] = e(Input::get('username'));
                    $data['first_name'] = e(Input::get('first_name'));
                    $data['password'] = e(Input::get('password'));

                    Mail::send('emails.send-login', $data, function ($m) use ($user) {
                        $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                        $m->subject('Welcome ' . $user->first_name);
                    });
                }


                return Redirect::route('users')->with('success', $success);
            }



            // Prepare the error message
            $error = Lang::get('admin/users/message.error.create');

            // Redirect to the user creation page
            return Redirect::route('create/user')->with('error', $error);
        } catch (LoginRequiredException $e) {
            $error = Lang::get('admin/users/message.user_login_required');
        } catch (PasswordRequiredException $e) {
            $error = Lang::get('admin/users/message.user_password_required');
        } catch (UserExistsException $e) {
            $error = Lang::get('admin/users/message.user_exists');
        }

        // Redirect to the user creation page
        return Redirect::route('create/user')->withInput()->with('error', $error);
    }

    public function store() {
        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $this->validationRules);
        $permissions = Input::get('permissions', array());
        $this->decodePermissions($permissions);
        app('request')->request->set('permissions', $permissions);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return JsonResponse::create(["error" => "Failed validation: " . print_r($validator->messages()->all('<li>:message</li>'), true)], 500);
        }

        try {
            // We need to reverse the UI specific logic for our
            // permissions here before we create the user.
            // Get the inputs, with some exceptions
            $inputs = Input::except('csrf_token', 'password_confirm', 'groups', 'email_user');
            $inputs['activated'] = true;


            // @TODO: Figure out WTF I need to do this.
            /* if ($inputs['manager_id']=='') {
              unset($inputs['manager_id']);
              } */

            /* if ($inputs['location_id']=='') {
              unset($inputs['location_id']);
              } */

            // Was the user created?
            if ($user = Sentry::getUserProvider()->create($inputs)) {

                if (Input::get('email_user') == 1) {
                    // Send the credentials through email

                    $data = array();
                    $data['email'] = e(Input::get('email'));
                    $data['first_name'] = e(Input::get('first_name'));
                    $data['password'] = e(Input::get('password'));

                    Mail::send('emails.send-login', $data, function ($m) use ($user) {
                        $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                        $m->subject('Welcome ' . $user->first_name);
                    });
                }


                return JsonResponse::create($user);
            } else {
                return JsonResponse::create(["error" => "Couldn't save User"], 500);
            }
        } catch (Exception $e) {

            // Redirect to the user creation page
            return JsonResponse::create(["error" => "Failed validation: " . print_r($validator->messages()->all('<li>:message</li>'), true)], 500);
        }
    }

    /**
     * User update.
     *
     * @param  int  $id
     * @return View
     */
    public function getEdit($id = null) {
        try {
            // Get the user information
            $user = Sentry::getUserProvider()->findById($id);

            if (!Company::isCurrentUserHasAccess($user)) {
                return Redirect::route('users')->with('error', Lang::get('general.insufficient_permissions'));
            }

            // Get this user groups
            $userGroups = $user->groups()->lists('group_id', 'name');

            // Get this user permissions
            $userPermissions = array_merge(Input::old('permissions', array('superuser' => -1)), $user->getPermissions());
            $this->encodePermissions($userPermissions);

            // Get a list of all the available groups
            $groups = Sentry::getGroupProvider()->findAll();

            // Get all the available permissions
            $permissions = Config::get('permissions');
            $this->encodeAllPermissions($permissions);

            $location_list = locationsList();
            $company_list = companyList();
            $manager_list = array('' => 'Select a User') + DB::table('users')
                            ->select(DB::raw('concat(last_name,", ",first_name," (",email,")") as full_name, id'))
                            ->whereNull('deleted_at')
                            ->where('id', '!=', $id)
                            ->orderBy('last_name', 'asc')
                            ->orderBy('first_name', 'asc')
                            ->lists('full_name', 'id');
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('users')->with('error', $error);
        }

        // Show the page
        return View::make('backend/users/edit', compact('user', 'groups', 'userGroups', 'permissions', 'userPermissions'))
                        ->with('location_list', $location_list)
                        ->with('company_list', $company_list)
                        ->with('manager_list', $manager_list);
    }

    /**
     * User update form processing page.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function postEdit($id = null) {
        // We need to reverse the UI specific logic for our
        // permissions here before we update the user.
        $permissions = Input::get('permissions', array());
        $this->decodePermissions($permissions);
        app('request')->request->set('permissions', $permissions);

        // Only update the email address if locking is set to false
        if (Config::get('app.lock_passwords')) {
            return Redirect::route('users')->with('error', 'Denied! You cannot update user information on the demo.');
        }

        try {
            // Get the user information
            $user = Sentry::getUserProvider()->findById($id);

            if (!Company::isCurrentUserHasAccess($user)) {
                return Redirect::route('users')->with('error', Lang::get('general.insufficient_permissions'));
            }
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('users')->with('error', $error);
        }

        //Check if username is the same then unset validationRules
        if (Input::get('username') == $user->username) {
            unset($this->validationRules['username']);
        }

        //Check if email is the same then unset validationRules
        if ($user->email == Input::get('email')) {
            unset($this->validationRules['email']);
        }

        // Do we want to update the user password?
        if (!$password = Input::get('password')) {
            unset($this->validationRules['password']);
            unset($this->validationRules['password_confirm']);
            #$this->validationRules['password']         = 'required|between:3,32';
            #$this->validationRules['password_confirm'] = 'required|between:3,32|same:password';
        }

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $this->validationRules);


        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        try {
            // Update the user
            $user->first_name = e(Input::get('first_name'));
            $user->last_name = e(Input::get('last_name'));
            $user->username = e(Input::get('username'));
            $user->email = e(Input::get('email'));
            $user->employee_num = e(Input::get('employee_num'));
            $user->activated = e(Input::get('activated', $user->activated));
            if (Sentry::getUser()->hasAccess('superuser')) {
              $user->permissions = Input::get('permissions');
            }
            $user->jobtitle = e(Input::get('jobtitle'));
            $user->phone = e(Input::get('phone'));
            $user->location_id = Input::get('location_id');
            $user->company_id = Company::getIdForUser(Input::get('company_id'));
            $user->manager_id = Input::get('manager_id');
            $user->notes = e(Input::get('notes'));

            if ($user->manager_id == "") {
                $user->manager_id = NULL;
            }

            if ($user->location_id == "") {
                $user->location_id = NULL;
            }


            // Do we want to update the user password?
            if (($password) && (!Config::get('app.lock_passwords'))) {
                $user->password = $password;
            }

            // Do we want to update the user email?
            if (!Config::get('app.lock_passwords')) {
                $user->email = e(Input::get('email'));
            }

            // Get the current user groups
            $userGroups = $user->groups()->lists('group_id', 'group_id');

            // Get the selected groups
            $selectedGroups = Input::get('groups', array());

            // Groups comparison between the groups the user currently
            // have and the groups the user wish to have.
            $groupsToAdd = array_diff($selectedGroups, $userGroups);
            $groupsToRemove = array_diff($userGroups, $selectedGroups);

            if (!Config::get('app.lock_passwords')) {

                // Assign the user to groups
                foreach ($groupsToAdd as $groupId) {
                    $group = Sentry::getGroupProvider()->findById($groupId);
                    $user->addGroup($group);
                }

                // Remove the user from groups
                foreach ($groupsToRemove as $groupId) {
                    $group = Sentry::getGroupProvider()->findById($groupId);

                    $user->removeGroup($group);
                }
            }

            // Was the user updated?
            if ($user->save()) {
                // Prepare the success message
                $success = Lang::get('admin/users/message.success.update');

                // Redirect to the user page
                return Redirect::route('users')->with('success', $success);
            }

            // Prepare the error message
            $error = Lang::get('admin/users/message.error.update');
        } catch (LoginRequiredException $e) {
            $error = Lang::get('admin/users/message.user_login_required');
        }

        // Redirect to the user page
        return Redirect::route('update/user', $id)->withInput()->with('error', $error);
    }

    /**
     * Delete the given user.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function getDelete($id = null) {
        try {
            // Get user information
            $user = Sentry::getUserProvider()->findById($id);

            // Check if we are not trying to delete ourselves
            if ($user->id === Sentry::getId()) {
                // Prepare the error message
                $error = Lang::get('admin/users/message.error.delete');

                // Redirect to the user management page
                return Redirect::route('users')->with('error', $error);
            }


            // Do we have permission to delete this user?
            if ((!Sentry::getUser()->isSuperUser()) || (Config::get('app.lock_passwords'))) {
                // Redirect to the user management page
                return Redirect::route('users')->with('error', 'Insufficient permissions!');
            }

            if (count($user->assets) > 0) {

                // Redirect to the user management page
                return Redirect::route('users')->with('error', 'This user still has ' . count($user->assets) . ' assets associated with them.');
            }

            if (count($user->licenses) > 0) {

                // Redirect to the user management page
                return Redirect::route('users')->with('error', 'This user still has ' . count($user->licenses) . ' licenses associated with them.');
            }

            // Delete the user
            $user->delete();

            // Prepare the success message
            $success = Lang::get('admin/users/message.success.delete');

            // Redirect to the user management page
            return Redirect::route('users')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('users')->with('error', $error);
        }
    }

    public function postBulkEdit() {

        if ((!Input::has('edit_user')) || (count(Input::has('edit_user')) == 0)) {
            return Redirect::back()->with('error', 'No users selected');
        } else {
            $statuslabel_list = statusLabelList();
            $user_raw_array = array_keys(Input::get('edit_user'));

            $users = User::whereIn('id', $user_raw_array)->with('groups');
            $users = Company::scopeCompanyables($users)->get();

            return View::make('backend/users/confirm-bulk-delete', compact('users', 'statuslabel_list'));
        }
    }

    public function postBulkSave() {

        if ((!Input::has('edit_user')) || (count(Input::has('edit_user')) == 0)) {
            return Redirect::back()->with('error', 'No users selected');
        } elseif ((!Input::has('status_id')) || (count(Input::has('status_id')) == 0)) {
            return Redirect::route('users')->with('error', 'No status selected');
        } else {

            $user_raw_array = Input::get('edit_user');
            $asset_array = array();

            if (($key = array_search(Sentry::getId(), $user_raw_array)) !== false) {
                unset($user_raw_array[$key]);
            }

            if (!Sentry::getUser()->isSuperUser()) {
                return Redirect::route('users')->with('error', Lang::get('admin/users/message.insufficient_permissions'));
            }

            if (!Config::get('app.lock_passwords')) {

                $assets = Asset::whereIn('assigned_to', $user_raw_array)->get();
                $accessories = DB::table('accessories_users')->whereIn('assigned_to', $user_raw_array)->get();

                $users = User::whereIn('id', $user_raw_array);
                $users = Company::scopeCompanyables($users)->delete();

                foreach ($assets as $asset) {

                    $asset_array[] = $asset->id;

                    // Update the asset log
                    $logaction = new Actionlog();
                    $logaction->asset_id = $asset->id;
                    $logaction->checkedout_to = $asset->assigned_to;
                    $logaction->asset_type = 'hardware';
                    $logaction->user_id = Sentry::getUser()->id;
                    $logaction->note = 'Bulk checkin';
                    $log = $logaction->logaction('checkin from');

                    $update_assets = Asset::whereIn('id', $asset_array)->update(
                            array(
                                'status_id' => e(Input::get('status_id')),
                                'assigned_to' => null,
                    ));
                }

                foreach ($accessories as $accessory) {
                    $accessory_array[] = $accessory->id;
                    // Update the asset log
                    $logaction = new Actionlog();
                    $logaction->accessory_id = $accessory->id;
                    $logaction->checkedout_to = $accessory->assigned_to;
                    $logaction->asset_type = 'accessory';
                    $logaction->user_id = Sentry::getUser()->id;
                    $logaction->note = 'Bulk checkin';
                    $log = $logaction->logaction('checkin from');

                    $update_accessories = DB::table('accessories_users')->whereIn('id', $accessory_array)->update(
                            array(
                                'assigned_to' => null,
                    ));
                }


                return Redirect::route('users')->with('success', 'Your selected users have been deleted and their assets have been updated.');
            } else {
                return Redirect::route('users')->with('error', 'Bulk delete is not enabled in this installation');
            }

            /** @noinspection PhpUnreachableStatementInspection Known to be unreachable but kept following discussion: https://github.com/snipe/snipe-it/pull/1423 */
            return Redirect::route('users')->with('error', 'An error has occurred');
        }
    }

    /**
     * Restore a deleted user.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function getRestore($id = null) {
        try {
            // Get user information
            $user = Sentry::getUserProvider()->createModel()->withTrashed()->find($id);

            if (!Company::isCurrentUserHasAccess($user)) {
                return Redirect::route('users')->with('error', Lang::get('general.insufficient_permissions'));
            }
            else
            {
                // Restore the user
                $user->restore();

                // Prepare the success message
                $success = Lang::get('admin/users/message.success.restored');

                // Redirect to the user management page
                return Redirect::route('users')->with('success', $success);
            }
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('users')->with('error', $error);
        }
    }

    /**
     * Get user info for user view
     *
     * @param  int  $userId
     * @return View
     */
    public function getView($userId = null) {

        $user = User::with('assets', 'assets.model', 'consumables', 'accessories', 'licenses', 'userloc')->withTrashed()->find($userId);

        $userlog = $user->userlog->load('assetlog', 'consumablelog', 'assetlog.model', 'licenselog', 'accessorylog', 'userlog', 'adminlog');

        if (isset($user->id)) {

            if (!Company::isCurrentUserHasAccess($user)) {
                return Redirect::route('users')->with('error', Lang::get('general.insufficient_permissions'));
            } else {
                return View::make('backend/users/view', compact('user', 'userlog'));
            }
        } else {
            // Prepare the error message
            $error = Lang::get('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('users')->with('error', $error);
        }
    }

    /**
     * Unsuspend the given user.
     *
     * @param  int      $id
     * @return Redirect
     */
    public function getUnsuspend($id = null) {
        try {
            // Get user information
            $user = Sentry::getUserProvider()->findById($id);

            // Check if we are not trying to unsuspend ourselves
            if ($user->id === Sentry::getId()) {
                // Prepare the error message
                $error = Lang::get('admin/users/message.error.unsuspend');

                // Redirect to the user management page
                return Redirect::route('users')->with('error', $error);
            }

            // Do we have permission to unsuspend this user?
            if ($user->isSuperUser() and ! Sentry::getUser()->isSuperUser()) {
                // Redirect to the user management page
                return Redirect::route('users')->with('error', 'Insufficient permissions!');
            }

            // Unsuspend the user
            $throttle = Sentry::findThrottlerByUserId($id);
            $throttle->unsuspend();

            // Prepare the success message
            $success = Lang::get('admin/users/message.success.unsuspend');

            // Redirect to the user management page
            return Redirect::route('users')->with('success', $success);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('users')->with('error', $error);
        }
    }

    public function getClone($id = null) {
        // We need to reverse the UI specific logic for our
        // permissions here before we update the user.
        $permissions = Input::get('permissions', array());
        $this->decodePermissions($permissions);
        app('request')->request->set('permissions', $permissions);


        try {
            // Get the user information
            $user_to_clone = Sentry::getUserProvider()->findById($id);
            $user = clone $user_to_clone;
            $user->first_name = '';
            $user->last_name = '';
            $user->email = substr($user->email, ($pos = strpos($user->email, '@')) !== false ? $pos : 0);
            ;
            $user->id = null;

            // Get this user groups
            $userGroups = $user_to_clone->groups()->lists('group_id', 'name');

            // Get this user permissions
            $userPermissions = array_merge(Input::old('permissions', array('superuser' => -1)), $user_to_clone->getPermissions());
            $this->encodePermissions($userPermissions);

            // Get a list of all the available groups
            $groups = Sentry::getGroupProvider()->findAll();

            // Get all the available permissions
            $permissions = Config::get('permissions');
            $this->encodeAllPermissions($permissions);

            $location_list = array('' => '') + Location::lists('name', 'id');
            $company_list = companyList();
            $manager_list = array('' => 'Select a User') + DB::table('users')
                            ->select(DB::raw('concat(last_name,", ",first_name," (",email,")") as full_name, id'))
                            ->whereNull('deleted_at')
                            ->where('id', '!=', $id)
                            ->orderBy('last_name', 'asc')
                            ->orderBy('first_name', 'asc')
                            ->lists('full_name', 'id');

            // Show the page
            return View::make('backend/users/edit', compact('groups', 'userGroups', 'permissions', 'userPermissions'))
                            ->with('location_list', $location_list)
                            ->with('company_list', $company_list)
                            ->with('manager_list', $manager_list)
                            ->with('user', $user)
                            ->with('clone_user', $user_to_clone);
        } catch (UserNotFoundException $e) {
            // Prepare the error message
            $error = Lang::get('admin/users/message.user_not_found', compact('id'));

            // Redirect to the user management page
            return Redirect::route('users')->with('error', $error);
        }
    }

    /**
     * User import.
     *
     * @return View
     */
    public function getImport() {
        // Get all the available groups
        $groups = Sentry::getGroupProvider()->findAll();
        // Selected groups
        $selectedGroups = Input::old('groups', array());
        // Get all the available permissions
        $permissions = Config::get('permissions');
        $this->encodeAllPermissions($permissions);
        // Selected permissions
        $selectedPermissions = Input::old('permissions', array('superuser' => -1));
        $this->encodePermissions($selectedPermissions);
        // Show the page
        return View::make('backend/users/import', compact('groups', 'selectedGroups', 'permissions', 'selectedPermissions'));
    }

    /**
     * User import form processing.
     *
     * @return Redirect
     */
    public function postImport() {

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
          			if (array_key_exists('4',$row)) {
          				$user_location_id = trim($row[4]);
                  if ($user_location_id=='') {
                    $user_location_id = null;
                  }
          			}



                try {
                    // Check if this email already exists in the system
                    $user = DB::table('users')->where('username', $row[2])->first();
                    if ($user) {
                        $duplicates .= $row[2] . ', ';
                    } else {

                        $newuser = array(
                            'first_name' => $row[0],
                            'last_name' => $row[1],
                            'username' => $row[2],
                            'email' => $row[3],
                            'password' => $pass,
                            'activated' => $activated,
                            'location_id' => $user_location_id,
                            'phone' => $row[5],
                            'jobtitle' => $row[6],
                            'employee_num' => $row[7],
                            //'company_id' => Company::getIdForUser($row[8]),
                            'permissions' => '{"user":1}',
                            'notes' => 'Imported user'
                        );

                        DB::table('users')->insert($newuser);

                        $updateuser = Sentry::findUserByLogin($row[2]);

                        // Update the user details
                        $updateuser->password = $pass;

                        // Update the user
                        $updateuser->save();


                        if (((Input::get('email_user') == 1) && !Config::get('app.lock_passwords'))) {
                            // Send the credentials through email
                            if ($row[3] != '') {
                                $data = array();
                                $data['username'] = $row[2];
                                $data['first_name'] = $row[0];
                                $data['password'] = $pass;

                                if ($newuser['email']) {
                                    Mail::send('emails.send-login', $data, function ($m) use ($newuser) {
                                        $m->to($newuser['email'], $newuser['first_name'] . ' ' . $newuser['last_name']);
                                        $m->subject('Welcome ' . $newuser['first_name']);
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


        return Redirect::route('users')->with('duplicates', $duplicates)->with('success', 'Success');
    }

    public function getDatatable($status = null)
    {

        if (Input::has('offset')) {
            $offset = e(Input::get('offset'));
        } else {
            $offset = 0;
        }

        if (Input::has('limit')) {
            $limit = e(Input::get('limit'));
        } else {
            $limit = 50;
        }

        if (Input::get('sort')=='name') {
            $sort = 'first_name';
        } else {
            $sort = e(Input::get('sort'));
        }

        $users = User::select(array('users.id','users.employee_num','users.email','users.username','users.location_id','users.manager_id','users.first_name','users.last_name','users.created_at','users.notes','users.company_id', 'users.deleted_at','users.activated'))
        ->with('assets','accessories','consumables','licenses','manager','sentryThrottle','groups','userloc','company');
        $users = Company::scopeCompanyables($users);

        switch ($status) {
        case 'deleted':
          $users = $users->withTrashed()->Deleted();
          break;
        }

         if (Input::has('search')) {
             $users = $users->TextSearch(Input::get('search'));
         }

         $order = Input::get('order') === 'asc' ? 'asc' : 'desc';

         switch (Input::get('sort'))
         {
             case 'manager':
                $users = $users->OrderManager($order);
               break;
             case 'location':
                $users = $users->OrderLocation($order);
              break;
             default:
                $allowed_columns =
                [
                  'last_name','first_name','email','username','employee_num',
                  'assets','accessories', 'consumables','licenses','groups','activated'
                ];

                $sort = in_array($sort, $allowed_columns) ? $sort : 'first_name';
                $users = $users->orderBy($sort, $order);
             break;
         }

        $userCount = $users->count();
        $users = $users->skip($offset)->take($limit)->get();
        $rows = array();

        foreach ($users as $user)
        {

            $group_names = '';
            $inout = '';
            $actions = '<nobr>';

            foreach ($user->groups as $group) {
                $group_names .= '<a href="' . Config::get('app.url') . '/admin/groups/' . $group->id . '/edit" class="label  label-default">' . e($group->name) . '</a> ';
            }


            if (!is_null($user->deleted_at)) {

                $actions .= '<a href="' . route('restore/user', $user->id) . '" class="btn btn-warning btn-sm"><i class="fa fa-share icon-white"></i></a> ';
            } else {

                if ($user->accountStatus() == 'suspended') {
                    $actions .= '<a href="' . route('unsuspend/user', $user->id) . '" class="btn btn-default btn-sm"><span class="fa fa-clock-o"></span></a> ';
                }

                $actions .= '<a href="' . route('update/user', $user->id) . '" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> ';

                if ((Sentry::getId() !== $user->id) && (!Config::get('app.lock_passwords'))) {
                    $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="' . route('delete/user', $user->id) . '" data-content="Are you sure you wish to delete this user?" data-title="Delete ' . htmlspecialchars($user->first_name) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a> ';
                } else {
                    $actions .= ' <span class="btn delete-asset btn-danger btn-sm disabled"><i class="fa fa-trash icon-white"></i></span>';
                }
            }
            $actions .= '</nobr>';

            $rows[] = array(
                'id'         => $user->id,
                'checkbox'      =>'<div class="text-center hidden-xs hidden-sm"><input type="checkbox" name="edit_user['.$user->id.']" class="one_required"></div>',
                'name'          => '<a title="'.$user->fullName().'" href="../admin/users/'.$user->id.'/view">'.$user->fullName().'</a>',
                'email'         => ($user->email!='') ?
                            '<a href="mailto:'.e($user->email).'" class="hidden-md hidden-lg">'.e($user->email).'</a>'
                            .'<a href="mailto:'.e($user->email).'" class="hidden-xs hidden-sm"><i class="fa fa-envelope"></i></a>'
                            .'</span>' : '',
                'username'         => e($user->username),
                'location'      => ($user->userloc) ? e($user->userloc->name) : '',
                'manager'         => ($user->manager) ? '<a title="' . e($user->manager->fullName()) . '" href="users/' . $user->manager->id . '/view">' . e($user->manager->fullName()) . '</a>' : '',
                'assets'        => $user->assets->count(),
                'employee_num'  => e($user->employee_num),
                'licenses'        => $user->licenses->count(),
                'accessories'        => $user->accessories->count(),
                'consumables'        => $user->consumables->count(),
                'groups'        => $group_names,
                'notes'         => e($user->notes),
                'activated'      => ($user->activated=='1') ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>',
                'actions'       => ($actions) ? $actions : '',
                'companyName'   => is_null($user->company) ? '' : e($user->company->name)
            );
        }

        $data = array('total'=>$userCount, 'rows'=>$rows);
        return $data;
    }

    /**
     *  Upload the file to the server
     *
     * @param  int  $userId
     * @return View
     * */
    public function postUpload($userId = null) {
        $user = User::find($userId);

        // the license is valid
        $destinationPath = app_path() . '/private_uploads';

        if (isset($user->id)) {

            if (!Company::isCurrentUserHasAccess($user)) {
                return Redirect::route('users')->with('error', Lang::get('general.insufficient_permissions'));
            }
            else if (Input::hasFile('userfile')) {

                foreach (Input::file('userfile') as $file) {

                    $rules = array(
                        'userfile' => 'required|mimes:png,gif,jpg,jpeg,doc,docx,pdf,txt,zip,rar|max:2000'
                    );
                    $validator = Validator::make(array('userfile' => $file), $rules);

                    if ($validator->passes()) {

                        $extension = $file->getClientOriginalExtension();
                        $filename = 'user-' . $user->id . '-' . str_random(8);
                        $filename .= '-' . Str::slug($file->getClientOriginalName()) . '.' . $extension;
                        $upload_success = $file->move($destinationPath, $filename);

                        //Log the deletion of seats to the log
                        $logaction = new Actionlog();
                        $logaction->asset_id = $user->id;
                        $logaction->asset_type = 'user';
                        $logaction->user_id = Sentry::getUser()->id;
                        $logaction->note = e(Input::get('notes'));
                        $logaction->checkedout_to = NULL;
                        $logaction->created_at = date("Y-m-d h:i:s");
                        $logaction->filename = $filename;
                        $log = $logaction->logaction('uploaded');
                    } else {
                        return Redirect::back()->with('error', Lang::get('admin/users/message.upload.invalidfiles'));
                    }
                }

                if ($upload_success) {
                    return Redirect::back()->with('success', Lang::get('admin/users/message.upload.success'));
                } else {
                    return Redirect::back()->with('error', Lang::get('admin/users/message.upload.error'));
                }
            } else {
                return Redirect::back()->with('error', Lang::get('admin/users/message.upload.nofiles'));
            }
        } else {
            // Prepare the error message
            $error = Lang::get('admin/users/message.does_not_exist', compact('id'));

            // Redirect to the licence management page
            return Redirect::route('users')->with('error', $error);
        }
    }

    /**
     *  Delete the associated file
     *
     * @param  int  $userId
     * @param  int  $fileId
     * @return View
     * */
    public function getDeleteFile($userId = null, $fileId = null) {
        $user = User::find($userId);
        $destinationPath = app_path() . '/private_uploads';

        // the license is valid
        if (isset($user->id)) {

            if (!Company::isCurrentUserHasAccess($user)) {
                return Redirect::route('users')->with('error', Lang::get('general.insufficient_permissions'));
            }
            else
            {
                $log = Actionlog::find($fileId);
                $full_filename = $destinationPath . '/' . $log->filename;
                if (file_exists($full_filename)) {
                    unlink($destinationPath . '/' . $log->filename);
                }
                $log->delete();
                return Redirect::back()->with('success', Lang::get('admin/users/message.deletefile.success'));
            }
        } else {
            // Prepare the error message
            $error = Lang::get('admin/users/message.does_not_exist', compact('id'));

            // Redirect to the licence management page
            return Redirect::route('users')->with('error', $error);
        }
    }

    /**
     *  Display/download the uploaded file
     *
     * @param  int  $userId
     * @param  int  $fileId
     * @return View
     * */
    public function displayFile($userId = null, $fileId = null) {

        $user = User::find($userId);

        // the license is valid
        if (isset($user->id)) {
            if (!Company::isCurrentUserHasAccess($user)) {
                return Redirect::route('users')->with('error', Lang::get('general.insufficient_permissions'));
            }
            else
            {
                $log = Actionlog::find($fileId);
                $file = $log->get_src();
                return Response::download($file);
            }
        } else {
            // Prepare the error message
            $error = Lang::get('admin/users/message.does_not_exist', compact('id'));

            // Redirect to the licence management page
            return Redirect::route('users')->with('error', $error);
        }
    }

    /**
     * LDAP import
     *
     * @author Aladin Alaily
     * @return View
     */
    public function getLDAP() {
        // Get all the available groups
        $groups = Sentry::getGroupProvider()->findAll();
        // Selected groups
        $selectedGroups = Input::old('groups', array());
        // Get all the available permissions
        $permissions = Config::get('permissions');
        $this->encodeAllPermissions($permissions);
        // Selected permissions
        $selectedPermissions = Input::old('permissions', array('superuser' => -1));
        $this->encodePermissions($selectedPermissions);

        $location_list = locationsList();

        // Show the page
        return View::make('backend/users/ldap', compact('groups', 'selectedGroups', 'permissions', 'selectedPermissions'))
                        ->with('location_list', $location_list);

    }

    /**
     * Declare the rules for the ldap fields validation.
     *
     * @var array
     */
    protected $ldapValidationRules = array(
        'firstname' => 'required|alpha_space|min:2',
        'lastname' => 'required|alpha_space|min:2',
        'employee_number' => 'alpha_space',
        'username' => 'required|min:2|unique:users,username',
        'email' => 'email|unique:users,email',
    );

    /**
     * Declare the rules for the form validation.
     *
     * @var array
     */
    protected $ldapFormInputValidationRules = array(
        'location_id' => 'required|numeric'
    );

    /**
     * LDAP form processing.
     *
     * @author Aldin Alaily
     * @return Redirect
     */
    public function postLDAP() {

        $location_id = Input::get('location_id');

        $formValidator = Validator::make(Input::all(), $this->ldapFormInputValidationRules);
        // If validation fails, we'll exit the operation now.
        if ($formValidator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($formValidator);
        }

        $ldap_version = Setting::getSettings()->ldap_version;
        $url = Setting::getSettings()->ldap_server;
        $username = Setting::getSettings()->ldap_uname;
        $password = Crypt::decrypt(Setting::getSettings()->ldap_pword);
        $base_dn = Setting::getSettings()->ldap_basedn;
        $filter = Setting::getSettings()->ldap_filter;

        $ldap_result_username = Setting::getSettings()->ldap_username_field;
        $ldap_result_last_name = Setting::getSettings()->ldap_lname_field;
        $ldap_result_first_name = Setting::getSettings()->ldap_fname_field;

        $ldap_result_active_flag = Setting::getSettings()->ldap_active_flag_field;
        $ldap_result_emp_num = Setting::getSettings()->ldap_emp_num;
        $ldap_result_email = Setting::getSettings()->ldap_email;
        $ldap_server_cert_ignore = Setting::getSettings()->ldap_server_cert_ignore;

        // If we are ignoring the SSL cert we need to setup the environment variable
        // before we create the connection
        if($ldap_server_cert_ignore) {
            putenv('LDAPTLS_REQCERT=never');
        }

        // Connect to LDAP server
        $ldapconn = @ldap_connect($url);

        // Needed for AD
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

        if (!$ldapconn) {
            return Redirect::route('users')->with('error', Lang::get('admin/users/message.error.ldap_could_not_connect'));
        }

        // Set options
        $ldapopt = @ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, $ldap_version);
        if (!$ldapopt) {
            return Redirect::route('users')->with('error', Lang::get('admin/users/message.error.ldap_could_not_connect'));
        }

        // Binding to ldap server
        $ldapbind = @ldap_bind($ldapconn, $username, $password);

        Log::error(ldap_errno($ldapconn));
        if (!$ldapbind) {
            return Redirect::route('users')->with('error', Lang::get('admin/users/message.error.ldap_could_not_bind').ldap_error($ldapconn));
        }

	// Set up LDAP pagination for very large databases
	// @author Richard Hofman
	$page_size = 500;
	$cookie = '';
	$result_set = array();
	$global_count = 0;

        // Perform the search
	do {
		// Paginate (non-critical, if not supported by server)
		ldap_control_paged_result($ldapconn, $page_size, false, $cookie);

        	$search_results = ldap_search($ldapconn, $base_dn, '('.$filter.')');

	        if (!$search_results) {
	            return Redirect::route('users')->with('error', Lang::get('admin/users/message.error.ldap_could_not_search').ldap_error($ldapconn));
	        }

	        // Get results from page
	        $results = ldap_get_entries($ldapconn, $search_results);
	        if (!$results) {
	            return Redirect::route('users')->with('error', Lang::get('admin/users/message.error.ldap_could_not_get_entries').ldap_error($ldapconn));
	        }

		// Add results to result set
		$global_count += $results['count'];
		$result_set = array_merge($result_set, $results);

		ldap_control_paged_result_response($ldapconn, $search_results, $cookie);

	} while ($cookie !== null && $cookie != '');

	// Clean up after search
	$result_set['count'] = $global_count;
	$results = $result_set;
	ldap_control_paged_result($ldapconn, 0);

        $summary = array();
        for ($i = 0; $i < $results["count"]; $i++) {
            if (empty($ldap_result_active_flag) || $results[$i][$ldap_result_active_flag][0] == "TRUE") {

                $item = array();
                $item["username"] = isset( $results[$i][$ldap_result_username][0] ) ? $results[$i][$ldap_result_username][0] : "";
                $item["employee_number"] = isset( $results[$i][$ldap_result_emp_num][0] ) ? $results[$i][$ldap_result_emp_num][0] : "";
                $item["lastname"] = isset( $results[$i][$ldap_result_last_name][0] ) ? $results[$i][$ldap_result_last_name][0] : "";
                $item["firstname"] = isset( $results[$i][$ldap_result_first_name][0] ) ? $results[$i][$ldap_result_first_name][0] : "";
                $item["email"] = isset( $results[$i][$ldap_result_email][0] ) ? $results[$i][$ldap_result_email][0] : "" ;

                $user = DB::table('users')->where('username', $item["username"])->first();
                if ($user) {
                    $item["note"] = "<strong>exists</strong>";
                } else {



                    $validator = Validator::make($item, $this->ldapValidationRules);
                    if ($validator->fails()) {
                        $validator_msg = '';

                		foreach($validator->messages()->all() as $key)
                		{
                			$validator_msg .= '<li>'.$key;
                		}

                        $item["note"] = '<span class="alert-msg">Validator failed: <br>'.$validator_msg.'</span>';

                    } else {

                        // Create the user if they don't exist.
                        $pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

                        $newuser = array(
                            'first_name' => $item["firstname"],
                            'last_name' => $item["lastname"],
                            'username' => $item["username"],
                            'email' => $item["email"],
                            'employee_num' => $item["employee_number"],
                            'password' => $pass,
                            'activated' => 1,
                            'location_id' => $location_id,
                            'permissions' => '{"user":1}',
                            'notes' => 'Imported from LDAP'
                        );

                        DB::table('users')->insert($newuser);

                        $updateuser = Sentry::findUserByLogin($item["username"]);

                        // Update the user details
                        $updateuser->password = $pass;

                        // Update the user
                        $updateuser->save();

                        $item["note"] = "<strong>created</strong>";
                    } // Validator didn't fail
                }


                array_push($summary, $item);
            }

        }



        return Redirect::route('ldap/user')->with('success', "OK")->with('summary', $summary);
    }

}
