<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use Input;
use Lang;
use App\Models\Location;
use phpDocumentor\Reflection\Types\Array_;
use Redirect;
use App\Models\Setting;
use App\Models\User;
use App\Models\Asset;
use DB;
use Str;
use Validator;
use View;
use Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Image;
use App\Http\Requests\ImageUploadRequest;

/**
 * This controller handles all actions related to Locations for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class LocationsController extends Controller
{

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the locations listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Grab all the locations
        $this->authorize('view', Location::class);
        $locations = Location::orderBy('created_at', 'DESC')->with('parent', 'assets', 'assignedassets')->get();

        // Show the page
        return view('locations/index', compact('locations'));
    }


    /**
    * Returns a form view used to create a new location.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::postCreate() method that validates and stores the data
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Location::class);
        $locations = Location::orderBy('name', 'ASC')->get();

        $location_options_array = Location::getLocationHierarchy($locations);
        $location_options = Location::flattenLocationsArray($location_options_array);
        $location_options = array('' => 'Top Level') + $location_options;

        return view('locations/edit')
            ->with('location_options', $location_options)
            ->with('item', new Location);
    }


    /**
    * Validates and stores a new location.
    *
    * @todo Check if a Form Request would work better here.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::getCreate() method that makes the form
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Location::class);
        $location = new Location();
        $location->name             = $request->input('name');
        $location->parent_id        = $request->input('parent_id', null);
        $location->currency         = $request->input('currency', '$');
        $location->address          = $request->input('address');
        $location->address2         = $request->input('address2');
        $location->city             = $request->input('city');
        $location->state            = $request->input('state');
        $location->country          = $request->input('country');
        $location->zip              = $request->input('zip');
        $location->ldap_ou          = $request->input('ldap_ou');
        $location->manager_id       = $request->input('manager_id');
        $location->user_id          = Auth::id();

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/locations/'.$file_name);
            Image::make($image->getRealPath())->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $location->image = $file_name;
        }

        if ($location->save()) {
            return redirect()->route("locations.index")->with('success', trans('admin/locations/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($location->getErrors());
    }


    /**
    * Makes a form view to edit location information.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::postCreate() method that validates and stores
    * @param int $locationId
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function edit($locationId = null)
    {
        $this->authorize('update', Location::class);
        // Check if the location exists
        if (is_null($item = Location::find($locationId))) {
            return redirect()->route('locations.index')->with('error', trans('admin/locations/message.does_not_exist'));
        }

        // Show the page
        $locations = Location::orderBy('name', 'ASC')->get();
        $location_options_array = Location::getLocationHierarchy($locations);
        $location_options = Location::flattenLocationsArray($location_options_array);
        $location_options = array('' => 'Top Level') + $location_options;

        return view('locations/edit', compact('item'))
            ->with('location_options', $location_options);
    }


    /**
    * Validates and stores updated location data from edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::getEdit() method that makes the form view
    * @param int $locationId
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ImageUploadRequest $request, $locationId = null)
    {
        $this->authorize('update', Location::class);
        // Check if the location exists
        if (is_null($location = Location::find($locationId))) {
            return redirect()->route('locations.index')->with('error', trans('admin/locations/message.does_not_exist'));
        }

        // Update the location data
        $location->name         = $request->input('name');
        $location->parent_id    = $request->input('parent_id', null);
        $location->currency     = $request->input('currency', '$');
        $location->address      = $request->input('address');
        $location->address2     = $request->input('address2');
        $location->city         = $request->input('city');
        $location->state        = $request->input('state');
        $location->country      = $request->input('country');
        $location->zip          = $request->input('zip');
        $location->ldap_ou      = $request->input('ldap_ou');
        $location->manager_id   = $request->input('manager_id');

        $old_image = $location->image;

        // Set the model's image property to null if the image is being deleted
        if ($request->input('image_delete') == 1) {
            $location->image = null;
        }

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = $location->id.'-'.str_slug($image->getClientOriginalName()) . "." . $image->getClientOriginalExtension();

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(app('locations_upload_path').$file_name);
            } else {
                $image->move(app('locations_upload_path'), $file_name);
            }
            $location->image = $file_name;

        }

        if ((($request->file('image')) && (isset($old_image)) && ($old_image!='')) || ($request->input('image_delete') == 1)) {
            try  {
                unlink(app('locations_upload_path').$old_image);
            } catch (\Exception $e) {
                \Log::error($e);
            }
        }


        if ($location->save()) {
            return redirect()->route("locations.index")->with('success', trans('admin/locations/message.update.success'));
        }
        return redirect()->back()->withInput()->withInput()->withErrors($location->getErrors());
    }

    /**
    * Validates and deletes selected location.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $locationId
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($locationId)
    {
        $this->authorize('delete', Location::class);
        if (is_null($location = Location::find($locationId))) {
            return redirect()->to(route('locations.index'))->with('error', trans('admin/locations/message.not_found'));
        }

        if ($location->users->count() > 0) {
            return redirect()->to(route('locations.index'))->with('error', trans('admin/locations/message.assoc_users'));

        } elseif ($location->childLocations->count() > 0) {
            return redirect()->to(route('locations.index'))->with('error', trans('admin/locations/message.assoc_child_loc'));

        } elseif ($location->assets->count() > 0) {
            return redirect()->to(route('locations.index'))->with('error', trans('admin/locations/message.assoc_assets'));

        } elseif ($location->assignedassets->count() > 0) {
            return redirect()->to(route('locations.index'))->with('error', trans('admin/locations/message.assoc_assets'));

        } else {
            $location->delete();
            return redirect()->to(route('locations.index'))->with('success', trans('admin/locations/message.delete.success'));
        }
    }


    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the locations detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $locationId
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($locationId = null)
    {
        $location = Location::find($locationId);

        if (isset($location->id)) {
            return view('locations/view', compact('location'));
        }

        return redirect()->route('locations.index')->with('error', trans('admin/locations/message.does_not_exist', compact('id')));
    }

}
