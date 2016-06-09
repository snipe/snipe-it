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
use Company;
use Mail;
use Datatable;
use Slack;
use Config;

class AccessoriesController extends AdminController
{
    /**
     * Show a list of all the accessories.
     *
     * @return View
     */

    public function getIndex()
    {
        return View::make('backend/accessories/index');
    }


    /**
     * Accessory create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
        $category_list = array('' => '') + DB::table('categories')->where('category_type','=','accessory')->whereNull('deleted_at')->orderBy('name','ASC')->lists('name', 'id');
        $company_list = companyList();
        $location_list = locationsList();
        return View::make('backend/accessories/edit')
            ->with('accessory', new Accessory)
            ->with('category_list', $category_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list);
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
            $accessory->location_id            	= e(Input::get('location_id'));
            $accessory->company_id              = Company::getIdForCurrentUser(Input::get('company_id'));
            $accessory->order_number            = e(Input::get('order_number'));

            if (e(Input::get('purchase_date')) == '') {
                $accessory->purchase_date       =  NULL;
            } else {
                $accessory->purchase_date       = e(Input::get('purchase_date'));
            }

            if (e(Input::get('purchase_cost')) == '0.00') {
                $accessory->purchase_cost       =  NULL;
            } else {
                $accessory->purchase_cost       = ParseFloat(e(Input::get('purchase_cost')));
            }

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
        else if (!Company::isCurrentUserHasAccess($accessory)) {
            return Redirect::to('admin/accessories')->with('error', Lang::get('general.insufficient_permissions'));
        }

		    $category_list = array('' => '') + DB::table('categories')->where('category_type','=','accessory')->whereNull('deleted_at')->orderBy('name','ASC')->lists('name', 'id');
        $company_list = companyList();
        $location_list = locationsList();

        return View::make('backend/accessories/edit', compact('accessory'))
            ->with('category_list',$category_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list);
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
        else if (!Company::isCurrentUserHasAccess($accessory)) {
            return Redirect::to('admin/accessories')->with('error', Lang::get('general.insufficient_permissions'));
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

            if (e(Input::get('location_id')) == '') {
                $accessory->location_id = NULL;
            } else {
                $accessory->location_id     = e(Input::get('location_id'));
            }

            $accessory->category_id            	= e(Input::get('category_id'));
            $accessory->company_id              = Company::getIdForCurrentUser(Input::get('company_id'));
            $accessory->order_number            = e(Input::get('order_number'));

            if (e(Input::get('purchase_date')) == '') {
                $accessory->purchase_date       =  NULL;
            } else {
                $accessory->purchase_date       = e(Input::get('purchase_date'));
            }

            if (e(Input::get('purchase_cost')) == '0.00') {
                $accessory->purchase_cost       =  NULL;
            } else {
                $accessory->purchase_cost       = ParseFloat(e(Input::get('purchase_cost')));
            }

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
        else if (!Company::isCurrentUserHasAccess($accessory)) {
            return Redirect::to('admin/accessories')->with('error', Lang::get('general.insufficient_permissions'));
        }


		if ($accessory->hasUsers() > 0) {
			 return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.assoc_users', array('count'=> $accessory->hasUsers())));
		} else {
			$accessory->delete();

            // Redirect to the locations management page
            return Redirect::to('admin/accessories')->with('success', Lang::get('admin/accessories/message.delete.success'));

		}





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

            if (!Company::isCurrentUserHasAccess($accessory)) {
                return Redirect::to('admin/accessories')->with('error', Lang::get('general.insufficient_permissions'));
            }
            else {
                return View::make('backend/accessories/view', compact('accessory'));
            }
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
        else if (!Company::isCurrentUserHasAccess($accessory)) {
            return Redirect::to('admin/accessories')->with('error', Lang::get('general.insufficient_permissions'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = array('' => 'Select a User') + DB::table('users')->select(DB::raw('concat(last_name,", ",first_name," (",username,")") as full_name, id'))->whereNull('deleted_at')->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->lists('full_name', 'id');

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
        else if (!Company::isCurrentUserHasAccess($accessory)) {
            return Redirect::to('admin/accessories')->with('error', Lang::get('general.insufficient_permissions'));
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
						            'value' => strtoupper($logaction->asset_type).' <'.Config::get('app.url').'/admin/accessories/'.$accessory->id.'/view'.'|'.$accessory->name.'> checked out to <'.Config::get('app.url').'/admin/users/'.$user->id.'/view|'.$user->fullName().'> by <'.Config::get('app.url').'/admin/users/'.$admin_user->id.'/view'.'|'.$admin_user->fullName().'>.'
						        ],
						        [
						            'title' => 'Note:',
						            'value' => e($logaction->note)
						        ],



						    ]
						])->send('Accessory Checked Out');

					} catch (Exception $e) {

					}

			}



            $log = $logaction->logaction('checkout');

            $accessory_user = DB::table('accessories_users')->where('assigned_to','=',$accessory->assigned_to)->where('accessory_id','=',$accessory->id)->first();

            $data['log_id'] = $logaction->id;
            $data['eula'] = $accessory->getEula();
            $data['first_name'] = $user->first_name;
            $data['item_name'] = $accessory->name;
            $data['checkout_date'] = $logaction->created_at;
            $data['item_tag'] = '';
            $data['item_serial'] = '';
            $data['expected_checkin'] = '';
            $data['note'] = $logaction->note;
            $data['require_acceptance'] = $accessory->requireAcceptance();


            if (($accessory->requireAcceptance()=='1')  || ($accessory->getEula())) {

	            Mail::send('emails.accept-asset', $data, function ($m) use ($user) {
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
    public function getCheckin($accessoryUserId = null, $backto = null)
    {
        // Check if the accessory exists
        if (is_null($accessory_user = DB::table('accessories_users')->find($accessoryUserId))) {
            // Redirect to the accessory management page with error
            return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.not_found'));
        }

		$accessory = Accessory::find($accessory_user->accessory_id);

        if (!Company::isCurrentUserHasAccess($accessory)) {
            return Redirect::to('admin/accessories')->with('error', Lang::get('general.insufficient_permissions'));
        }
        else {
            return View::make('backend/accessories/checkin', compact('accessory'))->with('backto',$backto);
        }
    }


    /**
    * Check in the item so that it can be checked out again to someone else
    *
    * @param  int  $accessoryId
    * @return View
    **/
    public function postCheckin($accessoryUserId = null, $backto = null)
    {
        // Check if the accessory exists
        if (is_null($accessory_user = DB::table('accessories_users')->find($accessoryUserId))) {
            // Redirect to the accessory management page with error
            return Redirect::to('admin/accessories')->with('error', Lang::get('admin/accessories/message.not_found'));
        }


		$accessory = Accessory::find($accessory_user->accessory_id);

        if (!Company::isCurrentUserHasAccess($accessory)) {
            return Redirect::to('admin/accessories')->with('error', Lang::get('general.insufficient_permissions'));
        }

        $logaction = new Actionlog();
        $logaction->checkedout_to = $accessory_user->assigned_to;
        $return_to = $accessory_user->assigned_to;
        $admin_user = Sentry::getUser();


        // Was the accessory updated?
        if(DB::table('accessories_users')->where('id', '=', $accessory_user->id)->delete()) {

            $logaction->accessory_id = $accessory->id;
            $logaction->location_id = NULL;
            $logaction->asset_type = 'accessory';
            $logaction->user_id = $admin_user->id;
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
						            'title' => 'Checked In:',
						            'value' => strtoupper($logaction->asset_type).' <'.Config::get('app.url').'/admin/accessories/'.$accessory->id.'/view'.'|'.$accessory->name.'> checked in by <'.Config::get('app.url').'/admin/users/'.$admin_user->id.'/view'.'|'.$admin_user->fullName().'>.'
						        ],
						        [
						            'title' => 'Note:',
						            'value' => e($logaction->note)
						        ],

						    ]
						])->send('Accessory Checked In');

					} catch (Exception $e) {

					}

			}


            $log = $logaction->logaction('checkin from');

            if(!is_null($accessory_user->assigned_to)) {
                $user = User::find($accessory_user->assigned_to);
            }

            $data['log_id'] = $logaction->id;
            $data['first_name'] = $user->first_name;
            $data['item_name'] = $accessory->name;
            $data['checkin_date'] = $logaction->created_at;
            $data['item_tag'] = '';
            $data['note'] = $logaction->note;

            if (($accessory->checkin_email()=='1')) {

                Mail::send('emails.checkin-asset', $data, function ($m) use ($user) {
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->subject('Confirm Accessory Checkin');
                });
            }

            if ($backto=='user') {
				return Redirect::to("admin/users/".$return_to.'/view')->with('success', Lang::get('admin/accessories/message.checkin.success'));
			} else {
				return Redirect::to("admin/accessories/".$accessory->id."/view")->with('success', Lang::get('admin/accessories/message.checkin.success'));
			}
        }

        // Redirect to the accessory management page with error
        return Redirect::to("admin/accessories")->with('error', Lang::get('admin/accessories/message.checkin.error'));
    }

    public function getDatatable()
    {
        $accessories = Accessory::select('accessories.*')->with('category', 'company')
        ->whereNull('accessories.deleted_at');

        if (Input::has('search')) {
            $accessories = $accessories->TextSearch(Input::get('search'));
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


        $allowed_columns = ['name','order_number','purchase_date','purchase_cost','companyName','category'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

        switch ($sort)
        {
            case 'category':
                $accessories = $accessories->OrderCategory($order);
                break;
            case 'companyName':
                $accessories = $accessories->OrderCompany($order);
                break;
            default:
                $accessories = $accessories->orderBy($sort, $order);
                break;
        }

        $accessCount = $accessories->count();
        $accessories = $accessories->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($accessories as $accessory) {
            $actions = '<nobr><a href="'.route('checkout/accessory', $accessory->id).'" style="margin-right:5px;" class="btn btn-info btn-sm" '.(($accessory->numRemaining() > 0 ) ? '' : ' disabled').'>'.Lang::get('general.checkout').'</a><a href="'.route('update/accessory', $accessory->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/accessory', $accessory->id).'" data-content="'.Lang::get('admin/accessories/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($accessory->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></nobr>';
            $company = $accessory->company;

            $rows[] = array(
                'name'          => link_to('admin/accessories/'.$accessory->id.'/view', $accessory->name),
                'category'      => link_to('admin/settings/categories/'.$accessory->category->id.'/view', $accessory->category->name),
                'qty'           => $accessory->qty,
                'order_number'  => $accessory->order_number,
                'location'      => ($accessory->location) ? $accessory->location->name: '',
                'purchase_date' => $accessory->purchase_date,
                'purchase_cost' => $accessory->purchase_cost,
                'numRemaining'  => $accessory->numRemaining(),
                'actions'       => $actions,
                'companyName'   => is_null($company) ? '' : e($company->name)
            );
        }

        $data = array('total'=>$accessCount, 'rows'=>$rows);

        return $data;
    }

	public function getDataView($accessoryID)
	{
		$accessory = Accessory::find($accessoryID);

        if (!Company::isCurrentUserHasAccess($accessory)) {
            return ['total' => 0, 'rows' => []];
        }

        $accessory_users = $accessory->users;
        $count = $accessory_users->count();

        $rows = array();

        foreach ($accessory_users as $user) {
            $actions = '<a href="'.route('checkin/accessory', $user->pivot->id).'" class="btn-flat info">Checkin</a>';

            $rows[] = array(
                'name'          => link_to('/admin/users/'.$user->id.'/view', $user->fullName()),
                'actions'       => $actions
                );
        }

        $data = array('total'=>$count, 'rows'=>$rows);

        return $data;
    }

}
