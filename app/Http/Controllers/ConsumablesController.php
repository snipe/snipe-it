<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Actionlog;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\Setting;
use App\Models\User;
use Auth;
use Config;
use DB;
use Input;
use Lang;
use Mail;
use Redirect;
use Slack;
use Str;
use View;
use Gate;

/**
 * This controller handles all actions related to Consumables for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ConsumablesController extends Controller
{
    /**
    * Return a view to display component information.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return View
    */
    public function getIndex()
    {
        return View::make('consumables/index');
    }


    /**
    * Return a view to display the form view to create a new consumable
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::postCreate() method that stores the form data
    * @since [v1.0]
    * @return View
    */
    public function getCreate()
    {
        // Show the page
        $category_list = Helper::categoryList('consumable');
        $company_list = Helper::companyList();
        $location_list = Helper::locationsList();
        $manufacturer_list = Helper::manufacturerList();

        return View::make('consumables/edit')
            ->with('item', new Consumable)
            ->with('category_list', $category_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list)
            ->with('manufacturer_list', $manufacturer_list);
    }


    /**
    * Validate and store new consumable data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getCreate() method that returns the form view
    * @since [v1.0]
    * @return Redirect
    */
    public function postCreate()
    {
        $consumable = new Consumable();
        $consumable->name                   = e(Input::get('name'));
        $consumable->category_id            = e(Input::get('category_id'));
        $consumable->location_id            = e(Input::get('location_id'));
        $consumable->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
        $consumable->order_number           = e(Input::get('order_number'));
        $consumable->min_amt                = e(Input::get('min_amt'));
        $consumable->manufacturer_id         = e(Input::get('manufacturer_id'));
        $consumable->model_number               = e(Input::get('model_number'));
        $consumable->item_no         = e(Input::get('item_no'));

        if (e(Input::get('purchase_date')) == '') {
            $consumable->purchase_date       =  null;
        } else {
            $consumable->purchase_date       = e(Input::get('purchase_date'));
        }

        if (e(Input::get('purchase_cost')) == '0.00') {
            $consumable->purchase_cost       =  null;
        } else {
            $consumable->purchase_cost       = Helper::ParseFloat(e(Input::get('purchase_cost')));
        }

        $consumable->qty                    = e(Input::get('qty'));
        $consumable->user_id                = Auth::user()->id;

        // Was the consumable created?
        if ($consumable->save()) {
            $consumable->logCreate();
            // Redirect to the new consumable  page
            return redirect()->to("admin/consumables")->with('success', trans('admin/consumables/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($consumable->getErrors());


    }

    /**
    * Returns a form view to edit a consumable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int $consumableId
    * @see ConsumablesController::postEdit() method that stores the form data.
    * @since [v1.0]
    * @return View
    */
    public function getEdit($consumableId = null)
    {
        // Check if the consumable exists
        if (is_null($item = Consumable::find($consumableId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/consumables')->with('error', trans('admin/consumables/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($item)) {
            return redirect()->to('admin/consumables')->with('error', trans('general.insufficient_permissions'));
        }

        $category_list =  Helper::categoryList('consumable');
        $company_list = Helper::companyList();
        $location_list = Helper::locationsList();
        $manufacturer_list = Helper::manufacturerList();

        return View::make('consumables/edit', compact('item'))
            ->with('category_list', $category_list)
            ->with('company_list', $company_list)
            ->with('location_list', $location_list)
            ->with('manufacturer_list', $manufacturer_list);
    }


    /**
    * Returns a form view to edit a consumable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int $consumableId
    * @see ConsumablesController::getEdit() method that stores the form data.
    * @since [v1.0]
    * @return Redirect
    */
    public function postEdit($consumableId = null)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->to('admin/consumables')->with('error', trans('admin/consumables/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($consumable)) {
            return redirect()->to('admin/consumables')->with('error', trans('general.insufficient_permissions'));
        }

        $consumable->name                   = e(Input::get('name'));
        $consumable->category_id            = e(Input::get('category_id'));
        $consumable->location_id            = e(Input::get('location_id'));
        $consumable->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
        $consumable->order_number           = e(Input::get('order_number'));
        $consumable->min_amt                   = e(Input::get('min_amt'));
        $consumable->manufacturer_id         = e(Input::get('manufacturer_id'));
        $consumable->model_number               = e(Input::get('model_number'));
        $consumable->item_no         = e(Input::get('item_no'));

        if (e(Input::get('purchase_date')) == '') {
            $consumable->purchase_date       =  null;
        } else {
            $consumable->purchase_date       = e(Input::get('purchase_date'));
        }

        if (e(Input::get('purchase_cost')) == '0.00') {
            $consumable->purchase_cost       =  null;
        } else {
            $consumable->purchase_cost       = Helper::ParseFloat(e(Input::get('purchase_cost')));
        }

        $consumable->qty                    = Helper::ParseFloat(e(Input::get('qty')));

        if ($consumable->save()) {

            $logaction = new Actionlog();
            $logaction->item_type = Consumable::class;
            $logaction->item_id = $consumable->id;
            $logaction->created_at =  date("Y-m-d H:i:s");
            $logaction->user_id = Auth::user()->id;
            $log = $logaction->logaction('update');


            return redirect()->to("admin/consumables")->with('success', trans('admin/consumables/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($consumable->getErrors());

    }

    /**
    * Delete a consumable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int $consumableId
    * @since [v1.0]
    * @return Redirect
    */
    public function getDelete($consumableId)
    {
        // Check if the blog post exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/consumables')->with('error', trans('admin/consumables/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($consumable)) {
            return redirect()->to('admin/consumables')->with('error', trans('general.insufficient_permissions'));
        }

            $consumable->delete();

            $logaction = new Actionlog();
            $logaction->item_type = Consumable::class;
            $logaction->item_id = $consumable->id;
            $logaction->created_at =  date("Y-m-d H:i:s");
            $logaction->user_id = Auth::user()->id;
            $log = $logaction->logaction('deleted');

            // Redirect to the locations management page
            return redirect()->to('admin/consumables')->with('success', trans('admin/consumables/message.delete.success'));

    }



    /**
    * Return a view to display component information.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getDataView() method that generates the JSON response
    * @since [v1.0]
    * @param int $consumableId
    * @return View
    */
    public function getView($consumableId = null)
    {
        $consumable = Consumable::find($consumableId);

        if (isset($consumable->id)) {


            if (!Company::isCurrentUserHasAccess($consumable)) {
                return redirect()->to('admin/consumables')->with('error', trans('general.insufficient_permissions'));
            } else {
                return View::make('consumables/view', compact('consumable'));
            }
        } else {
            // Prepare the error message
            $error = trans('admin/consumables/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('consumables')->with('error', $error);
        }


    }

    /**
    * Return a view to checkout a consumable to a user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::postCheckout() method that stores the data.
    * @since [v1.0]
    * @param int $consumableId
    * @return View
    */
    public function getCheckout($consumableId)
    {
        // Check if the consumable exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the consumable management page with error
            return redirect()->to('consumables')->with('error', trans('admin/consumables/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($consumable)) {
            return redirect()->to('admin/consumables')->with('error', trans('general.insufficient_permissions'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = Helper::usersList();

        return View::make('consumables/checkout', compact('consumable'))->with('users_list', $users_list);

    }

    /**
    * Saves the checkout information
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getCheckout() method that returns the form.
    * @since [v1.0]
    * @param int $consumableId
    * @return Redirect
    */
    public function postCheckout($consumableId)
    {
      // Check if the consumable exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the consumable management page with error
            return redirect()->to('consumables')->with('error', trans('admin/consumables/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($consumable)) {
            return redirect()->to('admin/consumables')->with('error', trans('general.insufficient_permissions'));
        }

        $admin_user = Auth::user();
        $assigned_to = e(Input::get('assigned_to'));

      // Check if the user exists
        if (is_null($user = User::find($assigned_to))) {
            // Redirect to the consumable management page with error
            return redirect()->to('admin/consumables')->with('error', trans('admin/consumables/message.user_does_not_exist'));
        }

      // Update the consumable data
        $consumable->assigned_to = e(Input::get('assigned_to'));

        $consumable->users()->attach($consumable->id, array(
        'consumable_id' => $consumable->id,
        'user_id' => $admin_user->id,
        'assigned_to' => e(Input::get('assigned_to'))));

        $logaction = $consumable->logCheckout(e(Input::get('note')));

        $settings = Setting::getSettings();

        if ($settings->slack_endpoint) {

            $slack_settings = [
                'username' => $settings->botname,
                'channel' => $settings->slack_channel,
                'link_names' => true
            ];

            $client = new \Maknz\Slack\Client($settings->slack_endpoint, $slack_settings);

            try {
                    $client->attach([
                        'color' => 'good',
                        'fields' => [
                            [
                                'title' => 'Checked Out:',
                                'value' => 'Consumable <'.config('app.url').'/admin/consumables/'.$consumable->id.'/view'.'|'.$consumable->name.'> checked out to <'.config('app.url').'/admin/users/'.$user->id.'/view|'.$user->fullName().'> by <'.config('app.url').'/admin/users/'.$admin_user->id.'/view'.'|'.$admin_user->fullName().'>.'
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

        $consumable_user = DB::table('consumables_users')->where('assigned_to', '=', $consumable->assigned_to)->where('consumable_id', '=', $consumable->id)->first();

        $data['log_id'] = $logaction->id;
        $data['eula'] = $consumable->getEula();
        $data['first_name'] = $user->first_name;
        $data['item_name'] = $consumable->name;
        $data['checkout_date'] = $logaction->created_at;
        $data['note'] = $logaction->note;
        $data['require_acceptance'] = $consumable->requireAcceptance();


        if (($consumable->requireAcceptance()=='1')  || ($consumable->getEula())) {

            Mail::send('emails.accept-asset', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                $m->subject(trans('mail.Confirm_consumable_delivery'));
            });
        }

      // Redirect to the new consumable page
        return redirect()->to("admin/consumables")->with('success', trans('admin/consumables/message.checkout.success'));



    }


    /**
    * Returns the JSON response containing the the consumables data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getIndex() method that returns the view that consumes the JSON.
    * @since [v1.0]
    * @param int $consumableId
    * @return View
    */
    public function getDatatable()
    {
        $consumables = Company::scopeCompanyables(
            Consumable::select('consumables.*')
            ->whereNull('consumables.deleted_at')
            ->with('company', 'location', 'category', 'users', 'manufacturer')
        );

        if (Input::has('search')) {
            $consumables = $consumables->TextSearch(e(Input::get('search')));
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

        $allowed_columns = ['id','name','order_number','min_amt','purchase_date','purchase_cost','companyName','category','model_number', 'item_no', 'manufacturer'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

        switch ($sort) {
            case 'category':
                $consumables = $consumables->OrderCategory($order);
                break;
            case 'location':
                $consumables = $consumables->OrderLocation($order);
                break;
            case 'manufacturer':
                $consumables = $consumables->OrderManufacturer($order);
                break;
            case 'companyName':
                $consumables = $consumables->OrderCompany($order);
                break;
            default:
                $consumables = $consumables->orderBy($sort, $order);
                break;
        }

        $consumCount = $consumables->count();
        $consumables = $consumables->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($consumables as $consumable) {
            $actions = '<nobr>';
            if (Gate::allows('consumables.checkout')) {
                $actions .= '<a href="' . route('checkout/consumable',
                        $consumable->id) . '" style="margin-right:5px;" class="btn btn-info btn-sm" ' . (($consumable->numRemaining() > 0) ? '' : ' disabled') . '>' . trans('general.checkout') . '</a>';
            }

            if (Gate::allows('consumables.edit')) {
                $actions .= '<a href="' . route('update/consumable',
                        $consumable->id) . '" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a>';
            }
            if (Gate::allows('consumables.delete')) {
                $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="' . route('delete/consumable',
                        $consumable->id) . '" data-content="' . trans('admin/consumables/message.delete.confirm') . '" data-title="' . trans('general.delete') . ' ' . htmlspecialchars($consumable->name) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            }

            $actions .='</nobr>';

            $company = $consumable->company;

            $rows[] = array(
                'id'            => $consumable->id,
                'name'          => (string)link_to('admin/consumables/'.$consumable->id.'/view', e($consumable->name)),
                'location'   => ($consumable->location) ? e($consumable->location->name) : '',
                'min_amt'           => e($consumable->min_amt),
                'qty'           => e($consumable->qty),
                'manufacturer'  => ($consumable->manufacturer) ? (string) link_to('/admin/settings/manufacturers/'.$consumable->manufacturer_id.'/view', $consumable->manufacturer->name): '',
                'model_number'      => e($consumable->model_number),
                'item_no'       => e($consumable->item_no),
                'category'      => ($consumable->category) ? (string) link_to('/admin/settings/categories/'.$consumable->category_id.'/view', $consumable->category->name) : 'Missing category',
                'order_number'  => e($consumable->order_number),
                'purchase_date'  => e($consumable->purchase_date),
                'purchase_cost'  => Helper::formatCurrencyOutput($consumable->purchase_cost),
                'numRemaining'  => $consumable->numRemaining(),
                'actions'       => $actions,
                'companyName'   => is_null($company) ? '' : e($company->name),
            );
        }

        $data = array('total' => $consumCount, 'rows' => $rows);

        return $data;

    }

    /**
    * Returns a JSON response containing details on the users associated with this consumable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getView() method that returns the form.
    * @since [v1.0]
    * @param int $consumableId
    * @return View
    */
    public function getDataView($consumableId)
    {
        //$consumable = Consumable::find($consumableID);
        $consumable = Consumable::with(array('consumableAssigments'=>
        function ($query) {
            $query->orderBy('created_at', 'DESC');
        },
        'consumableAssigments.admin'=> function ($query) {
        },
        'consumableAssigments.user'=> function ($query) {
        },
        ))->find($consumableId);

  //  $consumable->load('consumableAssigments.admin','consumableAssigments.user');

        if (!Company::isCurrentUserHasAccess($consumable)) {
            return ['total' => 0, 'rows' => []];
        }

        $rows = array();

        foreach ($consumable->consumableAssigments as $consumable_assignment) {
            $rows[] = array(
            'name' => (string)link_to('/admin/users/'.$consumable_assignment->user->id.'/view', e($consumable_assignment->user->fullName())),
            'created_at' => ($consumable_assignment->created_at->format('Y-m-d H:i:s')=='-0001-11-30 00:00:00') ? '' : $consumable_assignment->created_at->format('Y-m-d H:i:s'),
            'admin' => ($consumable_assignment->admin) ? e($consumable_assignment->admin->fullName()) : '',
            );
        }

        $consumableCount = $consumable->users->count();
        $data = array('total' => $consumableCount, 'rows' => $rows);
        return $data;
    }
}
