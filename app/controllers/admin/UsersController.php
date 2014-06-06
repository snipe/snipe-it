<?php namespace Controllers\Admin;

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
use Lang;
use Actionlog;
use Location;
use Setting;
use Redirect;
use Sentry;
use Validator;
use View;
use Chumper\Datatable\Facades\Datatable;

class UsersController extends AdminController {

	/**
	 * Declare the rules for the form validation
	 *
	 * @var array
	 */
	protected $validationRules = array(
		'first_name'       => 'required|alpha_space|min:2',
		'last_name'        => 'required|alpha_space|min:2',
		'email'            => 'required|email|unique:users,email',
		'password'         => 'required|between:10,32',
		'password_confirm' => 'required|between:10,32|same:password',
	);

	/**
	 * Show a list of all the users.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the users
		$users = Sentry::getUserProvider()->createModel();

		// Do we want to include the deleted users?
		if (Input::get('withTrashed'))
		{

		}
		else if (Input::get('onlyTrashed'))
		{
			$users = $users->onlyTrashed();
		}


		// Paginate the users
		$users = $users->paginate(100000)
			->appends(array(
				'withTrashed' => Input::get('withTrashed'),
				'onlyTrashed' => Input::get('onlyTrashed'),
			));


		// Show the page
		return View::make('backend/users/index', compact('users'));
	}

	/**
	 * User create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
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

		$location_list = array('' => '') + Location::lists('name', 'id');
		$manager_list = array('' => 'Select a User') + DB::table('users')
			->select(DB::raw('concat(first_name," ",last_name) as full_name, id'))
			->whereNull('deleted_at','and')
			->orderBy('last_name', 'asc')
			->orderBy('first_name', 'asc')
			->lists('full_name', 'id');

		// Show the page
		return View::make('backend/users/create', compact('groups', 'selectedGroups', 'permissions', 'selectedPermissions'))->with('location_list',$location_list)->with('manager_list',$manager_list);
	}

	/**
	 * User create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $this->validationRules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		try
		{
			// We need to reverse the UI specific logic for our
			// permissions here before we create the user.
			$permissions = Input::get('permissions', array());
			$this->decodePermissions($permissions);
			app('request')->request->set('permissions', $permissions);

			// Get the inputs, with some exceptions
			$inputs = Input::except('csrf_token', 'password_confirm', 'groups');

			// Was the user created?
			if ($user = Sentry::getUserProvider()->create($inputs))
			{
				// Assign the selected groups to this user
				foreach (Input::get('groups', array()) as $groupId)
				{
					$group = Sentry::getGroupProvider()->findById($groupId);

					$user->addGroup($group);
				}

				// Prepare the success message
				$success = Lang::get('admin/users/message.success.create');

				// Redirect to the new user page
				return Redirect::route('update/user', $user->id)->with('success', $success);
			}

			// Prepare the error message
			$error = Lang::get('admin/users/message.error.create');

			// Redirect to the user creation page
			return Redirect::route('create/user')->with('error', $error);
		}
		catch (LoginRequiredException $e)
		{
			$error = Lang::get('admin/users/message.user_login_required');
		}
		catch (PasswordRequiredException $e)
		{
			$error = Lang::get('admin/users/message.user_password_required');
		}
		catch (UserExistsException $e)
		{
			$error = Lang::get('admin/users/message.user_exists');
		}

		// Redirect to the user creation page
		return Redirect::route('create/user')->withInput()->with('error', $error);
	}

	/**
	 * User update.
	 *
	 * @param  int  $id
	 * @return View
	 */
	public function getEdit($id = null)
	{
		try
		{
			// Get the user information
			$user = Sentry::getUserProvider()->findById($id);

			// Get this user groups
			$userGroups = $user->groups()->lists('name', 'group_id');

			// Get this user permissions
			$userPermissions = array_merge(Input::old('permissions', array('superuser' => -1)), $user->getPermissions());
			$this->encodePermissions($userPermissions);

			// Get a list of all the available groups
			$groups = Sentry::getGroupProvider()->findAll();

			// Get all the available permissions
			$permissions = Config::get('permissions');
			$this->encodeAllPermissions($permissions);

			$location_list = array('' => '') + Location::lists('name', 'id');
			$manager_list = array('' => 'Select a User') + DB::table('users')
			->select(DB::raw('concat(first_name," ",last_name) as full_name, id'))
			->whereNull('deleted_at')
			->where('id','!=',$id)
			->orderBy('last_name', 'asc')
			->orderBy('first_name', 'asc')
			->lists('full_name', 'id');

		}
		catch (UserNotFoundException $e)
		{
			// Prepare the error message
			$error = Lang::get('admin/users/message.user_not_found', compact('id'));

			// Redirect to the user management page
			return Redirect::route('users')->with('error', $error);
		}

		// Show the page
		return View::make('backend/users/edit', compact('user', 'groups', 'userGroups', 'permissions', 'userPermissions'))
		->with('location_list',$location_list)
		->with('manager_list',$manager_list);
	}

