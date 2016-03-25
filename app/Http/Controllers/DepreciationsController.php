<?php
/**
 * This controller handles all actions related to Asset Depreciation
 * for the Snipe-IT Asset Management application.
 *
 * PHP version 5.5.9
 * @package    Snipe-IT
 * @version    v1.0
 */
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

class DepreciationsController extends Controller
{
    /**
     * Show a list of all the depreciations.
     *
     * @return View
     */

    public function getIndex()
    {
        // Show the page
        return View::make('depreciations/index', compact('depreciations'));
    }


    /**
     * Depreciation create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
        $depreciation_options = \App\Helpers\Helper::depreciationList();
        return View::make('depreciations/edit')->with('depreciation_options', $depreciation_options)->with('depreciation', new Depreciation);
    }


    /**
     * Depreciation create form processing.
     *
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
            return Redirect::to("admin/settings/depreciations")->with('success', Lang::get('admin/depreciations/message.create.success'));
        }

        return Redirect::back()->withInput()->withErrors($depreciation->getErrors());

    }

    /**
     * Depreciation update.
     *
     * @param  int  $depreciationId
     * @return View
     */
    public function getEdit($depreciationId = null)
    {
        // Check if the depreciation exists
        if (is_null($depreciation = Depreciation::find($depreciationId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/settings/depreciations')->with('error', Lang::get('admin/depreciations/message.does_not_exist'));
        }

        // Show the page
        //$depreciation_options = array('' => 'Top Level') + Depreciation::lists('name', 'id');

        $depreciation_options = array('' => 'Top Level') + DB::table('depreciations')->where('id', '!=', $depreciationId)->lists('name', 'id');
        return View::make('depreciations/edit', compact('depreciation'))->with('depreciation_options', $depreciation_options);
    }


    /**
     * Depreciation update form processing page.
     *
     * @param  int  $depreciationId
     * @return Redirect
     */
    public function postEdit($depreciationId = null)
    {
        // Check if the depreciation exists
        if (is_null($depreciation = Depreciation::find($depreciationId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/settings/depreciations')->with('error', Lang::get('admin/depreciations/message.does_not_exist'));
        }

        // Depreciation data
        $depreciation->name      = e(Input::get('name'));
        $depreciation->months    = e(Input::get('months'));

        // Was the asset created?
        if ($depreciation->save()) {
            // Redirect to the depreciation page
            return Redirect::to("admin/settings/depreciations/")->with('success', Lang::get('admin/depreciations/message.update.success'));
        }

        return Redirect::back()->withInput()->withErrors($depreciation->getErrors());


    }

    /**
     * Delete the given depreciation.
     *
     * @param  int  $depreciationId
     * @return Redirect
     */
    public function getDelete($depreciationId)
    {
        // Check if the depreciation exists
        if (is_null($depreciation = Depreciation::find($depreciationId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/settings/depreciations')->with('error', Lang::get('admin/depreciations/message.not_found'));
        }

        if ($depreciation->has_models() > 0) {

            // Redirect to the asset management page
            return Redirect::to('admin/settings/depreciations')->with('error', Lang::get('admin/depreciations/message.assoc_users'));
        } else {

            $depreciation->delete();

            // Redirect to the depreciations management page
            return Redirect::to('admin/settings/depreciations')->with('success', Lang::get('admin/depreciations/message.delete.success'));
        }

    }


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
            $actions = '<a href="'.route('update/depreciations', $depreciation->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/depreciations', $depreciation->id).'" data-content="'.Lang::get('admin/depreciations/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($depreciation->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

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
