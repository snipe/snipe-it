<?php namespace Controllers\Admin;

use AdminController;
use Cartalyst\Sentry\Groups\GroupExistsException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;
use Cartalyst\Sentry\Groups\NameRequiredException;
use Config;
use Input;
use Lang;
use Redirect;
use Setting;
use Sentry;
use Validator;
use View;

class GroupsController extends AdminController {

	/**
	 * Show a list of all the groups.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Grab all the groups
		$groups = Sentry::getGroupProvider()->createModel()->paginate();

		// Show the page
		return View::make('backend/groups/index', compact('groups'));
	}

	/**
	 * Group create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Get all the available permissions
		$permissions = Config::get('permissions');
		$this->encodeAllPermissions($permissions, true);

		// Selected permissions
		$selectedPermissions = Input::old('permissions', array());

		// Show the page
		return View::make('backend/groups/create', compact('permissions', 'selectedPermissions'));
	}

	/**
	 * Group create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{
		// Declare the rules for the form validation
		$rules = array(
			'name' => 'required|alpha_space|min:2',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

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
			$inputs = Input::except('_token');

			// Was the group created?
			if ($group = Sentry::getGroupProvider()->create($inputs))
			{
				// Redirect to the new group page
				return Redirect::route('update/group', $group->id)->with('success', Lang::get('admin/groups/message.success.create'));
			}

			// Redirect to the new group page
			return Redirect::route('create/group')->with('error', Lang::get('admin/groups/message.error.create'));
		}
		catch (NameRequiredException $e)
		{
			$error = 'group_name_required';
		}
		catch (GroupExistsException $e)
		{
			$error = 'group_exists';
		}

		// Redirect to the group create page
		return Redirect::route('create/group')->withInput()->with('error', Lang::get('admin/groups/message.'.$error));
	}

	/**
	 * Group update.
	 *
	 * @param  int  $id
	 * @return View
	 */
	public function getEdit($id = null)
	{
		try
		{
			// Get the group information
			$group = Sentry::getGroupProvider()->findById($id);

			// Get all the available permissions
			$permissions = Config::get('permissions');
			$this->encodeAllPermissions($permissions, true);

			// Get this group permissions
			$groupPermissions = $group->getPermissions();
			$this->encodePermissions($groupPermissions);
			$groupPermissions = array_merge($groupPermissions, Input::old('permissions', array()));
		}
		catch (GroupNotFoundException $e)
		{
			// Redirect to the groups management page
			return Redirect::route('groups')->with('error', Lang::get('admin/groups/message.group_not_found', compact('id')));
		}

		// Show the page
		return View::make('backend/groups/edit', compact('group', 'permissions', 'groupPermissions'));
	}

	/**
	 * Group update form processing page.
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function postEdit($id = null)
	{
		// We need to reverse the UI specific logic for our
		// permissions here before we update the group.
		$permissions = Input::get('permissions', array());
		$this->decodePermissions($permissions);
		app('request')->request->set('permissions', $permissions);

		try
		{
			// Get the group information
			$group = Sentry::getGroupProvider()->findById($id);
		}
		catch (GroupNotFoundException $e)
		{
			// Redirect to the groups management page
			return Rediret::route('groups')->with('error', Lang::get('admin/groups/message.group_not_found', compact('id')));
		}

		// Declare the rules for the form validation
		$rules = array(
			'name' => 'required|alpha_space|min:2',
		);

		// Create a new validator instance from our validation rules
		$validator = Validator::make(Input::all(), $rules);

		// If validation fails, we'll exit the operation now.
		if ($validator->fails())
		{
			// Ooops.. something went wrong
			return Redirect::back()->withInput()->withErrors($validator);
		}

		try
		{
			// Update the group data
			$group->name        = Input::get('name');
			$group->permissions = Input::get('permissions');

			// Was the group updated?
			if ($group->save())
			{
				// Redirect to the group page
				return Redirect::route('update/group', $id)->with('success', Lang::get('admin/groups/message.success.update'));
			}
			else
			{
				// Redirect to the group page
				return Redirect::route('update/group', $id)->with('error', Lang::get('admin/groups/message.error.update'));
			}
		}
		catch (NameRequiredException $e)
		{
			$error = Lang::get('admin/group/message.group_name_required');
		}

		// Redirect to the group page
		return Redirect::route('update/group', $id)->withInput()->with('error', $error);
	}

	/**
	 * Delete the given group.
	 *
	 * @param  int  $id
	 * @return Redirect
	 */
	public function getDelete($id = null)
	{
		try
		{
			// Get group information
			$group = Sentry::getGroupProvider()->findById($id);

			// Delete the group
			$group->delete();

			// Redirect to the group management page
			return Redirect::route('groups')->with('success', Lang::get('admin/groups/message.success.delete'));
		}
		catch (GroupNotFoundException $e)
		{
			// Redirect to the group management page
			return Redirect::route('groups')->with('error', Lang::get('admin/groups/message.group_not_found', compact('id')));
		}
	}

}
