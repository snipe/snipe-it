<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Redirect;
use Setting;
use DB;
use Sentry;
use Consumable;
use Str;
use Validator;
use View;
use User;
use Actionlog;
use Mail;
use Datatable;
use Slack;
use Config;

class ConsumablesController extends AdminController
{
    /**
     * Show a list of all the consumables.
     *
     * @return View
     */

    public function getIndex()
    {
        return View::make('backend/consumables/index');
    }


    /**
     * Consumable create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
        $category_list = array('' => '') + DB::table('categories')->where('category_type','=','consumable')->whereNull('deleted_at')->orderBy('name','ASC')->lists('name', 'id');
        return View::make('backend/consumables/edit')->with('consumable',new Consumable)->with('category_list',$category_list);
    }


    /**
     * Consumable create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // create a new model instance
        $consumable = new Consumable();

        $validator = Validator::make(Input::all(), $consumable->rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        else{

            // Update the consumable data
            $consumable->name            		= e(Input::get('name'));
            $consumable->category_id            	= e(Input::get('category_id'));
            $consumable->qty            			= e(Input::get('qty'));
            $consumable->user_id          		= Sentry::getId();

            // Was the consumable created?
            if($consumable->save()) {
                // Redirect to the new consumable  page
                return Redirect::to("admin/consumables")->with('success', Lang::get('admin/consumables/message.create.success'));
            }
        }

        // Redirect to the consumable create page
        return Redirect::to('admin/consumables/create')->with('error', Lang::get('admin/consumables/message.create.error'));


    }

    /**
     * Consumable update.
     *
     * @param  int  $consumableId
     * @return View
     */
    public function getEdit($consumableId = null)
    {
        // Check if the consumable exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/consumables')->with('error', Lang::get('admin/consumables/message.does_not_exist'));
        }

