<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Actionlog;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\CheckoutNotification;
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
    * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize('index', Consumable::class);
        return View::make('consumables/index');
    }


    /**
    * Return a view to display the form view to create a new consumable
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::postCreate() method that stores the form data
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Consumable::class);
        // Show the page
        return View::make('consumables/edit')
            ->with('item', new Consumable)
            ->with('category_list', Helper::categoryList('consumable'))
            ->with('company_list', Helper::companyList())
            ->with('location_list', Helper::locationsList())
            ->with('manufacturer_list', Helper::manufacturerList());
    }


    /**
    * Validate and store new consumable data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getCreate() method that returns the form view
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->authorize('create', Consumable::class);
        $consumable = new Consumable();
        $consumable->name                   = Input::get('name');
        $consumable->category_id            = Input::get('category_id');
        $consumable->location_id            = Input::get('location_id');
        $consumable->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
        $consumable->order_number           = Input::get('order_number');
        $consumable->min_amt                = Input::get('min_amt');
        $consumable->manufacturer_id         = Input::get('manufacturer_id');
        $consumable->model_number               = Input::get('model_number');
        $consumable->item_no         = Input::get('item_no');

        if (Input::get('purchase_date') == '') {
            $consumable->purchase_date       =  null;
        } else {
            $consumable->purchase_date       = Input::get('purchase_date');
        }

        if (Input::get('purchase_cost') == '0.00') {
            $consumable->purchase_cost       =  null;
        } else {
            $consumable->purchase_cost       = Helper::ParseFloat(Input::get('purchase_cost'));
        }

        $consumable->qty                    = Input::get('qty');
        $consumable->user_id                = Auth::id();

        // Was the consumable created?
        if ($consumable->save()) {
            $consumable->logCreate();
            // Redirect to the new consumable  page
            return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.create.success'));
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
    * @return \Illuminate\Contracts\View\View
     */
    public function edit($consumableId = null)
    {
        // Check if the consumable exists
        if (is_null($item = Consumable::find($consumableId))) {
            // Redirect to the blogs management page
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
        }

        $this->authorize($item);

        return View::make('consumables/edit', compact('item'))
            ->with('category_list', Helper::categoryList('consumable'))
            ->with('company_list', Helper::companyList())
            ->with('location_list', Helper::locationsList())
            ->with('manufacturer_list', Helper::manufacturerList());
    }


    /**
    * Returns a form view to edit a consumable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int $consumableId
    * @see ConsumablesController::getEdit() method that stores the form data.
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function update($consumableId = null)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
        }

        $this->authorize($consumable);

        $consumable->name                   = Input::get('name');
        $consumable->category_id            = Input::get('category_id');
        $consumable->location_id            = Input::get('location_id');
        $consumable->company_id             = Company::getIdForCurrentUser(Input::get('company_id'));
        $consumable->order_number           = Input::get('order_number');
        $consumable->min_amt                   = Input::get('min_amt');
        $consumable->manufacturer_id         = Input::get('manufacturer_id');
        $consumable->model_number               = Input::get('model_number');
        $consumable->item_no         = Input::get('item_no');

        if (Input::get('purchase_date') == '') {
            $consumable->purchase_date       =  null;
        } else {
            $consumable->purchase_date       = Input::get('purchase_date');
        }

        if (Input::get('purchase_cost') == '0.00') {
            $consumable->purchase_cost       =  null;
        } else {
            $consumable->purchase_cost       = Helper::ParseFloat(Input::get('purchase_cost'));
        }

        $consumable->qty                    = Helper::ParseFloat(Input::get('qty'));

        if ($consumable->save()) {
            return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($consumable->getErrors());
    }

    /**
    * Delete a consumable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int $consumableId
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($consumableId)
    {
        // Check if the blog post exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the blogs management page
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        }
        $this->authorize($consumable);
        $consumable->delete();
        // Redirect to the locations management page
        return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.delete.success'));
    }

    /**
    * Return a view to display component information.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getDataView() method that generates the JSON response
    * @since [v1.0]
    * @param int $consumableId
    * @return \Illuminate\Contracts\View\View
     */
    public function show($consumableId = null)
    {
        $consumable = Consumable::find($consumableId);
        $this->authorize($consumable);
        if (isset($consumable->id)) {
            return View::make('consumables/view', compact('consumable'));
        }
        // Prepare the error message
        $error = trans('admin/consumables/message.does_not_exist', compact('id'));

        // Redirect to the user management page
        return redirect()->route('consumables')->with('error', $error);
    }

    /**
    * Return a view to checkout a consumable to a user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::postCheckout() method that stores the data.
    * @since [v1.0]
    * @param int $consumableId
    * @return \Illuminate\Contracts\View\View
     */
    public function getCheckout($consumableId)
    {
        // Check if the consumable exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the consumable management page with error
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        }
        $this->authorize('checkout', $consumable);
        // Get the dropdown of users and then pass it to the checkout view
        return View::make('consumables/checkout', compact('consumable'))->with('users_list', Helper::usersList());
    }

    /**
    * Saves the checkout information
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getCheckout() method that returns the form.
    * @since [v1.0]
    * @param int $consumableId
    * @return \Illuminate\Http\RedirectResponse
     */
    public function postCheckout($consumableId)
    {
      // Check if the consumable exists
        if (is_null($consumable = Consumable::find($consumableId))) {
            // Redirect to the consumable management page with error
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        }

        $this->authorize('checkout', $consumable);

        $admin_user = Auth::user();
        $assigned_to = e(Input::get('assigned_to'));

      // Check if the user exists
        if (is_null($user = User::find($assigned_to))) {
            // Redirect to the consumable management page with error
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.user_does_not_exist'));
        }

      // Update the consumable data
        $consumable->assigned_to = e(Input::get('assigned_to'));

        $consumable->users()->attach($consumable->id, [
            'consumable_id' => $consumable->id,
            'user_id' => $admin_user->id,
            'assigned_to' => e(Input::get('assigned_to'))
        ]);

        $logaction = $consumable->logCheckout(e(Input::get('note')));
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
        return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.checkout.success'));

    }


    /**
    * Returns the JSON response containing the the consumables data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getIndex() method that returns the view that consumes the JSON.
    * @since [v1.0]
    * @return array
     */
    public function getDatatable()
    {
        $this->authorize('index', Consumable::class);
        $consumables = Company::scopeCompanyables(
            Consumable::select('consumables.*')
            ->whereNull('consumables.deleted_at')
            ->with('company', 'location', 'category', 'users', 'manufacturer')
        );

        if (Input::has('search')) {
            $consumables = $consumables->TextSearch(e(Input::get('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);
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
            $rows[] = $consumable->present()->forDataTable();
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
    * @return array
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
        $this->authorize('view', Component::class);
        $rows = array();

        foreach ($consumable->consumableAssigments as $consumable_assignment) {
            $rows[] = [
                'name' => $consumable_assignment->user->present()->nameUrl(),
                'created_at' => ($consumable_assignment->created_at->format('Y-m-d H:i:s')=='-0001-11-30 00:00:00') ? '' : $consumable_assignment->created_at->format('Y-m-d H:i:s'),
                'admin' => ($consumable_assignment->admin) ? $consumable_assignment->admin->present()->nameUrl() : '',
            ];
        }

        $consumableCount = $consumable->users->count();
        $data = array('total' => $consumableCount, 'rows' => $rows);
        return $data;
    }
}
