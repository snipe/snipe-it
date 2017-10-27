<?php
namespace App\Http\Controllers;

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
class StatuslabelsController extends Controller
{
    /**
     * Show a list of all the statuslabels.
     *
     * @return \Illuminate\Contracts\View\View
     */

    public function index()
    {
        return view('statuslabels.index', compact('statuslabels'));
    }

    public function show($id)
    {

        if ($statuslabel = Statuslabel::find($id)) {
            return view('statuslabels.view')->with('statuslabel', $statuslabel);
        }

        return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.does_not_exist', compact('id')));
    }



    /**
     * Statuslabel create.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Show the page
        $item = new Statuslabel;
        $use_statuslabel_type = $item->getStatuslabelType();
        $statuslabel_types = Helper::statusTypeList();

        return view('statuslabels/edit', compact('statuslabel_types', 'item'))->with('use_statuslabel_type', $use_statuslabel_type);
    }


    /**
     * Statuslabel create form processing.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        // create a new model instance
        $statusLabel = new Statuslabel();

        if (!$request->has('statuslabel_types')) {
            return redirect()->back()->withInput()->withErrors(['statuslabel_types' => trans('validation.statuslabel_type')]);
        }

        $statusType = Statuslabel::getStatuslabelTypesForDB($request->input('statuslabel_types'));

        // Save the Statuslabel data
        $statusLabel->name              = Input::get('name');
        $statusLabel->user_id           = Auth::id();
        $statusLabel->notes             =  Input::get('notes');
        $statusLabel->deployable        =  $statusType['deployable'];
        $statusLabel->pending           =  $statusType['pending'];
        $statusLabel->archived          =  $statusType['archived'];
        $statusLabel->color             =  Input::get('color');
        $statusLabel->show_in_nav       =  Input::get('show_in_nav', 0);


        // Was the asset created?
        if ($statusLabel->save()) {
            // Redirect to the new Statuslabel  page
            return redirect()->route('statuslabels.index')->with('success', trans('admin/statuslabels/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($statusLabel->getErrors());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function apiStore(Request $request)
    {
        $statuslabel = new Statuslabel();
        if (!$request->has('statuslabel_types')) {
            return JsonResponse::create(["error" => trans('validation.statuslabel_type')], 500);
        }
        $statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));
        $statuslabel->name            = Input::get('name');
        $statuslabel->user_id         = Auth::id();
        $statuslabel->notes           =  '';
        $statuslabel->deployable      =  $statustype['deployable'];
        $statuslabel->pending         =  $statustype['pending'];
        $statuslabel->archived        =  $statustype['archived'];


        if ($statuslabel->isValid()) {
            $statuslabel->save();
            // Redirect to the new Statuslabel  page
            return JsonResponse::create($statuslabel);
        }
        return JsonResponse::create(["error" => $statuslabel->getErrors()->first()], 500);

    }


    /**
     * Statuslabel update.
     *
     * @param  int  $statuslabelId
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($statuslabelId = null)
    {
        // Check if the Statuslabel exists
        if (is_null($item = Statuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }

        $use_statuslabel_type = $item->getStatuslabelType();

        $statuslabel_types = array('' => trans('admin/hardware/form.select_statustype')) + array('undeployable' => trans('admin/hardware/general.undeployable')) + array('pending' => trans('admin/hardware/general.pending')) + array('archived' => trans('admin/hardware/general.archived')) + array('deployable' => trans('admin/hardware/general.deployable'));

        return view('statuslabels/edit', compact('item', 'statuslabel_types'))->with('use_statuslabel_type', $use_statuslabel_type);
    }


    /**
     * Statuslabel update form processing page.
     *
     * @param  int  $statuslabelId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $statuslabelId = null)
    {
        // Check if the Statuslabel exists
        if (is_null($statuslabel = Statuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }

        if (!$request->has('statuslabel_types')) {
            return redirect()->back()->withInput()->withErrors(['statuslabel_types' => trans('validation.statuslabel_type')]);
        }


        // Update the Statuslabel data
        $statustype                 = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));
        $statuslabel->name              = Input::get('name');
        $statuslabel->notes          =  Input::get('notes');
        $statuslabel->deployable          =  $statustype['deployable'];
        $statuslabel->pending          =  $statustype['pending'];
        $statuslabel->archived          =  $statustype['archived'];
        $statuslabel->color          =  Input::get('color');
        $statuslabel->show_in_nav          =  Input::get('show_in_nav', 0);


        // Was the asset created?
        if ($statuslabel->save()) {
            // Redirect to the saved Statuslabel page
            return redirect()->route("statuslabels.index")->with('success', trans('admin/statuslabels/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($statuslabel->getErrors());
    }

    /**
     * Delete the given Statuslabel.
     *
     * @param  int  $statuslabelId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($statuslabelId)
    {
        // Check if the Statuslabel exists
        if (is_null($statuslabel = Statuslabel::find($statuslabelId))) {
            return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.not_found'));
        }

        // Check that there are no assets associated
        if ($statuslabel->assets()->count() == 0) {
            $statuslabel->delete();
            return redirect()->route('statuslabels.index')->with('success', trans('admin/statuslabels/message.delete.success'));
        }

        return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.assoc_assets'));
    }

}
