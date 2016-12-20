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
        // Show the page
        return View::make('statuslabels/index', compact('statuslabels'));
    }


    /**
     * Show a count of assets by status label
     *
     * @return array
     */

    public function getAssetCountByStatuslabel()
    {

        $statusLabels = Statuslabel::with()->get();
        $labels=[];
        $points=[];
        $colors=[];
        foreach ($statusLabels as $statusLabel) {
            if ($statusLabel->assets()->count() > 0) {
                $labels[]=$statusLabel->name;
                $points[]=$statusLabel->assets()->whereNull('assigned_to')->count();
                if ($statusLabel->color!='') {
                    $colors[]=$statusLabel->color;
                }
            }
        }
        $labels[]='Deployed';
        $points[]=Asset::whereNotNull('assigned_to')->count();

        $colors_array = array_merge($colors, Helper::chartColors());

        $result= [
            "labels" => $labels,
            "datasets" => [ [
                "data" => $points,
                "backgroundColor" => $colors_array,
                "hoverBackgroundColor" =>  $colors_array
            ]]
        ];
        return $result;
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

        return View::make('statuslabels/edit', compact('statuslabel_types', 'item'))->with('use_statuslabel_type', $use_statuslabel_type);
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
        $statusLabel->user_id          = Auth::id();
        $statusLabel->notes          =  Input::get('notes');
        $statusLabel->deployable          =  $statusType['deployable'];
        $statusLabel->pending          =  $statusType['pending'];
        $statusLabel->archived          =  $statusType['archived'];
        $statusLabel->color          =  Input::get('color');
        $statusLabel->show_in_nav          =  Input::get('show_in_nav', 0);


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

        return View::make('statuslabels/edit', compact('item', 'statuslabel_types'))->with('use_statuslabel_type', $use_statuslabel_type);
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
        $statuslabel->show_in_nav          =  Input::get('show_in_nav',0);


        // Was the asset created?
        if ($statuslabel->save()) {
            // Redirect to the saved Statuslabel page
            return redirect()->to("admin/settings/statuslabels/")->with('success', trans('admin/statuslabels/message.update.success'));
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
            // Redirect to the blogs management page
            return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.not_found'));
        }


        if ($statuslabel->has_assets() == 0) {
            $statuslabel->delete();
            // Redirect to the statuslabels management page
            return redirect()->route('statuslabels.index')->with('success', trans('admin/statuslabels/message.delete.success'));
        }
        // Redirect to the asset management page
        return redirect()->route('statuslabels.index')->with('error', trans('admin/statuslabels/message.assoc_assets'));
    }


    public function getDatatable()
    {
        $statuslabels = Statuslabel::select(array('id','name','deployable','pending','archived','color','show_in_nav'))
        ->whereNull('deleted_at');

        if (Input::has('search')) {
            $statuslabels = $statuslabels->TextSearch(e(Input::get('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $allowed_columns = ['id','name'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

        $statuslabels->orderBy($sort, $order);

        $statuslabelsCount = $statuslabels->count();
        $statuslabels = $statuslabels->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($statuslabels as $statuslabel) {

            if ($statuslabel->deployable == 1) {
                $label_type = trans('admin/statuslabels/table.deployable');
            } elseif ($statuslabel->pending == 1) {
                $label_type = trans('admin/statuslabels/table.pending');
            } elseif ($statuslabel->archived == 1) {
                $label_type = trans('admin/statuslabels/table.archived');
            } else {
                $label_type = trans('admin/statuslabels/table.undeployable');
            }
            $actions = '<nobr>';
            $actions .= Helper::generateDatatableButton('edit', route('statuslabels.edit', $statuslabel->id));
            $actions .= Helper::generateDatatableButton(
                'delete',
                route('statuslabels.destroy'),
                true, /*enabled*/
                trans('admin/statuslabels/message.delete.confirm'),
                $statuslabel->name
            );
            $actions .= '</nobr>';

            if ($statuslabel->color!='') {
                $color = '<div class="pull-left" style="margin-right: 5px; height: 20px; width: 20px; background-color: '.e($statuslabel->color).'"></div>'.e($statuslabel->color);
            } else {
                $color = '';
            }


            $rows[] = array(
                'id'            => e($statuslabel->id),
                'type'          => e($label_type),
                'name'          => e($statuslabel->name),
                'color'          => $color,
                'show_in_nav' => ($statuslabel->show_in_nav=='1') ? trans('general.yes') : trans('general.no'),
                'actions'       => $actions
            );
        }

        $data = array('total' => $statuslabelsCount, 'rows' => $rows);

        return $data;

    }
}
