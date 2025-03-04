<?php

namespace App\Http\Controllers\Assets;

use App\Actions\Assets\DestroyAssetAction;
use App\Actions\Assets\StoreAssetAction;
use App\Actions\Assets\UpdateAssetAction;
use App\Exceptions\CheckoutNotAllowed;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Assets\UpdateAssetRequest;
use App\Http\Requests\Assets\StoreAssetRequest;
use App\Models\Actionlog;
use App\Http\Requests\UploadFileRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CheckoutRequest;
use App\Models\Company;
use App\Models\Setting;
use App\Models\User;
use App\View\Label;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Watson\Validating\ValidationException;

/**
 * This class controls all actions related to assets for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 * @author [A. Gianotto] [<snipe@snipe.net>]
 */
class AssetsController extends Controller
{
    protected $qrCodeDimensions = ['height' => 3.5, 'width' => 3.5];
    protected $barCodeDimensions = ['height' => 2, 'width' => 22];

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
     * @param Request $request
     */
    public function index(Request $request) : View
    {
        $this->authorize('index', Asset::class);
        $company = Company::find($request->input('company_id'));

        return view('hardware/index')->with('company', $company);
    }

    /**
     * Returns a view that presents a form to create a new asset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param Request $request
     * @internal param int $model_id
     */
    public function create(Request $request) : View
    {
        $this->authorize('create', Asset::class);
        $view = view('hardware/edit')
            ->with('statuslabel_list', Helper::statusLabelList())
            ->with('item', new Asset)
            ->with('statuslabel_types', Helper::statusTypeList());

        if ($request->filled('model_id')) {
            $selected_model = AssetModel::find($request->input('model_id'));
            $view->with('selected_model', $selected_model);
        }

        return $view;
    }

    /**
     * Validate and process new asset form data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     */
    public function store(StoreAssetRequest $request): RedirectResponse
    {
        $successes = [];
        $failures = [];
        $errors = [];
        $asset_tags = $request->input('asset_tags');
        $serials = $request->input('serials');
        foreach ($asset_tags as $key => $asset_tag) {
            try {
                $asset = StoreAssetAction::run(
                    model_id: $request->validated('model_id'),
                    status_id: $request->validated('status_id'),
                    request: $request,
                    name: $request->validated('name'),
                    serial: $request->has('serials') ? $serials[$key] : null,
                    company_id: $request->validated('company_id'),
                    asset_tag: $asset_tag,
                    order_number: $request->validated('order_number'),
                    notes: $request->validated('notes'),
                    warranty_months: $request->validated('warranty_months'),
                    purchase_cost: $request->validated('purchase_cost'),
                    asset_eol_date: $request->validated('asset_eol_date'),
                    purchase_date: $request->validated('purchase_date'),
                    assigned_to: $request->validated('assigned_to'),
                    supplier_id: $request->validated('supplier_id'),
                    requestable: $request->validated('requestable'),
                    rtd_location_id: $request->validated('rtd_location_id'),
                    location_id: $request->validated('location_id'),
                    byod: $request->validated('byod'),
                    assigned_user: $request->validated('assigned_user'),
                    assigned_asset: $request->validated('assigned_asset'),
                    assigned_location: $request->validated('assigned_location'),
                    last_audit_date: $request->validated('last_audit_date'),
                    next_audit_date: $request->validated('next_audit_date'),
                );
                $successes[] = "<a href='".route('hardware.show', ['hardware' => $asset->id])."' style='color: white;'>".e($asset->asset_tag)."</a>";
            } catch (ValidationException|CheckoutNotAllowed $e) {
                $errors[] = $e->getMessage();
            } catch (Exception $e) {
                report($e);
            }
        }
        $failures[] = join(",", $errors);
        session()->put(['redirect_option' => $request->get('redirect_option'), 'checkout_to_type' => $request->get('checkout_to_type')]);

        if ($successes) {
            if ($failures) {
                //some succeeded, some failed
                return redirect()->to(Helper::getRedirectOption($request, $asset->id, 'Assets')) //FIXME - not tested
                ->with('success-unescaped', trans_choice('admin/hardware/message.create.multi_success_linked', $successes, ['links' => join(", ", $successes)]))
                    ->with('warning', trans_choice('admin/hardware/message.create.partial_failure', $failures, ['failures' => join("; ", $failures)]));
            } else {
                if (count($successes) == 1) {
                    //the most common case, keeping it so we don't have to make every use of that translation string be trans_choice'ed
                    //and re-translated
                    return redirect()->to(Helper::getRedirectOption($request, $asset->id, 'Assets'))
                        ->with('success-unescaped', trans('admin/hardware/message.create.success_linked', ['link' => route('hardware.show', $asset), 'id', 'tag' => e($asset->asset_tag)]));
                } else {
                    //multi-success
                    return redirect()->to(Helper::getRedirectOption($request, $asset->id, 'Assets'))
                        ->with('success-unescaped', trans_choice('admin/hardware/message.create.multi_success_linked', $successes, ['links' => join(", ", $successes)]));
                }
            }
        }
        // this shouldn't happen, but php complains if there's no final return
        return redirect()->to(Helper::getRedirectOption($request, $asset->id, 'Assets'))
            ->with('success-unescaped', trans('admin/hardware/message.create.success_linked', ['link' => route('hardware.show', ['hardware' => $asset->id]), 'id', 'tag' => e($asset->asset_tag)]));
    }

