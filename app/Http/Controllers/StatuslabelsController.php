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
     * @return View
     */

    public function getIndex()
    {
        // Show the page
        return View::make('statuslabels/index', compact('statuslabels'));
    }


    /**
     * Show a count of assets by status label
     *
     * @return View
     */

    public function getAssetCountByStatuslabel()
    {
        $colors = [];

        $statuslabels = Statuslabel::with('assets')->get();
        $labels=[];
        $points=[];
        $colors=[];
        foreach ($statuslabels as $statuslabel) {
            if ($statuslabel->assets->count() > 0) {
                $labels[]=$statuslabel->name;
                $points[]=$statuslabel->assets()->whereNull('assigned_to')->count();
                if ($statuslabel->color!='') {
                    $colors[]=$statuslabel->color;
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
     * @return View
     */
    public function getCreate()
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
     * @return Redirect
     */
    public function postCreate(Request $request)
    {

        // create a new model instance
        $statuslabel = new Statuslabel();

        if (!$request->has('statuslabel_types')) {
            return redirect()->back()->withInput()->withErrors(['statuslabel_types' => trans('validation.statuslabel_type')]);
        }

        $statustype = Statuslabel::getStatuslabelTypesForDB($request->input('statuslabel_types'));

        // Save the Statuslabel data
        $statuslabel->name              = e(Input::get('name'));
        $statuslabel->user_id          = Auth::user()->id;
        $statuslabel->notes          =  e(Input::get('notes'));
        $statuslabel->deployable          =  $statustype['deployable'];
        $statuslabel->pending          =  $statustype['pending'];
        $statuslabel->archived          =  $statustype['archived'];
        $statuslabel->color          =  e(Input::get('color'));
        $statuslabel->show_in_nav          =  e(Input::get('show_in_nav'),0);


        // Was the asset created?
        if ($statuslabel->save()) {
            // Redirect to the new Statuslabel  page
            return redirect()->to("admin/settings/statuslabels")->with('success', trans('admin/statuslabels/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($statuslabel->getErrors());

    }

    public function store(Request $request)
    {

        $statuslabel = new Statuslabel();
        if (!$request->has('statuslabel_types')) {
            return JsonResponse::create(["error" => trans('validation.statuslabel_type')], 500);
        }

        $statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));
        $statuslabel->name            = e(Input::get('name'));
        $statuslabel->user_id         = Auth::user()->id;
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
     * @return View
     */
    public function getEdit($statuslabelId = null)
    {
        // Check if the Statuslabel exists
        if (is_null($item = Statuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/statuslabels')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }

        $use_statuslabel_type = $item->getStatuslabelType();

        $statuslabel_types = array('' => trans('admin/hardware/form.select_statustype')) + array('undeployable' => trans('admin/hardware/general.undeployable')) + array('pending' => trans('admin/hardware/general.pending')) + array('archived' => trans('admin/hardware/general.archived')) + array('deployable' => trans('admin/hardware/general.deployable'));

        return View::make('statuslabels/edit', compact('item', 'statuslabel_types'))->with('use_statuslabel_type', $use_statuslabel_type);
    }


    /**
     * Statuslabel update form processing page.
     *
     * @param  int  $statuslabelId
     * @return Redirect
     */
    public function postEdit(Request $request, $statuslabelId = null)
    {
        // Check if the Statuslabel exists
        if (is_null($statuslabel = Statuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/statuslabels')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }

        if (!$request->has('statuslabel_types')) {
            return redirect()->back()->withInput()->withErrors(['statuslabel_types' => trans('validation.statuslabel_type')]);
        }


        // Update the Statuslabel data
        $statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));
        $statuslabel->name              = e(Input::get('name'));
        $statuslabel->notes          =  e(Input::get('notes'));
        $statuslabel->deployable          =  $statustype['deployable'];
        $statuslabel->pending          =  $statustype['pending'];
        $statuslabel->archived          =  $statustype['archived'];
        $statuslabel->color          =  e(Input::get('color'));
        $statuslabel->show_in_nav          =  e(Input::get('show_in_nav'),0);


        // Was the asset created?
        if ($statuslabel->save()) {
            // Redirect to the saved Statuslabel page
            return redirect()->to("admin/settings/statuslabels/")->with('success', trans('admin/statuslabels/message.update.success'));
        } else {
            return redirect()->back()->withInput()->withErrors($statuslabel->getErrors());
        }


        // Redirect to the Statuslabel management page
        return redirect()->to("admin/settings/statuslabels/$statuslabelId/edit")->with('error', trans('admin/statuslabels/message.update.error'));

    }

    /**
     * Delete the given Statuslabel.
     *
     * @param  int  $statuslabelId
     * @return Redirect
     */
    public function getDelete($statuslabelId)
    {
        // Check if the Statuslabel exists
        if (is_null($statuslabel = Statuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/statuslabels')->with('error', trans('admin/statuslabels/message.not_found'));
        }


        if ($statuslabel->has_assets() > 0) {

            // Redirect to the asset management page
            return redirect()->to('admin/settings/statuslabels')->with('error', trans('admin/statuslabels/message.assoc_assets'));
        } else {

            $statuslabel->delete();

            // Redirect to the statuslabels management page
            return redirect()->to('admin/settings/statuslabels')->with('success', trans('admin/statuslabels/message.delete.success'));
        }



    }


    public function getDatatable()
    {
        $statuslabels = Statuslabel::select(array('id','name','deployable','pending','archived','color','show_in_nav'))
        ->whereNull('deleted_at');

        if (Input::has('search')) {
            $statuslabels = $statuslabels->TextSearch(e(Input::get('search')));
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

            $actions = '<a href="'.route('update/statuslabel', $statuslabel->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/statuslabel', $statuslabel->id).'" data-content="'.trans('admin/statuslabels/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($statuslabel->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

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
