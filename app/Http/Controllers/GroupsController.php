<?php
namespace App\Http\Controllers;

use Config;
use Input;
use Lang;
use Redirect;
use App\Models\Setting;
use Validator;
use View;
use App\Models\Group;
use App\Helpers\Helper;

/**
 * This controller handles all actions related to User Groups for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class GroupsController extends Controller
{
    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the user group listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see GroupsController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Show the page
        return view('groups/index');
    }

    /**
    * Returns a view that displays a form to create a new User Group.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see GroupsController::postCreate()
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $group = new Group;
        // Get all the available permissions
        $permissions = config('permissions');
        $groupPermissions = Helper::selectedPermissionsArray($permissions, $permissions);
        $selectedPermissions = Input::old('permissions', $groupPermissions);

        // Show the page
        return view('groups/edit', compact('permissions', 'selectedPermissions', 'groupPermissions'))->with('group', $group);
    }

    /**
    * Validates and stores the new User Group data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see GroupsController::getCreate()
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        // create a new group instance
        $group = new Group();
        $group->name = e(Input::get('name'));
        $group->permissions = json_encode(Input::get('permission'));

        if ($group->save()) {
            return redirect()->route("groups.index")->with('success', trans('admin/groups/message.success.create'));
        }
        return redirect()->back()->withInput()->withErrors($group->getErrors());
    }

    /**
    * Returns a view that presents a form to edit a User Group.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see GroupsController::postEdit()
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $group = Group::find($id);

        if ($group) {
            $permissions = config('permissions');
            $groupPermissions = $group->decodePermissions();
            $selected_array = Helper::selectedPermissionsArray($permissions, $groupPermissions);
            return view('groups.edit', compact('group', 'permissions', 'selected_array', 'groupPermissions'));
        }

        return redirect()->route('groups.index')->with('error', trans('admin/groups/message.group_not_found'));
    }

    /**
    * Validates and stores the updated User Group data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see GroupsController::getEdit()
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id = null)
    {
        $permissions = config('permissions');
        if (!$group = Group::find($id)) {
            return redirect()->route('groups.index')->with('error', trans('admin/groups/message.group_not_found', compact('id')));
        }
        $group->name = e(Input::get('name'));
        $group->permissions = json_encode(Input::get('permission'));

        if (!config('app.lock_passwords')) {
            if ($group->save()) {
                return redirect()->route('groups.index')->with('success', trans('admin/groups/message.success.update'));
            }
            return redirect()->back()->withInput()->withErrors($group->getErrors());
        }
        return redirect()->route('groups.index')->with('error', trans('general.feature_disabled'));
    }

    /**
    * Validates and deletes the User Group.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see GroupsController::getEdit()
    * @param int $id
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id = null)
    {
        if (!config('app.lock_passwords')) {
            if (!$group = Group::find($id)) {
                return redirect()->route('groups.index')->with('error', trans('admin/groups/message.group_not_found', compact('id')));
            }
            $group->delete();
            // Redirect to the group management page
            return redirect()->route('groups.index')->with('success', trans('admin/groups/message.success.delete'));
        }
        return redirect()->route('groups.index')->with('error', trans('general.feature_disabled'));
    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the group detail page.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $locationId
     * @since [v4.0.11]
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $group = Group::find($id);

        if ($group) {
            return view('groups/view', compact('group'));
        }

        return redirect()->route('groups.index')->with('error', trans('admin/groups/message.group_not_found', compact('id')));
    }

}
