<?php namespace Controllers\Admin;

use AdminController;
use Company;
use Input;
use Lang;
use Manufacturer;
use Redirect;
use Setting;
use Sentry;
use Str;
use Validator;
use View;

class ManufacturersController extends AdminController
{
    /**
     * Show a list of all manufacturers
     *
     * @return View
     */
    public function getIndex()
    {
        // Show the page
        return View::make('backend/manufacturers/index', compact('manufacturers'));
    }


    /**
     * Manufacturer create.
     *
     * @return View
     */
    public function getCreate()
    {
        return View::make('backend/manufacturers/edit')->with('manufacturer', new Manufacturer);
    }


    /**
     * Manufacturer create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // Create a new manufacturer
        $manufacturer = new Manufacturer;

        // attempt validation
        if ($manufacturer->validate($new)) {

            // Save the location data
            $manufacturer->name            = e(Input::get('name'));
            $manufacturer->user_id          = Sentry::getId();

            // Was it created?
            if($manufacturer->save()) {
                // Redirect to the new manufacturer  page
                return Redirect::to("admin/settings/manufacturers")->with('success', Lang::get('admin/manufacturers/message.create.success'));
            }
        } else {
            // failure
            $errors = $manufacturer->errors();
            return Redirect::back()->withInput()->withErrors($errors);
        }

        // Redirect to the manufacturer create page
        return Redirect::to('admin/settings/manufacturers/create')->with('error', Lang::get('admin/manufacturers/message.create.error'));

    }

    /**
     * Manufacturer update.
     *
     * @param  int  $manufacturerId
     * @return View
     */
    public function getEdit($manufacturerId = null)
    {
        // Check if the manufacturer exists
        if (is_null($manufacturer = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturer  page
            return Redirect::to('admin/settings/manufacturers')->with('error', Lang::get('admin/manufacturers/message.does_not_exist'));
        }

        // Show the page
        return View::make('backend/manufacturers/edit', compact('manufacturer'));
    }


    /**
     * Manufacturer update form processing page.
     *
     * @param  int  $manufacturerId
     * @return Redirect
     */
    public function postEdit($manufacturerId = null)
    {
        // Check if the manufacturer exists
        if (is_null($manufacturer = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturer  page
            return Redirect::to('admin/settings/manufacturers')->with('error', Lang::get('admin/manufacturers/message.does_not_exist'));
        }

        $validator = Validator::make(Input::all(), $manufacturer->validationRules($manufacturerId));

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {
            // Save the  data
            $manufacturer->name 	= e(Input::get('name'));

            // Was it created?
            if($manufacturer->save()) {
                // Redirect to the new manufacturer page
                return Redirect::to("admin/settings/manufacturers")->with('success', Lang::get('admin/manufacturers/message.update.success'));
            }
        }

        // Redirect to the manufacturer management page
        return Redirect::to("admin/settings/manufacturers/$manufacturerId/edit")->with('error', Lang::get('admin/manufacturers/message.update.error'));

    }

    /**
     * Delete the given manufacturer.
     *
     * @param  int  $manufacturerId
     * @return Redirect
     */
    public function getDelete($manufacturerId)
    {
        // Check if the manufacturer exists
        if (is_null($manufacturer = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturers page
            return Redirect::to('admin/settings/manufacturers')->with('error', Lang::get('admin/manufacturers/message.not_found'));
        }

        if ($manufacturer->has_models() > 0) {

            // Redirect to the asset management page
            return Redirect::to('admin/settings/manufacturers')->with('error', Lang::get('admin/manufacturers/message.assoc_users'));
        } else {

            // Delete the manufacturer
            $manufacturer->delete();

            // Redirect to the manufacturers management page
        return Redirect::to('admin/settings/manufacturers')->with('success', Lang::get('admin/manufacturers/message.delete.success'));
        }






    }



    /**
    *  Get the asset information to present to the category view page
    *
    * @param  int  $assetId
    * @return View
    **/
    public function getView($manufacturerID = null)
    {
        $manufacturer = Manufacturer::find($manufacturerID);

        if (isset($manufacturer->id)) {
                return View::make('backend/manufacturers/view', compact('manufacturer'));
        } else {
            // Prepare the error message
            $error = Lang::get('admin/manufacturers/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('manufacturers')->with('error', $error);
        }


    }

    public function getDatatable()
    {
        $manufacturers = Manufacturer::select(array('id','name'))->with('assets')
        ->whereNull('deleted_at');

        if (Input::has('search')) {
            $manufacturers = $manufacturers->TextSearch(e(Input::get('search')));
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

        $allowed_columns = ['id','name'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

        $manufacturers->orderBy($sort, $order);

        $manufacturersCount = $manufacturers->count();
        $manufacturers = $manufacturers->skip($offset)->take($limit)->get();

        $rows = array();

        foreach($manufacturers as $manufacturer) {
            $actions = '<a href="'.route('update/manufacturer', $manufacturer->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/manufacturer', $manufacturer->id).'" data-content="'.Lang::get('admin/manufacturers/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($manufacturer->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

            $rows[] = array(
                'id'              => $manufacturer->id,
                'name'          => link_to('admin/settings/manufacturers/'.$manufacturer->id.'/view', $manufacturer->name),
                'assets'              => $manufacturer->assetscount(),
                'actions'       => $actions
            );
        }

        $data = array('total' => $manufacturersCount, 'rows' => $rows);

        return $data;

    }



    public function getDataView($manufacturerID) {

      $manufacturer = Manufacturer::with('assets.company')->find($manufacturerID);
      $manufacturer_assets = $manufacturer->assets;

      if (Input::has('search')) {
          $manufacturer_assets = $manufacturer_assets->TextSearch(e(Input::get('search')));
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

      $allowed_columns = ['id','name','serial','asset_tag'];
      $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
      $count = $manufacturer_assets->count();

      $rows = array();

      foreach ($manufacturer_assets as $asset) {

        $actions = '';
        if ($asset->deleted_at=='') {
            $actions = '<div style=" white-space: nowrap;"><a href="'.route('clone/hardware', $asset->id).'" class="btn btn-info btn-sm" title="Clone asset"><i class="fa fa-files-o"></i></a> <a href="'.route('update/hardware', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> <a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/hardware', $asset->id).'" data-content="'.Lang::get('admin/hardware/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($asset->asset_tag).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></div>';
        } elseif ($asset->deleted_at!='') {
            $actions = '<a href="'.route('restore/hardware', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle icon-white"></i></a>';
        }

        if ($asset->assetstatus) {
            if ($asset->assetstatus->deployable != 0) {
                if (($asset->assigned_to !='') && ($asset->assigned_to > 0)) {
                    $inout = '<a href="'.route('checkin/hardware', $asset->id).'" class="btn btn-primary btn-sm">'.Lang::get('general.checkin').'</a>';
                } else {
                    $inout = '<a href="'.route('checkout/hardware', $asset->id).'" class="btn btn-info btn-sm">'.Lang::get('general.checkout').'</a>';
                }
            }
        }

        $row = array(
          'id' => $asset->id,
          'name' => link_to('/hardware/'.$asset->id.'/view', $asset->showAssetName()),
          'model' => $asset->model->name,
          'asset_tag' => $asset->asset_tag,
          'serial' => $asset->serial,
          'assigned_to' => ($asset->assigneduser) ? link_to('/admin/users/'.$asset->assigneduser->id.'/view', $asset->assigneduser->fullName()): '',
          'actions' => $actions,
          'companyName' => Company::getName($asset),
        );

        if (isset($inout)) { $row['change'] = $inout; }

        $rows[] = $row;
      }

      $data = array('total' => $count, 'rows' => $rows);
      return $data;
    }


}
