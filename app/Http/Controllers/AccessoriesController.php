<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\Company;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Gate;
use Input;
use Lang;
use Redirect;
use Illuminate\Http\Request;
use Slack;
use Str;
use View;
use Validator;
use Image;
use App\Http\Requests\ImageUploadRequest;

/** This controller handles all actions related to Accessories for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class AccessoriesController extends Controller
{

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the accessories listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see AccessoriesController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return View
    */
    public function index(Request $request)
    {
        $this->authorize('index', Accessory::class);
        return view('accessories/index');
    }


  /**
   * Returns a view with a form to create a new Accessory.
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @return View
   */
    public function create(Request $request)
    {
        $this->authorize('create', Accessory::class);
        $category_type = 'accessory';
        return view('accessories/edit')->with('category_type', $category_type)
          ->with('item', new Accessory);
    }


  /**
   * Validate and save new Accessory from form post
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @return Redirect
   */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize(Accessory::class);
        // create a new model instance
        $accessory = new Accessory();

        // Update the accessory data
        $accessory->name                    = request('name');
        $accessory->category_id             = request('category_id');
        $accessory->location_id             = request('location_id');
        $accessory->min_amt                 = request('min_amt');
        $accessory->company_id              = Company::getIdForCurrentUser(request('company_id'));
        $accessory->order_number            = request('order_number');
        $accessory->manufacturer_id         = request('manufacturer_id');
        $accessory->model_number            = request('model_number');
        $accessory->purchase_date           = request('purchase_date');
        $accessory->purchase_cost           = Helper::ParseFloat(request('purchase_cost'));
        $accessory->qty                     = request('qty');
        $accessory->user_id                 = Auth::user()->id;
        $accessory->supplier_id             = request('supplier_id');
        $accessory->department_id           = request('department_id');
        $accessory = $request->handleImages($accessory,600, public_path().'/uploads/accessories');


        // Was the accessory created?
        if ($accessory->save()) {
            // Redirect to the new accessory  page
            return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($accessory->getErrors());
    }

  /**
   * Return view for the Accessory update form, prepopulated with existing data
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @param  int  $accessoryId
   * @return View
   */
    public function edit(Request $request, $accessoryId = null)
    {

        if ($item = Accessory::find($accessoryId)) {
            $this->authorize($item);
            $category_type = 'accessory';
            $min_quantity = $item->qty - $item->numRemaining();
            return view('accessories/edit', compact('item', 'min_quantity'))->with('category_type', $category_type);
        }

        return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist'));

    }


  /**
   * Save edited Accessory from form post
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @param  int  $accessoryId
   * @return Redirect
   */
    public function update(ImageUploadRequest $request, $accessoryId = null)
    {
        if (is_null($accessory = Accessory::find($accessoryId))) {
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist'));
        }

        $this->authorize($accessory);

        // check the quantity is equal to or greater than the checked out quantity
        $min_edit = $accessory->qty - $accessory->numRemaining();
        $validator = Validator::make($request->all(), [
            "qty"  => "required|numeric|min:$min_edit"
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update the accessory data
        $accessory->name                    = request('name');
        $accessory->location_id             = request('location_id');
        $accessory->min_amt                 = request('min_amt');
        $accessory->category_id             = request('category_id');
        $accessory->company_id              = Company::getIdForCurrentUser(request('company_id'));
        $accessory->manufacturer_id         = request('manufacturer_id');
        $accessory->order_number            = request('order_number');
        $accessory->model_number            = request('model_number');
        $accessory->purchase_date           = request('purchase_date');
        $accessory->purchase_cost           = request('purchase_cost');
        $accessory->qty                     = $new_quantity;
        $accessory->supplier_id             = request('supplier_id');
        $accessory->department_id             = request('department_id');

        $accessory = $request->handleImages($accessory,600, public_path().'/uploads/accessories');


        // Was the accessory updated?
        if ($accessory->save()) {
            return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($accessory->getErrors());
    }

  /**
   * Delete the given accessory.
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @param  int  $accessoryId
   * @return Redirect
   */
    public function destroy(Request $request, $accessoryId)
    {
        if (is_null($accessory = Accessory::find($accessoryId))) {
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.not_found'));
        }

        $this->authorize($accessory);


        if ($accessory->hasUsers() > 0) {
             return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.assoc_users', array('count'=> $accessory->hasUsers())));
        }
        $accessory->delete();
        return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.delete.success'));
    }



  /**
  * Returns a view that invokes the ajax table which  contains
  * the content for the accessory detail view, which is generated in getDataView.
  *
  * @author [A. Gianotto] [<snipe@snipe.net>]
  * @param  int  $accessoryID
  * @see AccessoriesController::getDataView() method that generates the JSON response
  * @since [v1.0]
  * @return View
  */
    public function show(Request $request, $accessoryID = null)
    {
        $accessory = Accessory::find($accessoryID);
        $this->authorize('view', $accessory);
        if (isset($accessory->id)) {
            return view('accessories/view', compact('accessory'));
        }
        return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist', compact('id')));
    }

  /**
   * Return the form to checkout an Accessory to a user.
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @param  int  $accessoryId
   * @return View
   */
    public function getCheckout(Request $request, $accessoryId)
    {
        // Check if the accessory exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the accessory management page with error
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.not_found'));
        }

        if ($accessory->category) {

            $this->authorize('checkout', $accessory);

            // Get the dropdown of users and then pass it to the checkout view
            return view('accessories/checkout', compact('accessory'));
        }

        return redirect()->back()->with('error', 'The category type for this accessory is not valid. Edit the accessory and select a valid accessory category.');



    }

  /**
   * Save the Accessory checkout information.
   *
   * If Slack is enabled and/or asset acceptance is enabled, it will also
   * trigger a Slack message and send an email.
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @param  int  $accessoryId
   * @return Redirect
   */
    public function postCheckout(Request $request, $accessoryId)
    {
      // Check if the accessory exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the accessory management page with error
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.user_not_found'));
        }

        $this->authorize('checkout', $accessory);

        // Validate quantity and assigned_user ID
        $max_to_checkout = $accessory->numRemaining();
        if ($max_to_checkout <= 0) {
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.checkout.not_enough'));
        }
        $validator = Validator::make($request->all(), [
            "assigned_to"   => "required",
            "qty"  => "required|numeric|between:1,$max_to_checkout"
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (!$assigned_user = User::find(request('assigned_to'))) {
            return redirect()->route('checkout/accessory', $accessory->id)->with('error', trans('admin/accessories/message.checkout.user_does_not_exist'));
        }

        // check if accessory is assigned already and add quantity
        $checkout_qty = (int)request('qty');
        $accessory_user = DB::table('accessories_users')->where('assigned_to', '=', request('assigned_to'))->where('accessory_id', '=', $accessory->id)->first();
        if ($accessory_user) {
            $updated_qty = $accessory_user->assigned_qty + $checkout_qty;
            DB::table('accessories_users')->where('id', $accessory_user->id)->update(['assigned_qty' => $updated_qty]);
        } else {
            $accessory->users()->attach($accessory->id, [
                'accessory_id' => $accessory->id,
                'created_at' => Carbon::now(),
                'user_id' => Auth::id(),
                'assigned_to' => request('assigned_to'),
                'assigned_qty' => $checkout_qty
            ]);
        }

        $logaction = $accessory->logCheckout(e(request('note')), $assigned_user);

        // Not used?  remove?
        /*
        $data['log_id'] = $logaction->id;
        $data['eula'] = $accessory->getEula();
        $data['first_name'] = $user->first_name;
        $data['item_name'] = $accessory->name;
        $data['checkout_date'] = $logaction->created_at;
        $data['item_tag'] = '';
        $data['expected_checkin'] = '';
        $data['note'] = $logaction->note;
        $data['require_acceptance'] = $accessory->requireAcceptance();
        */

        // Redirect to the new accessory page
        return redirect()->route('accessories.index')->with('success', trans('admin/accessories/message.checkout.success'));
    }


    /**
     * Check the accessory back into inventory
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @param integer $accessoryUserId
     * @param string $backto
     * @return View
     * @internal param int $accessoryId
     */
    public function getCheckin(Request $request, $accessoryUserId = null, $backto = null)
    {
        // Check if the accessory exists
        if ($accessory_user = DB::table('accessories_users')->find($accessoryUserId)) {
            if (is_null($accessory = Accessory::find($accessory_user->accessory_id))) {
                return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist'));
            }
            if (is_null($user = User::find($accessory_user->assigned_to))) {
                return redirect()->route('accessories.index')->with('error',
                    trans('admin/users/message.user_not_found'));
            }
            $this->authorize('checkin', $accessory);
            return view('accessories/checkin', compact('accessory_user', 'accessory', 'user'))->with('backto', $backto);
        }

        // Redirect to the accessory management page with error
        return redirect()->route('accessories.index')->with('error', trans('admin/components/messages.does_not_exist'));

    }


    /**
     * Check in the item so that it can be checked out again to someone else
     *
     * @uses Accessory::checkin_email() to determine if an email can and should be sent
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @param integer $accessoryUserId
     * @param string $backto
     * @return Redirect
     * @internal param int $accessoryId
     */
    public function postCheckin(Request $request, $accessoryUserId = null, $backto = null)
    {
      // Check if the accessory exists
        if (is_null($accessory_user = DB::table('accessories_users')->find($accessoryUserId))) {
            // Redirect to the accessory management page with error
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.does_not_exist'));
        }

        $accessory = Accessory::find($accessory_user->accessory_id);
        $this->authorize('checkin', $accessory);

        $assigned_user = User::find($accessory_user->assigned_to);

        // Quantity check
        $max_to_checkin = $accessory_user->assigned_qty;
        if ($max_to_checkin <= 0) {
            return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.checkin.error'));
        }
        $validator = Validator::make($request->all(), [
            "qty" => "required|numeric|between:1,$max_to_checkin"
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Quantity check was successful

        // Quantity adjust
        $checkin_qty = (int)request('qty');
        $qty_remaining_in_checkout = ($accessory_user->assigned_qty - $checkin_qty);
        if ($qty_remaining_in_checkout > 0) {
            // Update to correct checked out quantity
            DB::table('accessories_users')->where('id', $accessoryUserId)->update(['assigned_qty' => $qty_remaining_in_checkout]);
        } else {
            if (is_null(DB::table('accessories_users')->where('id', '=', $accessory_user->id)->delete())) {
                return redirect()->route('accessories.index')->with('error', trans('admin/accessories/message.checkin.error'));
            }
        }


        $logaction = $accessory->logCheckin($assigned_user, e(request('note')));

        // Unused anywhere ?, should delete ?
        /*
        $data['log_id'] = $logaction->id;
        $data['first_name'] = e($assigned_user->first_name);
        $data['last_name'] = e($assigned_user->last_name);
        $data['item_name'] = e($accessory->name);
        $data['checkin_date'] = e($logaction->created_at);
        $data['item_tag'] = '';
        $data['note'] = e($logaction->note);
        */

        if ($backto=='user') {
            return redirect()->route("users.show", $assigned_user->id)->with('success', trans('admin/accessories/message.checkin.success'));
        }
        return redirect()->route("accessories.show", $accessory->id)->with('success', trans('admin/accessories/message.checkin.success'));
    }


}
