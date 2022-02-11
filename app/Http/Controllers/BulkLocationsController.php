<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class BulkLocationsController extends Controller
{
    /**
     * Display the bulk edit page.
     *
     * @author [T. Regnery] [<tobias.regnery@gmail.com>]
     * @return View
     * @internal param int $locationId
     * @since [v6.0]
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request)
    {
        $this->authorize('update', Location::class);

        if (!$request->filled('ids')) {
            return redirect()->back()->with('error', 'You must select at least one location to edit.');
        }

        $location_ids = array_values(array_unique($request->input('ids')));

        if ($request->input('bulk_actions') == 'edit') {
            return view('locations/bulk-edit')
                ->with('locations', $location_ids);
        }
    }

    /**
     * Save bulk-edited locations
     *
     * @author [T.Regnery] [<tobias.regnery@gmail.com>]
     * @since [v6.0]
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        $this->authorize('update', Location::class);

        if(!$request->filled('ids') || count($request->input('ids')) <= 0) {
            return redirect()->route("locations.index")->with('warning', trans('No location selected, so nothing was updated.'));
        }

        $location_ids = array_keys($request->input('ids'));
        $parent_conflict = false;

        $return_array = [
            'success' => trans('admin/locations/message.update.success')
        ];

        $this->conditionallyAddItem('manager_id')
            ->conditionallyAddItem('company_id');

        // If the parent_id is one of the locations being updated, generate a warning.
        if (array_search($request->input('parent_id'), $location_ids)) {
            $parent_conflict = true;
            $return_array = [
                'warning' => trans('admin/locations/message.bulk_parent_warn')
            ];
        }
        if (!$parent_conflict) {
            $this->conditionallyAddItem('parent_id');
        }

        // Save the updated info
        Location::whereIn('id', $location_ids)->update($this->update_array);

        return redirect()->route("locations.index")->with($return_array);
    }

    /**
     * Array to store update data per item
     * @var Array
     */
    private $update_array = [];

    /**
     * Adds parameter to update array for an item if it exists in request
     * @param  String $field field name
     * @return BulkUsersController Model for Chaining
     */
    protected function conditionallyAddItem($field)
    {
        if(request()->filled($field)) {
            $this->update_array[$field] = request()->input($field);
        }
        return $this;
    }
}
