<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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
use Image;
use App\Http\Requests\ImageUploadRequest;

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
        return view('consumables/index');
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
        $category_type = 'consumable';
        return view('consumables/edit')->with('category_type', $category_type)
            ->with('item', new Consumable);
    }


    /**
    * Validate and store new consumable data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ConsumablesController::getCreate() method that returns the form view
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Consumable::class);
        $consumable = new Consumable();
        $consumable->name                   = $request->input('name');
        $consumable->category_id            = $request->input('category_id');
        $consumable->location_id            = $request->input('location_id');
        $consumable->company_id             = Company::getIdForCurrentUser($request->input('company_id'));
        $consumable->order_number           = $request->input('order_number');
        $consumable->min_amt                = $request->input('min_amt');
        $consumable->manufacturer_id        = $request->input('manufacturer_id');
        $consumable->model_number           = $request->input('model_number');
        $consumable->item_no                = $request->input('item_no');
        $consumable->purchase_date          = $request->input('purchase_date');
        $consumable->purchase_cost          = Helper::ParseFloat($request->input('purchase_cost'));
        $consumable->qty                    = $request->input('qty');
        $consumable->user_id                = Auth::id();


        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/consumables/'.$file_name);
            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $consumable->image = $file_name;
        }

        if ($consumable->save()) {
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
        if ($item = Consumable::find($consumableId)) {
            $this->authorize($item);
            $category_type = 'consumable';
            return view('consumables/edit', compact('item'))->with('category_type', $category_type);
        }

        return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));

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
    public function update(ImageUploadRequest $request,  $consumableId = null)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
        }

        $this->authorize($consumable);

        $consumable->name                   = $request->input('name');
        $consumable->category_id            = $request->input('category_id');
        $consumable->location_id            = $request->input('location_id');
        $consumable->company_id             = Company::getIdForCurrentUser($request->input('company_id'));
        $consumable->order_number           = $request->input('order_number');
        $consumable->min_amt                = $request->input('min_amt');
        $consumable->manufacturer_id        = $request->input('manufacturer_id');
        $consumable->model_number           = $request->input('model_number');
        $consumable->item_no                = $request->input('item_no');
        $consumable->purchase_date          = $request->input('purchase_date');
        $consumable->purchase_cost          = Helper::ParseFloat(Input::get('purchase_cost'));
        $consumable->qty                    = Helper::ParseFloat(Input::get('qty'));

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/consumables/'.$file_name);
            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $consumable->image = $file_name;
        } elseif ($request->input('image_delete')=='1') {
            $consumable->image = null;
        }

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
        if (is_null($consumable = Consumable::find($consumableId))) {
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
            return view('consumables/view', compact('consumable'));
        }
        return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist', compact('id')));
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
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
        }
        $this->authorize('checkout', $consumable);
        return view('consumables/checkout', compact('consumable'));
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
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        }

        $this->authorize('checkout', $consumable);

        $admin_user = Auth::user();
        $assigned_to = e(Input::get('assigned_to'));

        // Check if the user exists
        if (is_null($user = User::find($assigned_to))) {
            // Redirect to the consumable management page with error
            return redirect()->route('checkout/consumable', $consumable)->with('error', trans('admin/consumables/message.checkout.user_does_not_exist'));
        }

        // Update the consumable data
        $consumable->assigned_to = e(Input::get('assigned_to'));

        $consumable->users()->attach($consumable->id, [
            'consumable_id' => $consumable->id,
            'user_id' => $admin_user->id,
            'assigned_to' => e(Input::get('assigned_to'))
        ]);

        $logaction = $consumable->logCheckout(e(Input::get('note')), $user);
        $data['log_id'] = $logaction->id;
        $data['eula'] = $consumable->getEula();
        $data['first_name'] = $user->first_name;
        $data['item_name'] = $consumable->name;
        $data['checkout_date'] = $logaction->created_at;
        $data['note'] = $logaction->note;
        $data['require_acceptance'] = $consumable->requireAcceptance();

        if ((($consumable->requireAcceptance()=='1')  || ($consumable->getEula())) && $user->email!='') {

            Mail::send('emails.accept-asset', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                $m->subject(trans('mail.Confirm_consumable_delivery'));
            });
        }

      // Redirect to the new consumable page
        return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.checkout.success'));

    }

}