    /**
     * Returns a view that presents a form to edit an existing asset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Asset $asset) : View | RedirectResponse
    {
        $this->authorize($asset);
        return view('hardware/edit')
            ->with('item', $asset)
            ->with('statuslabel_list', Helper::statusLabelList())
            ->with('statuslabel_types', Helper::statusTypeList());
    }


    /**
     * Returns a view that presents information about an asset for detail view.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Asset $asset) : View | RedirectResponse
    {
        $this->authorize('view', $asset);
        $settings = Setting::getSettings();

        if (isset($asset)) {
            $audit_log = Actionlog::where('action_type', '=', 'audit')
                ->where('item_id', '=', $asset->id)
                ->where('item_type', '=', Asset::class)
                ->orderBy('created_at', 'DESC')->first();

            if ($asset->location) {
                $use_currency = $asset->location->currency;
            } else {
                if ($settings->default_currency != '') {
                    $use_currency = $settings->default_currency;
                } else {
                    $use_currency = trans('general.currency');
                }
            }

            $qr_code = (object) [
                'display' => $settings->qr_code == '1',
                'url' => route('qr_code/hardware', $asset),
            ];

            return view('hardware/view', compact('asset', 'qr_code', 'settings'))
                ->with('use_currency', $use_currency)->with('audit_log', $audit_log);
        }

        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
    }

    /**
     * Validate and process asset edit form.
     *
     * @param int $assetId
     * @since [v1.0]
     * @author [A. Gianotto] [<snipe@snipe.net>]
     */
    public function update(UpdateAssetRequest $request, Asset $asset): RedirectResponse
    {
        try {
            $serial = $request->input('serials');
            $asset_tag = $request->input('asset_tags');
            if (is_array($request->input('serials'))) {
                $serial = $request->input('serials')[1];
            }
            if (is_array($request->input('asset_tags'))) {
                $asset_tag = $request->input('asset_tags')[1];
            }

            $updatedAsset = UpdateAssetAction::run(
                asset: $asset,
                request: $request,
                status_id: $request->validated('status_id'),
                warranty_months: $request->validated('warranty_months'),
                purchase_cost: $request->validated('purchase_cost'),
                purchase_date: $request->validated('purchase_date'),
                next_audit_date: $request->validated('next_audit_date'),
                asset_eol_date: $request->validated('asset_eol_date'),
                supplier_id: $request->validated('supplier_id'),
                expected_checkin: $request->validated('expected_checkin'),
                requestable: $request->validated('requestable'),
                rtd_location_id: $request->validated('rtd_location_id'),
                byod: $request->validated('byod'),
                image_delete: $request->validated('image_delete'),
                serial: $serial, // this needs to be set up in request somehow
                name: $request->validated('name'),
                company_id: $request->validated('company_id'),
                model_id: $request->validated('model_id'),
                order_number: $request->validated('order_number'),
                asset_tag: $asset_tag, // same as serials
                notes: $request->validated('notes'),
            );
            session()->put(['redirect_option' => $request->get('redirect_option'), 'checkout_to_type' => $request->get('checkout_to_type')]);
            return redirect()->to(Helper::getRedirectOption($request, $updatedAsset->id, 'Assets'))
                ->with('success', trans('admin/hardware/message.update.success'));
        } catch (ValidationException $e) {
            return redirect()->back()->withInput()->withErrors($e->getErrors());
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->with('error', trans('admin/hardware/message.update.error'));
        }
    }

