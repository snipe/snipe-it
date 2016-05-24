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

        $statuslabels = Statuslabel::get();
        $labels=[];
        $points=[];

        foreach ($statuslabels as $statuslabel) {
            $labels[]=$statuslabel->name;
            $points[]=$statuslabel->assets()->whereNull('assigned_to')->count();
        }
        $labels[]='Deployed';
        $points[]=Asset::whereNotNull('assigned_to')->count();

        $result= [
            "labels" => $labels,
            "datasets" => [ [
                "data" => $points,
                "backgroundColor" => Helper::chartColors(),
                "hoverBackgroundColor" =>  Helper::chartColors()
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
        $statuslabel = new Statuslabel;
        $use_statuslabel_type = $statuslabel->getStatuslabelType();
        $statuslabel_types = Helper::statusTypeList();

        return View::make('statuslabels/edit', compact('statuslabel_types', 'statuslabel'))->with('use_statuslabel_type', $use_statuslabel_type);
    }


    /**
     * Statuslabel create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // create a new model instance
        $statuslabel = new Statuslabel();
        $statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));

        // Save the Statuslabel data
        $statuslabel->name              = e(Input::get('name'));
        $statuslabel->user_id          = Auth::user()->id;
        $statuslabel->notes          =  e(Input::get('notes'));
        $statuslabel->deployable          =  $statustype['deployable'];
        $statuslabel->pending          =  $statustype['pending'];
        $statuslabel->archived          =  $statustype['archived'];


        // Was the asset created?
        if ($statuslabel->save()) {
            // Redirect to the new Statuslabel  page
            return redirect()->to("admin/settings/statuslabels")->with('success', trans('admin/statuslabels/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($statuslabel->getErrors());

    }

    public function store()
    {

      // create a new model instance
        $statuslabel = new Statuslabel();
        $statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('modal-statuslabel_types'));

      // attempt validation
        if ($statuslabel->validate($new)) {

            // Save the Statuslabel data
            $statuslabel->name            = e(Input::get('name'));
            $statuslabel->user_id         = Auth::user()->id;
            $statuslabel->notes           =  '';
            $statuslabel->deployable      =  $statustype['deployable'];
            $statuslabel->pending         =  $statustype['pending'];
            $statuslabel->archived        =  $statustype['archived'];

            // Was the asset created?
            if ($statuslabel->save()) {
                // Redirect to the new Statuslabel  page
                return JsonResponse::create($statuslabel);
            } else {
                return JsonResponse::create(["error" => "Couldn't save Statuslabel"], 500);
            }
        } else {
            // failure
            $errors = $statuslabel->getErrors();
            return  JsonResponse::create(["error" => "Failed validation: ".print_r($errors->all('<li>:message</li>'), true)], 500);
        }
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
        if (is_null($statuslabel = Statuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/statuslabels')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }

        $use_statuslabel_type = $statuslabel->getStatuslabelType();

        $statuslabel_types = array('' => trans('admin/hardware/form.select_statustype')) + array('undeployable' => trans('admin/hardware/general.undeployable')) + array('pending' => trans('admin/hardware/general.pending')) + array('archived' => trans('admin/hardware/general.archived')) + array('deployable' => trans('admin/hardware/general.deployable'));

        return View::make('statuslabels/edit', compact('statuslabel', 'statuslabel_types'))->with('use_statuslabel_type', $use_statuslabel_type);
    }


    /**
     * Statuslabel update form processing page.
     *
     * @param  int  $statuslabelId
     * @return Redirect
     */
    public function postEdit($statuslabelId = null)
    {
        // Check if the Statuslabel exists
        if (is_null($statuslabel = Statuslabel::find($statuslabelId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/statuslabels')->with('error', trans('admin/statuslabels/message.does_not_exist'));
        }


        // Update the Statuslabel data
        $statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));
        $statuslabel->name              = e(Input::get('name'));
        $statuslabel->notes          =  e(Input::get('notes'));
        $statuslabel->deployable          =  $statustype['deployable'];
        $statuslabel->pending          =  $statustype['pending'];
        $statuslabel->archived          =  $statustype['archived'];


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
        $statuslabels = Statuslabel::select(array('id','name','deployable','pending','archived'))
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

            $rows[] = array(
                'id'            => e($statuslabel->id),
                'type'          => e($label_type),
                'name'          => e($statuslabel->name),
                'actions'       => $actions
            );
        }

        $data = array('total' => $statuslabelsCount, 'rows' => $rows);

        return $data;

    }
}
