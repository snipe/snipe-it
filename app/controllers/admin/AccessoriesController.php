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
use User;
use Actionlog;
use Mail;

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
        $category_list = array('' => '') + DB::table('categories')->where('category_type','=','accessory')->whereNull('deleted_at')->lists('name', 'id');
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

            // Was the accessory created?
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

		$category_list = array('' => '') + DB::table('categories')->where('category_type','=','accessory')->whereNull('deleted_at')->lists('name', 'id');
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

            // Was the accessory created?
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




            $accessory->delete();

            // Redirect to the locations management page
            return Redirect::to('admin/accessories')->with('success', Lang::get('admin/accessories/message.delete.success'));
        


    }



    /**
    *  Get the accessory information to present to the accessory view page
    *
    * @param  int  $accessoryId
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
    
    /**
    * Check out the accessory to a person
    **/
    public function getCheckout($accessoryId)
    {
        // Check if the accessory exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the accessory management page with error
            return Redirect::to('accessories')->with('error', Lang::get('admin/accessories/message.not_found'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat(last_name,", ",first_name) as full_name, id'))->whereNull('deleted_at')->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->lists('full_name', 'id');

        return View::make('backend/accessories/checkout', compact('accessory'))->with('users_list',$users_list);

    }

    /**
    * Check out the accessory to a person
    **/
    public function postCheckout($accessoryId)
    {
        // Check if the accessory exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the accessory management page with error
            return Redirect::to('accessories')->with('error', Lang::get('admin/accessories/message.not_found'));
        }

        $assigned_to = e(Input::get('assigned_to'));


        // Declare the rules for the form validation
        $rules = array(
            'assigned_to'   => 'required|min:1'
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }


        // Check if the user exists
        if (is_null($user = User::find($assigned_to))) {
            // Redirect to the accessory management page with error
            return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.user_does_not_exist'));
        }

        // Update the accessory data
        $accessory->assigned_to            		= e(Input::get('assigned_to'));

        $accessory->users()->attach($accessory->id, array(
        'accessory_id' => $accessory->id, 
        'assigned_to' => e(Input::get('assigned_to'))));
        
            $logaction = new Actionlog();
            $logaction->accessory_id = $accessory->id;
            $logaction->checkedout_to = $accessory->assigned_to;
            $logaction->asset_type = 'accessory';
            $logaction->location_id = $user->location_id;
            $logaction->user_id = Sentry::getUser()->id;
            $logaction->note = e(Input::get('note'));
            $log = $logaction->logaction('checkout');
            
            $accessory_user = DB::table('accessories_users')->where('assigned_to','=',$accessory->assigned_to)->where('accessory_id','=',$accessory->id)->first();
            
            print_r($accessory_user);
            //$data['accessory_user_id'] = $accessory_user->id;
            $data['eula'] = $accessory->getEula();
            $data['first_name'] = $user->first_name;
            
             
            if ($accessory->requireAcceptance()=='1') {
				
	            Mail::send('emails.accept-accessory', $data, function ($m) use ($user) {
	                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
	                $m->subject('Confirm accessory delivery');
	            });
            } 

            // Redirect to the new accessory page
            return Redirect::to("admin/accessories")->with('success', Lang::get('admin/accessories/message.checkout.success'));
        

        
    }


    /**
    * Check the accessory back into inventory
    *
    * @param  int  $accessoryId
    * @return View
    **/
    public function getCheckin($accessoryUserId)
    {
        // Check if the accessory exists
        if (is_null($accessory_user = DB::table('accessories_users')->find($accessoryUserId))) {
            // Redirect to the accessory management page with error
            return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.not_found'));
        }

		$accessory = Accessory::find($accessory_user->accessory_id);
        return View::make('backend/accessories/checkin', compact('accessory'));
    }


    /**
    * Check in the item so that it can be checked out again to someone else
    *
    * @param  int  $accessoryId
    * @return View
    **/
    public function postCheckin($accessoryUserId)
    {
        // Check if the accessory exists
        if (is_null($accessory_user = DB::table('accessories_users')->find($accessoryUserId))) {
            // Redirect to the accessory management page with error
            return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.not_found'));
        }

       
		$accessory = Accessory::find($accessory_user->accessory_id);
        $logaction = new Actionlog();
        $logaction->checkedout_to = $accessory_user->assigned_to;

        // Was the accessory updated?
        if(DB::table('accessories_users')->where('id', '=', $accessory_user->id)->delete()) {

            $logaction->accessory_id = $accessory->id;
            $logaction->location_id = NULL;
            $logaction->asset_type = 'accessory';
            $logaction->user_id = Sentry::getUser()->id;
            $log = $logaction->logaction('checkin from');

            // Redirect to the new accessory page
            return Redirect::to("admin/accessories")->with('success', Lang::get('admin/accessories/message.checkin.success'));
        } 

        // Redirect to the accessory management page with error
        return Redirect::to("admin/accessories")->with('error', Lang::get('admin/accessories/message.checkin.error'));
    }




}