	/**
	 * User update form processing page.
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function postEdit($id = null)
	{
		// We need to reverse the UI specific logic for our
		// permissions here before we update the user.
		$permissions = Input::get('permissions', array());
		$this->decodePermissions($permissions);
		app('request')->request->set('permissions', $permissions);

		try
		{
			// Get the user information
			$user = Sentry::getUserProvider()->findById($id);
		}
		catch (UserNotFoundException $e)
		{
			// Prepare the error message
			$error = Lang::get('admin/users/message.user_not_found', compact('id'));

			// Redirect to the user management page
			return Redirect::route('users')->with('error', $error);
		}

		//
		$this->validationRules['email'] = "required|email|unique:users,email,{$user->email},email";

		// Do we want to update the user password?
		if ( ! $password = Input::get('password'))
		{
			unset($this->validationRules['password']);
			unset($this->validationRules['password_confirm']);
			#$this->validationRules['password']         = 'required|between:3,32';
			#$this->validationRules['password_confirm'] = 'required|between:3,32|same:password';
		}

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $this->validationRules);


		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		try
		{
			// Update the user
			$user->first_name  = Input::get('first_name');
			$user->last_name   = Input::get('last_name');
			$user->email       = Input::get('email');
			$user->activated   = Input::get('activated', $user->activated);
			$user->permissions = Input::get('permissions');
			$user->jobtitle = Input::get('jobtitle');
			$user->phone = Input::get('phone');
			$user->location_id = Input::get('location_id');
			$user->manager_id = Input::get('manager_id');

			if ($user->manager_id == "") {
				$user->manager_id = NULL;
			}

			if ($user->location_id == "") {
					$user->location_id = NULL;
			}


			// Do we want to update the user password?
			if ($password)
			{
				$user->password = $password;
			}

			// Get the current user groups
			$userGroups = $user->groups()->lists('group_id', 'group_id');

			// Get the selected groups
			$selectedGroups = Input::get('groups', array());

			// Groups comparison between the groups the user currently
			// have and the groups the user wish to have.
			$groupsToAdd    = array_diff($selectedGroups, $userGroups);
			$groupsToRemove = array_diff($userGroups, $selectedGroups);

			// Assign the user to groups
			foreach ($groupsToAdd as $groupId)
			{
				$group = Sentry::getGroupProvider()->findById($groupId);

				$user->addGroup($group);
			}

			// Remove the user from groups
			foreach ($groupsToRemove as $groupId)
			{
				$group = Sentry::getGroupProvider()->findById($groupId);

				$user->removeGroup($group);
			}

			// Was the user updated?
			if ($user->save())
			{
				// Prepare the success message
				$success = Lang::get('admin/users/message.success.update');

				// Redirect to the user page
				return Redirect::route('update/user', $id)->with('success', $success);
			}

			// Prepare the error message
			$error = Lang::get('admin/users/message.error.update');
		}
		catch (LoginRequiredException $e)
		{
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
	public function getDelete($id = null)
	{
		try
		{
			// Get user information
			$user = Sentry::getUserProvider()->findById($id);

			// Check if we are not trying to delete ourselves
			if ($user->id === Sentry::getId())
			{
				// Prepare the error message
				$error = Lang::get('admin/users/message.error.delete');

				// Redirect to the user management page
				return Redirect::route('users')->with('error', $error);
			}


			// Do we have permission to delete this user?
			if ($user->isSuperUser() and ! Sentry::getUser()->isSuperUser())
			{
				// Redirect to the user management page
				return Redirect::route('users')->with('error', 'Insufficient permissions!');
			}

			if (count($user->assets) > 0) {

				// Redirect to the user management page
				return Redirect::route('users')->with('error', 'This user still has '.count($user->assets).' assets associated with them.');
			}

			if (count($user->licenses) > 0) {

				// Redirect to the user management page
				return Redirect::route('users')->with('error', 'This user still has '.count($user->licenses).' licenses associated with them.');
			}

			// Delete the user
			$user->delete();

			// Prepare the success message
			$success = Lang::get('admin/users/message.success.delete');

			// Redirect to the user management page
			return Redirect::route('users')->with('success', $success);
		}
		catch (UserNotFoundException $e)
		{
			// Prepare the error message
			$error = Lang::get('admin/users/message.user_not_found', compact('id' ));

			// Redirect to the user management page
			return Redirect::route('users')->with('error', $error);
		}
	}

	/**
	 * Restore a deleted user.
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function getRestore($id = null)
	{
		try
		{
			// Get user information
			$user = Sentry::getUserProvider()->createModel()->withTrashed()->find($id);

			// Restore the user
			$user->restore();

			// Prepare the success message
			$success = Lang::get('admin/users/message.success.restored');

			// Redirect to the user management page
			return Redirect::route('users')->with('success', $success);
		}
		catch (UserNotFoundException $e)
		{
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
	public function getView($userId = null)
	{

		$user = Sentry::getUserProvider()->createModel()->withTrashed()->find($userId);

			if (isset($user->id)) {
				return View::make('backend/users/view', compact('user'));
			} else {
				// Prepare the error message
				$error = Lang::get('admin/users/message.user_not_found', compact('id' ));

				// Redirect to the user management page
				return Redirect::route('users')->with('error', $error);
			}

	}

	public function getDatatable()
    {
    	return Datatable::collection(User::all())
		->addColumn('name',function($model)
	        {
				$name = HTML::image($model->gravatar(), $model->first_name, array('class'=>'img-circle avatar hidden-phone', 'style'=>'max-width: 45px'));
	        	$name .= HTML::link(URL::action('Controllers\Admin\UsersController@getView', $model->id), $model->first_name . ' ' . $model->last_name, array('class' => 'name'));
	            return $name;
	        }
        )
    	->showColumns('email')
		->addColumn('assets', function($model)
			{
				$assets = $model->assets->count();
				return $assets;
			}
		)
		->addColumn('licenses', function($model)
			{
				$licenses = $model->licenses->count();
				return $licenses;
			}
		)
		->addColumn('activated', function($model)
			{
				$activated = $model->isActivated() ? '<i class="icon-ok"></i>' : '';
				return $activated;
			}
		)
        ->make();
    }

}
