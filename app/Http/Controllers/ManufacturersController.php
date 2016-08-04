<?php
namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Manufacturer;
use App\Models\Setting;
use Auth;
use Illuminate\Support\Facades\Gate;
use Input;
use Lang;
use Redirect;
use Str;
use View;

/**
 * This controller handles all actions related to Manufacturers for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ManufacturersController extends Controller
{
    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the manufacturers listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return View
    */
    public function getIndex()
    {
        // Show the page
        return View::make('manufacturers/index', compact('manufacturers'));
    }


    /**
    * Returns a view that displays a form to create a new manufacturer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::postCreate()
    * @since [v1.0]
    * @return View
    */
    public function getCreate()
    {
        return View::make('manufacturers/edit')->with('manufacturer', new Manufacturer);
    }


    /**
    * Validates and stores the data for a new manufacturer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::postCreate()
    * @since [v1.0]
    * @return Redirect
    */
    public function postCreate()
    {
        $manufacturer = new Manufacturer;
        $manufacturer->name            = e(Input::get('name'));
        $manufacturer->user_id          = Auth::user()->id;

        if ($manufacturer->save()) {
            return redirect()->to("admin/settings/manufacturers")->with('success', trans('admin/manufacturers/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($manufacturer->getErrors());

    }

    /**
    * Returns a view that displays a form to edit a manufacturer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::postEdit()
    * @param int $manufacturerId
    * @since [v1.0]
    * @return View
    */
    public function getEdit($manufacturerId = null)
    {
        // Check if the manufacturer exists
        if (is_null($manufacturer = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturer  page
            return redirect()->to('admin/settings/manufacturers')->with('error', trans('admin/manufacturers/message.does_not_exist'));
        }

        // Show the page
        return View::make('manufacturers/edit', compact('manufacturer'));
    }


    /**
    * Validates and stores the updated manufacturer data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::getEdit()
    * @param int $manufacturerId
    * @since [v1.0]
    * @return View
    */
    public function postEdit($manufacturerId = null)
    {
        // Check if the manufacturer exists
        if (is_null($manufacturer = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturer  page
            return redirect()->to('admin/settings/manufacturers')->with('error', trans('admin/manufacturers/message.does_not_exist'));
        }

        // Save the  data
        $manufacturer->name     = e(Input::get('name'));

        // Was it created?
        if ($manufacturer->save()) {
            // Redirect to the new manufacturer page
            return redirect()->to("admin/settings/manufacturers")->with('success', trans('admin/manufacturers/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($manufacturer->getErrors());


    }

    /**
    * Deletes a manufacturer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $manufacturerId
    * @since [v1.0]
    * @return View
    */
    public function getDelete($manufacturerId)
    {
        // Check if the manufacturer exists
        if (is_null($manufacturer = Manufacturer::find($manufacturerId))) {
            // Redirect to the manufacturers page
            return redirect()->to('admin/settings/manufacturers')->with('error', trans('admin/manufacturers/message.not_found'));
        }

        if ($manufacturer->has_models() > 0) {

            // Redirect to the asset management page
            return redirect()->to('admin/settings/manufacturers')->with('error', trans('admin/manufacturers/message.assoc_users'));
        } else {

            // Delete the manufacturer
            $manufacturer->delete();

            // Redirect to the manufacturers management page
            return redirect()->to('admin/settings/manufacturers')->with('success', trans('admin/manufacturers/message.delete.success'));
        }

    }



    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the manufacturers detail listing, which is generated in getDatatable.
    * This data contains a listing of all assets that belong to that manufacturer.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::getDataView()
    * @param int $manufacturerId
    * @since [v1.0]
    * @return View
    */
    public function getView($manufacturerId = null)
    {
        $manufacturer = Manufacturer::find($manufacturerId);

        if (isset($manufacturer->id)) {
                return View::make('manufacturers/view', compact('manufacturer'));
        } else {
            // Prepare the error message
            $error = trans('admin/manufacturers/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('manufacturers')->with('error', $error);
        }


    }

    /**
    * Generates the JSON used to display the manufacturer listings.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::getIndex()
    * @since [v1.0]
    * @return String JSON
    */
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

        foreach ($manufacturers as $manufacturer) {
            $actions = '<a href="'.route('update/manufacturer', $manufacturer->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/manufacturer', $manufacturer->id).'" data-content="'.trans('admin/manufacturers/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($manufacturer->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

            $rows[] = array(
                'id'              => $manufacturer->id,
                'name'          => (string)link_to('admin/settings/manufacturers/'.$manufacturer->id.'/view', e($manufacturer->name)),
                'assets'              => $manufacturer->assets->count(),
                'actions'       => $actions
            );
        }

        $data = array('total' => $manufacturersCount, 'rows' => $rows);

        return $data;

    }


    /**
    * Generates the JSON used to display the manufacturer detail.
    * This JSON returns data on all of the assets with the specified
    * manufacturer ID number.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::getView()
    * @param int $manufacturerId
    * @since [v1.0]
    * @return String JSON
    */
    public function getDataView($manufacturerId)
    {

        $manufacturer = Manufacturer::with('assets.company')->find($manufacturerId);
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
                $actions = '<div style=" white-space: nowrap;"><a href="'.route('clone/hardware', $asset->id).'" class="btn btn-info btn-sm" title="Clone asset"><i class="fa fa-files-o"></i></a> <a href="'.route('update/hardware', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> <a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/hardware', $asset->id).'" data-content="'.trans('admin/hardware/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($asset->asset_tag).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></div>';
            } elseif ($asset->deleted_at!='') {
                $actions = '<a href="'.route('restore/hardware', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle icon-white"></i></a>';
            }

            if ($asset->availableForCheckout()) {
                if (Gate::allows('assets.checkout')) {
                    $inout = '<a href="'.route('checkout/hardware', $asset->id).'" class="btn btn-info btn-sm">'.trans('general.checkout').'</a>';
                }
            } else {
                if (Gate::allows('assets.checkin')) {
                    $inout = '<a href="'.route('checkin/hardware', $asset->id).'" class="btn btn-primary btn-sm">'.trans('general.checkin').'</a>';
                }
            }

            $row = array(
            'id' => $asset->id,
            'name' => (string)link_to('/hardware/'.$asset->id.'/view', e($asset->showAssetName())),
            'model' => e($asset->model->name),
            'asset_tag' => e($asset->asset_tag),
            'serial' => e($asset->serial),
            'assigned_to' => ($asset->assigneduser) ? (string)link_to('/admin/users/'.$asset->assigneduser->id.'/view', e($asset->assigneduser->fullName())): '',
            'actions' => $actions,
            'companyName' => e(Company::getName($asset)),
            );

            if (isset($inout)) {
                $row['change'] = $inout;
            }

            $rows[] = $row;
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }
}
