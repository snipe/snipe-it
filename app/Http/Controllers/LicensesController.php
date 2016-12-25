<?php
namespace App\Http\Controllers;

use Assets;
use Illuminate\Support\Facades\Session;
use Input;
use Lang;
use App\Models\License;
use App\Models\Asset;
use App\Models\User;
use App\Models\Actionlog;
use DB;
use App\Models\LicenseSeat;
use App\Models\Company;
use Validator;
use View;
use Response;
use Slack;
use Config;
use App\Helpers\Helper;
use Auth;
use Gate;
use Illuminate\Http\Request;

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
    * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize('view', License::class);
        return View::make('licenses/index');
    }


    /**
    * Returns a form view that allows an admin to create a new licence.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see AccessoriesController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', License::class);
        $maintained_list = [
            '' => 'Maintained',
            '1' => 'Yes',
            '0' => 'No'
        ];

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', License::class);
        // create a new model instance
        $license = new License();

        if ($request->input('purchase_cost') == '') {
            $license->purchase_cost =  null;
        } else {
            $license->purchase_cost = Helper::ParseFloat($request->input('purchase_cost'));
        }

        if ($request->input('supplier_id') == '') {
            $license->supplier_id = null;
        } else {
            $license->supplier_id = $request->input('supplier_id');
        }

        if ($request->input('maintained') == '') {
            $license->maintained = 0;
        } else {
            $license->maintained = $request->input('maintained');
        }

        if ($request->input('reassignable') == '') {
            $license->reassignable = 0;
        } else {
            $license->reassignable = $request->input('reassignable');
        }

        if ($request->input('purchase_order') == '') {
            $license->purchase_order = '';
        } else {
            $license->purchase_order = $request->input('purchase_order');
        }

        if (empty($request->input('manufacturer_id'))) {
            $license->manufacturer_id = null;
        } else {
            $license->manufacturer_id = $request->input('manufacturer_id');
        }

        // Save the license data
        $license->name              = $request->input('name');
        $license->serial            = $request->input('serial');
        $license->license_email     = $request->input('license_email');
        $license->license_name      = $request->input('license_name');
        $license->notes             = $request->input('notes');
        $license->order_number      = $request->input('order_number');
        $license->seats             = $request->input('seats');
        $license->purchase_date     = $request->input('purchase_date');
        $license->purchase_order    = $request->input('purchase_order');
        $license->depreciation_id   = $request->input('depreciation_id');
        $license->company_id        = Company::getIdForCurrentUser($request->input('company_id'));
        $license->expiration_date   = $request->input('expiration_date');
        $license->termination_date  = $request->input('termination_date');
        $license->user_id           = Auth::id();

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
                    $license_seat->user_id          = Auth::id();
                    $license_seat->assigned_to      = null;
                    $license_seat->notes            = null;
                    $license_seat->save();
                }
            });
          // Redirect to the new license page
            return redirect()->route("licenses.index")->with('success', trans('admin/licenses/message.create.success'));
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
    * @return \Illuminate\Contracts\View\View
     */
    public function edit($licenseId = null)
    {
        if (is_null($item = License::find($licenseId))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
        }

        $this->authorize('update', $item);

        if ($item->purchase_date == "0000-00-00") {
            $item->purchase_date = null;
        }

        if ($item->purchase_cost == "0.00") {
            $item->purchase_cost = null;
        }

        $maintained_list = [
            '' => 'Maintained',
            '1' => 'Yes',
            '0' => 'No'
        ];

        return View::make('licenses/edit', compact('item'))
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
     * @param Request $request
     * @param int $licenseId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $licenseId = null)
    {
        // Check if the license exists
        if (is_null($license = License::find($licenseId))) {
            // Redirect to the blogs management page
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
        }

        $this->authorize('update', $license);

      // Update the license data
        $license->name              = $request->input('name');
        $license->serial            = $request->input('serial');
        $license->license_email     = $request->input('license_email');
        $license->license_name      = $request->input('license_name');
        $license->notes             = $request->input('notes');
        $license->order_number      = $request->input('order_number');
        $license->depreciation_id   = $request->input('depreciation_id');
        $license->company_id        = Company::getIdForCurrentUser($request->input('company_id'));
        $license->purchase_order    = $request->input('purchase_order');
        $license->maintained        = $request->input('maintained');
        $license->reassignable      = $request->input('reassignable');

        if (empty($request->input('manufacturer_id'))) {
            $license->manufacturer_id = null;
        } else {
            $license->manufacturer_id = $request->input('manufacturer_id');
        }


        if ($request->input('supplier_id') == '') {
            $license->supplier_id = null;
        } else {
            $license->supplier_id = $request->input('supplier_id');
        }

      // Update the asset data
        if ($request->input('purchase_date') == '') {
              $license->purchase_date =  null;
        } else {
              $license->purchase_date = $request->input('purchase_date');
        }

        if ($request->input('expiration_date') == '') {
            $license->expiration_date = null;
        } else {
            $license->expiration_date = $request->input('expiration_date');
        }

        if ($request->input('termination_date') == '') {
            $license->termination_date =  null;
        } else {
            $license->termination_date = $request->input('termination_date');
        }

        if ($request->input('purchase_cost') == '') {
            $license->purchase_cost =  null;
        } else {
            $license->purchase_cost = Helper::ParseFloat($request->input('purchase_cost'));
        }

        if ($request->input('maintained') == '') {
            $license->maintained = 0;
        } else {
            $license->maintained = $request->input('maintained');
        }

        if ($request->input('reassignable') == '') {
            $license->reassignable = 0;
        } else {
            $license->reassignable = $request->input('reassignable');
        }

        if ($request->input('purchase_order') == '') {
            $license->purchase_order = '';
        } else {
            $license->purchase_order = $request->input('purchase_order');
        }

        //Are we changing the total number of seats?
        if ($license->seats != $request->input('seats')) {
          //Determine how many seats we are dealing with
            $difference = $request->input('seats') - $license->licenseseats()->count();

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
                    $logAction = new Actionlog();
                    $logAction->item_type = License::class;
                    $logAction->item_id = $license->id;
                    $logAction->user_id = Auth::user()->id;
                    $logAction->note = '-'.abs($difference)." seats";
                    $logAction->target_id =  null;
                    $logAction->logaction('delete seats');
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
                $logAction = new Actionlog();
                $logAction->item_type = License::class;
                $logAction->item_id = $license->id;
                $logAction->user_id = Auth::user()->id;
                $logAction->note = '+'.abs($difference)." seats";
                $logAction->target_id =  null;
                $logAction->logaction('add seats');
            }
            $license->seats             = e($request->input('seats'));
        }

        if ($license->save()) {
            return redirect()->route('licenses.show', ['license' => $licenseId])->with('success', trans('admin/licenses/message.update.success'));
        }
        return redirect()->to("admin/licenses/$licenseId/edit")->with('error', trans('admin/licenses/message.update.error'));
    }

    /**
    * Checks to see whether the selected license can be deleted, and
    * if it can, marks it as deleted.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($licenseId)
    {
        // Check if the license exists
        if (is_null($license = License::find($licenseId))) {
            // Redirect to the license management page
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $this->authorize('delete', $license);

        if ($license->assigned_seats_count == 0) {
            // Delete the license and the associated license seats
            DB::table('license_seats')
                ->where('id', $license->id)
                ->update(array('assigned_to' => null,'asset_id' => null));

            $licenseSeats = $license->licenseseats();
            $licenseSeats->delete();
            $license->delete();

            // Redirect to the licenses management page
            return redirect()->route('licenses.index')->with('success', trans('admin/licenses/message.delete.success'));
            // Redirect to the license management page
        }
        // There are still licenses in use.
        return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.assoc_users'));

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
    * @return \Illuminate\Contracts\View\View
     */
    public function getCheckout($seatId)
    {
        // Check if the license seat exists
        if (is_null($licenseSeat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $this->authorize('checkout', $licenseSeat);
        return View::make('licenses/checkout', compact('licenseSeat'))
            ->with('users_list', Helper::usersList())
            ->with('asset_list', Helper::detailedAssetList());
    }


    /**
     * Validates and stores the license checkout action.
     *
     * @todo Switch to using a FormRequest for validation here.
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param Request $request
     * @param int $seatId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCheckout(Request $request, $seatId)
    {
        $licenseSeat = LicenseSeat::find($seatId);
        $assigned_to = e($request->input('assigned_to'));
        $asset_id = e($request->input('asset_id'));

        $this->authorize('checkout', $licenseSeat);

        // Declare the rules for the form validation
        $rules = [
            'note'   => 'string',
            'asset_id'  => 'required_without:assigned_to',
        ];

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
                return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.user_does_not_exist'));
            }
        }

        if ($asset_id!='') {
            if (is_null($asset = Asset::find($asset_id))) {
                // Redirect to the asset management page with error
                return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.asset_does_not_exist'));
            }

            if (($asset->assigned_to!='') && (($asset->assigned_to!=$assigned_to)) && ($assigned_to!='')) {
                return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.owner_doesnt_match_asset'));
            }
        }

        // Check if the asset exists
        if (is_null($licenseSeat)) {
            // Redirect to the asset management page with error
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        if ($request->input('asset_id') == '') {
            $licenseSeat->asset_id = null;
        } else {
            $licenseSeat->asset_id = $request->input('asset_id');
        }

        // Update the asset data
        if ($request->input('assigned_to') == '') {
                $licenseSeat->assigned_to =  null;
        } else {
                $licenseSeat->assigned_to = $request->input('assigned_to');
        }

        // Was the asset updated?
        if ($licenseSeat->save()) {
            $licenseSeat->logCheckout($request->input('note'));

            $data['license_id'] =$licenseSeat->license_id;
            $data['note'] = $request->input('note');

            // Redirect to the new asset page
            return redirect()->route("licenses.index")->with('success', trans('admin/licenses/message.checkout.success'));
        }

        // Redirect to the asset management page with error
        return redirect()->to("admin/licenses/{$asset_id}/checkout")->with('error', trans('admin/licenses/message.create.error'))->with('license', new License);
    }


    /**
    * Makes the form view to check a license seat back into inventory.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $seatId
    * @param string $backTo
    * @return \Illuminate\Contracts\View\View
     */
    public function getCheckin($seatId = null, $backTo = null)
    {
        // Check if the asset exists
        if (is_null($licenseseat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }
        $this->authorize('checkin', $licenseseat);
        return View::make('licenses/checkin', compact('licenseseat'))->with('backto', $backTo);
    }


    /**
    * Validates and stores the license checkin action.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LicensesController::getCheckin() method that provides the form view
    * @since [v1.0]
    * @param int $seatId
    * @param string $backTo
    * @return \Illuminate\Http\RedirectResponse
     */
    public function postCheckin($seatId = null, $backTo = null)
    {
        // Check if the asset exists
        if (is_null($licenseSeat = LicenseSeat::find($seatId))) {
            // Redirect to the asset management page with error
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $license = License::find($licenseSeat->license_id);

        $this->authorize('checkin', $licenseSeat);

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
        $return_to = User::find($licenseSeat->assigned_to);
        if (!$return_to) {
            $return_to = Asset::find($licenseSeat->asset_id);
        }
        // Update the asset data
        $licenseSeat->assigned_to                   = null;
        $licenseSeat->asset_id                      = null;

        // Was the asset updated?
        if ($licenseSeat->save()) {
            $licenseSeat->logCheckin($return_to, e(request('note')));
            if ($backTo=='user') {
                return redirect()->route("users.show", $return_to->id)->with('success', trans('admin/licenses/message.checkin.success'));
            }
            return redirect()->route("licenses.show", $licenseSeat->license_id)->with('success', trans('admin/licenses/message.checkin.success'));
        }

        // Redirect to the license page with error
        return redirect()->route("licenses.index")->with('error', trans('admin/licenses/message.checkin.error'));
    }

    /**
    * Makes the license detail page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @return \Illuminate\Contracts\View\View
     */
    public function show($licenseId = null)
    {
        $license = License::find($licenseId);
        if (isset($license->id)) {
            $license = $license->load('assignedusers', 'licenseSeats.user', 'licenseSeats.asset');
            $this->authorize('view', $license);
            return View::make('licenses/view', compact('license'));
        }
        $error = trans('admin/licenses/message.does_not_exist', compact('id'));
        return redirect()->route('licenses.index')->with('error', $error);
    }

    public function getClone($licenseId = null)
    {
        if (is_null($license_to_clone = License::find($licenseId))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.does_not_exist'));
        }

        $this->authorize('create', License::class);

        $maintained_list = [
            '' => 'Maintained',
            '1' => 'Yes',
            '0' => 'No'
        ];
        //clone the orig
        $license = clone $license_to_clone;
        $license->id = null;
        $license->serial = null;

        // Show the page
        return View::make('licenses/edit')
        ->with('depreciation_list', Helper::depreciationList())
        ->with('supplier_list', Helper::suppliersList())
        ->with('item', $license)
        ->with('maintained_list', $maintained_list)
        ->with('company_list', Helper::companyList())
        ->with('manufacturer_list', Helper::manufacturerList());
    }


    /**
    * Validates and stores files associated with a license.
    *
    * @todo Switch to using the AssetFileRequest form request validator.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @return \Illuminate\Http\RedirectResponse
     */
    public function postUpload($licenseId = null)
    {
        $license = License::find($licenseId);
        // the license is valid
        $destinationPath = config('app.private_uploads').'/licenses';

        if (isset($license->id)) {
            $this->authorize('update', $license);

            if (Input::hasFile('licensefile')) {

                foreach (Input::file('licensefile') as $file) {

                    $rules = array(
                    'licensefile' => 'required|mimes:png,gif,jpg,jpeg,doc,docx,pdf,txt,zip,rar,rtf,xml,lic|max:2000'
                    );
                    $validator = Validator::make(array('licensefile'=> $file), $rules);

                    if ($validator->fails()) {
                         return redirect()->back()->with('error', trans('admin/licenses/message.upload.invalidfiles'));
                    }
                    $extension = $file->getClientOriginalExtension();
                    $filename = 'license-'.$license->id.'-'.str_random(8);
                    $filename .= '-'.str_slug($file->getClientOriginalName()).'.'.$extension;
                    $upload_success = $file->move($destinationPath, $filename);

                    //Log the upload to the log
                    $license->logUpload($filename, e($request->input('notes'))); 
                }

                if ($upload_success) {
                    return redirect()->back()->with('success', trans('admin/licenses/message.upload.success'));
                }
                return redirect()->back()->with('error', trans('admin/licenses/message.upload.error'));
            }
            return redirect()->back()->with('error', trans('admin/licenses/message.upload.nofiles'));
        }
        // Prepare the error message
        $error = trans('admin/licenses/message.does_not_exist', compact('id'));
        return redirect()->route('licenses.index')->with('error', $error);
    }


    /**
    * Deletes the selected license file.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @param int $fileId
    * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeleteFile($licenseId = null, $fileId = null)
    {
        $license = License::find($licenseId);
        $destinationPath = config('app.private_uploads').'/licenses';

        // the license is valid
        if (isset($license->id)) {
            $this->authorize('edit', $license);
            $log = Actionlog::find($fileId);
            $full_filename = $destinationPath.'/'.$log->filename;
            if (file_exists($full_filename)) {
                unlink($destinationPath.'/'.$log->filename);
            }
            $log->delete();
            return redirect()->back()->with('success', trans('admin/licenses/message.deletefile.success'));
        }
        // Prepare the error message
        $error = trans('admin/licenses/message.does_not_exist', compact('id'));

        // Redirect to the licence management page
        return redirect()->route('licenses.index')->with('error', $error);
    }



    /**
    * Allows the selected file to be viewed.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.4]
    * @param int $licenseId
    * @param int $fileId
    * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function displayFile($licenseId = null, $fileId = null)
    {

        $license = License::find($licenseId);

        // the license is valid
        if (isset($license->id)) {
            $this->authorize('view', $license);
            $log = Actionlog::find($fileId);
            $file = $log->get_src('licenses');
            return Response::download($file);
        }
        // Prepare the error message
        $error = trans('admin/licenses/message.does_not_exist', compact('id'));
        // Redirect to the licence management page
        return redirect()->route('licenses.index')->with('error', $error);
    }


    /**
    * Generates a JSON response to populate the licence index datatables.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see LicensesController::getIndex() method that provides the view
    * @since [v1.0]
    * @return String JSON
    */
    public function getDatatable(Request $request)
    {
        $this->authorize('view', License::class);
        $licenses = Company::scopeCompanyables(License::with('company', 'licenseSeatsRelation', 'manufacturer'));

        if (Input::has('search')) {
            $licenses = $licenses->TextSearch($request->input('search'));
        }
        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $allowed_columns = ['id','name','purchase_cost','expiration_date','purchase_order','order_number','notes','purchase_date','serial','manufacturer','company'];
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';

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
        $licenses = $licenses->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($licenses as $license) {
            $rows[] = $license->present()->forDataTable();
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
    * @return \Illuminate\Http\RedirectResponse
     */
    public function getFreeLicense($licenseId)
    {
        $this->authorize('checkout', License::class);
        if (is_null($license = License::find($licenseId))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }
        $seatId = $license->freeSeat($licenseId);
        return redirect()->route('licenses.checkout', $seatId);
    }
}
