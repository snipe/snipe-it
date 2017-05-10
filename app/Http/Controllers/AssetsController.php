<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\AssetRequest;
use App\Http\Requests\AssetFileRequest;
use App\Http\Requests\AssetCheckinRequest;
use App\Http\Requests\AssetCheckoutRequest;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\Depreciation;
use App\Models\Location;
use App\Models\Manufacturer; //for embedded-create
use App\Models\Setting;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Validator;
use Artisan;
use Auth;
use Config;
use League\Csv\Reader;
use DB;
use Image;
use Input;
use Lang;
use Log;
use Mail;
use Paginator;
use Redirect;
use Response;
use Slack;
use Str;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use TCPDF;
use View;
use Carbon\Carbon;
use Gate;

/**
 * This class controls all actions related to assets for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 * @author [A. Gianotto] [<snipe@snipe.net>]
 */
class AssetsController extends Controller
{
    protected $qrCodeDimensions = array( 'height' => 3.5, 'width' => 3.5);
    protected $barCodeDimensions = array( 'height' => 2, 'width' => 22);


    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the assets listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see AssetController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return View
    */
    public function getIndex()
    {
        return View::make('hardware/index');
    }

    /**
     * Searches the assets table by asset tag, and redirects if it finds one
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return Redirect
     */
    public function getAssetByTag()
    {
        if (Input::get('topsearch')=="true") {
            $topsearch = true;
        } else {
            $topsearch = false;
        }
        if ($asset = Asset::where('asset_tag', '=', Input::get('assetTag'))->first()) {
            return redirect()->route('view/hardware', $asset->id)->with('topsearch', $topsearch);
        }
        return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));

    }

    /**
    * Returns a view that presents a form to create a new asset.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getCreate($model_id = null)
    {
        // Grab the dropdown lists
        $model_list = Helper::modelList();
        $statuslabel_list = Helper::statusLabelList();
        $location_list = Helper::locationsList();
        $manufacturer_list = Helper::manufacturerList();
        $category_list = Helper::categoryList('asset');
        $supplier_list = Helper::suppliersList();
        $company_list = Helper::companyList();
        $assigned_to = Helper::usersList();
        $statuslabel_types = Helper::statusTypeList();

        $view = View::make('hardware/edit');
        $view->with('supplier_list', $supplier_list);
        $view->with('company_list', $company_list);
        $view->with('model_list', $model_list);
        $view->with('statuslabel_list', $statuslabel_list);
        $view->with('assigned_to', $assigned_to);
        $view->with('location_list', $location_list);
        $view->with('item', new Asset);
        $view->with('manufacturer', $manufacturer_list);
        $view->with('category', $category_list);
        $view->with('statuslabel_types', $statuslabel_types);

        if (!is_null($model_id)) {
            $selected_model = AssetModel::find($model_id);
            $view->with('selected_model', $selected_model);
        }

        return $view;
    }

    /**
    * Validate and process new asset form data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return Redirect
    */
    public function postCreate(AssetRequest $request)
    {
        // create a new model instance
        $asset = new Asset();
        $asset->model()->associate(AssetModel::find(e(Input::get('model_id'))));

        $checkModel = config('app.url').'/api/models/'.e(Input::get('model_id')).'/check';

        $asset->name                    = e(Input::get('name'));
        $asset->serial                  = e(Input::get('serial'));
        $asset->company_id              = Company::getIdForCurrentUser(e(Input::get('company_id')));
        $asset->model_id                = e(Input::get('model_id'));
        $asset->order_number            = e(Input::get('order_number'));
        $asset->notes                   = e(Input::get('notes'));
        $asset->asset_tag               = e(Input::get('asset_tag'));
        $asset->user_id                 = Auth::user()->id;
        $asset->archived                    = '0';
        $asset->physical                    = '1';
        $asset->depreciate                  = '0';
        if (e(Input::get('status_id')) == '') {
            $asset->status_id =  null;
        } else {
            $asset->status_id = e(Input::get('status_id'));
        }

        if (e(Input::get('warranty_months')) == '') {
            $asset->warranty_months =  null;
        } else {
            $asset->warranty_months        = e(Input::get('warranty_months'));
        }

        if (e(Input::get('purchase_cost')) == '') {
            $asset->purchase_cost =  null;
        } else {
            $asset->purchase_cost = Helper::ParseFloat(e(Input::get('purchase_cost')));
        }

        if (e(Input::get('purchase_date')) == '') {
            $asset->purchase_date =  null;
        } else {
            $asset->purchase_date        = e(Input::get('purchase_date'));
        }

        if (e(Input::get('assigned_to')) == '') {
            $asset->assigned_to =  null;
        } else {
            $asset->assigned_to        = e(Input::get('assigned_to'));
        }

        if (e(Input::get('supplier_id')) == '') {
            $asset->supplier_id =  0;
        } else {
            $asset->supplier_id        = e(Input::get('supplier_id'));
        }

        if (e(Input::get('requestable')) == '') {
            $asset->requestable =  0;
        } else {
            $asset->requestable        = e(Input::get('requestable'));
        }

        if (e(Input::get('rtd_location_id')) == '') {
            $asset->rtd_location_id = null;
        } else {
            $asset->rtd_location_id     = e(Input::get('rtd_location_id'));
        }

        // Create the image (if one was chosen.)
        if (Input::has('image')) {



            $image = Input::get('image');

            // After modification, the image is prefixed by mime info like the following:
            // data:image/jpeg;base64,; This causes the image library to be unhappy, so we need to remove it.
            $header = explode(';', $image, 2)[0];
            // Grab the image type from the header while we're at it.
            $extension = substr($header, strpos($header, '/')+1);
            // Start reading the image after the first comma, postceding the base64.
            $image = substr($image, strpos($image, ',')+1);

            $file_name = str_random(25).".".$extension;

            $directory= public_path('uploads/assets/');
            // Check if the uploads directory exists.  If not, try to create it.
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            $path = public_path('uploads/assets/'.$file_name);
            try {
                Image::make($image)->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $asset->image = $file_name;
            } catch (\Exception $e) {
                \Input::flash();
                $messageBag = new \Illuminate\Support\MessageBag();
                $messageBag->add('image', $e->getMessage());
                \Session()->flash('errors', \Session::get('errors', new \Illuminate\Support\ViewErrorBag)
                    ->put('default', $messageBag));
                return response()->json(['image' => $e->getMessage()], 422);
            }

        }

        // Update custom fields in the database.
        // Validation for these fields is handlded through the AssetRequest form request
        // FIXME: No idea why this is returning a Builder error on db_column_name.
        // Need to investigate and fix. Using static method for now.
        $model = AssetModel::find($request->get('model_id'));
        if ($model->fieldset) {
            foreach ($model->fieldset->fields as $field) {
                $asset->{\App\Models\CustomField::name_to_db_name($field->name)} = e($request->input(\App\Models\CustomField::name_to_db_name($field->name)));
            }
        }

            // Was the asset created?
        if ($asset->save()) {
            $asset->logCreate();
            if (Input::get('assigned_to')!='') {
                $user = User::find(e(Input::get('assigned_to')));
                $asset->checkOutToUser($user, Auth::user(), date('Y-m-d H:i:s'), '', 'Checked out on asset creation', e(Input::get('name')));
            }
            // Redirect to the asset listing page
            \Session::flash('success', trans('admin/hardware/message.create.success'));
            return response()->json(['redirect_url' => route('hardware')]);
        }
        \Input::flash();
        \Session::flash('errors', $asset->getErrors());
        return response()->json(['errors' => $asset->getErrors()], 500);
    }

    /**
    * Returns a view that presents a form to edit an existing asset.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return View
    */
    public function getEdit($assetId = null)
    {

        // Check if the asset exists
        if (!$item = Asset::find($assetId)) {
            // Redirect to the asset management page
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($item)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }

        // Grab the dropdown lists
        $model_list = Helper::modelList();
        $statuslabel_list = Helper::statusLabelList();
        $location_list = Helper::locationsList();
        $manufacturer_list = Helper::manufacturerList();
        $category_list = Helper::categoryList('asset');
        $supplier_list = Helper::suppliersList();
        $company_list = Helper::companyList();
        $assigned_to = Helper::usersList();
        $statuslabel_types =Helper::statusTypeList();

        return View::make('hardware/edit', compact('item'))
        ->with('model_list', $model_list)
        ->with('supplier_list', $supplier_list)
        ->with('company_list', $company_list)
        ->with('location_list', $location_list)
        ->with('statuslabel_list', $statuslabel_list)
        ->with('assigned_to', $assigned_to)
        ->with('manufacturer', $manufacturer_list)
        ->with('statuslabel_types', $statuslabel_types)
        ->with('category', $category_list);
    }


    /**
    * Validate and process asset edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return Redirect
    */

    public function postEdit(AssetRequest $request, $assetId = null)
    {

        // Check if the asset exists
        if (!$asset = Asset::find($assetId)) {
            // Redirect to the asset management page with error
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }

        if ($request->has('status_id')) {
            $asset->status_id = e($request->input('status_id'));
        } else {
            $asset->status_id =  null;
        }

        if ($request->has('warranty_months')) {
            $asset->warranty_months = e($request->input('warranty_months'));
        } else {
            $asset->warranty_months =  null;
        }

        if ($request->has('purchase_cost')) {
            $asset->purchase_cost = Helper::ParseFloat(e($request->input('purchase_cost')));
        } else {
            $asset->purchase_cost =  null;
        }

        if ($request->has('purchase_date')) {
            $asset->purchase_date = e($request->input('purchase_date'));
        } else {
            $asset->purchase_date =  null;
        }

        if ($request->has('supplier_id')) {
            $asset->supplier_id = e($request->input('supplier_id'));
        } else {
            $asset->supplier_id =  null;
        }

        // If the box isn't checked, it's not in the request at all.
        $asset->requestable = $request->has('requestable');

        if ($request->has('rtd_location_id')) {
            $asset->rtd_location_id = e($request->input('rtd_location_id'));
        } else {
            $asset->rtd_location_id =  null;
        }

        if ($request->has('image_delete')) {
            unlink(public_path().'/uploads/assets/'.$asset->image);
            $asset->image = '';
        }


        // Update the asset data
        $asset->name         = e($request->input('name'));
        $asset->serial       = e($request->input('serial'));
        $asset->company_id   = Company::getIdForCurrentUser(e($request->input('company_id')));
        $asset->model_id     = e($request->input('model_id'));
        $asset->order_number = e($request->input('order_number'));
        $asset->asset_tag    = e($request->input('asset_tag'));
        $asset->notes        = e($request->input('notes'));
        $asset->physical     = '1';

        // Update the image
        if (Input::has('image')) {
            $image = $request->input('image');
            // See postCreate for more explaination of the following.
            $header = explode(';', $image, 2)[0];
            $extension = substr($header, strpos($header, '/')+1);
            $image = substr($image, strpos($image, ',')+1);

            $directory= public_path('uploads/assets/');
            // Check if the uploads directory exists.  If not, try to create it.
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $file_name = str_random(25).".".$extension;
            $path = public_path('uploads/assets/'.$file_name);
            try {
                Image::make($image)->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path);
                $asset->image = $file_name;
            } catch (\Exception $e) {
                \Input::flash();
                $messageBag = new \Illuminate\Support\MessageBag();
                $messageBag->add('image', $e->getMessage());
                \Session()->flash('errors', \Session::get('errors', new \Illuminate\Support\ViewErrorBag)
                    ->put('default', $messageBag));
                return response()->json(['image' => $e->getMessage()], 422);
            }
            $asset->image = $file_name;
        }

        // Update custom fields in the database.
        // Validation for these fields is handlded through the AssetRequest form request
        // FIXME: No idea why this is returning a Builder error on db_column_name.
        // Need to investigate and fix. Using static method for now.
        $model = AssetModel::find($request->get('model_id'));
        if ($model->fieldset) {
            foreach ($model->fieldset->fields as $field) {


                if ($field->field_encrypted=='1') {
                    if (Gate::allows('admin')) {
                        $asset->{\App\Models\CustomField::name_to_db_name($field->name)} = \Crypt::encrypt(e($request->input(\App\Models\CustomField::name_to_db_name($field->name))));
                    }

                } else {
                    $asset->{\App\Models\CustomField::name_to_db_name($field->name)} = e($request->input(\App\Models\CustomField::name_to_db_name($field->name)));
                }


            }
        }


        if ($asset->save()) {
            // Redirect to the new asset page

                $logaction = new Actionlog();
                $logaction->item_type = Asset::class;
                $logaction->item_id = $asset->id;
                $logaction->created_at =  date("Y-m-d H:i:s");
                if (Input::has('rtd_location_id')) {
                    $logaction->location_id = e(Input::get('rtd_location_id'));
                }
                $logaction->user_id = Auth::user()->id;
                $log = $logaction->logaction('update');

                
                
                \Session::flash('success', trans('admin/hardware/message.update.success'));
            return response()->json(['redirect_url' => route("view/hardware", $assetId)]);
        }
        \Input::flash();
        \Session::flash('errors', $asset->getErrors());
        return response()->json(['errors' => $asset->getErrors()], 500);

    }

    /**
    * Delete a given asset (mark as deleted).
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return Redirect
    */
    public function getDelete($assetId)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }

        DB::table('assets')
        ->where('id', $asset->id)
        ->update(array('assigned_to' => null));


        $asset->delete();

        $logaction = new Actionlog();
        $logaction->item_type = Asset::class;
        $logaction->item_id = $asset->id;
        $logaction->created_at =  date("Y-m-d H:i:s");
        $logaction->user_id = Auth::user()->id;
        $log = $logaction->logaction('deleted');

        // Redirect to the asset management page
        return redirect()->to('hardware')->with('success', trans('admin/hardware/message.delete.success'));




    }

    /**
    * Returns a view that presents a form to check an asset out to a
    * user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return View
    */
    public function getCheckout($assetId)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find(e($assetId)))) {
            // Redirect to the asset management page with error
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }

        // Get the dropdown of users and then pass it to the checkout view
        $users_list = Helper::usersList();

        return View::make('hardware/checkout', compact('asset'))->with('users_list', $users_list);

    }

    /**
    * Validate and process the form data to check out an asset to a user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return Redirect
    */
    public function postCheckout(AssetCheckoutRequest $request, $assetId)
    {

        // Check if the asset exists
        if (!$asset = Asset::find($assetId)) {
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        } elseif (!$asset->availableForCheckout()) {
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.checkout.not_available'));
        }

        $user = User::find(e(Input::get('assigned_to')));
        $admin = Auth::user();

        if ((Input::has('checkout_at')) && (Input::get('checkout_at')!= date("Y-m-d"))) {
            $checkout_at = e(Input::get('checkout_at'));
        } else {
            $checkout_at = date("Y-m-d H:i:s");
        }

        if (Input::has('expected_checkin')) {
            $expected_checkin = e(Input::get('expected_checkin'));
        } else {
            $expected_checkin = '';
        }


        if ($asset->checkOutToUser($user, $admin, $checkout_at, $expected_checkin, e(Input::get('note')), e(Input::get('name')))) {
          // Redirect to the new asset page
            return redirect()->to("hardware")->with('success', trans('admin/hardware/message.checkout.success'));
        }

      // Redirect to the asset management page with error
        return redirect()->to("hardware/$assetId/checkout")->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($asset->getErrors());
    }


    /**
    * Returns a view that presents a form to check an asset back into inventory.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @param string $backto
    * @since [v1.0]
    * @return View
    */
    public function getCheckin($assetId, $backto = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }
        $statusLabel_list = Helper::statusLabelList();
        return View::make('hardware/checkin', compact('asset'))->with('statusLabel_list', $statusLabel_list)->with('backto', $backto);
    }


    /**
    * Validate and process the form data to check an asset back into inventory.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return Redirect
    */
    public function postCheckin(AssetCheckinRequest $request, $assetId = null, $backto = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }

        $admin = Auth::user();

        if (!is_null($asset->assigned_to)) {
            $user = User::find($asset->assigned_to);
        } else {
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.checkin.already_checked_in'));
        }

        // This is just used for the redirect
        $return_to = $asset->assigned_to;
        $asset->expected_checkin = null;
        $asset->last_checkout = null;
        $asset->assigned_to = null;
        $asset->accepted = null;
        $asset->name = e(Input::get('name'));


        if (Input::has('status_id')) {
            $asset->status_id =  e(Input::get('status_id'));
        }
        // Was the asset updated?
        if ($asset->save()) {

            if ($request->input('checkin_at') == Carbon::now()->format('Y-m-d')) {
                $checkin_at = Carbon::now();
            } else {
                $checkin_at = $request->input('checkin_at').' 00:00:00';
            }
            //$checkin_at = e(Input::get('checkin_at'));
            $logaction = $asset->createLogRecord('checkin', $asset, $admin, $user, null, e(Input::get('note')), $checkin_at);


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
                                    'value' => class_basename(strtoupper($logaction->item_type)).' asset <'.config('app.url').'/hardware/'.$asset->id.'/view'.'|'.e($asset->showAssetName()).'> checked in by <'.config('app.url').'/admin/users/'.Auth::user()->id.'/view'.'|'.e(Auth::user()->fullName()).'>.'
                                ],
                                [
                                    'title' => 'Note:',
                                    'value' => e($logaction->note)
                                ],

                            ]
                        ])->send('Asset Checked In');

                } catch (Exception $e) {

                }

            }

            $data['log_id'] = $logaction->id;
            $data['first_name'] = $user->first_name;
            $data['item_name'] = $asset->showAssetName();
            $data['checkin_date'] = $logaction->created_at;
            $data['item_tag'] = $asset->asset_tag;
            $data['item_serial'] = $asset->serial;
            $data['note'] = $logaction->note;

            if ((($asset->checkin_email()=='1')) && ($user) && (!config('app.lock_passwords'))) {
                Mail::send('emails.checkin-asset', $data, function ($m) use ($user) {
                    $m->to($user->email, $user->first_name . ' ' . $user->last_name);
                    $m->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'));
                    $m->subject(trans('mail.Confirm_Asset_Checkin'));
                });
            }

            if ($backto=='user') {
                return redirect()->to("admin/users/".$return_to.'/view')->with('success', trans('admin/hardware/message.checkin.success'));
            } else {
                return redirect()->to("hardware")->with('success', trans('admin/hardware/message.checkin.success'));
            }

        }

        // Redirect to the asset management page with error
        return redirect()->to("hardware")->with('error', trans('admin/hardware/message.checkin.error'));
    }


    /**
    * Returns a view that presents information about an asset for detail view.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return View
    */
    public function getView($assetId = null)
    {
        $asset = Asset::withTrashed()->find($assetId);
        $settings = Setting::getSettings();

        if (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        } elseif ($asset->userloc) {
            $use_currency = $asset->userloc->currency;
        } elseif ($asset->assetloc) {
            $use_currency = $asset->assetloc->currency;
        } else {
            $default_currency = Setting::first()->default_currency;

            if ($settings->default_currency!='') {
                $use_currency = $settings->default_currency;
            } else {
                $use_currency = trans('general.currency');
            }

        }

        if (isset($asset->id)) {



            $qr_code = (object) array(
                'display' => $settings->qr_code == '1',
                'url' => route('qr_code/hardware', $asset->id)
            );

            return View::make('hardware/view', compact('asset', 'qr_code', 'settings'))->with('use_currency', $use_currency);
        } else {
            // Prepare the error message
            $error = trans('admin/hardware/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('hardware')->with('error', $error);
        }

    }

    /**
    * Return a QR code for the asset
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return Response
    */
    public function getQrCode($assetId = null)
    {
        $settings = Setting::getSettings();

        if ($settings->qr_code == '1') {
            $asset = Asset::find($assetId);
            $size = Helper::barcodeDimensions($settings->barcode_type);
            $qr_file = public_path().'/uploads/barcodes/qr-'.str_slug($asset->asset_tag).'.png';

            if (isset($asset->id,$asset->asset_tag)) {

                if (file_exists($qr_file)) {
                    $header = ['Content-type' => 'image/png'];
                    return response()->file($qr_file, $header);
                } else {
                    $barcode = new \Com\Tecnick\Barcode\Barcode();
                    $barcode_obj =  $barcode->getBarcodeObj($settings->barcode_type, route('view/hardware', $asset->id), $size['height'], $size['width'], 'black', array(-2, -2, -2, -2));
                    file_put_contents($qr_file, $barcode_obj->getPngData());
                    return response($barcode_obj->getPngData())->header('Content-type', 'image/png');
                }

            }
        }

    }


    /**
     * Return a 2D barcode for the asset
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return Response
     */
    public function getBarCode($assetId = null)
    {

        $settings = Setting::getSettings();
        $asset = Asset::find($assetId);
        $barcode_file = public_path().'/uploads/barcodes/'.str_slug($settings->alt_barcode).'-'.str_slug($asset->asset_tag).'.png';


        if (isset($asset->id,$asset->asset_tag)) {

            if (file_exists($barcode_file)) {
                $header = ['Content-type' => 'image/png'];
                return response()->file($barcode_file, $header);
            } else {
                $barcode = new \Com\Tecnick\Barcode\Barcode();
                $barcode_obj = $barcode->getBarcodeObj($settings->alt_barcode, $asset->asset_tag, 250, 20);
                file_put_contents($barcode_file, $barcode_obj->getPngData());
                return response($barcode_obj->getPngData())->header('Content-type', 'image/png');
            }
        }

    }


    /**
    * Get the Asset import upload page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v2.0]
    * @return View
    */
    public function getImportUpload()
    {

        $path = config('app.private_uploads').'/imports/assets';
        $files = array();

        if (!Company::isCurrentUserAuthorized()) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }

        // Check if the uploads directory exists.  If not, try to create it.
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        if ($handle = opendir($path)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                clearstatcache();
                if (substr(strrchr($entry, '.'), 1)=='csv') {
                    $files[] = array(
                            'filename' => $entry,
                            'filesize' => Setting::fileSizeConvert(filesize($path.'/'.$entry)),
                            'modified' => filemtime($path.'/'.$entry)
                        );
                }

            }
            closedir($handle);
            $files = array_reverse($files);
        }

        return View::make('hardware/import')->with('files', $files);
    }



    /**
    * Upload the import file via AJAX
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v2.0]
    * @return View
    */
    public function postAPIImportUpload(AssetFileRequest $request)
    {

        if (!Company::isCurrentUserAuthorized()) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));

        } elseif (!config('app.lock_passwords')) {

            $files = Input::file('files');
            $path = config('app.private_uploads').'/imports/assets';
            $results = array();

            foreach ($files as $file) {

                if (!in_array($file->getMimeType(), array(
                    'application/vnd.ms-excel',
                    'text/csv',
                    'text/plain',
                    'text/comma-separated-values',
                    'text/tsv'))) {
                    $results['error']='File type must be CSV';
                    return $results;
                }

                $date = date('Y-m-d-his');
                $fixed_filename = str_replace(' ', '-', $file->getClientOriginalName());
                try {
                    $file->move($path, $date.'-'.$fixed_filename);
                } catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $exception) {
                    $results['error']=trans('admin/hardware/message.upload.error');
                    if (config('app.debug')) {
                        $results['error'].= ' ' . $exception->getMessage();
                    }
                    return $results;
                }
                $name = date('Y-m-d-his').'-'.$fixed_filename;
                $filesize = Setting::fileSizeConvert(filesize($path.'/'.$name));
                $results[] = compact('name', 'filesize');
            }

            return array(
                'files' => $results
            );




        } else {
            $results['error']=trans('general.feature_disabled');
            return $results;
        }



    }

    public function getDeleteImportFile($filename)
    {
        if (!Company::isCurrentUserAuthorized()) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }

        if (unlink(config('app.private_uploads').'/imports/assets/'.$filename)) {
            return redirect()->back()->with('success', trans('admin/hardware/message.import.file_delete_success'));
        }
        return redirect()->back()->with('error', trans('admin/hardware/message.import.file_delete_error'));
    }


    /**
    * Process the uploaded file
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param string $filename
    * @since [v2.0]
    * @return Redirect
    */
    public function postProcessImportFile()
    {
        // php artisan asset-import:csv path/to/your/file.csv --domain=yourdomain.com --email_format=firstname.lastname
        $filename = Input::get('filename');
        $itemType = Input::get('import-type');
        $updateItems  = Input::get('import-update');

        if (!Company::isCurrentUserAuthorized()) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }
        $importOptions =    ['filename'=> config('app.private_uploads').'/imports/assets/'.$filename,
                                '--email_format'=>'firstname.lastname',
                                '--username_format'=>'firstname.lastname',
                                '--web-importer' => true,
                                '--user_id' => Auth::user()->id,
                                '--item-type' => $itemType,
                            ];
        if ($updateItems) {
            $importOptions['--update'] = true;
        }

        $return = Artisan::call('snipeit:import', $importOptions);
        $display_output =  Artisan::output();
        $file = config('app.private_uploads').'/imports/assets/'.str_replace('.csv', '', $filename).'-output-'.date("Y-m-d-his").'.txt';
        file_put_contents($file, $display_output);
        // We use hardware instead of asset in the url
        $redirectTo = "hardware";
        switch($itemType) {
            case "asset":
                $redirectTo = "hardware";
                break;
            case "accessory":
                $redirectTo = "accessories";
                break;
            case "consumable":
                $redirectTo = "consumables";
                break;
        }

        if ($return === 0) { //Success
            return redirect()->to(route($redirectTo))->with('success', trans('admin/hardware/message.import.success'));
        } elseif ($return === 1) { // Failure
            return redirect()->back()->with('import_errors', json_decode($display_output))->with('error', trans('admin/hardware/message.import.error'));
        }
        dd("Shouldn't be here");

    }

    /**
    * Returns a view that presents a form to clone an asset.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return View
    */
    public function getClone($assetId = null)
    {
        // Check if the asset exists
        if (is_null($asset_to_clone = Asset::find($assetId))) {
            // Redirect to the asset management page
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        } elseif (!Company::isCurrentUserHasAccess($asset_to_clone)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }

        // Grab the dropdown lists
        $model_list = Helper::modelList();
        $statuslabel_list = Helper::statusLabelList();
        $location_list = Helper::locationsList();
        $manufacturer_list = Helper::manufacturerList();
        $category_list = Helper::categoryList('asset');
        $supplier_list = Helper::suppliersList();
        $assigned_to =Helper::usersList();
        $statuslabel_types = Helper::statusTypeList();
        $company_list = Helper::companyList();

        $asset = clone $asset_to_clone;
        $asset->id = null;
        $asset->asset_tag = '';
        $asset->serial = '';
        $asset->assigned_to = '';

        return View::make('hardware/edit')
        ->with('supplier_list', $supplier_list)
        ->with('model_list', $model_list)
        ->with('statuslabel_list', $statuslabel_list)
        ->with('statuslabel_types', $statuslabel_types)
        ->with('assigned_to', $assigned_to)
        ->with('item', $asset)
        ->with('location_list', $location_list)
        ->with('manufacturer', $manufacturer_list)
        ->with('category', $category_list)
        ->with('company_list', $company_list);

    }


    /**
     * Return history import view
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function getImportHistory()
    {

        return View::make('hardware/history');
    }

    /**
     * Import history
     *
     * This needs a LOT of love. It's done very inelegantly right now, and there are
     * a ton of optimizations that could (and should) be done.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.3]
     * @return View
     */
    public function postImportHistory(Request $request)
    {

        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $assets = Asset::all(['asset_tag']);

        $csv = Reader::createFromPath(Input::file('user_import_csv'));
        $csv->setNewline("\r\n");
        //get the first row, usually the CSV header
        //$headers = $csv->fetchOne();

        $results = $csv->fetchAssoc();
        $item = array();
        $status = array();
        $status['error'] = array();
        $status['success'] = array();


        foreach($results as $row) {

            if (is_array($row)) {

                $row = array_change_key_case($row, CASE_LOWER);
                $asset_tag = Helper::array_smart_fetch($row, "asset tag");
                if (!array_key_exists($asset_tag, $item)) {
                    $item[$asset_tag] = array();
                }
                $batch_counter = count($item[$asset_tag]);

                $item[$asset_tag][$batch_counter]['checkout_date'] = Carbon::parse(Helper::array_smart_fetch($row, "date"))->format('Y-m-d H:i:s');

                $item[$asset_tag][$batch_counter]['asset_tag'] = Helper::array_smart_fetch($row, "asset tag");
                $item[$asset_tag][$batch_counter]['name'] = Helper::array_smart_fetch($row, "name");
                $item[$asset_tag][$batch_counter]['email'] = Helper::array_smart_fetch($row, "email");

                if ($asset = Asset::where('asset_tag','=',$asset_tag)->first()) {

                    $item[$asset_tag][$batch_counter]['asset_id'] = $asset->id;

                    $base_username = User::generateFormattedNameFromFullName(Setting::getSettings()->username_format,$item[$asset_tag][$batch_counter]['name']);
                    $user = User::where('username','=',$base_username['username']);
                    $user_query = ' on username '.$base_username['username'];

                    if ($request->input('match_firstnamelastname')=='1') {
                        $firstnamedotlastname = User::generateFormattedNameFromFullName('firstname.lastname',$item[$asset_tag][$batch_counter]['name']);
                        $item[$asset_tag][$batch_counter]['username'][] = $firstnamedotlastname['username'];
                        $user->orWhere('username','=',$firstnamedotlastname['username']);
                        $user_query .= ', or on username '.$firstnamedotlastname['username'];
                    }

                    if ($request->input('match_flastname')=='1') {
                        $flastname = User::generateFormattedNameFromFullName('filastname',$item[$asset_tag][$batch_counter]['name']);
                        $item[$asset_tag][$batch_counter]['username'][] = $flastname['username'];
                        $user->orWhere('username','=',$flastname['username']);
                        $user_query .= ', or on username '.$flastname['username'];
                    }
                    if ($request->input('match_firstname')=='1') {
                        $firstname = User::generateFormattedNameFromFullName('firstname',$item[$asset_tag][$batch_counter]['name']);
                        $item[$asset_tag][$batch_counter]['username'][] = $firstname['username'];
                        $user->orWhere('username','=',$firstname['username']);
                        $user_query .= ', or on username '.$firstname['username'];
                    }
                    if ($request->input('match_email')=='1') {
                        if ($item[$asset_tag][$batch_counter]['email']=='') {
                            $item[$asset_tag][$batch_counter]['username'][] = $user_email = User::generateEmailFromFullName($item[$asset_tag][$batch_counter]['name']);
                            $user->orWhere('username','=',$user_email);
                            $user_query .= ', or on username '.$user_email;
                        }
                    }

                    // A matching user was found
                    if ($user = $user->first()) {
                        $item[$asset_tag][$batch_counter]['checkedout_to'] = $user->id;
                        $item[$asset_tag][$batch_counter]['user_id'] = $user->id;

                        Actionlog::firstOrCreate(array(
                                'item_id' => $asset->id,
                                'item_type' => Asset::class,
                                'user_id' =>  Auth::user()->id,
                                'note' => 'Checkout imported by '.Auth::user()->fullName().' from history importer',
                                'target_id' => $item[$asset_tag][$batch_counter]['user_id'],
                                'target_type' => User::class,
                                'created_at' =>  $item[$asset_tag][$batch_counter]['checkout_date'],
                                'action_type'   => 'checkout',
                            )
                        );

                        $asset->assigned_to = $user->id;

                        if ($asset->save()) {
                            $status['success'][]['asset'][$asset_tag]['msg'] = 'Asset successfully matched for '.Helper::array_smart_fetch($row, "name").$user_query.' on '.$item[$asset_tag][$batch_counter]['checkout_date'];
                        } else {
                            $status['error'][]['asset'][$asset_tag]['msg'] = 'Asset and user was matched but could not be saved.';
                        }

                    } else {
                        $item[$asset_tag][$batch_counter]['checkedout_to'] = null;
                        $status['error'][]['user'][Helper::array_smart_fetch($row, "name")]['msg'] = 'User does not exist so no checkin log was created.';
                    }

                } else {
                    $item[$asset_tag][$batch_counter]['asset_id'] = null;
                    $status['error'][]['asset'][$asset_tag]['msg'] = 'Asset does not exist so no match was attempted.';
                }




            }
        }

        // Loop through and backfill the checkins
        foreach ($item as $key => $asset_batch) {
            $total_in_batch = count($asset_batch);
            for($x = 0; $x < $total_in_batch; $x++) {
                $next = $x + 1;

                // Only do this if a matching user was found
                if ((array_key_exists('checkedout_to',$asset_batch[$x])) && ($asset_batch[$x]['checkedout_to']!='')) {

                    if (($total_in_batch > 1) && ($x < $total_in_batch) && (array_key_exists($next,$asset_batch))) {
                        $checkin_date = Carbon::parse($asset_batch[$next]['checkout_date'])->subDay(1)->format('Y-m-d H:i:s');
                        $asset_batch[$x]['real_checkin'] = $checkin_date;

                        Actionlog::firstOrCreate(array(
                                'item_id' => $asset_batch[$x]['asset_id'],
                                'item_type' => Asset::class,
                                'user_id' => Auth::user()->id,
                                'note' => 'Checkin imported by ' . Auth::user()->fullName() . ' from history importer',
                                'target_id' => null,
                                'created_at' => $checkin_date,
                                'action_type' => 'checkin'
                            )
                        );
                    }
                }


            }
        }


        return View::make('hardware/history')->with('status',$status);
    }


    /**
    * Retore a deleted asset.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return View
    */
    public function getRestore($assetId = null)
    {

        // Get user information
        $asset = Asset::withTrashed()->find($assetId);

        if (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        } elseif (isset($asset->id)) {

            // Restore the asset
            Asset::withTrashed()->where('id', $assetId)->restore();
            return redirect()->route('hardware')->with('success', trans('admin/hardware/message.restore.success'));

        } else {
            return redirect()->to('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

    }


    /**
    * Upload a file to the server.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param int $assetId
    * @since [v1.0]
    * @return Redirect
    */
    public function postUpload(AssetFileRequest $request, $assetId = null)
    {

        if (!$asset = Asset::find($assetId)) {
            return redirect()->route('hardware')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $destinationPath = config('app.private_uploads').'/assets';



        if (!Company::isCurrentUserHasAccess($asset)) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        }

        if (Input::hasFile('assetfile')) {

            foreach (Input::file('assetfile') as $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = 'hardware-'.$asset->id.'-'.str_random(8);
                $filename .= '-'.str_slug($file->getClientOriginalName()).'.'.$extension;
                $upload_success = $file->move($destinationPath, $filename);

                //Log the deletion of seats to the log
                $asset->logUpload($filename, e(Input::get('notes')));

            }
        } else {
            return redirect()->back()->with('error', trans('admin/hardware/message.upload.nofiles'));
        }

        if ($upload_success) {
            return redirect()->back()->with('success', trans('admin/hardware/message.upload.success'));
        } else {
            return redirect()->back()->with('error', trans('admin/hardware/message.upload.error'));
        }



    }

    /**
    * Delete the associated file
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int  $assetId
    * @param  int  $fileId
    * @since [v1.0]
    * @return View
    */
    public function getDeleteFile($assetId = null, $fileId = null)
    {
        $asset = Asset::find($assetId);
        $destinationPath = config('app.private_uploads').'/imports/assets';

        // the asset is valid
        if (isset($asset->id)) {


            if (!Company::isCurrentUserHasAccess($asset)) {
                return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
            }

            $log = Actionlog::find($fileId);
            $full_filename = $destinationPath.'/'.$log->filename;
            if (file_exists($full_filename)) {
                unlink($destinationPath.'/'.$log->filename);
            }
            $log->delete();
            return redirect()->back()->with('success', trans('admin/hardware/message.deletefile.success'));

        } else {
            // Prepare the error message
            $error = trans('admin/hardware/message.does_not_exist', compact('id'));

            // Redirect to the hardware management page
            return redirect()->route('hardware')->with('error', $error);
        }
    }



    /**
    * Check for permissions and display the file.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int  $assetId
    * @param  int  $fileId
    * @since [v1.0]
    * @return View
    */
    public function displayFile($assetId = null, $fileId = null)
    {

        $asset = Asset::find($assetId);

        // the asset is valid
        if (isset($asset->id)) {


            if (!Company::isCurrentUserHasAccess($asset)) {
                return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
            }

            $log = Actionlog::find($fileId);
            $file = $log->get_src('assets');

            $filetype = Helper::checkUploadIsImage($file);

            if ($filetype) {
                  $contents = file_get_contents($file);
                  return Response::make($contents)->header('Content-Type', $filetype);
            } else {
                  return Response::download($file);
            }

        } else {
            // Prepare the error message
            $error = trans('admin/hardware/message.does_not_exist', compact('id'));

            // Redirect to the hardware management page
            return redirect()->route('hardware')->with('error', $error);
        }
    }




    /**
    * Display the bulk edit page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  int  $assetId
    * @since [v2.0]
    * @return View
    */
    public function postBulkEdit($assets = null)
    {

        if (!Company::isCurrentUserAuthorized()) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));

        } elseif (!Input::has('edit_asset')) {
                 return redirect()->back()->with('error', 'No assets selected');

        } else {
            $asset_raw_array = Input::get('edit_asset');
            foreach ($asset_raw_array as $asset_id => $value) {
                $asset_ids[] = $asset_id;

            }

        }

        if (Input::has('bulk_actions')) {


            // Create labels
            if (Input::get('bulk_actions')=='labels') {


                $settings = Setting::getSettings();

                    $assets = Asset::find($asset_ids);
                    $count = 0;

                    return View::make('hardware/labels')->with('assets', $assets)->with('settings', $settings)->with('count', $count)->with('settings', $settings);



            } elseif (Input::get('bulk_actions')=='delete') {


                $assets = Asset::with('assigneduser', 'assetloc')->find($asset_ids);
                return View::make('hardware/bulk-delete')->with('assets', $assets);

             // Bulk edit
            } elseif (Input::get('bulk_actions')=='edit') {

                $assets = Input::get('edit_asset');
                $supplier_list = Helper::suppliersList();
                $statuslabel_list = Helper::statusLabelList();
                $location_list = Helper::locationsList();
                $models_list =  Helper::modelList();
                $companies_list = array('' => '') + array('clear' => trans('general.remove_company')) + Helper::companyList();

                return View::make('hardware/bulk')
                ->with('assets', $assets)
                ->with('supplier_list', $supplier_list)
                ->with('statuslabel_list', $statuslabel_list)
                ->with('location_list', $location_list)
                ->with('models_list', $models_list)
                ->with('companies_list', $companies_list);


            }

        } else {
            return redirect()->back()->with('error', 'No action selected');
        }



    }



    /**
    * Save bulk edits
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  array  $assets
    * @since [v2.0]
    * @return Redirect
    */
    public function postBulkSave($assets = null)
    {

        if (!Company::isCurrentUserAuthorized()) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));

        } elseif (Input::has('bulk_edit')) {

            $assets = Input::get('bulk_edit');

            if ((Input::has('purchase_date')) ||  (Input::has('purchase_cost'))  ||  (Input::has('supplier_id')) ||  (Input::has('order_number')) || (Input::has('warranty_months')) || (Input::has('rtd_location_id'))  || (Input::has('requestable')) ||  (Input::has('company_id')) || (Input::has('status_id')) ||  (Input::has('model_id'))) {

                foreach ($assets as $key => $value) {

                    $update_array = array();

                    if (Input::has('purchase_date')) {
                        $update_array['purchase_date'] =  e(Input::get('purchase_date'));
                    }

                    if (Input::has('purchase_cost')) {
                        $update_array['purchase_cost'] =  Helper::ParseFloat(e(Input::get('purchase_cost')));
                    }

                    if (Input::has('supplier_id')) {
                        $update_array['supplier_id'] =  e(Input::get('supplier_id'));
                    }

                    if (Input::has('model_id')) {
                        $update_array['model_id'] =  e(Input::get('model_id'));
                    }

                    if (Input::has('company_id')) {
                        if (Input::get('company_id')=="clear") {
                            $update_array['company_id'] =  null;
                        } else {
                            $update_array['company_id'] =  e(Input::get('company_id'));
                        }

                    }

                    if (Input::has('order_number')) {
                        $update_array['order_number'] =  e(Input::get('order_number'));
                    }

                    if (Input::has('warranty_months')) {
                        $update_array['warranty_months'] =  e(Input::get('warranty_months'));
                    }

                    if (Input::has('rtd_location_id')) {
                        $update_array['rtd_location_id'] = e(Input::get('rtd_location_id'));
                    }

                    if (Input::has('status_id')) {
                        $update_array['status_id'] = e(Input::get('status_id'));
                    }

                    if (Input::has('requestable')) {
                        $update_array['requestable'] = e(Input::get('requestable'));
                    }


                    if (DB::table('assets')
                    ->where('id', $key)
                    ->update($update_array)) {

                        $logaction = new Actionlog();
                        $logaction->item_type = Asset::class;
                        $logaction->item_id = $key;
                        $logaction->created_at =  date("Y-m-d H:i:s");

                        if (Input::has('rtd_location_id')) {
                            $logaction->location_id = e(Input::get('rtd_location_id'));
                        }
                        $logaction->user_id = Auth::user()->id;
                        $log = $logaction->logaction('update');

                    }

                } // endforeach

                return redirect()->to("hardware")->with('success', trans('admin/hardware/message.update.success'));

            // no values given, nothing to update
            } else {
                return redirect()->to("hardware")->with('info', trans('admin/hardware/message.update.nothing_updated'));

            }


        } // endif

        return redirect()->to("hardware");

    }

    /**
    * Save bulk deleted.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  array  $assets
    * @since [v2.0]
    * @return View
    */
    public function postBulkDelete($assets = null)
    {

        if (!Company::isCurrentUserAuthorized()) {
            return redirect()->to('hardware')->with('error', trans('general.insufficient_permissions'));
        } elseif (Input::has('bulk_edit')) {
              //$assets = Input::get('bulk_edit');
            $assets = Asset::find(Input::get('bulk_edit'));
          //print_r($assets);


            foreach ($assets as $asset) {
          //echo '<li>'.$asset;
                $update_array['deleted_at'] = date('Y-m-d H:i:s');
                $update_array['assigned_to'] = null;

                if (DB::table('assets')
                ->where('id', $asset->id)
                ->update($update_array)) {

                    $logaction = new Actionlog();
                    $logaction->item_type = Asset::class;
                    $logaction->item_id = $asset->id;
                    $logaction->created_at =  date("Y-m-d H:i:s");
                    $logaction->user_id = Auth::user()->id;
                    $log = $logaction->logaction('deleted');

                }

            } // endforeach
                return redirect()->to("hardware")->with('success', trans('admin/hardware/message.delete.success'));

            // no values given, nothing to update
        } else {
            return redirect()->to("hardware")->with('info', trans('admin/hardware/message.delete.nothing_updated'));

        }

        // Something weird happened here - default to hardware
        return redirect()->to("hardware");

    }



    /**
    * Generates the JSON used to display the asset listing.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @param  string  $status
    * @since [v2.0]
    * @return String JSON
    */
    public function getDatatable(Request $request, $status = null)
    {


        $assets = Company::scopeCompanyables(Asset::select('assets.*'))->with('model', 'assigneduser', 'assigneduser.userloc', 'assetstatus', 'defaultLoc', 'assetlog', 'model', 'model.category', 'model.manufacturer', 'model.fieldset', 'assetstatus', 'assetloc', 'company')
        ->Hardware();

        if ($request->has('search')) {
             $assets = $assets->TextSearch(e($request->get('search')));
        }

        if ($request->has('offset')) {
             $offset = e($request->get('offset'));
        } else {
             $offset = 0;
        }

        if ($request->has('limit')) {
             $limit = e($request->get('limit'));
        } else {
             $limit = 50;
        }

        if ($request->has('order_number')) {
            $assets->where('order_number', '=', e($request->get('order_number')));
        }

        switch ($status) {
            case 'Deleted':
                $assets->withTrashed()->Deleted();
                break;
            case 'Pending':
                $assets->Pending();
                break;
            case 'RTD':
                $assets->RTD();
                break;
            case 'Undeployable':
                $assets->Undeployable();
                break;
            case 'Archived':
                $assets->Archived();
                break;
            case 'Requestable':
                $assets->RequestableAssets();
                break;
            case 'Deployed':
                $assets->Deployed();
                break;
        }

        if ($request->has('status_id')) {
            $assets->where('status_id','=', e($request->get('status_id')));
        }



        $allowed_columns = [
        'id',
        'name',
        'asset_tag',
        'serial',
        'model',
        'model_number',
        'last_checkout',
        'category',
        'manufacturer',
        'notes',
        'expected_checkin',
        'order_number',
        'companyName',
        'location',
        'image',
        'status_label',
        'assigned_to',
        'created_at',
        'purchase_date',
        'purchase_cost'
        ];

        $all_custom_fields = CustomField::all(); //used as a 'cache' of custom fields throughout this page load

        foreach ($all_custom_fields as $field) {
            $allowed_columns[]=$field->db_column_name();
        }

        $order = $request->get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'asset_tag';

        switch ($sort) {
            case 'model':
                $assets = $assets->OrderModels($order);
                break;
            case 'model_number':
                $assets = $assets->OrderModelNumber($order);
                break;
            case 'category':
                $assets = $assets->OrderCategory($order);
                break;
            case 'manufacturer':
                $assets = $assets->OrderManufacturer($order);
                break;
            case 'companyName':
                $assets = $assets->OrderCompany($order);
                break;
            case 'location':
                $assets = $assets->OrderLocation($order);
                break;
            case 'status_label':
                $assets = $assets->OrderStatus($order);
                break;
            case 'assigned_to':
                $assets = $assets->OrderAssigned($order);
                break;
            default:
                $assets = $assets->orderBy($sort, $order);
                break;
        }

        $assetCount = $assets->count();
        $assets = $assets->skip($offset)->take($limit)->get();


        $rows = array();
        foreach ($assets as $asset) {
            $inout = '';
            $actions = '<div style="white-space: nowrap;">';
            if ($asset->deleted_at=='') {
                if (Gate::allows('assets.create')) {
                    $actions .= '<a href="' . route('clone/hardware',
                            $asset->id) . '" class="btn btn-info btn-sm" title="Clone asset" data-toggle="tooltip"><i class="fa fa-clone"></i></a> ';
                }
                if (Gate::allows('assets.edit')) {
                    $actions .= '<a href="' . route('update/hardware',
                            $asset->id) . '" class="btn btn-warning btn-sm" title="Edit asset" data-toggle="tooltip"><i class="fa fa-pencil icon-white"></i></a> ';
                }
                if (Gate::allows('assets.delete')) {
                    $actions .= '<a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="' . route('delete/hardware',
                            $asset->id) . '" data-content="' . trans('admin/hardware/message.delete.confirm') . '" data-title="' . trans('general.delete') . ' ' . htmlspecialchars($asset->asset_tag) . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
                }
            } elseif ($asset->model->deleted_at=='') {
                $actions .= '<a href="'.route('restore/hardware', $asset->id).'" title="Restore asset" data-toggle="tooltip" class="btn btn-warning btn-sm"><i class="fa fa-recycle icon-white"></i></a>';
            }

            $actions .= '</div>';

            if (($asset->availableForCheckout()))
            {
                if (Gate::allows('assets.checkout')) {
                    $inout = '<a href="' . route('checkout/hardware',
                            $asset->id) . '" class="btn btn-info btn-sm" title="Checkout this asset to a user" data-toggle="tooltip">' . trans('general.checkout') . '</a>';
                }

            } else {
                if (($asset->assigned_to!='') && (Gate::allows('assets.checkin'))) {
                    $inout = '<a href="' . route('checkin/hardware',
                            $asset->id) . '" class="btn btn-primary btn-sm" title="Checkin this asset" data-toggle="tooltip">' . trans('general.checkin') . '</a>';
                }
            }

            $purchase_cost = Helper::formatCurrencyOutput($asset->purchase_cost);

            $row = array(
            'checkbox'      =>'<div class="text-center"><input type="checkbox" name="edit_asset['.$asset->id.']" class="one_required"></div>',
            'id'        => $asset->id,
            'image' => (($asset->image) && ($asset->image!='')) ? '<img src="'.config('app.url').'/uploads/assets/'.$asset->image.'" height=50 width=50>' : ((($asset->model) && ($asset->model->image!='')) ? '<img src="'.config('app.url').'/uploads/models/'.$asset->model->image.'" height=40 width=50>' : ''),
            'name'          => '<a title="'.e($asset->name).'" href="hardware/'.$asset->id.'/view">'.e($asset->name).'</a>',
            'asset_tag'     => '<a title="'.e($asset->asset_tag).'" href="hardware/'.$asset->id.'/view">'.e($asset->asset_tag).'</a>',
            'serial'        => e($asset->serial),
            'model'         => ($asset->model) ? (string)link_to('/hardware/models/'.$asset->model->id.'/view', e($asset->model->name)) : 'No model',
            'model_number'  => ($asset->model && $asset->model->model_number) ? (string)$asset->model->model_number : '',
            'status_label'        => ($asset->assigneduser) ? 'Deployed' : ((e($asset->assetstatus)) ? e($asset->assetstatus->name) : ''),
            'assigned_to'        => ($asset->assigneduser) ? (string)link_to(config('app.url').'/admin/users/'.$asset->assigned_to.'/view', e($asset->assigneduser->fullName())) : '',
            'location'      => (($asset->assigneduser) && ($asset->assigneduser->userloc!='')) ? (string)link_to('admin/settings/locations/'.$asset->assigneduser->userloc->id.'/view', e($asset->assigneduser->userloc->name)) : (($asset->defaultLoc!='') ? (string)link_to('admin/settings/locations/'.$asset->defaultLoc->id.'/view', e($asset->defaultLoc->name)) : ''),
            'category'      => (($asset->model) && ($asset->model->category)) ?(string)link_to('/admin/settings/categories/'.$asset->model->category->id.'/view', e($asset->model->category->name)) : '',
            'manufacturer'      => (($asset->model) && ($asset->model->manufacturer)) ? (string)link_to('/admin/settings/manufacturers/'.$asset->model->manufacturer->id.'/view', e($asset->model->manufacturer->name)) : '',
            'eol'           => ($asset->eol_date()) ? $asset->eol_date() : '',
            'purchase_cost'           => $purchase_cost,
            'purchase_date'           => ($asset->purchase_date) ? $asset->purchase_date : '',
            'notes'         => e($asset->notes),
            'order_number'  => ($asset->order_number!='') ? '<a href="'.config('app.url').'/hardware?order_number='.e($asset->order_number).'">'.e($asset->order_number).'</a>' : '',
            'last_checkout' => ($asset->last_checkout!='') ? e($asset->last_checkout) : '',
            'expected_checkin' => ($asset->expected_checkin!='')  ? e($asset->expected_checkin) : '',
            'created_at' => ($asset->created_at!='')  ? e($asset->created_at->format('F j, Y h:iA')) : '',
            'change'        => ($inout) ? $inout : '',
            'actions'       => ($actions) ? $actions : '',
            'companyName'   => is_null($asset->company) ? '' : e($asset->company->name)
            );
            foreach ($all_custom_fields as $field) {
                $column_name = $field->db_column_name();

                if ($field->isFieldDecryptable($asset->{$column_name})) {

                    if (Gate::allows('admin')) {
                        if (($field->format=='URL') && ($asset->{$column_name}!='')) {
                            $row[$column_name] = '<a href="'.Helper::gracefulDecrypt($field, $asset->{$column_name}).'" target="_blank">'.Helper::gracefulDecrypt($field, $asset->{$column_name}).'</a>';
                        } else {
                            $row[$column_name] = Helper::gracefulDecrypt($field, $asset->{$column_name});
                        }

                    } else {
                        $row[$field->db_column_name()] = strtoupper(trans('admin/custom_fields/general.encrypted'));
                    }
                } else {
                    if (($field->format=='URL') && ($asset->{$field->db_column_name()}!='')) {
                        $row[$field->db_column_name()] = '<a href="'.$asset->{$field->db_column_name()}.'" target="_blank">'.$asset->{$field->db_column_name()}.'</a>';
                    } else {
                        $row[$field->db_column_name()] = e($asset->{$field->db_column_name()});
                    }
                }

            }

            if (($request->has('report')) && ($request->get('report')=='true')) {
                $rows[]= Helper::stripTagsFromJSON($row);
            } else {
                $rows[]= $row;
            }

        }

        $data = array('total'=>$assetCount, 'rows'=>$rows);

        return $data;
    }

      public function getBulkCheckout()
      {
          // Get the dropdown of users and then pass it to the checkout view
          $users_list = Helper::usersList();
          // Filter out assets that are not deployable.
          $assets = Asset::RTD()->get();

          $assets_list = Company::scopeCompanyables($assets, 'assets.company_id')->lists('detailed_name', 'id')->toArray();

          return View::make('hardware/bulk-checkout')->with('users_list', $users_list)->with('assets_list', $assets_list);
      }

      public function postBulkCheckout(Request $request)
      {

          $this->validate($request, [
             "assigned_to"   => 'required'
          ]);

          $user = User::find(e(Input::get('assigned_to')));
          $admin = Auth::user();

          $asset_ids = array_filter(Input::get('selected_assets'));

          if ((Input::has('checkout_at')) && (Input::get('checkout_at')!= date("Y-m-d"))) {
              $checkout_at = e(Input::get('checkout_at'));
          } else {
              $checkout_at = date("Y-m-d H:i:s");
          }

          if (Input::has('expected_checkin')) {
              $expected_checkin = e(Input::get('expected_checkin'));
          } else {
              $expected_checkin = '';
          }

          $has_errors = false;
          $errors = [];
          DB::transaction(function() use ($user, $admin, $checkout_at, $expected_checkin, $errors, $asset_ids)
          {
              foreach($asset_ids as $asset_id)
              {
                  $asset = Asset::find($asset_id);

                  $error = $asset->checkOutToUser($user, $admin, $checkout_at, $expected_checkin, e(Input::get('note')), null);

                  if($error)
                  {
                      $has_errors = true;
                      array_merge_recursive($errors, $asset->getErrors()->toArray());
                  }
              }
            });

          if (!$errors) {
            // Redirect to the new asset page
              return redirect()->to("hardware")->with('success', trans('admin/hardware/message.checkout.success'));
          }

        // Redirect to the asset management page with error
          return redirect()->to("hardware/bulk-checkout")->with('error', trans('admin/hardware/message.checkout.error'))->withErrors($errors);
      }

}
