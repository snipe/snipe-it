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
        $locations = Location::orderBy('name', 'ASC')->get();

        $location_options_array = Location::getLocationHierarchy($locations);
        $location_options = Location::flattenLocationsArray($location_options_array);
        $location_options = array('' => 'Top Level') + $location_options;

        return view('locations/edit')
            ->with('location_options', $location_options)
            ->with('item', new Location)
            ->with('manager_list', Helper::managerList());
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
    public function store()
    {
        $location = new Location();
        $location->name             = Input::get('name');
        $location->parent_id        = Input::get('parent_id', null);
        $location->currency         = Input::get('currency', '$');
        $location->address          = Input::get('address');
        $location->address2         = Input::get('address2');
        $location->city             = Input::get('city');
        $location->state            = Input::get('state');
        $location->country          = Input::get('country');
        $location->zip              = Input::get('zip');
        $location->ldap_ou          = Input::get('ldap_ou');
        $location->manager_id       = Input::get('manager_id');
        $location->user_id          = Auth::id();

        if ($location->save()) {
            return redirect()->route("locations.index")->with('success', trans('admin/locations/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($location->getErrors());
    }

    /**
    * Validates and stores a new location created via the Create Asset form modal.
    *
    * @todo Check if a Form Request would work better here.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see AssetsController::getCreate() method that makes the form
    * @since [v1.0]
    * @return String JSON
    */
    public function apiStore()
    {
        $new['currency']=Setting::first()->default_currency;

        // create a new location instance
        $location = new Location();

        // Save the location data
        $location->name               = Input::get('name');
        $location->currency           =  Setting::first()->default_currency; //e(Input::get('currency'));
        $location->address            = ''; //e(Input::get('address'));
        // $location->address2			= e(Input::get('address2'));
        $location->city               = Input::get('city');
        $location->state          = '';//e(Input::get('state'));
        $location->country            = Input::get('country');
        // $location->zip    			= e(Input::get('zip'));
        $location->user_id          = Auth::id();

        // Was the location created?
        if ($location->save()) {
            return JsonResponse::create($location);
        }
        // failure
        return JsonResponse::create(["error" => "Failed validation: ".print_r($location->getErrors(), true)], 500);
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
            ->with('location_options', $location_options)
            ->with('manager_list', Helper::managerList());
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
    public function update($locationId = null)
    {
        // Check if the location exists
        if (is_null($location = Location::find($locationId))) {
            return redirect()->route('locations.index')->with('error', trans('admin/locations/message.does_not_exist'));
        }

        // Update the location data
        $location->name         = Input::get('name');
        $location->parent_id    = Input::get('parent_id', null);
        $location->currency     = Input::get('currency', '$');
        $location->address      = Input::get('address');
        $location->address2     = Input::get('address2');
        $location->city         = Input::get('city');
        $location->state        = Input::get('state');
        $location->country      = Input::get('country');
        $location->zip          = Input::get('zip');
        $location->ldap_ou      = Input::get('ldap_ou');
        $location->manager_id   = Input::get('manager_id');

        // Was the location updated?
        if ($location->save()) {
          // Redirect to the saved location page
            return redirect()->route("locations.index")->with('success', trans('admin/locations/message.update.success'));
        }
        // Redirect to the location management page
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
        // Check if the location exists
        if (is_null($location = Location::find($locationId))) {
            // Redirect to the blogs management page
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
        // Prepare the error message
        $error = trans('admin/locations/message.does_not_exist', compact('id'));

        // Redirect to the user management page
        return redirect()->route('locations.index')->with('error', $error);
    }

}
