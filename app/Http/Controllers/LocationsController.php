<?php
namespace App\Http\Controllers;

use Input;
use Lang;
use App\Models\Location;
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
    * @return View
    */
    public function getIndex()
    {
        // Grab all the locations
        $locations = Location::orderBy('created_at', 'DESC')->with('parent', 'assets', 'assignedassets')->get();

        // Show the page
        return View::make('locations/index', compact('locations'));
    }


    /**
    * Returns a form view used to create a new location.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::postCreate() method that validates and stores the data
    * @since [v1.0]
    * @return View
    */
    public function getCreate()
    {
        $locations = Location::orderBy('name', 'ASC')->get();

        $location_options_array = Location::getLocationHierarchy($locations);
        $location_options = Location::flattenLocationsArray($location_options_array);
        $location_options = array('' => 'Top Level') + $location_options;

        return View::make('locations/edit')
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
    * @return Redirect
    */
    public function postCreate()
    {

    // create a new location instance
        $location = new Location();


    // Save the location data
        $location->name             = e(Input::get('name'));
        if (Input::get('parent_id')=='') {
            $location->parent_id        = null;
        } else {
            $location->parent_id        = e(Input::get('parent_id'));
        }
        $location->currency             = e(Input::get('currency', '$'));
        $location->address          = e(Input::get('address'));
        $location->address2             = e(Input::get('address2'));
        $location->city             = e(Input::get('city'));
        $location->state            = e(Input::get('state'));
        $location->country          = e(Input::get('country'));
        $location->zip              = e(Input::get('zip'));
        $location->user_id          = Auth::user()->id;

        if ($location->save()) {
            // Redirect to the new location  page
            return redirect()->to("admin/settings/locations")->with('success', trans('admin/locations/message.create.success'));
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
    public function store()
    {

        $new['currency']=Setting::first()->default_currency;

        // create a new location instance
        $location = new Location();

        // Save the location data
        $location->name               = e(Input::get('name'));
        $location->currency           =  Setting::first()->default_currency; //e(Input::get('currency'));
        $location->address            = ''; //e(Input::get('address'));
        // $location->address2			= e(Input::get('address2'));
        $location->city               = e(Input::get('city'));
        $location->state          = '';//e(Input::get('state'));
        $location->country            = e(Input::get('country'));
        // $location->zip    			= e(Input::get('zip'));
        $location->user_id          = Auth::user()->id;

        // Was the location created?
        if ($location->save()) {
            return JsonResponse::create($location);

        }

        // failure
        $errors = $location->errors();
        return JsonResponse::create(["error" => "Failed validation: ".print_r($location->getErrors(), true)], 500);

    }


    /**
    * Makes a form view to edit location information.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::postCreate() method that validates and stores
    * @param int $locationId
    * @since [v1.0]
    * @return View
    */
    public function getEdit($locationId = null)
    {
        // Check if the location exists
        if (is_null($item = Location::find($locationId))) {
            return redirect()->to('admin/settings/locations')->with('error', trans('admin/locations/message.does_not_exist'));
        }

        // Show the page
        $locations = Location::orderBy('name', 'ASC')->get();
        $location_options_array = Location::getLocationHierarchy($locations);
        $location_options = Location::flattenLocationsArray($location_options_array);
        $location_options = array('' => 'Top Level') + $location_options;

        return View::make('locations/edit', compact('item'))->with('location_options', $location_options);
    }


    /**
    * Validates and stores updated location data from edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::getEdit() method that makes the form view
    * @param int $locationId
    * @since [v1.0]
    * @return Redirect
    */
    public function postEdit($locationId = null)
    {
        // Check if the location exists
        if (is_null($location = Location::find($locationId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/locations')->with('error', trans('admin/locations/message.does_not_exist'));
        }

        // Update the location data
        $location->name         = e(Input::get('name'));
        if (Input::get('parent_id')=='') {
            $location->parent_id        = null;
        } else {
            $location->parent_id        = e(Input::get('parent_id', ''));
        }
        $location->currency             = e(Input::get('currency', '$'));
        $location->address          = e(Input::get('address'));
        $location->address2             = e(Input::get('address2'));
        $location->city             = e(Input::get('city'));
        $location->state            = e(Input::get('state'));
        $location->country      = e(Input::get('country'));
        $location->zip            = e(Input::get('zip'));

        // Was the asset created?
        if ($location->save()) {
          // Redirect to the saved location page
            return redirect()->to("admin/settings/locations/")->with('success', trans('admin/locations/message.update.success'));
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
    * @return Redirect
    */
    public function getDelete($locationId)
    {
        // Check if the location exists
        if (is_null($location = Location::find($locationId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/locations')->with('error', trans('admin/locations/message.not_found'));
        }


        if ($location->users->count() > 0) {
            return redirect()->to('admin/settings/locations')->with('error', trans('admin/locations/message.assoc_users'));
        } elseif ($location->childLocations->count() > 0) {
            return redirect()->to('admin/settings/locations')->with('error', trans('admin/locations/message.assoc_child_loc'));
        } elseif ($location->assets->count() > 0) {
            return redirect()->to('admin/settings/locations')->with('error', trans('admin/locations/message.assoc_assets'));
        } elseif ($location->assignedassets->count() > 0) {
            return redirect()->to('admin/settings/locations')->with('error', trans('admin/locations/message.assoc_assets'));
        } else {
            $location->delete();
            return redirect()->to('admin/settings/locations')->with('success', trans('admin/locations/message.delete.success'));
        }



    }


    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the locations detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::getDataViewUsers() method that returns JSON for location users
    * @see LocationsController::getDataViewAssets() method that returns JSON for location assets
    * @param int $locationId
    * @since [v1.0]
    * @return View
    */
    public function getView($locationId = null)
    {
        $location = Location::find($locationId);

        if (isset($location->id)) {
                return View::make('locations/view', compact('location'));
        } else {
            // Prepare the error message
            $error = trans('admin/locations/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('locations')->with('error', $error);
        }


    }


    /**
    * Returns the JSON response to populate the bootstrap tables on the locationa view.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::getIndex() method that returns JSON for location index
    * @since [v1.0]
    * @return View
    */
    public function getDatatable()
    {
        $locations = Location::select(array('locations.id','locations.name','locations.address','locations.address2','locations.city','locations.state','locations.zip','locations.country','locations.parent_id','locations.currency'))->with('assets');


        if (Input::has('search')) {
            $locations = $locations->TextSearch(e(Input::get('search')));
        }

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

        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';



        switch (Input::get('sort')) {
            case 'parent':
                $locations = $locations->OrderParent($order);
                break;
            default:
                $allowed_columns = ['id','name','address','city','state','country','currency','zip'];

                $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
                $locations = $locations->orderBy($sort, $order);
                break;
        }


        $locationsCount = $locations->count();
        $locations = $locations->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($locations as $location) {
            $actions = '<nobr><a href="'.route('update/location', $location->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/location', $location->id).'" data-content="'.trans('admin/locations/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($location->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></nobr>';

            $rows[] = array(
                'id'            => $location->id,
                'name'          => (string)link_to('admin/settings/locations/'.$location->id.'/view', e($location->name)),
                'parent'        => ($location->parent) ? e($location->parent->name) : '',
              //  'assets'        => ($location->assets->count() + $location->assignedassets->count()),
                'assets_default' => $location->assignedassets->count(),
                'assets_checkedout' => $location->assets->count(),
                'address'       => ($location->address) ? e($location->address): '',
                'city'          => e($location->city),
                'state'         => e($location->state),
                'zip'           => e($location->zip),
                'country'       => e($location->country),
                'currency'      => e($location->currency),
                'actions'       => $actions
            );
        }

        $data = array('total' => $locationsCount, 'rows' => $rows);

        return $data;

    }


    /**
    * Returns a JSON response that contains the users association with the
    * selected location, to be used by the location detail view.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::getView() method that creates the display view
    * @param int $locationId
    * @since [v1.8]
    * @return View
    */
    public function getDataViewUsers($locationID)
    {
        $location = Location::find($locationID);
        $users = User::where('location_id', '=', $location->id);

        if (Input::has('search')) {
            $users = $users->TextSearch(e(Input::get('search')));
        }

        $users = $users->get();
        $rows = array();

        foreach ($users as $user) {
            $rows[] = array(
              'name' => (string)link_to('/admin/users/'.$user->id.'/view', e($user->fullName()))
              );
        }

        $data = array('total' => $users->count(), 'rows' => $rows);

        return $data;
    }


    /**
    * Returns a JSON response that contains the assets association with the
    * selected location, to be used by the location detail view.
    *
    * @todo This is broken for accessories and consumables.
    * @todo This is a very naive implementation. Should clean this up with query scopes.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LocationsController::getView() method that creates the display view
    * @param int $locationID
    * @since [v1.8]
    * @return View
    */
    public function getDataViewAssets($locationID)
    {
        $location = Location::find($locationID)->load('assignedassets.model');
        $assets = Asset::AssetsByLocation($location);

        if (Input::has('search')) {
            $assets = $assets->TextSearch(e(Input::get('search')));
        }

        $assets = $assets->get();

        $rows = array();

        foreach ($assets as $asset) {
            $rows[] = array(
            'name' => (string)link_to(config('app.url').'/hardware/'.$asset->id.'/view', e($asset->showAssetName())),
            'asset_tag' => e($asset->asset_tag),
            'serial' => e($asset->serial),
            'model' => e($asset->model->name),
            );
        }

        $data = array('total' => $assets->count(), 'rows' => $rows);
        return $data;

    }
}
