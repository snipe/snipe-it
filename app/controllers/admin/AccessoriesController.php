<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Accessory;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;

class AccessoriesController extends AdminController
{
    /**
     * Show a list of all the accessories.
     *
     * @return View
     */

    public function getIndex()
    {
        // Grab all the accessories
        $accessories = Accessory::orderBy('created_at', 'DESC')->get();

        // Show the page
        return View::make('backend/accessories/index', compact('accessories'));
    }


    /**
     * Accessory create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
        $category_list = array('' => '') + DB::table('categories')->whereNull('deleted_at')->lists('name', 'id');
        return View::make('backend/accessories/edit')->with('accessory',new Accessory)->with('category_list',$category_list);
    }


    /**
     * Accessory create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // create a new model instance
        $accessory = new Accessory();

        $validator = Validator::make(Input::all(), $accessory->rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        else{

            // Update the accessory data
            $accessory->name            		= e(Input::get('name'));
            $accessory->category_id            	= e(Input::get('category_id'));
            $accessory->qty            			= e(Input::get('qty'));
            $accessory->user_id          		= Sentry::getId();

            // Was the asset created?
            if($accessory->save()) {
                // Redirect to the new accessory  page
                return Redirect::to("admin/accessories")->with('success', Lang::get('admin/accessories/message.create.success'));
            }
        }

        // Redirect to the accessory create page
        return Redirect::to('admin/accessories/create')->with('error', Lang::get('admin/accessories/message.create.error'));


    }

    /**
     * Accessory update.
     *
     * @param  int  $accessoryId
     * @return View
     */
    public function getEdit($accessoryId = null)
    {
        // Check if the accessory exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.does_not_exist'));
        }

		$category_list = array('' => '') + DB::table('categories')->whereNull('deleted_at')->lists('name', 'id');
        return View::make('backend/accessories/edit', compact('accessory'))->with('category_list',$category_list);
    }


    /**
     * Accessory update form processing page.
     *
     * @param  int  $accessoryId
     * @return Redirect
     */
    public function postEdit($accessoryId = null)
    {
        // Check if the blog post exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.does_not_exist'));
        }


        // get the POST data
        $new = Input::all();

        // attempt validation
        $validator = Validator::make(Input::all(), $accessory->validationRules($accessoryId));


        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

            // Update the accessory data
            $accessory->name            		= e(Input::get('name'));
            $accessory->category_id            	= e(Input::get('category_id'));
            $accessory->qty            			= e(Input::get('qty'));

            // Was the asset created?
            if($accessory->save()) {
                // Redirect to the new accessory page
                return Redirect::to("admin/accessories")->with('success', Lang::get('admin/accessories/message.update.success'));
            }
        }

        // Redirect to the accessory management page
        return Redirect::to("admin/accessories/$accessoryID/edit")->with('error', Lang::get('admin/accessories/message.update.error'));

    }

    /**
     * Delete the given accessory.
     *
     * @param  int  $accessoryId
     * @return Redirect
     */
    public function getDelete($accessoryId)
    {
        // Check if the blog post exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.not_found'));
        }


        if ($accessory->has_models() > 0) {

            // Redirect to the asset management page
            return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.assoc_users'));
        } else {

            $accessory->delete();

            // Redirect to the locations management page
            return Redirect::to('admin/accessories')->with('success', Lang::get('admin/accessories/message.delete.success'));
        }


    }



    /**
    *  Get the asset information to present to the accessory view page
    *
    * @param  int  $assetId
    * @return View
    **/
    public function getView($accessoryID = null)
    {
        $accessory = Accessory::find($accessoryID);

        if (isset($accessory->id)) {
                return View::make('backend/accessories/view', compact('accessory'));
        } else {
            // Prepare the error message
            $error = Lang::get('admin/accessories/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('accessories')->with('error', $error);
        }


    }




}
