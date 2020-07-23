<?php
namespace App\Http\Controllers;

use App\Models\InventoryStatuslabel;
use App\Models\Location;
use Input;
use Lang;
use App\Models\Statuslabel;
use App\Models\Asset;
use Redirect;
use DB;
use App\Models\Setting;
use Str;
use View;
use App\Helpers\Helper;
use Auth;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This controller handles all actions related to Status Labels for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class InventoryStatuslabelsController extends Controller
{
    /**
     * Show a list of all the statuslabels.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function index()
    {
        $this->authorize('view', Statuslabel::class);
        return view('inventorystatuslabels.index');
    }

    public function show($id)
    {
        $this->authorize('view', Statuslabel::class);
        if ($statuslabel = InventoryStatuslabel::find($id)) {
            return view('inventorystatuslabels.view')->with('inventorystatuslabels', $statuslabel);
        }

        return redirect()->route('inventorystatuslabels.index')->with('error', trans('admin/statuslabels/message.does_not_exist'));
    }



    /**
     * Statuslabel create.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Show the page
        $this->authorize('create', Statuslabel::class);

        return view('inventorystatuslabels/edit')
            ->with('item', new InventoryStatuslabel);
    }


    /**
     * Statuslabel create form processing.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $this->authorize('create', Statuslabel::class);
        // create a new model instance
        $statusLabel = new InventoryStatuslabel();

        // Save the Statuslabel data
        $statusLabel->name              = Input::get('name');
        $statusLabel->user_id           = Auth::id();
        $statusLabel->notes             =  Input::get('notes');
        $statusLabel->color             =  Input::get('color');
        $statusLabel->success       =  Input::get('success', 0);


        if ($statusLabel->save()) {
            // Redirect to the new Statuslabel  page
            return redirect()->route('inventorystatuslabels.index')->with('success', trans('admin/statuslabels/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($statusLabel->getErrors());
    }

    /**
     * Statuslabel update.
     *
     * @param  int  $statuslabelId
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($statuslabelId = null)
    {
        $this->authorize('update', Statuslabel::class);
        // Check if the Statuslabel exists
        if (is_null($item = InventoryStatuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->route('inventorystatuslabels.index')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }

        return view('inventorystatuslabels/edit', compact('item'));
    }


    /**
     * Statuslabel update form processing page.
     *
     * @param  int  $statuslabelId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $statuslabelId = null)
    {
        $this->authorize('update', Statuslabel::class);
        // Check if the Statuslabel exists
        if (is_null($statusLabel = InventoryStatuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->route('inventorystatuslabels.index')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }


        // Save the Statuslabel data
        $statusLabel->name              = Input::get('name');
        $statusLabel->user_id           = Auth::id();
        $statusLabel->notes             =  Input::get('notes');
        $statusLabel->color             =  Input::get('color');
        $statusLabel->success       =  Input::get('success', 0);


        // Was the asset created?
        if ($statusLabel->save()) {
            // Redirect to the saved Statuslabel page
            return redirect()->route("inventorystatuslabels.index")->with('success', trans('admin/statuslabels/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($statusLabel->getErrors());
    }

    /**
     * Delete the given Statuslabel.
     *
     * @param  int  $statuslabelId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($statuslabelId)
    {
        $this->authorize('delete', Statuslabel::class);
        // Check if the Statuslabel exists
        if (is_null($statuslabel = InventoryStatuslabel::find($statuslabelId))) {
            return redirect()->route('inventorystatuslabels.index')->with('error', trans('admin/statuslabels/message.not_found'));
        }

        $statuslabel->delete();
        return redirect()->route('inventorystatuslabels.index')->with('success', trans('admin/statuslabels/message.delete.success'));
}

}
