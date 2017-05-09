<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Gate;
use Input;
use Lang;
use Mail;
use Redirect;
use Request;
use Slack;
use Str;
use View;

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
    public function getIndex(Request $request)
    {
        return View::make('accessories/index');
    }


  /**
   * Returns a view with a form to create a new Accessory.
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @return View
   */
    public function getCreate(Request $request)
    {
        // Show the page
        return View::make('accessories/edit')
          ->with('item', new Accessory)
          ->with('category_list', Helper::categoryList('accessory'))
          ->with('company_list', Helper::companyList())
          ->with('location_list', Helper::locationsList())
          ->with('manufacturer_list', Helper::manufacturerList());
    }


  /**
   * Validate and save new Accessory from form post
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @return Redirect
   */
    public function postCreate(Request $request)
    {

        // create a new model instance
        $accessory = new Accessory();

        // Update the accessory data
        $accessory->name                    = e(Input::get('name'));
        $accessory->category_id             = e(Input::get('category_id'));
        $accessory->location_id             = e(Input::get('location_id'));
        $accessory->min_amt                 = e(Input::get('min_amt'));
        $accessory->company_id              = Company::getIdForCurrentUser(Input::get('company_id'));
        $accessory->order_number            = e(Input::get('order_number'));
        $accessory->manufacturer_id         = e(Input::get('manufacturer_id'));
        $accessory->model_number            = e(Input::get('model_number'));

        if (e(Input::get('purchase_date')) == '') {
            $accessory->purchase_date       =  null;
        } else {
            $accessory->purchase_date       = e(Input::get('purchase_date'));
        }

        if (e(Input::get('purchase_cost')) == '0.00') {
            $accessory->purchase_cost       =  null;
        } else {
            $accessory->purchase_cost       = Helper::ParseFloat(e(Input::get('purchase_cost')));
        }

        $accessory->qty                     = e(Input::get('qty'));
        $accessory->user_id                 = Auth::user()->id;

        // Was the accessory created?
        if ($accessory->save()) {
            $accessory->logCreate();
            // Redirect to the new accessory  page
            return redirect()->to("admin/accessories")->with('success', trans('admin/accessories/message.create.success'));
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
    public function getEdit(Request $request, $accessoryId = null)
    {
        // Check if the accessory exists
        if (is_null($item = Accessory::find($accessoryId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/accessories')->with('error', trans('admin/accessories/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($item)) {
            return redirect()->to('admin/accessories')->with('error', trans('general.insufficient_permissions'));
        }

        return View::make('accessories/edit', compact('item'))
          ->with('category_list', Helper::categoryList('accessory'))
          ->with('company_list', Helper::companyList())
          ->with('location_list', Helper::locationsList())
          ->with('manufacturer_list', Helper::manufacturerList());
    }


  /**
   * Save edited Accessory from form post
   *
   * @author [A. Gianotto] [<snipe@snipe.net>]
   * @param  int  $accessoryId
   * @return Redirect
   */
    public function postEdit(Request $request, $accessoryId = null)
    {
      // Check if the accessory exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the accessory index page
            return redirect()->to('admin/accessories')->with('error', trans('admin/accessories/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($accessory)) {
            return redirect()->to('admin/accessories')->with('error', trans('general.insufficient_permissions'));
        }

      // Update the accessory data
        $accessory->name                    = e(Input::get('name'));

        if (e(Input::get('location_id')) == '') {
            $accessory->location_id = null;
        } else {
            $accessory->location_id         = e(Input::get('location_id'));
        }
        $accessory->min_amt                 = e(Input::get('min_amt'));
        $accessory->category_id             = e(Input::get('category_id'));
        $accessory->company_id              = Company::getIdForCurrentUser(Input::get('company_id'));
        $accessory->manufacturer_id         = e(Input::get('manufacturer_id'));
        $accessory->order_number            = e(Input::get('order_number'));
        $accessory->model_number            = e(Input::get('model_number'));

        if (e(Input::get('purchase_date')) == '') {
            $accessory->purchase_date       =  null;
        } else {
            $accessory->purchase_date       = e(Input::get('purchase_date'));
        }

        if (e(Input::get('purchase_cost')) == '0.00') {
            $accessory->purchase_cost       =  null;
        } else {
            $accessory->purchase_cost       = e(Input::get('purchase_cost'));
        }

        $accessory->qty                     = e(Input::get('qty'));

      // Was the accessory updated?
        if ($accessory->save()) {

            $logaction = new Actionlog();
            $logaction->item_type = Accessory::class;
            $logaction->item_id = $accessory->id;
            $logaction->created_at =  date("Y-m-d H:i:s");
            $logaction->user_id = Auth::user()->id;
            $log = $logaction->logaction('update');


            // Redirect to the updated accessory page
            return redirect()->to("admin/accessories")->with('success', trans('admin/accessories/message.update.success'));
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
    public function getDelete(Request $request, $accessoryId)
    {
        // Check if the blog post exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/accessories')->with('error', trans('admin/accessories/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($accessory)) {
            return redirect()->to('admin/accessories')->with('error', trans('general.insufficient_permissions'));
        }


        if ($accessory->hasUsers() > 0) {
             return redirect()->to('admin/accessories')->with('error', trans('admin/accessories/message.assoc_users', array('count'=> $accessory->hasUsers())));
        } else {
            $accessory->delete();

            $logaction = new Actionlog();
            $logaction->item_type = Accessory::class;
            $logaction->item_id = $accessory->id;
            $logaction->created_at =  date("Y-m-d H:i:s");
            $logaction->user_id = Auth::user()->id;
            $log = $logaction->logaction('deleted');

            // Redirect to the locations management page
            return redirect()->to('admin/accessories')->with('success', trans('admin/accessories/message.delete.success'));

        }
    }



  /**
  * Returns a view that invokes the ajax table which  contains
  * the content for the accessory detail view, which is generated in getDataView.
  *
  * @author [A. Gianotto] [<snipe@snipe.net>]
  * @param  int  $accessoryId
  * @see AccessoriesController::getDataView() method that generates the JSON response
  * @since [v1.0]
  * @return View
  */
    public function getView(Request $request, $accessoryID = null)
    {
        $accessory = Accessory::find($accessoryID);

        if (isset($accessory->id)) {

            if (!Company::isCurrentUserHasAccess($accessory)) {
                return redirect()->to('admin/accessories')->with('error', trans('general.insufficient_permissions'));
            } else {
                return View::make('accessories/view', compact('accessory'));
            }
        } else {
            // Prepare the error message
            $error = trans('admin/accessories/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('accessories')->with('error', $error);
        }


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
            return redirect()->to('accessories')->with('error', trans('admin/accessories/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($accessory)) {
            return redirect()->to('admin/accessories')->with('error', trans('general.insufficient_permissions'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = Helper::usersList();

        return View::make('accessories/checkout', compact('accessory'))->with('users_list', $users_list);

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
            return redirect()->to('accessories')->with('error', trans('admin/accessories/message.user_not_found'));
        } elseif (!Company::isCurrentUserHasAccess($accessory)) {
            return redirect()->to('admin/accessories')->with('error', trans('general.insufficient_permissions'));
        }

        if (!$user = User::find(Input::get('assigned_to'))) {
            return redirect()->to('admin/accessories')->with('error', trans('admin/accessories/message.not_found'));
        }

      // Update the accessory data
        $accessory->assigned_to                 = e(Input::get('assigned_to'));

        $accessory->users()->attach($accessory->id, array(
        'accessory_id' => $accessory->id,
        'created_at' => Carbon::now(),
        'user_id' => Auth::user()->id,
        'assigned_to' => e(Input::get('assigned_to'))));

        $logaction = $accessory->logCheckout(e(Input::get('note')));



        $admin_user = Auth::user();
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
                  'value' => 'Accessory <'.config('app.url').'/admin/accessories/'.$accessory->id.'/view'.'|'.$accessory->name.'> checked out to <'.config('app.url').'/admin/users/'.$user->id.'/view|'.$user->fullName().'> by <'.config('app.url').'/admin/users/'.$admin_user->id.'/view'.'|'.$admin_user->fullName().'>.'
                  ],
                  [
                      'title' => 'Note:',
                      'value' => e(Input::get('note'))
                  ],
                ]
                ])->send('Accessory Checked Out');
            } catch (Exception $e) {

            }

        }


        $accessory_user = DB::table('accessories_users')->where('assigned_to', '=', $accessory->assigned_to)->where('accessory_id', '=', $accessory->id)->first();

        $data['log_id'] = $logaction->id;
        $data['eula'] = $accessory->getEula();
        $data['first_name'] = $user->first_name;
        $data['item_name'] = $accessory->name;
        $data['checkout_date'] = $logaction->created_at;
        $data['item_tag'] = '';
        $data['expected_checkin'] = '';
        $data['note'] = $logaction->note;
        $data['require_acceptance'] = $accessory->requireAcceptance();


        if (($accessory->requireAcceptance()=='1')  || ($accessory->getEula())) {

            Mail::send('emails.accept-accessory', $data, function ($m) use ($user) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                $m->subject(trans('mail.Confirm_accessory_delivery'));
            });
        }

      // Redirect to the new accessory page
        return redirect()->to("admin/accessories")->with('success', trans('admin/accessories/message.checkout.success'));



    }


  /**
  * Check the accessory back into inventory
  *
  * @author [A. Gianotto] [<snipe@snipe.net>]
  * @param  int  $accessoryId
  * @return View
  **/
    public function getCheckin(Request $request, $accessoryUserId = null, $backto = null)
    {
        // Check if the accessory exists
        if (is_null($accessory_user = DB::table('accessories_users')->find($accessoryUserId))) {
            // Redirect to the accessory management page with error
            return redirect()->to('admin/accessories')->with('error', trans('admin/accessories/message.not_found'));
        }

        $accessory = Accessory::find($accessory_user->accessory_id);

        if (!Company::isCurrentUserHasAccess($accessory)) {
            return redirect()->to('admin/accessories')->with('error', trans('general.insufficient_permissions'));
        } else {
            return View::make('accessories/checkin', compact('accessory'))->with('backto', $backto);
        }
    }


  /**
  * Check in the item so that it can be checked out again to someone else
  *
  * @uses Accessory::checkin_email() to determine if an email can and should be sent
  * @author [A. Gianotto] [<snipe@snipe.net>]
  * @param  int  $accessoryId
  * @return Redirect
  **/
    public function postCheckin(Request $request, $accessoryUserId = null, $backto = null)
    {
      // Check if the accessory exists
        if (is_null($accessory_user = DB::table('accessories_users')->find($accessoryUserId))) {
            // Redirect to the accessory management page with error
            return redirect()->to('admin/accessories')->with('error', trans('admin/accessories/message.not_found'));
        }


        $accessory = Accessory::find($accessory_user->accessory_id);

        if (!Company::isCurrentUserHasAccess($accessory)) {
            return redirect()->to('admin/accessories')->with('error', trans('general.insufficient_permissions'));
        }

        $return_to = e($accessory_user->assigned_to);
        $logaction = $accessory->logCheckin(User::find($return_to), e(Input::get('note')));
        $admin_user = Auth::user();


      // Was the accessory updated?
        if (DB::table('accessories_users')->where('id', '=', $accessory_user->id)->delete()) {

            $settings = Setting::getSettings();

            if ($settings->slack_endpoint) {


                $slack_settings = [
                'username' => e($settings->botname),
                'channel' => e($settings->slack_channel),
                'link_names' => true
                ];

                $client = new \Maknz\Slack\Client($settings->slack_endpoint, $slack_settings);

                try {
                    $client->attach([
                        'color' => 'good',
                        'fields' => [
                            [
                                'title' => 'Checked In:',
                                'value' => class_basename(strtoupper($logaction->item_type)).' <'.config('app.url').'/admin/accessories/'.e($accessory->id).'/view'.'|'.e($accessory->name).'> checked in by <'.config('app.url').'/admin/users/'.e($admin_user->id).'/view'.'|'.e($admin_user->fullName()).'>.'
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

            if (!is_null($accessory_user->assigned_to)) {
                $user = User::find($accessory_user->assigned_to);
            }

            $data['log_id'] = $logaction->id;
            $data['first_name'] = e($user->first_name);
            $data['item_name'] = e($accessory->name);
            $data['checkin_date'] = e($logaction->created_at);
            $data['item_tag'] = '';
            $data['note'] = e($logaction->note);

            if (($accessory->checkin_email()=='1')) {

                Mail::send('emails.checkin-asset', $data, function ($m) use ($user) {
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.Confirm_Accessory_Checkin'));
                });
            }

            if ($backto=='user') {
                return redirect()->to("admin/users/".$return_to.'/view')->with('success', trans('admin/accessories/message.checkin.success'));
            } else {
                return redirect()->to("admin/accessories/".$accessory->id."/view")->with('success', trans('admin/accessories/message.checkin.success'));
            }
        }

        // Redirect to the accessory management page with error
        return redirect()->to("admin/accessories")->with('error', trans('admin/accessories/message.checkin.error'));
    }

    /**
    * Generates the JSON response for accessories listing view.
    *
    * Example:
    * {
    *  "actions": "(links to available actions)",
    *  "category": "(link to category)",
    *  "companyName": "My Company",
    *  "location":  "My Location",
    *  "min_amt": 2,
    *  "name":  "(link to accessory),
    *  "numRemaining": 6,
    *  "order_number": null,
    *  "purchase_cost": "0.00",
    *  "purchase_date": null,
    *  "qty": 7
    *  },
    *
    * The names of the fields in the returns JSON correspond directly to the the
    * names of the fields in the bootstrap-tables in the view.
    *
    * For debugging, see at /api/accessories/list
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int  $accessoryId
    * @return string JSON containing accessories and their associated atrributes.
    **/
    public function getDatatable(Request $request)
    {
        $accessories = Company::scopeCompanyables(
            Accessory::select('accessories.*')
            ->whereNull('accessories.deleted_at')
            ->with('category', 'company', 'manufacturer', 'users', 'location')
        );
        if (Input::has('search')) {
            $accessories = $accessories->TextSearch(e(Input::get('search')));
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


        $allowed_columns = ['name','min_amt','order_number','purchase_date','purchase_cost','companyName','category','model_number'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? e(Input::get('sort')) : 'created_at';

        switch ($sort) {
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

            $actions = '<nobr>';
            if (Gate::allows('accessories.checkout')) {
                $actions .= '<a href="' . route('checkout/accessory',
                        $accessory->id) . '" style="margin-right:5px;" class="btn btn-info btn-sm" ' . (($accessory->numRemaining() > 0) ? '' : ' disabled') . '>' . trans('general.checkout') . '</a>';
            }
            if (Gate::allows('accessories.edit')) {
                $actions .= '<a href="' . route('update/accessory',
                        $accessory->id) . '" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a>';
            }
            if (Gate::allows('accessories.delete')) {
                $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="' . route('delete/accessory',
                        $accessory->id) . '" data-content="' . trans('admin/accessories/message.delete.confirm') . '" data-title="' . trans('general.delete') . ' ' . htmlspecialchars($accessory->name) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            }
            $actions .= '</nobr>';
            $company = $accessory->company;

            $rows[] = array(
            'name'          => '<a href="'.url('admin/accessories/'.$accessory->id).'/view">'. $accessory->name.'</a>',
            'category'      => ($accessory->category) ? (string)link_to('admin/settings/categories/'.$accessory->category->id.'/view', $accessory->category->name) : '',
            'model_number'      =>  e($accessory->model_number),
            'qty'           => e($accessory->qty),
            'order_number'  => e($accessory->order_number),
            'min_amt'  => e($accessory->min_amt),
            'location'      => ($accessory->location) ? e($accessory->location->name): '',
            'purchase_date' => e($accessory->purchase_date),
            'purchase_cost' => Helper::formatCurrencyOutput($accessory->purchase_cost),
            'numRemaining'  => $accessory->numRemaining(),
            'actions'       => $actions,
            'companyName'   => is_null($company) ? '' : e($company->name),
            'manufacturer'      => $accessory->manufacturer ? (string) link_to('/admin/settings/manufacturers/'.$accessory->manufacturer_id.'/view', $accessory->manufacturer->name) : ''

            );
        }

        $data = array('total'=>$accessCount, 'rows'=>$rows);

        return $data;
    }


  /**
  * Generates the JSON response for accessory detail view.
  *
  * Example:
  * <code>
  * {
  * "rows": [
  * {
  * "actions": "(link to available actions)",
  * "name": "(link to user)"
  * }
  * ],
  * "total": 1
  * }
  * </code>
  *
  * The names of the fields in the returns JSON correspond directly to the the
  * names of the fields in the bootstrap-tables in the view.
  *
  * For debugging, see at /api/accessories/$accessoryID/view
  *
  * @author [A. Gianotto] [<snipe@snipe.net>]
  * @param  int  $accessoryId
  * @return string JSON containing accessories and their associated atrributes.
  **/
    public function getDataView(Request $request, $accessoryID)
    {
        $accessory = Accessory::find($accessoryID);

        if (!Company::isCurrentUserHasAccess($accessory)) {
            return ['total' => 0, 'rows' => []];
        }

        $accessory_users = $accessory->users;
        $count = $accessory_users->count();

        $rows = array();

        foreach ($accessory_users as $user) {
            $actions = '';
            if (Gate::allows('accessories.checkin')) {
                $actions .= '<a href="' . route('checkin/accessory',
                        $user->pivot->id) . '" class="btn btn-info btn-sm">Checkin</a>';
            }

            if (Gate::allows('users.view')) {
                $name = (string) link_to('/admin/users/'.$user->id.'/view', e($user->fullName()));
            } else {
                $name = e($user->fullName());
            }

            $rows[] = array(
              'name'          => $name,
              'actions'       => $actions
              );
        }

        $data = array('total'=>$count, 'rows'=>$rows);

        return $data;
    }
}
