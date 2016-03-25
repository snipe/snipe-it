<?php
namespace App\Http\Controllers;

use Config;
use Input;
use Lang;
use Redirect;
use App\Models\Setting;
use Validator;
use View;

class GroupsController extends Controller
{
    /**
     * Show a list of all the groups.
     *
     * @return View
     */
    public function getIndex()
    {
        // Show the page
        return View::make('groups/index', compact('groups'));
    }

    /**
     * Group create.
     *
     * @return View
     */
    public function getCreate()
    {
        $group = new \App\Models\Group;
        // Get all the available permissions
        $permissions = config('permissions');


        $selectedPermissions = Input::old('permissions', array());

        // Show the page
        return View::make('groups/edit', compact('permissions', 'selectedPermissions'))->with('group', $group);
    }

    /**
     * Group create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {
        // create a new group instance
        $group = new \App\Models\Group();
        // Update the consumable data
        $group->name = e(Input::get('name'));

        // Was the consumable created?
        if ($group->save()) {
            // Redirect to the new consumable  page
            return Redirect::to("admin/groups")->with('success', Lang::get('admin/groups/message.create.success'));
        }

        return Redirect::back()->withInput()->withErrors($group->getErrors());


    }

    /**
     * Group update.
     *
     * @param  int  $id
     * @return View
     */
    public function getEdit($id = null)
    {
        $group = \App\Models\Group::find($id);
        $group->name = e(Input::get('name'));
        $group->permissions = json_decode($group->permissions, true);
        $permissions = config('permissions');

      // Show the page
        return View::make('groups/edit', compact('group', 'permissions','allpermissions'));
    }

    /**
     * Group update form processing page.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function postEdit($id = null)
    {

        if (!$group = \App\Models\Group::find($id)) {
            return Redirect::route('groups')->with('error', Lang::get('admin/groups/message.group_not_found', compact('id')));

        }
        $group->name = e(Input::get('name'));

        if (!config('app.lock_passwords')) {

          // Was the consumable created?
            if ($group->save()) {
              // Redirect to the new consumable  page
                return Redirect::to("admin/groups")->with('success', Lang::get('admin/groups/message.create.success'));
            }
            return Redirect::back()->withInput()->withErrors($group->getErrors());

        } else {
            return Redirect::route('update/group', $id)->withInput()->with('error', 'Denied! Editing groups is not allowed in the demo.');
        }

    }

    /**
     * Delete the given group.
     *
     * @param  int  $id
     * @return Redirect
     */
    public function getDelete($id = null)
    {
        if (!config('app.lock_passwords')) {
            try {
                // Get group information
                $group = Sentry::getGroupProvider()->findById($id);

                // Delete the group
                $group->delete();

                // Redirect to the group management page
                return Redirect::route('groups')->with('success', Lang::get('admin/groups/message.success.delete'));
            } catch (GroupNotFoundException $e) {
                // Redirect to the group management page
                return Redirect::route('groups')->with('error', Lang::get('admin/groups/message.group_not_found', compact('id')));
            }
        } else {
            return Redirect::route('groups')->with('error', Lang::get('general.feature_disabled'));
        }
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

        // Grab all the groups
        $groups = \App\Models\Group::with('users')->orderBy('name', 'ASC');
        //$users = Company::scopeCompanyables($users);

        if (Input::has('search')) {
            $groups = $users->TextSearch(e(Input::get('search')));
        }

         $order = Input::get('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns =
         [
           'name','created_at'
         ];

        $sort = in_array($sort, $allowed_columns) ? $sort : 'name';
        $groups = $groups->orderBy($sort, $order);

        $groupsCount = $groups->count();
        $groups = $groups->skip($offset)->take($limit)->get();
        $rows = array();

        foreach ($groups as $group) {
            $group_names = '';
            $inout = '';
            $actions = '<nobr>';

            $actions .= '<a href="' . route('update/group', $group->id) . '" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> ';

            if (!config('app.lock_passwords')) {
                  $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="' . route('delete/group', $group->id) . '" data-content="'.Lang::get('admin/groups/message.delete.confirm').'" data-title="Delete ' . htmlspecialchars($group->name) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a> ';
            } else {
                $actions .= ' <span class="btn delete-asset btn-danger btn-sm disabled"><i class="fa fa-trash icon-white"></i></span>';
            }

            $actions .= '</nobr>';

            $rows[] = array(
                'id'         => $group->id,
                'name'        => $group->name,
                'users'         => $group->users->count(),
                'created_at'        => $group->created_at->format('Y-m-d'),
                'actions'       => ($actions) ? $actions : '',
            );
        }

        $data = array('total'=>$groupsCount, 'rows'=>$rows);
        return $data;
    }
}