		$category_list = array('' => '') + DB::table('categories')->where('category_type','=','consumable')->whereNull('deleted_at')->orderBy('name','ASC')->lists('name', 'id');
        return View::make('backend/consumables/edit', compact('consumable'))->with('category_list',$category_list);
    }


    /**
     * Consumable update form processing page.
     *
     * @param  int  $consumableId
     * @return Redirect
     */
    public function postEdit($consumableId = null)
    {
        // Check if the blog post exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/consumables')->with('error', Lang::get('admin/consumables/message.does_not_exist'));
        }


        // get the POST data
        $new = Input::all();

        // attempt validation
        $validator = Validator::make(Input::all(), $consumable->validationRules($consumableId));


        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

            // Update the consumable data
            $consumable->name            		= e(Input::get('name'));
            $consumable->category_id            	= e(Input::get('category_id'));
            $consumable->qty            			= e(Input::get('qty'));

            // Was the consumable created?
            if($consumable->save()) {
                // Redirect to the new consumable page
                return Redirect::to("admin/consumables")->with('success', Lang::get('admin/consumables/message.update.success'));
            }
        }

        // Redirect to the consumable management page
        return Redirect::to("admin/consumables/$consumableID/edit")->with('error', Lang::get('admin/consumables/message.update.error'));

    }

    /**
     * Delete the given consumable.
     *
     * @param  int  $consumableId
     * @return Redirect
     */
    public function getDelete($consumableId)
    {
        // Check if the blog post exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/consumables')->with('error', Lang::get('admin/consumables/message.not_found'));
        }


		if ($consumable->hasUsers() > 0) {
			 return Redirect::to('admin/consumables')->with('error', Lang::get('admin/consumables/message.assoc_users', array('count'=> $consumable->hasUsers())));
		} else {
			$consumable->delete();

            // Redirect to the locations management page
            return Redirect::to('admin/consumables')->with('success', Lang::get('admin/consumables/message.delete.success'));

		}





    }



    /**
    *  Get the consumable information to present to the consumable view page
    *
    * @param  int  $consumableId
    * @return View
    **/
    public function getView($consumableID = null)
    {
        $consumable = Consumable::find($consumableID);

        if (isset($consumable->id)) {
                return View::make('backend/consumables/view', compact('consumable'));
        } else {
            // Prepare the error message
            $error = Lang::get('admin/consumables/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('consumables')->with('error', $error);
        }


    }

    /**
    * Check out the consumable to a person
    **/
    public function getCheckout($consumableId)
    {
        // Check if the consumable exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the consumable management page with error
            return Redirect::to('consumables')->with('error', Lang::get('admin/consumables/message.not_found'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat(last_name,", ",first_name," (",username,")") as full_name, id'))->whereNull('deleted_at')->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->lists('full_name', 'id');

        return View::make('backend/consumables/checkout', compact('consumable'))->with('users_list',$users_list);

    }

    /**
    * Check out the consumable to a person
    **/
    public function postCheckout($consumableId)
    {
        // Check if the consumable exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the consumable management page with error
            return Redirect::to('consumables')->with('error', Lang::get('admin/consumables/message.not_found'));
        }

		$admin_user = Sentry::getUser();
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
            // Redirect to the consumable management page with error
            return Redirect::to('admin/consumables')->with('error', Lang::get('admin/consumables/message.user_does_not_exist'));
        }

        // Update the consumable data
        $consumable->assigned_to            		= e(Input::get('assigned_to'));

        $consumable->users()->attach($consumable->id, array(
        'consumable_id' => $consumable->id,
        'assigned_to' => e(Input::get('assigned_to'))));

            $logaction = new Actionlog();
            $logaction->consumable_id = $consumable->id;
            $logaction->checkedout_to = $consumable->assigned_to;
            $logaction->asset_type = 'consumable';
            $logaction->location_id = $user->location_id;
            $logaction->user_id = Sentry::getUser()->id;
            $logaction->note = e(Input::get('note'));

            $settings = Setting::getSettings();

			if ($settings->slack_endpoint) {


				$slack_settings = [
				    'username' => $settings->botname,
				    'channel' => $settings->slack_channel,
				    'link_names' => true
				];

				$client = new \Maknz\Slack\Client($settings->slack_endpoint,$slack_settings);

				try {
						$client->attach([
						    'color' => 'good',
						    'fields' => [
						        [
						            'title' => 'Checked Out:',
						            'value' => strtoupper($logaction->asset_type).' <'.Config::get('app.url').'/admin/consumables/'.$consumable->id.'/view'.'|'.$consumable->name.'> checked out to <'.Config::get('app.url').'/admin/users/'.$user->id.'/view|'.$user->fullName().'> by <'.Config::get('app.url').'/admin/users/'.$admin_user->id.'/view'.'|'.$admin_user->fullName().'>.'
						        ],
						        [
						            'title' => 'Note:',
						            'value' => e($logaction->note)
						        ],



						    ]
						])->send('Consumable Checked Out');

					} catch (Exception $e) {

					}

			}



            $log = $logaction->logaction('checkout');

            $consumable_user = DB::table('consumables_users')->where('assigned_to','=',$consumable->assigned_to)->where('consumable_id','=',$consumable->id)->first();

            $data['log_id'] = $logaction->id;
            $data['eula'] = $consumable->getEula();
            $data['first_name'] = $user->first_name;
            $data['item_name'] = $consumable->name;
            $data['require_acceptance'] = $consumable->requireAcceptance();


            if (($consumable->requireAcceptance()=='1')  || ($consumable->getEula())) {

	            Mail::send('emails.accept-asset', $data, function ($m) use ($user) {
	                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
	                $m->subject('Confirm consumable delivery');
	            });
            }

            // Redirect to the new consumable page
            return Redirect::to("admin/consumables")->with('success', Lang::get('admin/consumables/message.checkout.success'));



    }


    public function getDatatable()
    {
        $consumables = Consumable::select(array('id','name','qty'))
        ->whereNull('deleted_at')
        ->orderBy('created_at', 'DESC');

        $consumables = $consumables->get();

        $actions = new \Chumper\Datatable\Columns\FunctionColumn('actions',function($consumables)
            {
                return '<a href="'.route('checkout/consumable', $consumables->id).'" style="margin-right:5px;" class="btn btn-info btn-sm" '.(($consumables->numRemaining() > 0 ) ? '' : ' disabled').'>'.Lang::get('general.checkout').'</a><a href="'.route('update/consumable', $consumables->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/consumable', $consumables->id).'" data-content="'.Lang::get('admin/consumables/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($consumables->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            });

        return Datatable::collection($consumables)
        ->addColumn('name',function($consumables)
            {
                return link_to('admin/consumables/'.$consumables->id.'/view', $consumables->name);
            })
        ->addColumn('qty',function($consumables)
            {
                return $consumables->qty;
            })
        ->addColumn('numRemaining',function($consumables)
            {
                return $consumables->numRemaining();
            })
        ->addColumn($actions)
        ->searchColumns('name','qty','numRemaining','actions')
        ->orderColumns('name','qty','numRemaining','actions')
        ->make();
    }

	public function getDataView($consumableID)
	{
		$consumable = Consumable::find($consumableID);
        $consumable_users = $consumable->users;


		return Datatable::collection($consumable_users)
		->addColumn('name',function($consumable_users)
			{
				return link_to('/admin/users/'.$consumable_users->id.'/view', $consumable_users->fullName());
			})
		->make();
    }

}