    /**
     * Delete a given asset (mark as deleted).
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     */
    public function destroy(Asset $asset): RedirectResponse
    {
        $this->authorize('delete', $asset);
        try {
            DestroyAssetAction::run($asset);
            return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.delete.success'));
        } catch (Exception $e) {
            report($e);
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Searches the assets table by serial, and redirects if it finds one
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     */
    public function getAssetBySerial(Request $request) : RedirectResponse
    {
        $topsearch = ($request->get('topsearch')=="true");

        if (!$asset = Asset::where('serial', '=', $request->get('serial'))->first()) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }
        $this->authorize('view', $asset);
        return redirect()->route('hardware.show', $asset->id)->with('topsearch', $topsearch);
    }

    /**
     * Searches the assets table by asset tag, and redirects if it finds one
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAssetByTag(Request $request, $tag=null) : RedirectResponse
    {
        $tag = $tag ? $tag : $request->get('assetTag');
        $topsearch = ($request->get('topsearch') == 'true');

        // Search for an exact and unique asset tag match
        $assets = Asset::where('asset_tag', '=', $tag);

        // If not a unique result, redirect to the index view
        if ($assets->count() != 1) {
            return redirect()->route('hardware.index')
                ->with('search', $tag)
                ->with('warning', trans('admin/hardware/message.does_not_exist_var', [ 'asset_tag' => $tag ]));
        }
        $asset = $assets->first();
        $this->authorize('view', $asset);

        return redirect()->route('hardware.show', $asset->id)->with('topsearch', $topsearch);
    }


    /**
     * Return a QR code for the asset
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     */
    public function getQrCode(Asset $asset) : Response | BinaryFileResponse | string | bool
    {
        $settings = Setting::getSettings();

        if (($settings->qr_code == '1') && ($settings->label2_2d_type !== 'none')) {

            if ($asset) {
                $size = Helper::barcodeDimensions($settings->label2_2d_type);
                $qr_file = public_path().'/uploads/barcodes/qr-'.str_slug($asset->asset_tag).'-'.str_slug($asset->id).'.png';

                if (isset($asset->id, $asset->asset_tag)) {
                    if (file_exists($qr_file)) {
                        $header = ['Content-type' => 'image/png'];

                        return response()->file($qr_file, $header);
                    } else {
                        $barcode = new \Com\Tecnick\Barcode\Barcode();
                        $barcode_obj = $barcode->getBarcodeObj($settings->label2_2d_type, route('hardware.show', $asset->id), $size['height'], $size['width'], 'black', [-2, -2, -2, -2]);
                        file_put_contents($qr_file, $barcode_obj->getPngData());

                        return response($barcode_obj->getPngData())->header('Content-type', 'image/png');
                    }
                }
            }

            return 'That asset is invalid';
        }
        return false;
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
        if ($asset = Asset::withTrashed()->find($assetId)) {
            $barcode_file = public_path().'/uploads/barcodes/'.str_slug($settings->label2_1d_type).'-'.str_slug($asset->asset_tag).'.png';

            if (isset($asset->id, $asset->asset_tag)) {
                if (file_exists($barcode_file)) {
                    $header = ['Content-type' => 'image/png'];

                    return response()->file($barcode_file, $header);
                } else {
                    // Calculate barcode width in pixel based on label width (inch)
                    $barcode_width = ($settings->labels_width - $settings->labels_display_sgutter) * 200.000000000001;

                    $barcode = new \Com\Tecnick\Barcode\Barcode();
                    try {
                        $barcode_obj = $barcode->getBarcodeObj($settings->label2_1d_type, $asset->asset_tag, ($barcode_width < 300 ? $barcode_width : 300), 50);
                        file_put_contents($barcode_file, $barcode_obj->getPngData());

                        return response($barcode_obj->getPngData())->header('Content-type', 'image/png');
                    } catch (Exception $e) {
                        Log::debug('The barcode format is invalid.');

                        return response(file_get_contents(public_path('uploads/barcodes/invalid_barcode.gif')))->header('Content-type', 'image/gif');
                    }
                }
            }
        }
        return null;
    }

    /**
     * Return a label for an individual asset.
     *
     * @author [L. Swartzendruber] [<logan.swartzendruber@gmail.com>
     * @param int $assetId
     * @return \Illuminate\Contracts\View\View
     */
    public function getLabel($assetId = null)
    {
        if (isset($assetId)) {
            $asset = Asset::find($assetId);
            $this->authorize('view', $asset);

            return (new Label())
                ->with('assets', collect([ $asset ]))
                ->with('settings', Setting::getSettings())
                ->with('template', request()->get('template'))
                ->with('offset', request()->get('offset'))
                ->with('bulkedit', false)
                ->with('count', 0);
        }
    }

    /**
     * Returns a view that presents a form to clone an asset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function getClone(Asset $asset)
    {
        $this->authorize('create', $asset);
        $cloned = clone $asset;
        $cloned->id = null;
        $cloned->asset_tag = '';
        $cloned->serial = '';
        $cloned->assigned_to = '';
        $cloned->deleted_at = '';

        return view('hardware/edit')
            ->with('statuslabel_list', Helper::statusLabelList())
            ->with('statuslabel_types', Helper::statusTypeList())
            ->with('item', $cloned);
    }

    /**
     * Return history import view
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function getImportHistory()
    {
        $this->authorize('admin');

        return view('hardware/history');
    }

    /**
     * Import history
     *
     * This needs a LOT of love. It's done very inelegantly right now, and there are
     * a ton of optimizations that could (and should) be done.
     *
     * Updated to respect checkin dates:
     * No checkin column, assume all items are checked in (todays date)
     * Checkin date in the past, update history.
     * Checkin date in future or empty, check the item out to the user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.3]
     * @return \Illuminate\Contracts\View\View
     */
    public function postImportHistory(Request $request)
    {
        if (! $request->hasFile('user_import_csv')) {
            return back()->with('error', 'No file provided. Please select a file for import and try again. ');
        }

        if (! ini_get('auto_detect_line_endings')) {
            ini_set('auto_detect_line_endings', '1');
        }
        $csv = Reader::createFromPath($request->file('user_import_csv'));
        $csv->setHeaderOffset(0);
        $header = $csv->getHeader();
        $isCheckinHeaderExplicit = in_array('checkin date', (array_map('strtolower', $header)));
        try {
            $results = $csv->getRecords();
        } catch (Exception $e) {
            return back()->with('error', trans('general.error_in_import_file', ['error' => $e->getMessage()]));
        } 
        $item = [];
        $status = [];
        $status['error'] = [];
        $status['success'] = [];
        foreach ($results as $row) {
            if (is_array($row)) {
                $row = array_change_key_case($row, CASE_LOWER);
                $asset_tag = Helper::array_smart_fetch($row, 'asset tag');
                if (! array_key_exists($asset_tag, $item)) {
                    $item[$asset_tag] = [];
                }
                $batch_counter = count($item[$asset_tag]);
                $item[$asset_tag][$batch_counter]['checkout_date'] = Carbon::parse(Helper::array_smart_fetch($row, 'checkout date'))->format('Y-m-d H:i:s');

                if ($isCheckinHeaderExplicit) {
                    //checkin date not empty, assume past transaction or future checkin date (expected)
                    if (! empty(Helper::array_smart_fetch($row, 'checkin date'))) {
                        $item[$asset_tag][$batch_counter]['checkin_date'] = Carbon::parse(Helper::array_smart_fetch($row, 'checkin date'))->format('Y-m-d H:i:s');
                    } else {
                        $item[$asset_tag][$batch_counter]['checkin_date'] = '';
                    }
                } else {
                    //checkin header missing, assume data is unavailable and make checkin date explicit (now) so we don't encounter invalid state.
                    $item[$asset_tag][$batch_counter]['checkin_date'] = Carbon::parse(now())->format('Y-m-d H:i:s');
                }

                $item[$asset_tag][$batch_counter]['asset_tag'] = Helper::array_smart_fetch($row, 'asset tag');
                $item[$asset_tag][$batch_counter]['name'] = Helper::array_smart_fetch($row, 'name');
                $item[$asset_tag][$batch_counter]['email'] = Helper::array_smart_fetch($row, 'email');
                if ($asset = Asset::where('asset_tag', '=', $asset_tag)->first()) {
                    $item[$asset_tag][$batch_counter]['asset_id'] = $asset->id;
                    $base_username = User::generateFormattedNameFromFullName(Setting::getSettings()->username_format, $item[$asset_tag][$batch_counter]['name']);
                    $user = User::where('username', '=', $base_username['username']);
                    $user_query = ' on username '.$base_username['username'];
                    if ($request->input('match_firstnamelastname') == '1') {
                        $firstnamedotlastname = User::generateFormattedNameFromFullName('firstname.lastname', $item[$asset_tag][$batch_counter]['name']);
                        $item[$asset_tag][$batch_counter]['username'][] = $firstnamedotlastname['username'];
                        $user->orWhere('username', '=', $firstnamedotlastname['username']);
                        $user_query .= ', or on username '.$firstnamedotlastname['username'];
                    }
                    if ($request->input('match_flastname') == '1') {
                        $flastname = User::generateFormattedNameFromFullName('filastname', $item[$asset_tag][$batch_counter]['name']);
                        $item[$asset_tag][$batch_counter]['username'][] = $flastname['username'];
                        $user->orWhere('username', '=', $flastname['username']);
                        $user_query .= ', or on username '.$flastname['username'];
                    }
                    if ($request->input('match_firstname') == '1') {
                        $firstname = User::generateFormattedNameFromFullName('firstname', $item[$asset_tag][$batch_counter]['name']);
                        $item[$asset_tag][$batch_counter]['username'][] = $firstname['username'];
                        $user->orWhere('username', '=', $firstname['username']);
                        $user_query .= ', or on username '.$firstname['username'];
                    }
                    if ($request->input('match_email') == '1') {
                        if ($item[$asset_tag][$batch_counter]['name'] == '') {
                            $item[$asset_tag][$batch_counter]['username'][] = $user_email = User::generateEmailFromFullName($item[$asset_tag][$batch_counter]['name']);
                            $user->orWhere('username', '=', $user_email);
                            $user_query .= ', or on username '.$user_email;
                        }
                    }
                    if ($request->input('match_username') == '1') {
                        // Added #8825: add explicit username lookup
                        $raw_username = $item[$asset_tag][$batch_counter]['name'];
                        $user->orWhere('username', '=', $raw_username);
                        $user_query .= ', or on username '.$raw_username;
                    }

                    // A matching user was found
                    if ($user = $user->first()) {
                        //$user is now matched user from db
                        $item[$asset_tag][$batch_counter]['user_id'] = $user->id;

                        Actionlog::firstOrCreate([
                            'item_id' => $asset->id,
                            'item_type' => Asset::class,
                            'created_by' =>  auth()->id(),
                            'note' => 'Checkout imported by '.auth()->user()->present()->fullName().' from history importer',
                            'target_id' => $item[$asset_tag][$batch_counter]['user_id'],
                            'target_type' => User::class,
                            'created_at' =>  $item[$asset_tag][$batch_counter]['checkout_date'],
                            'action_type'   => 'checkout',
                        ]);

                        $checkin_date = $item[$asset_tag][$batch_counter]['checkin_date'];

                        if ($isCheckinHeaderExplicit) {

                            // if checkin date header exists, assume that empty or future date is still checked out
                            // if checkin is before today's date, assume it's checked in and do not assign user ID, if checkin date is in the future or blank, this is the expected checkin date, items are checked out

                            if ((strtotime($checkin_date) > strtotime(Carbon::now())) || (empty($checkin_date)))
                            {
                                //only do this if item is checked out
                                $asset->assigned_to = $user->id;
                                $asset->assigned_type = User::class;
                            }
                        }

                        if (! empty($checkin_date)) {
                            //only make a checkin there is a valid checkin date or we created one on import.
                            Actionlog::firstOrCreate([
                                'item_id' => $item[$asset_tag][$batch_counter]['asset_id'],
                                'item_type' => Asset::class,
                                'created_by' => auth()->id(),
                                'note' => 'Checkin imported by '.auth()->user()->present()->fullName().' from history importer',
                                'target_id' => null,
                                'created_at' => $checkin_date,
                                'action_type' => 'checkin',
                            ]);
                        }

                        if ($asset->save()) {
                            $status['success'][]['asset'][$asset_tag]['msg'] = 'Asset successfully matched for '.Helper::array_smart_fetch($row, 'name').$user_query.' on '.$item[$asset_tag][$batch_counter]['checkout_date'];
                        } else {
                            $status['error'][]['asset'][$asset_tag]['msg'] = 'Asset and user was matched but could not be saved.';
                        }
                    } else {
                        $item[$asset_tag][$batch_counter]['user_id'] = null;
                        $status['error'][]['user'][Helper::array_smart_fetch($row, 'name')]['msg'] = 'User does not exist so no checkin log was created.';
                    }
                } else {
                    $item[$asset_tag][$batch_counter]['asset_id'] = null;
                    $status['error'][]['asset'][$asset_tag]['msg'] = 'Asset does not exist so no match was attempted.';
                }
            }
        }

        return view('hardware/history')->with('status', $status);
    }

    public function sortByName(array $recordA, array $recordB): int
    {
        return strcmp($recordB['Full Name'], $recordA['Full Name']);
    }

    /**
     * Restore a deleted asset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function getRestore($assetId = null)
    {
        if ($asset = Asset::withTrashed()->find($assetId)) {
            $this->authorize('delete', $asset);

            if ($asset->deleted_at == '') {
                return redirect()->back()->with('error', trans('general.not_deleted', ['item_type' => trans('general.asset')]));
            }

            if ($asset->restore()) {
                // Redirect them to the deleted page if there are more, otherwise the section index
                $deleted_assets = Asset::onlyTrashed()->count();
                if ($deleted_assets > 0) {
                    return redirect()->back()->with('success', trans('admin/hardware/message.restore.success'));
                }
                return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.restore.success'));
            }

            // Check validation to make sure we're not restoring an asset with the same asset tag (or unique attribute) as an existing asset
            return redirect()->back()->with('error', trans('general.could_not_restore', ['item_type' => trans('general.asset'), 'error' => $asset->getErrors()->first()]));
        }

        return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
    }

    public function quickScan()
    {
        $this->authorize('audit', Asset::class);
        $settings = Setting::getSettings();
        $dt = Carbon::now()->addMonths($settings->audit_interval)->toDateString();
        return view('hardware/quickscan')->with('next_audit_date', $dt);
    }

    public function quickScanCheckin()
    {
        $this->authorize('checkin', Asset::class);

        return view('hardware/quickscan-checkin')->with('statusLabel_list', Helper::statusLabelList());
    }

    public function audit(Asset $asset)
    {
        $settings = Setting::getSettings();
        $this->authorize('audit', Asset::class);
        $dt = Carbon::now()->addMonths($settings->audit_interval)->toDateString();
        return view('hardware/audit')->with('asset', $asset)->with('next_audit_date', $dt)->with('locations_list');
    }

    public function dueForAudit()
    {
        $this->authorize('audit', Asset::class);

        return view('hardware/audit-due');
    }

    public function dueForCheckin()
    {
        $this->authorize('checkin', Asset::class);

        return view('hardware/checkin-due');
    }


    public function auditStore(UploadFileRequest $request, Asset $asset)
    {
        $this->authorize('audit', Asset::class);

        $rules = [
            'location_id' => 'exists:locations,id|nullable|numeric',
            'next_audit_date' => 'date|nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(Helper::formatStandardApiResponse('error', null, $validator->errors()->all()));
        }

        /**
         * Even though we do a save() further down, we don't want to log this as a "normal" asset update,
         * which would trigger the Asset Observer and would log an asset *update* log entry (because the
         * de-normed fields like next_audit_date on the asset itself will change on save()) *in addition* to
         * the audit log entry we're creating through this controller.
         *
         * To prevent this double-logging (one for update and one for audit), we skip the observer and bypass
         * that de-normed update log entry by using unsetEventDispatcher(), BUT invoking unsetEventDispatcher()
         * will bypass normal model-level validation that's usually handled at the observer )
         *
         * We handle validation on the save() by checking if the asset is valid via the ->isValid() method,
         * which manually invokes Watson Validating to make sure the asset's model is valid.
         *
         * @see \App\Observers\AssetObserver::updating()
         */
        $asset->unsetEventDispatcher();

        $asset->next_audit_date = $request->input('next_audit_date');
        $asset->last_audit_date = date('Y-m-d H:i:s');

        // Check to see if they checked the box to update the physical location,
        // not just note it in the audit notes
        if ($request->input('update_location') == '1') {
            $asset->location_id = $request->input('location_id');
        }
        

        /**
         * Invoke Watson Validating to check the asset itself and check to make sure it saved correctly.
         * We have to invoke this manually because of the unsetEventDispatcher() above.)
         */
        if ($asset->isValid() && $asset->save()) {

            $file_name = null;
            // Create the image (if one was chosen.)
            if ($request->hasFile('image')) {
                $file_name = $request->handleFile('private_uploads/audits/', 'audit-'.$asset->id, $request->file('image'));
            }

            $asset->logAudit($request->input('note'), $request->input('location_id'), $file_name);
            return redirect()->route('assets.audit.due')->with('success', trans('admin/hardware/message.audit.success'));
        }

        return redirect()->back()->withInput()->withErrors($asset->getErrors());
    }

    public function getRequestedIndex($user_id = null)
    {
        $this->authorize('index', Asset::class);
        $requestedItems = CheckoutRequest::with('user', 'requestedItem')->whereNull('canceled_at')->with('user', 'requestedItem');

        if ($user_id) {
            $requestedItems->where('user_id', $user_id)->get();
        }

        $requestedItems = $requestedItems->orderBy('created_at', 'desc')->get();

        return view('hardware/requested', compact('requestedItems'));
    }
}
