<?php
namespace App\Http\Controllers;

use Assets;
use Input;
use Lang;
use App\Models\License;
use App\Models\Asset;
use App\Models\User;
use App\Models\Actionlog;
use DB;
use Redirect;
use App\Models\LicenseSeat;
use App\Models\Depreciation;
use App\Models\Company;
use App\Models\Setting;
use App\Models\Supplier;
use Validator;
use View;
use Response;
use Slack;
use Config;
use Session;
use App\Helpers\Helper;
use Auth;
use Gate;

/**
 * This controller handles all actions related to Licenses for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class LicensesController extends Controller
{

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the licenses listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LicensesController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return View
    */
    public function getIndex()
    {
        // Show the page
        return View::make('licenses/index');
    }


    /**
    * Returns a form view that allows an admin to create a new licence.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see AccessoriesController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return View
    */
    public function getCreate()
    {

        $maintained_list = array('' => 'Maintained', '1' => 'Yes', '0' => 'No');

        return View::make('licenses/edit')
            //->with('license_options',$license_options)
            ->with('depreciation_list', Helper::depreciationList())
            ->with('supplier_list', Helper::suppliersList())
            ->with('maintained_list', $maintained_list)
            ->with('company_list', Helper::companyList())
            ->with('manufacturer_list', Helper::manufacturerList())
            ->with('item', new License);

    }


    /**
    * Validates and stores the license form data submitted from the new
    * license form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LicensesController::getCreate() method that provides the form view
    * @since [v1.0]
    * @return Redirect
    */
    public function postCreate()
    {

        // create a new model instance
        $license = new License();

        if (e(Input::get('purchase_cost')) == '') {
            $license->purchase_cost =  null;
        } else {
            $license->purchase_cost = Helper::ParseFloat(e(Input::get('purchase_cost')));
        }

        if (e(Input::get('supplier_id')) == '') {
            $license->supplier_id = null;
        } else {
            $license->supplier_id = e(Input::get('supplier_id'));
        }

        if (e(Input::get('maintained')) == '') {
            $license->maintained = 0;
        } else {
            $license->maintained = e(Input::get('maintained'));
        }

        if (e(Input::get('reassignable')) == '') {
            $license->reassignable = 0;
        } else {
            $license->reassignable = e(Input::get('reassignable'));
        }

        if (e(Input::get('purchase_order')) == '') {
            $license->purchase_order = '';
        } else {
            $license->purchase_order = e(Input::get('purchase_order'));
        }

        if (empty(e(Input::get('manufacturer_id')))) {
            $license->manufacturer_id = null;
        } else {
            $license->manufacturer_id = e(Input::get('manufacturer_id'));
        }

        // Save the license data
        $license->name              = e(Input::get('name'));
        $license->serial            = e(Input::get('serial'));
        $license->license_email     = e(Input::get('license_email'));
        $license->license_name      = e(Input::get('license_name'));
        $license->notes             = e(Input::get('notes'));
        $license->order_number      = e(Input::get('order_number'));
        $license->seats             = e(Input::get('seats'));
        $license->purchase_date     = e(Input::get('purchase_date'));
        $license->purchase_order    = e(Input::get('purchase_order'));
        $license->depreciation_id   = e(Input::get('depreciation_id'));
        $license->company_id        = Company::getIdForCurrentUser(Input::get('company_id'));
        $license->expiration_date   = e(Input::get('expiration_date'));
        $license->termination_date  = e(Input::get('termination_date'));
        $license->user_id           = Auth::user()->id;

        if (($license->purchase_date == "") || ($license->purchase_date == "0000-00-00")) {
            $license->purchase_date = null;
        }

        if (($license->expiration_date == "") || ($license->expiration_date == "0000-00-00")) {
            $license->expiration_date = null;
        }

        if (($license->purchase_cost == "") || ($license->purchase_cost == "0.00")) {
            $license->purchase_cost = null;
        }

            // Was the license created?
        if ($license->save()) {
            $license->logCreate();
            $insertedId = $license->id;
          // Save the license seat data
            DB::transaction(function () use (&$insertedId, &$license) {
                for ($x=0; $x<$license->seats; $x++) {
                    $license_seat = new LicenseSeat();
                    $license_seat->license_id       = $insertedId;
                    $license_seat->user_id          = Auth::user()->id;
                    $license_seat->assigned_to      = null;
                    $license_seat->notes            = null;
                    $license_seat->save();
                }
            });


          // Redirect to the new license page
            return redirect()->to("admin/licenses")->with('success', trans('admin/licenses/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($license->getErrors());

    }

    /**
    * Returns a form with existing license data to allow an admin to
    * update license information.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @return View
    */
    public function getEdit($licenseId = null)
    {
        // Check if the license exists
        if (is_null($item = License::find($licenseId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($item)) {
            return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
        }

        if ($item->purchase_date == "0000-00-00") {
            $item->purchase_date = null;
        }

        if ($item->purchase_cost == "0.00") {
            $item->purchase_cost = null;
        }

        // Show the page
        $license_options = array('' => 'Top Level') + DB::table('assets')->where('id', '!=', $licenseId)->pluck('name', 'id');
        $maintained_list = array('' => 'Maintained', '1' => 'Yes', '0' => 'No');

        return View::make('licenses/edit', compact('item'))
            ->with('license_options', $license_options)
            ->with('depreciation_list', Helper::depreciationList())
            ->with('supplier_list', Helper::suppliersList())
            ->with('company_list', Helper::companyList())
            ->with('maintained_list', $maintained_list)
            ->with('manufacturer_list', Helper::manufacturerList());
    }


    /**
    * Validates and stores the license form data submitted from the edit
    * license form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LicensesController::getEdit() method that provides the form view
    * @since [v1.0]
    * @param int $licenseId
    * @return Redirect
    */
    public function postEdit($licenseId = null)
    {
        // Check if the license exists
        if (is_null($license = License::find($licenseId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($license)) {
            return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
        }

      // Update the license data
        $license->name              = e(Input::get('name'));
        $license->serial            = e(Input::get('serial'));
        $license->license_email     = e(Input::get('license_email'));
        $license->license_name      = e(Input::get('license_name'));
        $license->notes             = e(Input::get('notes'));
        $license->order_number      = e(Input::get('order_number'));
        $license->depreciation_id   = e(Input::get('depreciation_id'));
        $license->company_id        = Company::getIdForCurrentUser(Input::get('company_id'));
        $license->purchase_order    = e(Input::get('purchase_order'));
        $license->maintained        = e(Input::get('maintained'));
        $license->reassignable      = e(Input::get('reassignable'));

        if (empty(e(Input::get('manufacturer_id')))) {
            $license->manufacturer_id = null;
        } else {
            $license->manufacturer_id = e(Input::get('manufacturer_id'));
        }


        if (e(Input::get('supplier_id')) == '') {
            $license->supplier_id = null;
        } else {
            $license->supplier_id = e(Input::get('supplier_id'));
        }

      // Update the asset data
        if (e(Input::get('purchase_date')) == '') {
              $license->purchase_date =  null;
        } else {
              $license->purchase_date = e(Input::get('purchase_date'));
        }

        if (e(Input::get('expiration_date')) == '') {
            $license->expiration_date = null;
        } else {
            $license->expiration_date = e(Input::get('expiration_date'));
        }

        if (e(Input::get('termination_date')) == '') {
            $license->termination_date =  null;
        } else {
            $license->termination_date = e(Input::get('termination_date'));
        }

        if (e(Input::get('purchase_cost')) == '') {
            $license->purchase_cost =  null;
        } else {
            $license->purchase_cost = Helper::ParseFloat(e(Input::get('purchase_cost')));
        }

        if (e(Input::get('maintained')) == '') {
            $license->maintained = 0;
        } else {
            $license->maintained = e(Input::get('maintained'));
        }

        if (e(Input::get('reassignable')) == '') {
            $license->reassignable = 0;
        } else {
            $license->reassignable = e(Input::get('reassignable'));
        }

        if (e(Input::get('purchase_order')) == '') {
            $license->purchase_order = '';
        } else {
            $license->purchase_order = e(Input::get('purchase_order'));
        }

        //Are we changing the total number of seats?
        if ($license->seats != e(Input::get('seats'))) {
          //Determine how many seats we are dealing with
            $difference = e(Input::get('seats')) - $license->licenseseats()->count();

            if ($difference < 0) {
                //Filter out any license which have a user attached;
                $seats = $license->licenseseats->filter(function ($seat) {
                    return is_null($seat->user);
                });


              //If the remaining collection is as large or larger than the number of seats we want to delete
                if ($seats->count() >= abs($difference)) {
                    for ($i=1; $i <= abs($difference); $i++) {
                        //Delete the appropriate number of seats
                        $seats->pop()->delete();
                    }

                  //Log the deletion of seats to the log
                    $logaction = new Actionlog();
                    $logaction->item_type = License::class;
                    $logaction->item_id = $license->id;
                    $logaction->user_id = Auth::user()->id;
                    $logaction->note = '-'.abs($difference)." seats";
                    $logaction->target_id =  null;
                    $log = $logaction->logaction('delete seats');

                } else {
                  // Redirect to the license edit page
                    return redirect()->to("admin/licenses/$licenseId/edit")->with('error', trans('admin/licenses/message.assoc_users'));
                }
            } else {

                for ($i=1; $i <= $difference; $i++) {
                  //Create a seat for this license
                    $license_seat = new LicenseSeat();
                    $license_seat->license_id       = $license->id;
                    $license_seat->user_id          = Auth::user()->id;
                    $license_seat->assigned_to      = null;
                    $license_seat->notes            = null;
                    $license_seat->save();
                }

                //Log the addition of license to the log.
                $logaction = new Actionlog();
                $logaction->item_type = License::class;
                $logaction->item_id = $license->id;
                $logaction->user_id = Auth::user()->id;
                $logaction->note = '+'.abs($difference)." seats";
                $logaction->target_id =  null;
                $log = $logaction->logaction('add seats');
            }
            $license->seats             = e(Input::get('seats'));
        }

        // Was the asset created?
        if ($license->save()) {
            // Redirect to the new license page
            return redirect()->to("admin/licenses/$licenseId/view")->with('success', trans('admin/licenses/message.update.success'));
        }


        // Redirect to the license edit page
        return redirect()->to("admin/licenses/$licenseId/edit")->with('error', trans('admin/licenses/message.update.error'));

    }

    /**
    * Checks to see whether the selected license can be deleted, and
    * if it can, marks it as deleted.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @return Redirect
    */
    public function getDelete($licenseId)
    {
        // Check if the license exists
        if (is_null($license = License::find($licenseId))) {
            // Redirect to the license management page
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($license)) {
            return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
        }

        if ($license->assigned_seats_count > 0) {

            // Redirect to the license management page
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.assoc_users'));

        } else {

            // Delete the license and the associated license seats
            DB::table('license_seats')
            ->where('id', $license->id)
            ->update(array('assigned_to' => null,'asset_id' => null));

            $licenseseats = $license->licenseseats();
            $licenseseats->delete();
            $license->delete();




            // Redirect to the licenses management page
            return redirect()->to('admin/licenses')->with('success', trans('admin/licenses/message.delete.success'));
        }


    }


    /**
    * Provides the form view for checking out a license to a user.
    * Here we pass the license seat ID instead of the license ID,
    * because licenses themselves are never checked out to anyone,
    * only the seats associated with them.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $seatId
    * @return View
    */
    public function getCheckout($seatId)
    {
        // Check if the license seat exists
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($licenseseat->license)) {
            return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = Helper::usersList();

        $assets = Helper::detailedAssetList();
        return View::make('licenses/checkout', compact('licenseseat'))
        ->with('users_list', $users_list)
        ->with('asset_list', $assets);

    }



    /**
    * Validates and stores the license checkout action.
    *
    * @todo Switch to using a FormRequest for validation here.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $seatId
    * @return Redirect
    */
    public function postCheckout($seatId)
    {

        $licenseseat = LicenseSeat::find($seatId);
        $assigned_to = e(Input::get('assigned_to'));
        $asset_id = e(Input::get('asset_id'));
        $user = Auth::user();

        if (!Company::isCurrentUserHasAccess($licenseseat->license)) {
            return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
        }

        // Declare the rules for the form validation
        $rules = array(

            'note'   => 'string',
            'asset_id'  => 'required_without:assigned_to',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($assigned_to!='') {
        // Check if the user exists
            if (is_null($is_assigned_to = User::find($assigned_to))) {
                // Redirect to the asset management page with error
                return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.user_does_not_exist'));
            }
        }

        if ($asset_id!='') {

            if (is_null($asset = Asset::find($asset_id))) {
                // Redirect to the asset management page with error
                return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.asset_does_not_exist'));
            }


            if (($asset->assigned_to!='') && (($asset->assigned_to!=$assigned_to)) && ($assigned_to!='')) {
                return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.owner_doesnt_match_asset'));
            }

        }



        // Check if the asset exists
        if (is_null($licenseseat)) {
            // Redirect to the asset management page with error
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.not_found'));
        }

        if (Input::get('asset_id') == '') {
            $licenseseat->asset_id = null;
        } else {
            $licenseseat->asset_id = e(Input::get('asset_id'));
        }

        // Update the asset data
        if (e(Input::get('assigned_to')) == '') {
                $licenseseat->assigned_to =  null;

        } else {
                $licenseseat->assigned_to = e(Input::get('assigned_to'));
        }

        // Was the asset updated?
        if ($licenseseat->save()) {

            $licenseseat->logCheckout(e(Input::get('note')));

            $data['license_id'] =$licenseseat->license_id;
            $data['note'] = e(Input::get('note'));

            $license = License::find($licenseseat->license_id);
            $settings = Setting::getSettings();


            // Update the asset data
            if (e(Input::get('assigned_to')) == '') {
                $slack_msg = 'License <'.config('app.url').'/admin/licenses/'.$license->id.'/view'.'|'.$license->name.'> checked out to <'.config('app.url').'/hardware/'.$asset->id.'/view|'.$asset->showAssetName().'> by <'.config('app.url').'/admin/users/'.$user->id.'/view'.'|'.$user->fullName().'>.';
            } else {
                $slack_msg = 'License <'.config('app.url').'/admin/licenses/'.$license->id.'/view'.'|'.$license->name.'> checked out to <'.config('app.url').'/admin/users/'.$user->id.'/view|'.$is_assigned_to->fullName().'> by <'.config('app.url').'/admin/users/'.$user->id.'/view'.'|'.$user->fullName().'>.';
            }



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
                                    'value' => $slack_msg
                                ],
                                [
                                    'title' => 'Note:',
                                    'value' => e(Input::get('note'))
                                ],



                            ]
                        ])->send('License Checked Out');

                } catch (Exception $e) {

                }

            }

            // Redirect to the new asset page
            return redirect()->to("admin/licenses")->with('success', trans('admin/licenses/message.checkout.success'));
        }

        // Redirect to the asset management page with error
        return redirect()->to('admin/licenses/$assetId/checkout')->with('error', trans('admin/licenses/message.create.error'))->with('license', new License);
    }


    /**
    * Makes the form view to check a license seat back into inventory.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $seatId
    * @param string $backto
    * @return View
    */
    public function getCheckin($seatId = null, $backto = null)
    {
        // Check if the asset exists
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.not_found'));
        } elseif (!Company::isCurrentUserHasAccess($licenseseat->license)) {
            return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
        }
        return View::make('licenses/checkin', compact('licenseseat'))->with('backto', $backto);

    }



    /**
    * Validates and stores the license checkin action.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LicensesController::getCheckin() method that provides the form view
    * @since [v1.0]
    * @param int $seatId
    * @param string $backto
    * @return Redirect
    */
    public function postCheckin($seatId = null, $backto = null)
    {
        // Check if the asset exists
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.not_found'));
        }

        $license = License::find($licenseseat->license_id);

        if (!Company::isCurrentUserHasAccess($license)) {
            return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
        }

        if (!$license->reassignable) {
            // Not allowed to checkin
            Session::flash('error', 'License not reassignable.');
            return redirect()->back()->withInput();
        }

        // Declare the rules for the form validation
        $rules = array(
            'note'   => 'string',
            'notes'   => 'string',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $return_to = User::find($licenseseat->assigned_to);
        if (!$return_to) {
            $return_to = Asset::find($licenseseat->asset_id);
        }
        // Update the asset data
        $licenseseat->assigned_to                   = null;
        $licenseseat->asset_id                      = null;

        $user = Auth::user();

        // Was the asset updated?
        if ($licenseseat->save()) {
            $licenseseat->logCheckin($return_to, e(Input::get('note')));

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
                                    'title' => 'Checked In:',
                                    'value' => 'License: <'.config('app.url').'/admin/licenses/'.$license->id.'/view'.'|'.$license->name.'> checked in by <'.config('app.url').'/admin/users/'.$user->id.'/view'.'|'.$user->fullName().'>.'
                                ],
                                [
                                    'title' => 'Note:',
                                    'value' => e(Input::get('note'))
                                ],

                            ]
                        ])->send('License Checked In');

                } catch (Exception $e) {

                }

            }



            if ($backto=='user') {
                return redirect()->to("admin/users/".$return_to->id.'/view')->with('success', trans('admin/licenses/message.checkin.success'));
            } else {
                return redirect()->to("admin/licenses/".$licenseseat->license_id."/view")->with('success', trans('admin/licenses/message.checkin.success'));
            }

        }

        // Redirect to the license page with error
        return redirect()->to("admin/licenses")->with('error', trans('admin/licenses/message.checkin.error'));
    }

    /**
    * Makes the license detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @return View
    */
    public function getView($licenseId = null)
    {

        $license = License::find($licenseId);
        $license = $license->load('assignedusers', 'licenseSeats.user', 'licenseSeats.asset');

        if (isset($license->id)) {

            if (!Company::isCurrentUserHasAccess($license)) {
                return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
            }
            return View::make('licenses/view', compact('license'));

        } else {
            // Prepare the error message
            $error = trans('admin/licenses/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('licenses')->with('error', $error);
        }
    }

    public function getClone($licenseId = null)
    {
         // Check if the license exists
        if (is_null($license_to_clone = License::find($licenseId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($license_to_clone)) {
            return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
        }

          // Show the page
        $license_options = array('0' => 'Top Level') + License::pluck('name', 'id')->toArray();
        $maintained_list = array('' => 'Maintained', '1' => 'Yes', '0' => 'No');
        $company_list = Helper::companyList();
        //clone the orig
        $license = clone $license_to_clone;
        $license->id = null;
        $license->serial = null;

        // Show the page
        $depreciation_list = Helper::depreciationList();
        $supplier_list = Helper::suppliersList();
        return View::make('licenses/edit')
        ->with('license_options', $license_options)
        ->with('depreciation_list', $depreciation_list)
        ->with('supplier_list', $supplier_list)
        ->with('item', $license)
        ->with('maintained_list', $maintained_list)
        ->with('company_list', $company_list)
        ->with('manufacturer_list', Helper::manufacturerList());

    }


    /**
    * Validates and stores files associated with a license.
    *
    * @todo Switch to using the AssetFileRequest form request validator.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @return Redirect
    */
    public function postUpload($licenseId = null)
    {
        $license = License::find($licenseId);

        // the license is valid
        $destinationPath = config('app.private_uploads').'/licenses';

        if (isset($license->id)) {


            if (!Company::isCurrentUserHasAccess($license)) {
                return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
            }

            if (Input::hasFile('licensefile')) {

                foreach (Input::file('licensefile') as $file) {

                    $rules = array(
                    'licensefile' => 'required|mimes:png,gif,jpg,jpeg,doc,docx,pdf,txt,zip,rar,rtf,xml,lic|max:2000'
                    );
                    $validator = Validator::make(array('licensefile'=> $file), $rules);

                    if ($validator->passes()) {

                        $extension = $file->getClientOriginalExtension();
                        $filename = 'license-'.$license->id.'-'.str_random(8);
                        $filename .= '-'.str_slug($file->getClientOriginalName()).'.'.$extension;
                        $upload_success = $file->move($destinationPath, $filename);

                        //Log the upload to the log
                        $license->logUpload($filename, e(Input::get('notes')));
                    } else {
                         return redirect()->back()->with('error', trans('admin/licenses/message.upload.invalidfiles'));
                    }


                }

                if ($upload_success) {
                    return redirect()->back()->with('success', trans('admin/licenses/message.upload.success'));
                } else {
                    return redirect()->back()->with('success', trans('admin/licenses/message.upload.error'));
                }

            } else {
                 return redirect()->back()->with('error', trans('admin/licenses/message.upload.nofiles'));
            }


        } else {
            // Prepare the error message
            $error = trans('admin/licenses/message.does_not_exist', compact('id'));

            // Redirect to the licence management page
            return redirect()->route('licenses')->with('error', $error);
        }
    }


    /**
    * Deletes the selected license file.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @param int $fileId
    * @return Redirect
    */
    public function getDeleteFile($licenseId = null, $fileId = null)
    {
        $license = License::find($licenseId);
        $destinationPath = config('app.private_uploads').'/licenses';

        // the license is valid
        if (isset($license->id)) {


            if (!Company::isCurrentUserHasAccess($license)) {
                return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
            }

            $log = Actionlog::find($fileId);
            $full_filename = $destinationPath.'/'.$log->filename;
            if (file_exists($full_filename)) {
                unlink($destinationPath.'/'.$log->filename);
            }
            $log->delete();
            return redirect()->back()->with('success', trans('admin/licenses/message.deletefile.success'));

        } else {
            // Prepare the error message
            $error = trans('admin/licenses/message.does_not_exist', compact('id'));

            // Redirect to the licence management page
            return redirect()->route('licenses')->with('error', $error);
        }
    }



    /**
    * Allows the selected file to be viewed.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.4]
    * @param int $licenseId
    * @param int $fileId
    * @return Redirect
    */
    public function displayFile($licenseId = null, $fileId = null)
    {

        $license = License::find($licenseId);

        // the license is valid
        if (isset($license->id)) {

            if (!Company::isCurrentUserHasAccess($license)) {
                return redirect()->to('admin/licenses')->with('error', trans('general.insufficient_permissions'));
            }

                $log = Actionlog::find($fileId);
                $file = $log->get_src('licenses');
                return Response::download($file);
        } else {
            // Prepare the error message
            $error = trans('admin/licenses/message.does_not_exist', compact('id'));

            // Redirect to the licence management page
            return redirect()->route('licenses')->with('error', $error);
        }
    }


    /**
    * Generates a JSON response to populate the licence index datatables.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LicensesController::getIndex() method that provides the view
    * @since [v1.0]
    * @return String JSON
    */
    public function getDatatable()
    {
        $licenses = Company::scopeCompanyables(License::with('company', 'licenseSeatsRelation', 'manufacturer'));

        if (Input::has('search')) {
            $licenses = $licenses->TextSearch(Input::get('search'));
        }

        $allowed_columns = ['id','name','purchase_cost','expiration_date','purchase_order','order_number','notes','purchase_date','serial','manufacturer','company'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? e(Input::get('sort')) : 'created_at';

        switch ($sort) {
            case 'manufacturer':
                $licenses = $licenses->OrderManufacturer($order);
                break;
            case 'company':
                $licenses = $licenses->OrderCompany($order);
                break;
            default:
                $licenses = $licenses->orderBy($sort, $order);
                break;
        }


        $licenseCount = $licenses->count();
        $licenses = $licenses->skip(Input::get('offset'))->take(Input::get('limit'))->get();

        $rows = array();

        foreach ($licenses as $license) {
            $actions = '<span style="white-space: nowrap;">';

            if (Gate::allows('licenses.checkout')) {
                $actions .= '<a href="' . route('freecheckout/license', $license->id)
                . '" class="btn btn-primary btn-sm' . (($license->remaincount() > 0) ? '' : ' disabled') . '" style="margin-right:5px;">' . trans('general.checkout') . '</a> ';
            }

            if (Gate::allows('licenses.create')) {
                $actions .= '<a href="' . route('clone/license', $license->id)
                . '" class="btn btn-info btn-sm" style="margin-right:5px;" title="Clone license"><i class="fa fa-files-o"></i></a>';
            }
            if (Gate::allows('licenses.edit')) {
                $actions .= '<a href="' . route('update/license', $license->id)
                . '" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a>';
            }
            if (Gate::allows('licenses.delete')) {
                $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'
                 . route('delete/license', $license->id)
                 . '" data-content="' . trans('admin/licenses/message.delete.confirm') . '" data-title="' . trans('general.delete') . ' ' . htmlspecialchars($license->name) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            }
            $actions .='</span>';

            $rows[] = array(
                'id'                => $license->id,
                'name'              => (string) link_to('/admin/licenses/'.$license->id.'/view', $license->name),
                'serial'            => (string) link_to('/admin/licenses/'.$license->id.'/view', mb_strimwidth($license->serial, 0, 50, "...")),
                'totalSeats'        => $license->licenseSeatsCount,
                'remaining'         => $license->remaincount(),
                'license_name'      => e($license->license_name),
                'license_email'     => e($license->license_email),
                'purchase_date'     => ($license->purchase_date) ? $license->purchase_date : '',
                'expiration_date'     => ($license->expiration_date) ? $license->expiration_date : '',
                'purchase_cost'     => Helper::formatCurrencyOutput($license->purchase_cost),
                'purchase_order'     => ($license->purchase_order) ? e($license->purchase_order) : '',
                'order_number'     => ($license->order_number) ? e($license->order_number) : '',
                'notes'     => ($license->notes) ? e($license->notes) : '',
                'actions'           => $actions,
                'company'       => is_null($license->company) ? '' : e($license->company->name),
                'manufacturer'      => $license->manufacturer ? (string) link_to('/admin/settings/manufacturers/'.$license->manufacturer_id.'/view', $license->manufacturer->name) : ''
            );
        }

        $data = array('total' => $licenseCount, 'rows' => $rows);

        return $data;
    }

    /**
    * Generates the next free seat ID for checkout.
    *
    * @todo This is a dumb way to solve this problem.
    * Author should refactor. And go hide in a hole and
    * think about what she's done. And perhaps find a new
    * line of work. And get in the sea.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @return View
    */
    public function getFreeLicense($licenseId)
    {
        // Check if the asset exists
        if (is_null($license = License::find($licenseId))) {
            // Redirect to the asset management page with error
            return redirect()->to('admin/licenses')->with('error', trans('admin/licenses/message.not_found'));
        }
        $seatId = $license->freeSeat($licenseId);
        return redirect()->to('admin/licenses/'.$seatId.'/checkout');
    }
}
