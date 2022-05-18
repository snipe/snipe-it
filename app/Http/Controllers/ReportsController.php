<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\CheckoutAcceptance;
use App\Models\CustomField;
use App\Models\Depreciation;
use App\Models\License;
use App\Models\Setting;
use App\Notifications\CheckoutAssetNotification;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Input;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * This controller handles all actions related to Reports for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ReportsController extends Controller
{
    /**
     * Checks for correct permissions
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Returns a view that displays the accessories report.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getAccessoryReport()
    {
        $this->authorize('reports.view');
        $accessories = Accessory::orderBy('created_at', 'DESC')->with('company')->get();

        return view('reports/accessories', compact('accessories'));
    }

    /**
    * Exports the accessories to CSV
    *
    * @deprecated Server-side exports have been replaced by datatables export since v2.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ManufacturersController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function exportAccessoryReport()
    {
        $this->authorize('reports.view');
        $accessories = Accessory::orderBy('created_at', 'DESC')->get();

        $rows = [];
        $header = [
            trans('admin/accessories/table.title'),
            trans('admin/accessories/general.accessory_category'),
            trans('admin/accessories/general.total'),
            trans('admin/accessories/general.remaining'),
        ];
        $header = array_map('trim', $header);
        $rows[] = implode(', ', $header);

        // Row per accessory
        foreach ($accessories as $accessory) {
            $row = [];
            $row[] = e($accessory->accessory_name);
            $row[] = e($accessory->accessory_category);
            $row[] = e($accessory->total);
            $row[] = e($accessory->remaining);

            $rows[] = implode(',', $row);
        }

        $csv = implode("\n", $rows);
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
    * Show depreciation report for assets.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getDeprecationReport()
    {
        $this->authorize('reports.view');
        $depreciations = Depreciation::get();
        return view('reports/depreciation')->with('depreciations',$depreciations);
    }

    /**
    * Exports the depreciations to CSV
    *
    * @deprecated Server-side exports have been replaced by datatables export since v2.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function exportDeprecationReport()
    {
        $this->authorize('reports.view');
        // Grab all the assets
        $assets = Asset::with('model', 'assignedTo', 'assetstatus', 'defaultLoc', 'assetlog')
                       ->orderBy('created_at', 'DESC')->get();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->setOutputBOM(Reader::BOM_UTF16_BE);

        $rows = [];

        // Create the header row
        $header = [
            trans('admin/hardware/table.asset_tag'),
            trans('admin/hardware/table.title'),
            trans('admin/hardware/table.serial'),
            trans('admin/hardware/table.checkoutto'),
            trans('admin/hardware/table.location'),
            trans('admin/hardware/table.purchase_date'),
            trans('admin/hardware/table.purchase_cost'),
            trans('admin/hardware/table.book_value'),
            trans('admin/hardware/table.diff'),
        ];

        //we insert the CSV header
        $csv->insertOne($header);

        // Create a row per asset
        foreach ($assets as $asset) {
            $row = [];
            $row[] = e($asset->asset_tag);
            $row[] = e($asset->name);
            $row[] = e($asset->serial);

            if ($target = $asset->assignedTo) {
                $row[] = e($target->present()->name());
            } else {
                $row[] = ''; // Empty string if unassigned
            }

            if (($asset->assigned_to > 0) && ($location = $asset->location)) {
                if ($location->city) {
                    $row[] = e($location->city).', '.e($location->state);
                } elseif ($location->name) {
                    $row[] = e($location->name);
                } else {
                    $row[] = '';
                }
            } else {
                $row[] = '';  // Empty string if location is not set
            }

            if ($asset->location) {
                $currency = e($asset->location->currency);
            } else {
                $currency = e(Setting::getSettings()->default_currency);
            }

            $row[] = $asset->purchase_date;
            $row[] = $currency.Helper::formatCurrencyOutput($asset->purchase_cost);
            $row[] = $currency.Helper::formatCurrencyOutput($asset->getDepreciatedValue());
            $row[] = $currency.Helper::formatCurrencyOutput(($asset->purchase_cost - $asset->getDepreciatedValue()));
            $csv->insertOne($row);
        }

        $csv->output('depreciation-report-'.date('Y-m-d').'.csv');
        die;
    }


    /**
     * Displays audit report.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return View
     */
    public function audit()
    {
        $this->authorize('reports.view');

        return view('reports/audit');
    }


    /**
    * Displays activity report.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getActivityReport()
    {
        $this->authorize('reports.view');

        return view('reports/activity');
    }

    /**
     * Exports the activity report to CSV
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.0.7]
     * @return \Illuminate\Http\Response
     */
    public function postActivityReport(Request $request)
    {
        ini_set('max_execution_time', 12000);
        $this->authorize('reports.view');

        \Debugbar::disable();
        $response = new StreamedResponse(function () {
            \Log::debug('Starting streamed response');

            // Open output stream
            $handle = fopen('php://output', 'w');
            stream_set_timeout($handle, 2000);

            $header = [
                trans('general.date'),
                trans('general.admin'),
                trans('general.action'),
                trans('general.type'),
                trans('general.item'),
                'To',
                trans('general.notes'),
                'Changed',

            ];
            $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
            \Log::debug('Starting headers: '.$executionTime);
            fputcsv($handle, $header);
            $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
            \Log::debug('Added headers: '.$executionTime);

            $actionlogs = Actionlog::with('item', 'user', 'target', 'location')
                ->orderBy('created_at', 'DESC')
                ->chunk(20, function ($actionlogs) use ($handle) {
                    $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
                \Log::debug('Walking results: '.$executionTime);
                $count = 0;

                foreach ($actionlogs as $actionlog) {
                    $count++;
                    $target_name = '';

                    if ($actionlog->target) {
                            if ($actionlog->targetType() == 'user') {
                                $target_name = $actionlog->target->getFullNameAttribute();
                        } else {
                            $target_name = $actionlog->target->getDisplayNameAttribute();
                        }
                    }

                    if($actionlog->item){
                        $item_name = e($actionlog->item->getDisplayNameAttribute());
                    } else {
                        $item_name = '';
                    }

                    $row = [
                        $actionlog->created_at,
                        ($actionlog->user) ? e($actionlog->user->getFullNameAttribute()) : '',
                        $actionlog->present()->actionType(),
                        e($actionlog->itemType()),
                        ($actionlog->itemType() == 'user') ? $actionlog->filename : $item_name,
                        $target_name,
                        ($actionlog->note) ? e($actionlog->note) : '',
                        $actionlog->log_meta,
                    ];
                    fputcsv($handle, $row);
                }
            });

            // Close the output stream
            fclose($handle);
            $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
            \Log::debug('-- SCRIPT COMPLETED IN '.$executionTime);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity-report-'.date('Y-m-d-his').'.csv"',
        ]);


        return $response;
    }


    /**
     * Displays license report
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     */
    public function getLicenseReport()
    {
        $this->authorize('reports.view');
        $licenses = License::with('depreciation')->orderBy('created_at', 'DESC')
                           ->with('company')
                           ->get();

        return view('reports/licenses', compact('licenses'));
    }

    /**
    * Exports the licenses to CSV
    *
    * @deprecated Server-side exports have been replaced by datatables export since v2.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function exportLicenseReport()
    {
        $this->authorize('reports.view');
        $licenses = License::orderBy('created_at', 'DESC')->get();

        $rows = [];
        $header = [
            trans('admin/licenses/table.title'),
            trans('admin/licenses/table.serial'),
            trans('admin/licenses/form.seats'),
            trans('admin/licenses/form.remaining_seats'),
            trans('admin/licenses/form.expiration'),
            trans('general.purchase_date'),
            trans('general.depreciation'),
            trans('general.purchase_cost'),
        ];

        $header = array_map('trim', $header);
        $rows[] = implode(', ', $header);

        // Row per license
        foreach ($licenses as $license) {
            $row = [];
            $row[] = e($license->name);
            $row[] = e($license->serial);
            $row[] = e($license->seats);
            $row[] = $license->remaincount();
            $row[] = $license->expiration_date;
            $row[] = $license->purchase_date;
            $row[] = ($license->depreciation != '') ? '' : e($license->depreciation->name);
            $row[] = '"'.Helper::formatCurrencyOutput($license->purchase_cost).'"';

            $rows[] = implode(',', $row);
        }


        $csv      = implode("\n", $rows);
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
    * Returns a form that allows the user to generate a custom CSV report.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see ReportsController::postCustomReport() method that generates the CSV
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function getCustomReport()
    {
        $this->authorize('reports.view');
        $customfields = CustomField::get();

        return view('reports/custom')->with('customfields', $customfields);
    }

    /**
     * Exports the custom report to CSV
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ReportsController::getCustomReport() method that generates form view
     * @since [v1.0]
     * @return \Illuminate\Http\Response
     */
    public function postCustom(Request $request)
    {
        ini_set('max_execution_time', env('REPORT_TIME_LIMIT', 12000)); //12000 seconds = 200 minutes
        $this->authorize('reports.view');

        \Debugbar::disable();
        $customfields = CustomField::get();
        $response = new StreamedResponse(function () use ($customfields, $request) {
            \Log::debug('Starting streamed response');

            // Open output stream
            $handle = fopen('php://output', 'w');
            stream_set_timeout($handle, 2000);
            
            if ($request->filled('use_bom')) {
                fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
            }

            $header = [];


            if ($request->filled('company')) {
                $header[] = trans('general.company');
            }

            if ($request->filled('asset_name')) {
                $header[] = trans('admin/hardware/form.name');
            }

            if ($request->filled('asset_tag')) {
                $header[] = trans('admin/hardware/table.asset_tag');
            }

            if ($request->filled('model')) {
                $header[] = trans('admin/hardware/form.model');
                $header[] = trans('general.model_no');
            }

            if ($request->filled('category')) {
                $header[] = trans('general.category');
            }

            if ($request->filled('manufacturer')) {
                $header[] = trans('admin/hardware/form.manufacturer');
            }

            if ($request->filled('serial')) {
                $header[] = trans('admin/hardware/table.serial');
            }
            if ($request->filled('purchase_date')) {
                $header[] = trans('admin/hardware/table.purchase_date');
            }

            if (($request->filled('purchase_cost')) || ($request->filled('depreciation'))) {
                $header[] = trans('admin/hardware/table.purchase_cost');
            }

            if ($request->filled('eol')) {
                $header[] = trans('admin/hardware/table.eol');
            }

            if ($request->filled('order')) {
                $header[] = trans('admin/hardware/form.order');
            }

            if ($request->filled('supplier')) {
                $header[] = trans('general.supplier');
            }

            if ($request->filled('location')) {
                $header[] = trans('admin/hardware/table.location');
            }
            if ($request->filled('location_address')) {
                $header[] = trans('general.address');
                $header[] = trans('general.address');
                $header[] = trans('general.city');
                $header[] = trans('general.state');
                $header[] = trans('general.country');
                $header[] = trans('general.zip');
            }

            if ($request->filled('rtd_location')) {
                $header[] = trans('admin/hardware/form.default_location');
            }
            
            if ($request->filled('rtd_location_address')) {
                $header[] = trans('general.address');
                $header[] = trans('general.address');
                $header[] = trans('general.city');
                $header[] = trans('general.state');
                $header[] = trans('general.country');
                $header[] = trans('general.zip');
            }


            if ($request->filled('assigned_to')) {
                $header[] = trans('admin/hardware/table.checkoutto');
                $header[] = trans('general.type');
            }

            if ($request->filled('username')) {
                $header[] = 'Username';
            }

            if ($request->filled('employee_num')) {
                $header[] = 'Employee No.';
            }

            if ($request->filled('manager')) {
                $header[] = trans('admin/users/table.manager');
            }

            if ($request->filled('department')) {
                $header[] = trans('general.department');
            }

            if ($request->filled('title')) {
                $header[] = trans('admin/users/table.title');
            }

            if ($request->filled('status')) {
                $header[] = trans('general.status');
            }

            if ($request->filled('warranty')) {
                $header[] = 'Warranty';
                $header[] = 'Warranty Expires';
            }
            if ($request->filled('depreciation')) {
                $header[] = 'Value';
                $header[] = 'Diff';
                $header[] = 'Fully Depreciated';
            }

            if ($request->filled('checkout_date')) {
                $header[] = trans('admin/hardware/table.checkout_date');
            }

            if ($request->filled('expected_checkin')) {
                $header[] = trans('admin/hardware/form.expected_checkin');
            }

            if ($request->filled('created_at')) {
                $header[] = trans('general.created_at');
            }

            if ($request->filled('updated_at')) {
                $header[] = trans('general.updated_at');
            }

            if ($request->filled('last_audit_date')) {
                $header[] = trans('general.last_audit');
            }

            if ($request->filled('next_audit_date')) {
                $header[] = trans('general.next_audit_date');
            }

            if ($request->filled('notes')) {
                $header[] = trans('general.notes');
            }


            foreach ($customfields as $customfield) {
                if ($request->input($customfield->db_column_name()) == '1') {
                    $header[] = $customfield->name;
                }
            }

            $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
            \Log::debug('Starting headers: '.$executionTime);
            fputcsv($handle, $header);
            $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
            \Log::debug('Added headers: '.$executionTime);

            $assets = \App\Models\Company::scopeCompanyables(Asset::select('assets.*'))->with(
                'location', 'assetstatus', 'assetlog', 'company', 'defaultLoc', 'assignedTo',
                'model.category', 'model.manufacturer', 'supplier');
            
            if ($request->filled('by_location_id')) {
                $assets->where('assets.location_id', $request->input('by_location_id'));
            }

            if ($request->filled('by_rtd_location_id')) {
                \Log::debug('RTD location should match: '.$request->input('by_rtd_location_id'));
                $assets->where('assets.rtd_location_id', $request->input('by_rtd_location_id'));
            }

            if ($request->filled('by_supplier_id')) {
                $assets->where('assets.supplier_id', $request->input('by_supplier_id'));
            }

            if ($request->filled('by_company_id')) {
                $assets->where('assets.company_id', $request->input('by_company_id'));
            }

            if ($request->filled('by_model_id')) {
                $assets->where('assets.model_id', $request->input('by_model_id'));
            }

            if ($request->filled('by_category_id')) {
                $assets->InCategory($request->input('by_category_id'));
            }

            if ($request->filled('by_dept_id')) {
                \Log::debug('Only users in dept '.$request->input('by_dept_id'));
                $assets->CheckedOutToTargetInDepartment($request->input('by_dept_id'));
            }

            if ($request->filled('by_manufacturer_id')) {
                $assets->ByManufacturer($request->input('by_manufacturer_id'));
            }

            if ($request->filled('by_order_number')) {
                $assets->where('assets.order_number', $request->input('by_order_number'));
            }

            if ($request->filled('by_status_id')) {
                $assets->where('assets.status_id', $request->input('by_status_id'));
            }

            if (($request->filled('purchase_start')) && ($request->filled('purchase_end'))) {
                $assets->whereBetween('assets.purchase_date', [$request->input('purchase_start'), $request->input('purchase_end')]);
            }

            if (($request->filled('created_start')) && ($request->filled('created_end'))) {
                $assets->whereBetween('assets.created_at', [$request->input('created_start'), $request->input('created_end')]);
            }

            if (($request->filled('expected_checkin_start')) && ($request->filled('expected_checkin_end'))) {
                $assets->whereBetween('assets.expected_checkin', [$request->input('expected_checkin_start'), $request->input('expected_checkin_end')]);
            }

            if (($request->filled('last_audit_start')) && ($request->filled('last_audit_end'))) {
                $assets->whereBetween('assets.last_audit_date', [$request->input('last_audit_start'), $request->input('last_audit_end')]);
            }

            if (($request->filled('next_audit_start')) && ($request->filled('next_audit_end'))) {
                $assets->whereBetween('assets.next_audit_date', [$request->input('next_audit_start'), $request->input('next_audit_end')]);
            }
            $assets->orderBy('assets.id', 'ASC')->chunk(20, function ($assets) use ($handle, $customfields, $request) {
            
                $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
                \Log::debug('Walking results: '.$executionTime);
                $count = 0;
                foreach ($assets as $asset) {
                    $count++;
                    $row = [];
                    
                    if ($request->filled('company')) {
                        $row[] = ($asset->company) ? $asset->company->name : '';
                    }

                    if ($request->filled('asset_name')) {
                        $row[] = ($asset->name) ? $asset->name : '';
                    }

                    if ($request->filled('asset_tag')) {
                        $row[] = ($asset->asset_tag) ? $asset->asset_tag : '';
                    }

                    if ($request->filled('model')) {
                        $row[] = ($asset->model) ? $asset->model->name : '';
                        $row[] = ($asset->model) ? $asset->model->model_number : '';
                    }

                    if ($request->filled('category')) {
                        $row[] = (($asset->model) && ($asset->model->category)) ? $asset->model->category->name : '';
                    }

                    if ($request->filled('manufacturer')) {
                        $row[] = ($asset->model && $asset->model->manufacturer) ? $asset->model->manufacturer->name : '';
                    }

                    if ($request->filled('serial')) {
                        $row[] = ($asset->serial) ? $asset->serial : '';
                    }

                    if ($request->filled('purchase_date')) {
                        $row[] = ($asset->purchase_date) ? $asset->purchase_date : '';
                    }

                    if ($request->filled('purchase_cost')) {
                        $row[] = ($asset->purchase_cost) ? Helper::formatCurrencyOutput($asset->purchase_cost) : '';
                    }

                    if ($request->filled('eol')) {
                        $row[] = ($asset->purchase_date != '') ? $asset->present()->eol_date() : '';
                    }

                    if ($request->filled('order')) {
                        $row[] = ($asset->order_number) ? $asset->order_number : '';
                    }

                    if ($request->filled('supplier')) {
                        $row[] = ($asset->supplier) ? $asset->supplier->name : '';
                    }
                    
                    if ($request->filled('location')) {
                        $row[] = ($asset->location) ? $asset->location->present()->name() : '';
                    }

                    if ($request->filled('location_address')) {
                        $row[] = ($asset->location) ? $asset->location->address : '';
                        $row[] = ($asset->location) ? $asset->location->address2 : '';
                        $row[] = ($asset->location) ? $asset->location->city : '';
                        $row[] = ($asset->location) ? $asset->location->state : '';
                        $row[] = ($asset->location) ? $asset->location->country : '';
                        $row[] = ($asset->location) ? $asset->location->zip : '';
                    }

                    if ($request->filled('rtd_location')) {
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->present()->name() : '';
                    }

                    if ($request->filled('rtd_location_address')) {
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->address : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->address2 : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->city : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->state : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->country : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->zip : '';
                    }

                    if ($request->filled('assigned_to')) {
                        $row[] = ($asset->checkedOutToUser() && $asset->assigned) ? $asset->assigned->getFullNameAttribute() : ($asset->assigned ? $asset->assigned->display_name : '');
                        $row[] = ($asset->checkedOutToUser() && $asset->assigned) ? 'user' : $asset->assignedType();
                    }

                    if ($request->filled('username')) {
                        // Only works if we're checked out to a user, not anything else.
                        if ($asset->checkedOutToUser()) {
                            $row[] = ($asset->assignedto) ? $asset->assignedto->username : '';
                        } else {
                            $row[] = ''; // Empty string if unassigned
                        }
                    }

                    if ($request->filled('employee_num')) {
                        // Only works if we're checked out to a user, not anything else.
                        if ($asset->checkedOutToUser()) {
                            $row[] = ($asset->assignedto) ? $asset->assignedto->employee_num : '';
                        } else {
                            $row[] = ''; // Empty string if unassigned
                        }
                    }

                    if ($request->filled('manager')) {
                        if ($asset->checkedOutToUser()) {
                            $row[] = (($asset->assignedto) && ($asset->assignedto->manager)) ? $asset->assignedto->manager->present()->fullName : '';
                        } else {
                            $row[] = ''; // Empty string if unassigned
                        }
                    }

                    if ($request->filled('department')) {
                        if ($asset->checkedOutToUser()) {
                            $row[] = (($asset->assignedto) && ($asset->assignedto->department)) ? $asset->assignedto->department->name : '';
                        } else {
                            $row[] = ''; // Empty string if unassigned
                        }
                    }

                    if ($request->filled('title')) {
                        if ($asset->checkedOutToUser()) {
                            $row[] = ($asset->assignedto) ? $asset->assignedto->jobtitle : '';
                        } else {
                            $row[] = ''; // Empty string if unassigned
                        }
                    }

                    if ($request->filled('status')) {
                        $row[] = ($asset->assetstatus) ? $asset->assetstatus->name.' ('.$asset->present()->statusMeta.')' : '';
                    }

                    if ($request->filled('warranty')) {
                        $row[] = ($asset->warranty_months) ? $asset->warranty_months : '';
                        $row[] = $asset->present()->warrantee_expires();
                    }

                    if ($request->filled('depreciation')) {
                            $depreciation = $asset->getDepreciatedValue();
                            $diff = ($asset->purchase_cost - $depreciation);
                        $row[] = Helper::formatCurrencyOutput($depreciation);
                        $row[] = Helper::formatCurrencyOutput($diff);
                        $row[] = ($asset->depreciation) ? $asset->depreciated_date()->format('Y-m-d') : '';
                    }

                    if ($request->filled('checkout_date')) {
                        $row[] = ($asset->last_checkout) ? $asset->last_checkout : '';
                    }

                    if ($request->filled('expected_checkin')) {
                        $row[] = ($asset->expected_checkin) ? $asset->expected_checkin : '';
                    }

                    if ($request->filled('created_at')) {
                        $row[] = ($asset->created_at) ? $asset->created_at : '';
                    }

                    if ($request->filled('updated_at')) {
                        $row[] = ($asset->updated_at) ? $asset->updated_at : '';
                    }

                    if ($request->filled('last_audit_date')) {
                        $row[] = ($asset->last_audit_date) ? $asset->last_audit_date : '';
                    }

                    if ($request->filled('next_audit_date')) {
                        $row[] = ($asset->next_audit_date) ? $asset->next_audit_date : '';
                    }

                    if ($request->filled('notes')) {
                        $row[] = ($asset->notes) ? $asset->notes : '';
                    }

                    foreach ($customfields as $customfield) {
                        $column_name = $customfield->db_column_name();
                        if ($request->filled($customfield->db_column_name())) {
                            $row[] = $asset->$column_name;
                        }
                    }
                    fputcsv($handle, $row);
                    $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
                    \Log::debug('-- Record '.$count.' Asset ID:'.$asset->id.' in '.$executionTime);
                }
            });

            // Close the output stream
            fclose($handle);
            $executionTime = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
            \Log::debug('-- SCRIPT COMPLETED IN '.$executionTime);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="custom-assets-report-'.date('Y-m-d-his').'.csv"',
        ]);

        return $response;
    }

    /**
     * getImprovementsReport
     *
     * @return View
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function getAssetMaintenancesReport()
    {
        $this->authorize('reports.view');
        // Grab all the improvements
        $assetMaintenances = AssetMaintenance::with('asset', 'supplier', 'asset.company')
                                              ->orderBy('created_at', 'DESC')
                                              ->get();

        return view('reports/asset_maintenances', compact('assetMaintenances'));
    }

    /**
     * exportImprovementsReport
     *
     * @return \Illuminate\Http\Response
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function exportAssetMaintenancesReport()
    {
        $this->authorize('reports.view');
        // Grab all the improvements
        $assetMaintenances = AssetMaintenance::with('asset', 'supplier')
                                             ->orderBy('created_at', 'DESC')
                                             ->get();

        $rows = [];

        $header = [
            trans('admin/hardware/table.asset_tag'),
            trans('admin/asset_maintenances/table.asset_name'),
            trans('general.supplier'),
            trans('admin/asset_maintenances/form.asset_maintenance_type'),
            trans('admin/asset_maintenances/form.title'),
            trans('admin/asset_maintenances/form.start_date'),
            trans('admin/asset_maintenances/form.completion_date'),
            trans('admin/asset_maintenances/form.asset_maintenance_time'),
            trans('admin/asset_maintenances/form.cost'),
        ];

        $header = array_map('trim', $header);
        $rows[] = implode(',', $header);

        foreach ($assetMaintenances as $assetMaintenance) {
            $row = [];
            $row[] = str_replace(',', '', e($assetMaintenance->asset->asset_tag));
            $row[] = str_replace(',', '', e($assetMaintenance->asset->name));
            $row[] = str_replace(',', '', e($assetMaintenance->supplier->name));
            $row[] = e($assetMaintenance->improvement_type);
            $row[] = e($assetMaintenance->title);
            $row[] = e($assetMaintenance->start_date);
            $row[] = e($assetMaintenance->completion_date);
            if (is_null($assetMaintenance->asset_maintenance_time)) {
                $improvementTime = intval(Carbon::now()
                                                 ->diffInDays(Carbon::parse($assetMaintenance->start_date)));
            } else {
                $improvementTime = intval($assetMaintenance->asset_maintenance_time);
            }
            $row[]  = $improvementTime;
            $row[]  = trans('general.currency') . Helper::formatCurrencyOutput($assetMaintenance->cost);
            $rows[] = implode(',', $row);
        }

        // spit out a csv
        $csv      = implode("\n", $rows);
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
     * getAssetAcceptanceReport
     *
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException

     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function getAssetAcceptanceReport($deleted = false)
    {
        $this->authorize('reports.view');
        $showDeleted = $deleted == 'deleted';

        /**
         * Get all assets with pending checkout acceptances
         */
        if($showDeleted) {
            $acceptances = CheckoutAcceptance::pending()->where('checkoutable_type', 'App\Models\Asset')->withTrashed()->with(['assignedTo' , 'checkoutable.assignedTo', 'checkoutable.model'])->get();
        } else {
            $acceptances = CheckoutAcceptance::pending()->where('checkoutable_type', 'App\Models\Asset')->with(['assignedTo' => function ($query) {
                $query->withTrashed();
            }, 'checkoutable.assignedTo', 'checkoutable.model'])->get();
        }

        $assetsForReport = $acceptances
            ->filter(function ($acceptance) {
                return $acceptance->checkoutable_type == 'App\Models\Asset';
            })
            ->map(function($acceptance) {
                return ['assetItem' => $acceptance->checkoutable, 'acceptance' => $acceptance];
            });

        return view('reports/unaccepted_assets', compact('assetsForReport','showDeleted' ));
    }

    /**
     * sentAssetAcceptanceReminder
     *
     * @param integer|null $acceptanceId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @version v1.0
     */
    public function sentAssetAcceptanceReminder($acceptanceId = null)
    {
        $this->authorize('reports.view');

        if (!$acceptance = CheckoutAcceptance::pending()->find($acceptanceId)) {
            // Redirect to the unaccepted assets report page with error
            return redirect()->route('reports/unaccepted_assets')->with('error', trans('general.bad_data'));
        }
        $assetItem = $acceptance->checkoutable;

        $logItem = $assetItem->checkouts()->where('created_at', '=', $acceptance->created_at)->get()[0];

        if(!$assetItem->assignedTo->locale){
            Notification::locale(Setting::getSettings()->locale)->send(
                $assetItem->assignedTo,
                new CheckoutAssetNotification($assetItem, $assetItem->assignedTo, $logItem->user, $acceptance, $logItem->note)
            );
        } else {
            Notification::send(
                $assetItem->assignedTo,
                new CheckoutAssetNotification($assetItem, $assetItem->assignedTo, $logItem->user, $acceptance, $logItem->note)
            );
        }

        return redirect()->route('reports/unaccepted_assets')->with('success', trans('admin/reports/general.reminder_sent'));
    }

    /**
     * sentAssetAcceptanceReminder
     *
     * @param integer|null $acceptanceId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @version v1.0
     */
    public function deleteAssetAcceptance($acceptanceId = null)
    {
        $this->authorize('reports.view');

        if (!$acceptance = CheckoutAcceptance::pending()->find($acceptanceId)) {
            // Redirect to the unaccepted assets report page with error
            return redirect()->route('reports/unaccepted_assets')->with('error', trans('general.bad_data'));
        }

        if($acceptance->delete()) {
            return redirect()->route('reports/unaccepted_assets')->with('success', trans('admin/reports/general.acceptance_deleted'));
        } else {
            return redirect()->route('reports/unaccepted_assets')->with('error', trans('general.deletion_failed'));
        }
    }

    /**
     * Exports the AssetAcceptance report to CSV
     *
     * @return \Illuminate\Http\Response
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function postAssetAcceptanceReport($deleted = false)
    {
        $this->authorize('reports.view');
        $showDeleted = $deleted == 'deleted';

        /**
         * Get all assets with pending checkout acceptances
         */
        if($showDeleted) {
            $acceptances = CheckoutAcceptance::pending()->withTrashed()->with(['assignedTo', 'checkoutable.assignedTo', 'checkoutable.model'])->get();
        } else {
            $acceptances = CheckoutAcceptance::pending()->with(['assignedTo', 'checkoutable.assignedTo', 'checkoutable.model'])->get();
        }

        $assetsForReport = $acceptances
            ->filter(function($acceptance) {
                return $acceptance->checkoutable_type == 'App\Models\Asset';
            })
            ->map(function($acceptance) {
                return ['assetItem' => $acceptance->checkoutable, 'acceptance' => $acceptance];
            });

        $rows = [];

        $header = [
            trans('general.category'),
            trans('admin/hardware/form.model'),
            trans('admin/hardware/form.name'),
            trans('admin/hardware/table.asset_tag'),
            trans('admin/hardware/table.checkoutto'),
        ];

        $header = array_map('trim', $header);
        $rows[] = implode(',', $header);

        foreach ($assetsForReport as $item) {
            $row    = [ ];
            $row[]  = str_replace(',', '', e($item['assetItem']->model->category->name));
            $row[]  = str_replace(',', '', e($item['assetItem']->model->name));
            $row[]  = str_replace(',', '', e($item['assetItem']->name));
            $row[]  = str_replace(',', '', e($item['assetItem']->asset_tag));
            $row[]  = str_replace(',', '', e(($item['acceptance']->assignedTo) ? $item['acceptance']->assignedTo->present()->name() : trans('admin/reports/general.deleted_user')));
            $rows[] = implode(',', $row);
        }

        // spit out a csv
        $csv      = implode("\n", $rows);
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
     * getCheckedOutAssetsRequiringAcceptance
     *
     * @param $modelsInCategoriesThatRequireAcceptance
     *
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getCheckedOutAssetsRequiringAcceptance($modelsInCategoriesThatRequireAcceptance)
    {
        $this->authorize('reports.view');
        $assets = Asset::deployed()
                        ->inModelList($modelsInCategoriesThatRequireAcceptance)
                        ->select('id')
                        ->get()
                        ->toArray();

        return array_pluck($assets, 'id');
    }

    /**
     * getModelsInCategoriesThatRequireAcceptance
     *
     * @param $assetCategoriesRequiringAcceptance
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getModelsInCategoriesThatRequireAcceptance($assetCategoriesRequiringAcceptance)
    {
        $this->authorize('reports.view');

        return array_pluck(Model::inCategory($assetCategoriesRequiringAcceptance)
                                 ->select('id')
                                 ->get()
                                 ->toArray(), 'id');
    }

    /**
     * getCategoriesThatRequireAcceptance
     *
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getCategoriesThatRequireAcceptance()
    {
        $this->authorize('reports.view');

        return array_pluck(Category::requiresAcceptance()
                                    ->select('id')
                                    ->get()
                                    ->toArray(), 'id');
    }

    /**
     * getAssetsCheckedOutRequiringAcceptance
     *
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getAssetsCheckedOutRequiringAcceptance()
    {
        $this->authorize('reports.view');

        return $this->getCheckedOutAssetsRequiringAcceptance(
            $this->getModelsInCategoriesThatRequireAcceptance($this->getCategoriesThatRequireAcceptance())
        );
    }

    /**
     * getAssetsNotAcceptedYet
     *
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getAssetsNotAcceptedYet()
    {
        $this->authorize('reports.view');

        return Asset::unaccepted();
    }
}
