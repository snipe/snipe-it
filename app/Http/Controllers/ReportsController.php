<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\CustomField;
use App\Models\Depreciation;
use App\Models\License;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Input;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;

/**
 * This controller handles all actions related to Reports for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ReportsController extends Controller
{

    /**
    * Returns a view that displays the accessories report.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getAccessoryReport()
    {
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
        $accessories = Accessory::orderBy('created_at', 'DESC')->get();

        $rows = array();
        $header = array(
            trans('admin/accessories/table.title'),
            trans('admin/accessories/general.accessory_category'),
            trans('admin/accessories/general.total'),
            trans('admin/accessories/general.remaining')
        );
        $header = array_map('trim', $header);
        $rows[] = implode($header, ', ');

        // Row per accessory
        foreach ($accessories as $accessory) {
            $row = array();
            $row[] = e($accessory->accessory_name);
            $row[] = e($accessory->accessory_category);
            $row[] = e($accessory->total);
            $row[] = e($accessory->remaining);

            $rows[] = implode($row, ',');
        }

        $csv = implode($rows, "\n");
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

        $depreciations = Depreciation::get();
        // Grab all the assets
        $assets = Asset::with( 'assignedTo', 'assetstatus', 'defaultLoc', 'location', 'assetlog', 'company', 'model.category', 'model.depreciation')
                       ->orderBy('created_at', 'DESC')->get();

        return view('reports/depreciation', compact('assets'))->with('depreciations',$depreciations);
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

        // Grab all the assets
        $assets = Asset::with('model', 'assignedTo', 'assetstatus', 'defaultLoc', 'assetlog')
                       ->orderBy('created_at', 'DESC')->get();

        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->setOutputBOM(Reader::BOM_UTF16_BE);

        $rows = [ ];

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
            trans('admin/hardware/table.diff')
        ];

        //we insert the CSV header
        $csv->insertOne($header);

        // Create a row per asset
        foreach ($assets as $asset) {
            $row   = [ ];
            $row[] = e($asset->asset_tag);
            $row[] = e($asset->name);
            $row[] = e($asset->serial);

            if ($target = $asset->assignedTo) {
                $row[] = e($target->present()->name());
            } else {
                $row[] = ''; // Empty string if unassigned
            }

            if (( $asset->assigned_to > 0 ) && ( $location = $asset->location )) {
                if ($location->city) {
                    $row[] = e($location->city) . ', ' . e($location->state);
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
                $currency = e(Setting::first()->default_currency);
            }

            $row[] = $asset->purchase_date;
            $row[] = $currency . Helper::formatCurrencyOutput($asset->purchase_cost);
            $row[] = $currency . Helper::formatCurrencyOutput($asset->getDepreciatedValue());
            $row[] = $currency . Helper::formatCurrencyOutput(( $asset->purchase_cost - $asset->getDepreciatedValue() ));
            $csv->insertOne($row);
        }

        $csv->output('depreciation-report-' . date('Y-m-d') . '.csv');
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

        return view('reports/activity');
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
        $licenses = License::orderBy('created_at', 'DESC')->get();

        $rows     = [ ];
        $header   = [
            trans('admin/licenses/table.title'),
            trans('admin/licenses/table.serial'),
            trans('admin/licenses/form.seats'),
            trans('admin/licenses/form.remaining_seats'),
            trans('admin/licenses/form.expiration'),
            trans('general.purchase_date'),
            trans('general.depreciation'),
            trans('general.purchase_cost')
        ];

        $header = array_map('trim', $header);
        $rows[] = implode($header, ', ');

        // Row per license
        foreach ($licenses as $license) {
            $row   = [ ];
            $row[] = e($license->name);
            $row[] = e($license->serial);
            $row[] = e($license->seats);
            $row[] = $license->remaincount();
            $row[] = $license->expiration_date;
            $row[] = $license->purchase_date;
            $row[] = ($license->depreciation!='') ? '' : e($license->depreciation->name);
            $row[] = '"' . Helper::formatCurrencyOutput($license->purchase_cost) . '"';

            $rows[] = implode($row, ',');
        }

        $csv      = implode($rows, "\n");
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

        \Debugbar::disable();
        $customfields = CustomField::get();
        $response = new StreamedResponse(function () use ($customfields, $request) {

            // Open output stream
            $handle = fopen('php://output', 'w');
            
            if ($request->has('use_bom')) {
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            }

            $header = [];


            if ($request->has('company')) {
                $header[] = trans('general.company');
            }

            if ($request->has('asset_name')) {
                $header[] = trans('admin/hardware/form.name');
            }

            if ($request->has('asset_tag')) {
                $header[] = trans('admin/hardware/table.asset_tag');
            }

            if ($request->has('model')) {
                $header[] = trans('admin/hardware/form.model');
                $header[] = trans('general.model_no');
            }

            if ($request->has('category')) {
                $header[] = trans('general.category');
            }

            if ($request->has('manufacturer')) {
                $header[] = trans('admin/hardware/form.manufacturer');
            }

            if ($request->has('serial')) {
                $header[] = trans('admin/hardware/table.serial');
            }
            if ($request->has('purchase_date')) {
                $header[] = trans('admin/hardware/table.purchase_date');
            }

            if (($request->has('purchase_cost'))  || ($request->has('depreciation'))) {
                $header[] = trans('admin/hardware/table.purchase_cost');
            }

            if ($request->has('eol')) {
                $header[] = trans('admin/hardware/table.eol');
            }

            if ($request->has('order')) {
                $header[] = trans('admin/hardware/form.order');
            }

            if ($request->has('supplier')) {
                $header[] = trans('general.supplier');
            }

            if ($request->has('location')) {
                $header[] = trans('admin/hardware/table.location');
            }
            if ($request->has('location_address')) {
                $header[] = trans('general.address');
                $header[] = trans('general.address');
                $header[] = trans('general.city');
                $header[] = trans('general.state');
                $header[] = trans('general.country');
                $header[] = trans('general.zip');
            }

            if ($request->has('rtd_location')) {
                $header[] = trans('admin/hardware/form.default_location');
            }
            if ($request->has('rtd_location_address')) {
                $header[] = trans('general.address');
                $header[] = trans('general.address');
                $header[] = trans('general.city');
                $header[] = trans('general.state');
                $header[] = trans('general.country');
                $header[] = trans('general.zip');
            }


            if ($request->has('assigned_to')) {
                $header[] = trans('admin/hardware/table.checkoutto');
                $header[] = trans('general.type');
            }

            if ($request->has('username')) {
                $header[] = 'Username';
            }

            if ($request->has('employee_num')) {
                $header[] = 'Employee No.';
            }

            if ($request->has('department')) {
                $header[] = trans('general.department');
            }

            if ($request->has('status')) {
                $header[] = trans('general.status');
            }

            if ($request->has('warranty')) {
                $header[] = 'Warranty';
                $header[] = 'Warranty Expires';
            }
            if ($request->has('depreciation')) {
                $header[] = 'Value';
                $header[] = 'Diff';
            }

            if ($request->has('checkout_date')) {
                $header[] = trans('admin/hardware/table.checkout_date');
            }

            if ($request->has('expected_checkin')) {
                $header[] = trans('admin/hardware/form.expected_checkin');
            }

            if ($request->has('created_at')) {
                $header[] = trans('general.created_at');
            }

            if ($request->has('updated_at')) {
                $header[] = trans('general.updated_at');
            }

            if ($request->has('last_audit_date')) {
                $header[] = trans('general.last_audit');
            }

            if ($request->has('next_audit_date')) {
                $header[] = trans('general.next_audit_date');
            }

            if ($request->has('notes')) {
                $header[] = trans('general.notes');
            }


            foreach ($customfields as $customfield) {
                if (e(Input::get($customfield->db_column_name())) == '1') {
                    $header[] = $customfield->name;
                }
            }


            fputcsv($handle, $header);

            $assets = \App\Models\Company::scopeCompanyables(Asset::select('assets.*'))->with(
                'location', 'assetstatus', 'assetlog', 'company', 'defaultLoc','assignedTo',
                'model.category', 'model.manufacturer','supplier');
            
            if ($request->has('by_location_id')) {
                $assets->where('assets.location_id', $request->input('by_location_id'));
            }

            if ($request->has('by_supplier_id')) {
                $assets->where('assets.supplier_id', $request->input('by_supplier_id'));
            }

            if ($request->has('by_company_id')) {
                $assets->where('assets.company_id', $request->input('by_company_id'));
            }

            if ($request->has('by_model_id')) {
                $assets->where('assets.model_id', $request->input('by_model_id'));
            }

            if ($request->has('by_category_id')) {
                $assets->InCategory($request->input('by_category_id'));
            }

            if ($request->has('by_manufacturer_id')) {
                $assets->ByManufacturer($request->input('by_manufacturer_id'));
            }

            if ($request->has('by_order_number')) {
                $assets->where('assets.order_number', $request->input('by_order_number'));
            }

            if ($request->has('by_status_id')) {
                $assets->where('assets.status_id', $request->input('by_status_id'));
            }

            if (($request->has('purchase_start')) && ($request->has('purchase_end'))) {
                $assets->whereBetween('assets.purchase_date', [$request->input('purchase_start'), $request->input('purchase_end')]);
            }

            if (($request->has('created_start')) && ($request->has('created_end'))) {
                $assets->whereBetween('assets.created_at', [$request->input('created_start'), $request->input('created_end')]);
            }
            
            $assets->orderBy('assets.created_at', 'ASC')->chunk(500, function($assets) use($handle, $customfields, $request) {

                foreach ($assets as $asset) {
                    $row = [];
                    
                    if ($request->has('company')) {
                        $row[] = ($asset->company) ? $asset->company->name : '';
                    }

                    if ($request->has('asset_name')) {
                        $row[] = ($asset->name) ? $asset->name : '';
                    }

                    if ($request->has('asset_tag')) {
                        $row[] = ($asset->asset_tag) ? $asset->asset_tag : '';
                    }

                    if ($request->has('model')) {
                        $row[] = ($asset->model) ? $asset->model->name : '';
                        $row[] = ($asset->model) ? $asset->model->model_number : '';
                    }

                    if ($request->has('category')) {
                        $row[] = (($asset->model) && ($asset->model->category)) ? $asset->model->category->name : '';
                    }

                    if ($request->has('manufacturer')) {
                        $row[] = ($asset->model && $asset->model->manufacturer) ? $asset->model->manufacturer->name : '';
                    }

                    if ($request->has('serial')) {
                        $row[] = ($asset->serial) ? $asset->serial : '';
                    }

                    if ($request->has('purchase_date')) {
                        $row[] = ($asset->purchase_date) ? $asset->purchase_date : '';
                    }

                    if ($request->has('purchase_cost')) {
                        $row[] = ($asset->purchase_cost) ? Helper::formatCurrencyOutput($asset->purchase_cost) : '';
                    }

                    if ($request->has('eol')) {
                        $row[] = ($asset->purchase_date!='') ? $asset->present()->eol_date() : '';
                    }

                    if ($request->has('order')) {
                        $row[] = ($asset->order_number) ? $asset->order_number : '';
                    }

                    if ($request->has('supplier')) {
                        $row[] = ($asset->supplier) ? $asset->supplier->name : '';
                    }
                    

                    if ($request->has('location')) {
                        $row[] = ($asset->location) ? $asset->location->present()->name() : '';
                    }

                    if ($request->has('location_address')) {
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->address : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->address2 : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->city : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->state : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->country : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->zip : '';
                    }

                    if ($request->has('rtd_location')) {
                        $row[] = ($asset->location) ? $asset->defaultLoc->present()->name() : '';
                    }

                    if ($request->has('rtd_location_address')) {
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->address : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->address2 : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->city : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->state : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->country : '';
                        $row[] = ($asset->defaultLoc) ? $asset->defaultLoc->zip : '';
                    }


                    if ($request->has('assigned_to')) {
                        $row[] = ($asset->checkedOutToUser() && $asset->assigned) ? e($asset->assigned->getFullNameAttribute()) : ($asset->assigned ? e($asset->assigned->display_name) : '');
                        $row[] = ($asset->checkedOutToUser() && $asset->assigned) ? 'user' : e($asset->assignedType());
                    }

                    if ($request->has('username')) {
                        // Only works if we're checked out to a user, not anything else.
                        if ($asset->checkedOutToUser()) {
                            $row[] = ($asset->assignedto) ? $asset->assignedto->username : '';
                        } else {
                            $row[] = ''; // Empty string if unassigned
                        }
                    }

                    if ($request->has('employee_num')) {
                        // Only works if we're checked out to a user, not anything else.
                        if ($asset->checkedOutToUser()) {
                            $row[] = ($asset->assignedto) ? $asset->assignedto->employee_num : '';
                        } else {
                            $row[] = ''; // Empty string if unassigned
                        }
                    }


                    if ($request->has('department')) {
                        if ($asset->checkedOutToUser()) {
                            $row[] = (($asset->assignedto) && ($asset->assignedto->department)) ? $asset->assignedto->department->name : '';
                        } else {
                            $row[] = ''; // Empty string if unassigned
                        }
                    }

                    if ($request->has('status')) {
                        $row[] = ($asset->assetstatus) ? $asset->assetstatus->name.' ('.$asset->present()->statusMeta.')' : '';
                    }


                    if ($request->has('warranty')) {
                        $row[] = ($asset->warranty_months) ? $asset->warranty_months : '';
                        $row[] = $asset->present()->warrantee_expires();
                    }


                    if ($request->has('depreciation')) {
                            $depreciation = $asset->getDepreciatedValue();
                            $diff = ($asset->purchase_cost - $depreciation);
                            $row[]        = Helper::formatCurrencyOutput($depreciation);
                            $row[]        = Helper::formatCurrencyOutput($diff);
                    }

                    if ($request->has('checkout_date')) {
                        $row[] = ($asset->last_checkout) ? $asset->last_checkout : '';
                    }

                    if ($request->has('expected_checkin')) {
                        $row[] = ($asset->expected_checkin) ? $asset->expected_checkin : '';
                    }

                    if ($request->has('created_at')) {
                        $row[] = ($asset->created_at) ? $asset->created_at : '';
                    }

                    if ($request->has('updated_at')) {
                        $row[] = ($asset->updated_at) ? $asset->updated_at : '';
                    }

                    if ($request->has('last_audit_date')) {
                        $row[] = ($asset->last_audit_date) ? $asset->last_audit_date : '';
                    }

                    if ($request->has('next_audit_date')) {
                        $row[] = ($asset->next_audit_date) ? $asset->next_audit_date : '';
                    }

                    if ($request->has('notes')) {
                        $row[] = ($asset->notes) ? $asset->notes : '';
                    }

                    foreach ($customfields as $customfield) {
                        $column_name = $customfield->db_column_name();
                        if ($request->has($customfield->db_column_name())) {
                            $row[] = $asset->$column_name;
                        }
                    }
                    fputcsv($handle, $row);
                }
            });

            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition'
            => 'attachment; filename="custom-assets-report-'.date('Y-m-d-his').'.csv"',
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
        // Grab all the improvements
        $assetMaintenances = AssetMaintenance::with('asset', 'supplier')
                                             ->orderBy('created_at', 'DESC')
                                             ->get();

        $rows = [ ];

        $header = [
            trans('admin/hardware/table.asset_tag'),
            trans('admin/asset_maintenances/table.asset_name'),
            trans('general.supplier'),
            trans('admin/asset_maintenances/form.asset_maintenance_type'),
            trans('admin/asset_maintenances/form.title'),
            trans('admin/asset_maintenances/form.start_date'),
            trans('admin/asset_maintenances/form.completion_date'),
            trans('admin/asset_maintenances/form.asset_maintenance_time'),
            trans('admin/asset_maintenances/form.cost')
        ];

        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        foreach ($assetMaintenances as $assetMaintenance) {
            $row   = [ ];
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
            $rows[] = implode($row, ',');
        }

        // spit out a csv
        $csv      = implode($rows, "\n");
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
     * getAssetAcceptanceReport
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function getAssetAcceptanceReport()
    {
        $assetsForReport = Asset::notYetAccepted()->with('company')->get();

        return view('reports/unaccepted_assets', compact('assetsForReport'));
    }

    /**
     * exportAssetAcceptanceReport
     *
     * @return \Illuminate\Http\Response
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function exportAssetAcceptanceReport()
    {

        // Grab all the improvements
        $assetsForReport = Actionlog::whereIn('id', $this->getAssetsNotAcceptedYet())
                                    ->get();

        $rows = [ ];

        $header = [
            trans('general.category'),
            trans('admin/hardware/form.model'),
            trans('admin/hardware/form.name'),
            trans('admin/hardware/table.asset_tag'),
            trans('admin/hardware/table.checkoutto'),
        ];

        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        foreach ($assetsForReport as $assetItem) {
            $row    = [ ];
            $row[]  = str_replace(',', '', e($assetItem->assetlog->model->category->name));
            $row[]  = str_replace(',', '', e($assetItem->assetlog->model->name));
            $row[]  = str_replace(',', '', e($assetItem->assetlog->present()->name()));
            $row[]  = str_replace(',', '', e($assetItem->assetlog->asset_tag));
            $row[]  = str_replace(',', '', e($assetItem->assetlog->assignedTo->present()->name()));
            $rows[] = implode($row, ',');
        }

        // spit out a csv
        $csv      = implode($rows, "\n");
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
        return Asset::unaccepted();
    }
}
