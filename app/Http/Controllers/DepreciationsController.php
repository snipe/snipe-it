<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use Lang;
use App\Models\Depreciation;
use Redirect;
use App\Models\Setting;
use DB;
use Str;
use View;
use Auth;
use Illuminate\Http\Request;

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
    * @return \Illuminate\Contracts\View\View
     */
    public function index()
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
    * @return \Illuminate\Contracts\View\View
     */
    public function create()
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // create a new instance
        $depreciation = new Depreciation();
        // Depreciation data
        $depreciation->name             = $request->input('name');
        $depreciation->months           = $request->input('months');
        $depreciation->user_id          = Auth::id();

        // Was the asset created?
        if ($depreciation->save()) {
            // Redirect to the new depreciation  page
            return redirect()->route('depreciations.index')->with('success', trans('admin/depreciations/message.create.success'));
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
    * @return \Illuminate\Contracts\View\View
     */
    public function edit($depreciationId = null)
    {
        // Check if the depreciation exists
        if (is_null($item = Depreciation::find($depreciationId))) {
            // Redirect to the blogs management page
            return redirect()->route('depreciations.index')->with('error', trans('admin/depreciations/message.does_not_exist'));
        }

        return View::make('depreciations/edit', compact('item'));
    }


    /**
     * Validates and stores the updated depreciation data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net]
     * @see DepreciationsController::getEdit()
     * @param Request $request
     * @param int $depreciationId
     * @return \Illuminate\Http\RedirectResponse
     * @since [v1.0]
     */
    public function update(Request $request, $depreciationId = null)
    {
        // Check if the depreciation exists
        if (is_null($depreciation = Depreciation::find($depreciationId))) {
            // Redirect to the blogs management page
            return redirect()->route('depreciations.index')->with('error', trans('admin/depreciations/message.does_not_exist'));
        }

        // Depreciation data
        $depreciation->name      = $request->input('name');
        $depreciation->months    = $request->input('months');

        // Was the asset created?
        if ($depreciation->save()) {
            // Redirect to the depreciation page
            return redirect()->route("depreciations.index")->with('success', trans('admin/depreciations/message.update.success'));
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
     * @param integer $depreciationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($depreciationId)
    {
        // Check if the depreciation exists
        if (is_null($depreciation = Depreciation::find($depreciationId))) {
            return redirect()->route('depreciations.index')->with('error', trans('admin/depreciations/message.not_found'));
        }

        if ($depreciation->has_models() > 0) {
            // Redirect to the asset management page
            return redirect()->route('depreciations.index')->with('error', trans('admin/depreciations/message.assoc_users'));
        }

        $depreciation->delete();
        // Redirect to the depreciations management page
        return redirect()->route('depreciations.index')->with('success', trans('admin/depreciations/message.delete.success'));
    }


    /**
     * Generates the JSON used to display the depreciation listing.
     *
     * @see DepreciationsController::getIndex()
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @return String JSON
     * @internal param string $status
     * @since [v1.2]
     */
    public function getDatatable(Request $request)
    {
        $depreciations = Depreciation::select(array('id','name','months'));

        if ($request->has('search')) {
            $depreciations = $depreciations->TextSearch(e($request->input('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $allowed_columns = ['id','name','months'];
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

        $depreciations->orderBy($sort, $order);

        $depreciationsCount = $depreciations->count();
        $depreciations = $depreciations->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($depreciations as $depreciation) {
            $rows[] = $depreciation->present()->forDataTable();
        }

        $data = array('total' => $depreciationsCount, 'rows' => $rows);

        return $data;

    }
}
