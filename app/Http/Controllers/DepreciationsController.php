<?php
namespace App\Http\Controllers;

use Input;
use Lang;
use App\Models\Depreciation;
use Redirect;
use App\Models\Setting;
use DB;
use Str;
use View;
use Auth;

/**
 * This controller handles all actions related to Depreciations for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class DepreciationsController extends Controller
{
    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the depreciation listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see DepreciationsController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return View
    */
    public function getIndex()
    {
        // Show the page
        return View::make('depreciations/index', compact('depreciations'));
    }


    /**
    * Returns a view that displays a form to create a new depreciation.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see DepreciationsController::postCreate()
    * @since [v1.0]
    * @return View
    */
    public function getCreate()
    {
        // Show the page
        return View::make('depreciations/edit')->with('item', new Depreciation);
    }


    /**
    * Validates and stores the new depreciation data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see DepreciationsController::postCreate()
    * @since [v1.0]
    * @return Redirect
    */
    public function postCreate()
    {

      // get the POST data
        $new = Input::all();

      // create a new instance
        $depreciation = new Depreciation();

      // Depreciation data
        $depreciation->name            = e(Input::get('name'));
        $depreciation->months    = e(Input::get('months'));
        $depreciation->user_id          = Auth::user()->id;

      // Was the asset created?
        if ($depreciation->save()) {
            // Redirect to the new depreciation  page
            return redirect()->to("admin/settings/depreciations")->with('success', trans('admin/depreciations/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($depreciation->getErrors());

    }

    /**
    * Returns a view that displays a form to update a depreciation.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see DepreciationsController::postEdit()
    * @param int $depreciationId
    * @since [v1.0]
    * @return View
    */
    public function getEdit($depreciationId = null)
    {
        // Check if the depreciation exists
        if (is_null($item = Depreciation::find($depreciationId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/depreciations')->with('error', trans('admin/depreciations/message.does_not_exist'));
        }

        return View::make('depreciations/edit', compact('item'));
    }


    /**
    * Validates and stores the updated depreciation data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @see DepreciationsController::getEdit()
    * @param int $depreciationId
    * @since [v1.0]
    * @return Redirect
    */
    public function postEdit($depreciationId = null)
    {
        // Check if the depreciation exists
        if (is_null($depreciation = Depreciation::find($depreciationId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/depreciations')->with('error', trans('admin/depreciations/message.does_not_exist'));
        }

        // Depreciation data
        $depreciation->name      = e(Input::get('name'));
        $depreciation->months    = e(Input::get('months'));

        // Was the asset created?
        if ($depreciation->save()) {
            // Redirect to the depreciation page
            return redirect()->to("admin/settings/depreciations/")->with('success', trans('admin/depreciations/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($depreciation->getErrors());


    }

    /**
    * Validates and deletes a selected depreciation.
    *
    * This is a hard-delete. We do not currently soft-delete depreciations.
    *
    * @author [A. Gianotto] [<snipe@snipe.net]
    * @since [v1.0]
    * @return Redirect
    */
    public function getDelete($depreciationId)
    {
        // Check if the depreciation exists
        if (is_null($depreciation = Depreciation::find($depreciationId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/depreciations')->with('error', trans('admin/depreciations/message.not_found'));
        }

        if ($depreciation->has_models() > 0) {

            // Redirect to the asset management page
            return redirect()->to('admin/settings/depreciations')->with('error', trans('admin/depreciations/message.assoc_users'));
        } else {

            $depreciation->delete();

            // Redirect to the depreciations management page
            return redirect()->to('admin/settings/depreciations')->with('success', trans('admin/depreciations/message.delete.success'));
        }

    }


    /**
    * Generates the JSON used to display the depreciation listing.
    *
    * @see DepreciationsController::getIndex()
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  string  $status
    * @since [v1.2]
    * @return String JSON
    */
    public function getDatatable()
    {
        $depreciations = Depreciation::select(array('id','name','months'));

        if (Input::has('search')) {
            $depreciations = $depreciations->TextSearch(e(Input::get('search')));
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

        $allowed_columns = ['id','name','months'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

        $depreciations->orderBy($sort, $order);

        $depreciationsCount = $depreciations->count();
        $depreciations = $depreciations->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($depreciations as $depreciation) {
            $actions = '<a href="'.route('update/depreciations', $depreciation->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/depreciations', $depreciation->id).'" data-content="'.trans('admin/depreciations/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($depreciation->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

            $rows[] = array(
                'id'            => $depreciation->id,
                'name'          => e($depreciation->name),
                'months'        => e($depreciation->months),
                'actions'       => $actions
            );
        }

        $data = array('total' => $depreciationsCount, 'rows' => $rows);

        return $data;

    }
}
