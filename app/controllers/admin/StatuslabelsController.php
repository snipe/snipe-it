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

class StatuslabelsController extends AdminController
{
    /**
     * Show a list of all the statuslabels.
     *
     * @return View
     */

    public function getIndex()
    {
        // Grab all the statuslabels
        $statuslabels = Statuslabel::orderBy('created_at', 'DESC')->get();

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

    	$statuslabel_types = array('' => Lang::get('admin/hardware/form.select_statustype')) + array('undeployable' => Lang::get('admin/hardware/general.undeployable')) + array('pending' => Lang::get('admin/hardware/general.pending')) + array('archived' => Lang::get('admin/hardware/general.archived')) + array('deployable' => Lang::get('admin/hardware/general.deployable'));

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



}
