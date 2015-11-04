<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Statuslabel;
use Redirect;
use DB;
use Sentry;
use Setting;
use Str;
use Validator;
use View;

use Symfony\Component\HttpFoundation\JsonResponse;

class StatuslabelsController extends AdminController
{
    /**
     * Show a list of all the statuslabels.
     *
     * @return View
     */

    public function getIndex()
    {
        // Show the page
        return View::make('backend/statuslabels/index', compact('statuslabels'));
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
    	$statuslabel_types = statusTypeList();

        return View::make('backend/statuslabels/edit', compact('statuslabel_types','statuslabel'))->with('use_statuslabel_type',$use_statuslabel_type);
    }


    /**
     * Statuslabel create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // create a new model instance
        $statuslabel = new Statuslabel();

        // attempt validation
        if ($statuslabel->validate($new)) {

        	$statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));

            // Save the Statuslabel data
            $statuslabel->name            	= e(Input::get('name'));
            $statuslabel->user_id          = Sentry::getId();
            $statuslabel->notes          =  e(Input::get('notes'));
            $statuslabel->deployable          =  $statustype['deployable'];
            $statuslabel->pending          =  $statustype['pending'];
            $statuslabel->archived          =  $statustype['archived'];

            // Was the asset created?
            if($statuslabel->save()) {
                // Redirect to the new Statuslabel  page
                return Redirect::to("admin/settings/statuslabels")->with('success', Lang::get('admin/statuslabels/message.create.success'));
            }
        } else {
            // failure
            $errors = $statuslabel->errors();
            return Redirect::back()->withInput()->withErrors($errors);
        }

        // Redirect to the Statuslabel create page
        return Redirect::to('admin/settings/statuslabels/create')->with('error', Lang::get('admin/statuslabels/message.create.error'));

    }

    public function store()
    {
      // get the POST data
      $new = Input::all();

      $new['statuslabel_types']="deployable";

      // create a new model instance
      $statuslabel = new Statuslabel();
      $statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));

      // attempt validation
      if ($statuslabel->validate($new)) {

        //$statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));

          // Save the Statuslabel data
          $statuslabel->name            = e(Input::get('name'));
          $statuslabel->user_id         = Sentry::getId();
          $statuslabel->notes           =  '';
          $statuslabel->deployable      =  $statustype['deployable'];
          $statuslabel->pending         =  $statustype['pending'];
          $statuslabel->archived        =  $statustype['archived'];

          // Was the asset created?
          if($statuslabel->save()) {
              // Redirect to the new Statuslabel  page
              return JsonResponse::create($statuslabel);
          } else {
            return JsonResponse::create(["error" => "Couldn't save Statuslabel"],500);
          }
      } else {
          // failure
          $errors = $statuslabel->errors();
          return  JsonResponse::create(["error" => "Failed validation: ".print_r($errors->all('<li>:message</li>'),true)],500);
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
            return Redirect::to('admin/settings/statuslabels')->with('error', Lang::get('admin/statuslabels/message.does_not_exist'));
        }

		$use_statuslabel_type = $statuslabel->getStatuslabelType();

		$statuslabel_types = array('' => Lang::get('admin/hardware/form.select_statustype')) + array('undeployable' => Lang::get('admin/hardware/general.undeployable')) + array('pending' => Lang::get('admin/hardware/general.pending')) + array('archived' => Lang::get('admin/hardware/general.archived')) + array('deployable' => Lang::get('admin/hardware/general.deployable'));

        return View::make('backend/statuslabels/edit', compact('statuslabel','statuslabel_types'))->with('use_statuslabel_type',$use_statuslabel_type);
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
            return Redirect::to('admin/settings/statuslabels')->with('error', Lang::get('admin/statuslabels/message.does_not_exist'));
        }

        //attempt to validate
        $validator = Validator::make(Input::all(), $statuslabel->validationRules($statuslabelId));

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {
            // Update the Statuslabel data
            $statustype = Statuslabel::getStatuslabelTypesForDB(Input::get('statuslabel_types'));

            $statuslabel->name            	= e(Input::get('name'));
            $statuslabel->notes          =  e(Input::get('notes'));
            $statuslabel->deployable          =  $statustype['deployable'];
            $statuslabel->pending          =  $statustype['pending'];
            $statuslabel->archived          =  $statustype['archived'];


            // Was the asset created?
            if($statuslabel->save()) {
                // Redirect to the saved Statuslabel page
                return Redirect::to("admin/settings/statuslabels/")->with('success', Lang::get('admin/statuslabels/message.update.success'));
            }
        }

        // Redirect to the Statuslabel management page
        return Redirect::to("admin/settings/statuslabels/$statuslabelId/edit")->with('error', Lang::get('admin/statuslabels/message.update.error'));

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
            return Redirect::to('admin/settings/statuslabels')->with('error', Lang::get('admin/statuslabels/message.not_found'));
        }


        if ($statuslabel->has_assets() > 0) {

            // Redirect to the asset management page
            return Redirect::to('admin/settings/statuslabels')->with('error', Lang::get('admin/statuslabels/message.assoc_users'));
        } else {

            $statuslabel->delete();

            // Redirect to the statuslabels management page
            return Redirect::to('admin/settings/statuslabels')->with('success', Lang::get('admin/statuslabels/message.delete.success'));
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

        foreach($statuslabels as $statuslabel) {

            if ($statuslabel->deployable == 1) {
			$label_type = Lang::get('admin/statuslabels/table.deployable');
            } elseif ($statuslabel->pending == 1) {
			$label_type = Lang::get('admin/statuslabels/table.pending');
            } elseif ($statuslabel->archived == 1) {
		      $label_type = Lang::get('admin/statuslabels/table.archived');
		} else {
                  $label_type = Lang::get('admin/statuslabels/table.undeployable');
            }

            $actions = '<a href="'.route('update/statuslabel', $statuslabel->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/statuslabel', $statuslabel->id).'" data-content="'.Lang::get('admin/statuslabels/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($statuslabel->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

            $rows[] = array(
                'id'            => $statuslabel->id,
                'type'          => $label_type,
                'name'          => e($statuslabel->name),
                'actions'       => $actions
            );
        }

        $data = array('total' => $statuslabelsCount, 'rows' => $rows);

        return $data;

    }




}
