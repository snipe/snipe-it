<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Location;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;

use Symfony\Component\HttpFoundation\JsonResponse;

class LocationsController extends AdminController
{
    /**
     * Show a list of all the locations.
     *
     * @return View
     */

    public function getIndex()
    {
        // Grab all the locations
        $locations = Location::orderBy('created_at', 'DESC')->with('parent','assets','assignedassets')->get();

        // Show the page
        return View::make('backend/locations/index', compact('locations'));
    }


    /**
     * Location create.
     *
     * @return View
     */
    public function getCreate()
    {
        $locations = Location::orderBy('name','ASC')->get();

        $location_options_array = Location::getLocationHierarchy($locations);
        $location_options = Location::flattenLocationsArray($location_options_array);
        $location_options = array('' => 'Top Level') + $location_options;

        return View::make('backend/locations/edit')
        ->with('location_options',$location_options)
        ->with('location',new Location);
    }


    /**
     * Location create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // create a new location instance
        $location = new Location();

        // attempt validation
        if ($location->validate($new)) {

            // Save the location data
            $location->name            	= e(Input::get('name'));
            if (Input::get('parent_id')=='') {
                $location->parent_id		= null;
            } else {
                $location->parent_id		= e(Input::get('parent_id'));
            }
            $location->currency			= e(Input::get('currency','$'));
            $location->address			= e(Input::get('address'));
            $location->address2			= e(Input::get('address2'));
            $location->city    			= e(Input::get('city'));
            $location->state    		= e(Input::get('state'));
            $location->country    		= e(Input::get('country'));
            $location->zip    			= e(Input::get('zip'));
            $location->user_id          = Sentry::getId();

            // Was the asset created?
            if($location->save()) {
                // Redirect to the new location  page
                return Redirect::to("admin/settings/locations")->with('success', Lang::get('admin/locations/message.create.success'));
            }
        } else {
            // failure
            $errors = $location->errors();
            return Redirect::back()->withInput()->withErrors($errors);
        }

        // Redirect to the location create page
        return Redirect::to('admin/settings/locations/create')->with('error', Lang::get('admin/locations/message.create.error'));

    }

    public function store()
    {
      $new = Input::all();

      $new['currency']=Setting::first()->default_currency;

      // create a new location instance
      $location = new Location();

      // attempt validation
      if ($location->validate($new)) {

          // Save the location data
          $location->name            	= e(Input::get('name'));
          // if (Input::get('parent_id')=='') {
          //     $location->parent_id		= null;
          // } else {
          //     $location->parent_id		= e(Input::get('parent_id'));
          // }
          $location->currency			=  Setting::first()->default_currency; //e(Input::get('currency'));
          $location->address			= ''; //e(Input::get('address'));
          // $location->address2			= e(Input::get('address2'));
          $location->city    			= e(Input::get('city'));
          $location->state    		= '';//e(Input::get('state'));
          $location->country    		= e(Input::get('country'));
          // $location->zip    			= e(Input::get('zip'));
          $location->user_id          = Sentry::getId();

          // Was the asset created?
          if($location->save()) {
              // Redirect to the new location  page
              return JsonResponse::create($location);
              //return Redirect::to("admin/settings/locations")->with('success', Lang::get('admin/locations/message.create.success'));
          } else {
            return JsonResponse::create(["error" => "Couldn't save Location"],500);
          }
      } else {
          // failure
          $errors = $location->errors();
          return JsonResponse::create(["error" => "Failed validation: ".print_r($errors->all('<li>:message</li>'),true)],500);
      }

      // Redirect to the location create page
      /** @noinspection PhpUnreachableStatementInspection Known to be unreachable but kept following discussion: https://github.com/snipe/snipe-it/pull/1423 */
      return Redirect::to('admin/settings/locations/create')->with('error', Lang::get('admin/locations/message.create.error'));
    }


    /**
     * Location update.
     *
     * @param  int  $locationId
     * @return View
     */
    public function getEdit($locationId = null)
    {
        // Check if the location exists
        if (is_null($location = Location::find($locationId))) {
            return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.does_not_exist'));
        }

        // Show the page
        $locations = Location::orderBy('name','ASC')->get();
        $location_options_array = Location::getLocationHierarchy($locations);
        $location_options = Location::flattenLocationsArray($location_options_array);
        $location_options = array('' => 'Top Level') + $location_options;

        return View::make('backend/locations/edit', compact('location'))->with('location_options',$location_options);
    }


    /**
     * Location update form processing page.
     *
     * @param  int  $locationId
     * @return Redirect
     */
    public function postEdit($locationId = null)
    {
        // Check if the location exists
        if (is_null($location = Location::find($locationId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.does_not_exist'));
        }

        //attempt to validate
        $validator = Validator::make(Input::all(), $location->validationRules($locationId));

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

            // Update the location data
            $location->name         = e(Input::get('name'));
            if (Input::get('parent_id')=='') {
                $location->parent_id		= null;
            } else {
                $location->parent_id		= e(Input::get('parent_id',''));
            }
            $location->currency			= e(Input::get('currency','$'));
            $location->address			= e(Input::get('address'));
            $location->address2			= e(Input::get('address2'));
            $location->city    			= e(Input::get('city'));
            $location->state    		= e(Input::get('state'));
            $location->country    	= e(Input::get('country'));
            $location->zip    		  = e(Input::get('zip'));

            // Was the asset created?
            if($location->save()) {
                // Redirect to the saved location page
                return Redirect::to("admin/settings/locations/")->with('success', Lang::get('admin/locations/message.update.success'));
            }
        }

        // Redirect to the location management page
        return Redirect::to("admin/settings/locations/$locationId/edit")->with('error', Lang::get('admin/locations/message.update.error'));

    }

    /**
     * Delete the given location.
     *
     * @param  int  $locationId
     * @return Redirect
     */
    public function getDelete($locationId)
    {
        // Check if the location exists
        if (is_null($location = Location::find($locationId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.not_found'));
        }


        if ($location->users->count() > 0) {
            return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.assoc_users'));
        } elseif ($location->childLocations->count() > 0) {
            return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.assoc_child_loc'));
        } elseif ($location->assets->count() > 0) {
            return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.assoc_assets'));
        } elseif ($location->assignedassets->count() > 0) {
            return Redirect::to('admin/settings/locations')->with('error', Lang::get('admin/locations/message.assoc_assets'));
        } else {
            $location->delete();
            return Redirect::to('admin/settings/locations')->with('success', Lang::get('admin/locations/message.delete.success'));
        }



    }


    /**
    *  Get the location page detail page
    *
    * @param  int  $locationID
    * @return View
    **/
    public function getView($locationId = null)
    {
        $location = Location::find($locationId);

        if (isset($location->id)) {
                return View::make('backend/locations/view', compact('location'));
        } else {
            // Prepare the error message
            $error = Lang::get('admin/locations/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('locations')->with('error', $error);
        }


    }


    /**
    *  Get the locations API information to present to the location view page
    *
    * @param  int  $locationID
    * @return JSON
    **/
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



        switch (Input::get('sort'))
        {
            case 'parent':
              $locations = $locations->OrderParent($order);
              break;
            default:
              $allowed_columns = ['id','name','address','city','state','country','currency'];

              $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
              $locations = $locations->orderBy($sort, $order);
            break;
        }


        $locationsCount = $locations->count();
        $locations = $locations->skip($offset)->take($limit)->get();

        $rows = array();

        foreach($locations as $location) {
            $actions = '<nobr><a href="'.route('update/location', $location->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/location', $location->id).'" data-content="'.Lang::get('admin/locations/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($location->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></nobr>';

            $rows[] = array(
                'id'            => $location->id,
                'name'          => link_to('admin/settings/locations/'.$location->id.'/view', $location->name),
                'parent'        => ($location->parent) ? $location->parent->name : '',
              //  'assets'        => ($location->assets->count() + $location->assignedassets->count()),
                'assets_default' => $location->assignedassets->count(),
                'assets_checkedout' => $location->assets->count(),
                'address'       => ($location->address) ? $location->address: '',
                'city'          => $location->city,
                'state'         => $location->state,
                'country'       => $location->country,
                'currency'      => $location->currency,
                'actions'       => $actions
            );
        }

        $data = array('total' => $locationsCount, 'rows' => $rows);

        return $data;

    }


    /**
    *  Get the location user listing information to present to the location details page
    *
    * @param  int  $locationID
    * @return JSON
    **/
    public function getDataViewUsers($locationID)
  	{
  		$location = Location::find($locationID);
      $location_users = $location->users;
      $count = $location_users->count();

      $rows = array();

      foreach ($location_users as $user) {
          $rows[] = array(
              'name' => link_to('/admin/users/'.$user->id.'/view', $user->fullName())
              );
      }

      $data = array('total' => $count, 'rows' => $rows);

      return $data;
  }


  /**
  *  Get the location asset information to present to the location details page
  *
  * @param  int  $locationID
  * @return JSON
  **/
  public function getDataViewAssets($locationID)
  {
    $location = Location::find($locationID);
    $count = $location->assets->count();

    $rows = array();

    foreach ($location->assets as $asset) {
        $rows[] = array(
          'name' => link_to('/hardware/'.$asset->id.'/view', $asset->showAssetName()),
          'asset_tag' => $asset->asset_tag,
          'serial' => $asset->serial,
          'model' => $asset->model->name,

        );
    }

    $data = array('total' => $count, 'rows' => $rows);
    return $data;

  }


}
