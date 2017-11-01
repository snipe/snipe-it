<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\CustomField;
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
    * Display asset report view.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getAssetsReport()
    {
        $settings = \App\Models\Setting::first();
        return view('reports/asset', compact('assets'))->with('settings', $settings);
    }



    /**
    * Exports the assets to CSV
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return \Illuminate\Http\Response
    */
    public function exportAssetReport(Request $request)
    {

         \Debugbar::disable();

        $customfields = CustomField::get();

        $response = new StreamedResponse(function () use ($customfields, $request) {
            // Open output stream
            $handle = fopen('php://output', 'w');

            $assets = Asset::with('assignedTo', 'location','defaultLoc','assignedTo','model','supplier','assetstatus','model.manufacturer');

                // This is used by the sidenav, mostly
            switch ($request->input('status')) {
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

            $assets->orderBy('created_at', 'DESC')->chunk(500, function($assets) use($handle, $customfields) {
                $headers=[
                    trans('general.company'),
                    trans('admin/hardware/table.asset_tag'),
                    trans('admin/hardware/form.manufacturer'),
                    trans('admin/hardware/form.model'),
                    trans('general.model_no'),
                    trans('general.name'),
                    trans('admin/hardware/table.serial'),
                    trans('general.status'),
                    trans('admin/hardware/table.purchase_date'),
                    trans('admin/hardware/table.purchase_cost'),
                    trans('admin/hardware/form.order'),
                    trans('general.supplier'),
                    trans('admin/hardware/table.checkoutto'),
                    trans('admin/hardware/table.checkout_date'),
                    trans('admin/hardware/table.location'),
                    trans('general.notes'),
                ];
                foreach ($customfields as $field) {
                    $headers[]=$field->name;
                }
                fputcsv($handle, $headers);

                foreach ($assets as $asset) {
                    // Add a new row with data
                    $values=[
                        ($asset->company) ? $asset->company->name : '',
                        $asset->asset_tag,
                        ($asset->model->manufacturer) ? $asset->model->manufacturer->name : '',
                        ($asset->model) ? $asset->model->name : '',
                        ($asset->model->model_number) ? $asset->model->model_number : '',
                        ($asset->name) ? $asset->name : '',
                        ($asset->serial) ? $asset->serial : '',
                        ($asset->assetstatus) ? e($asset->assetstatus->name) : '',
                        ($asset->purchase_date) ? e($asset->purchase_date) : '',
                        ($asset->purchase_cost > 0) ? Helper::formatCurrencyOutput($asset->purchase_cost) : '',
                        ($asset->order_number) ? e($asset->order_number) : '',
                        ($asset->supplier) ? e($asset->supplier->name) : '',
                        ($asset->assignedTo) ? e($asset->assignedTo->present()->name()) : '',
                        ($asset->last_checkout!='') ? e($asset->last_checkout) : '',
                        ($asset->location) ? e($asset->location->present()->name()) : '',
                        ($asset->notes) ? e($asset->notes) : '',
                    ];
                    foreach ($customfields as $field) {
                        $values[]=$asset->{$field->db_column_name()};
                    }
                    fputcsv($handle, $values);
                }
            });

            // Close the output stream
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition'
                => 'attachment; filename="'.(($request->has('status')) ? trim($request->input('status')) : 'all').'-assets-'.date('Y-m-d-his').'.csv"',
        ]);

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

        // Grab all the assets
        $assets = Asset::with( 'assignedTo', 'assetstatus', 'defaultLoc', 'location', 'assetlog', 'company', 'model.category', 'model.depreciation')
                       ->orderBy('created_at', 'DESC')->get();

        return view('reports/depreciation', compact('assets'));
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
    public function postCustom()
    {
        $assets = Asset::orderBy('created_at', 'DESC')->with('company', 'assignedTo', 'location', 'defaultLoc', 'model', 'supplier', 'assetstatus', 'model.manufacturer')->get();
        $customfields = CustomField::get();

        $rows   = [ ];
        $header = [ ];

        if (e(Input::get('company')) == '1') {
            $header[] = 'Company Name';
        }

        if (e(Input::get('asset_name')) == '1') {
            $header[] = 'Asset Name';
        }
        if (e(Input::get('asset_tag')) == '1') {
            $header[] = 'Asset Tag';
        }
        if (e(Input::get('manufacturer')) == '1') {
            $header[] = 'Manufacturer';
        }
        if (e(Input::get('model')) == '1') {
            $header[] = 'Model';
            $header[] = 'Model Number';
        }
        if (e(Input::get('category')) == '1') {
            $header[] = 'Category';
        }
        if (e(Input::get('serial')) == '1') {
            $header[] = 'Serial';
        }
        if (e(Input::get('purchase_date')) == '1') {
            $header[] = 'Purchase Date';
        }
        if (( e(Input::get('purchase_cost')) == '1' ) && ( e(Input::get('depreciation')) != '1' )) {
            $header[] = 'Purchase Cost';
        }
        if (e(Input::get('eol')) == '1') {
            $header[] = 'EOL';
        }
        if (e(Input::get('order')) == '1') {
            $header[] = 'Order Number';
        }
        if (e(Input::get('supplier')) == '1') {
            $header[] = 'Supplier';
        }
        if (e(Input::get('location')) == '1') {
            $header[] = 'Location';
        }
        if (e(Input::get('assigned_to')) == '1') {
            $header[] = 'Assigned To';
        }
        if (e(Input::get('username')) == '1') {
            $header[] = 'Username';
        }
        if (e(Input::get('employee_num')) == '1') {
            $header[] = 'Employee No.';
        }
        if (e(Input::get('status')) == '1') {
            $header[] = 'Status';
        }
        if (e(Input::get('warranty')) == '1') {
            $header[] = 'Warranty';
            $header[] = 'Warranty Expires';
        }
        if (e(Input::get('depreciation')) == '1') {
            $header[] = 'Purchase Cost';
            $header[] = 'Value';
            $header[] = 'Diff';
        }
        if (e(Input::get('expected_checkin')) == '1') {
            $header[] = trans('admin/hardware/form.expected_checkin');
        }

        if (e(Input::get('notes')) == '1') {
            $header[] = trans('general.notes');
        }


        foreach ($customfields as $customfield) {
            if (e(Input::get($customfield->db_column_name())) == '1') {
                $header[] = $customfield->name;
            }
        }


        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        foreach ($assets as $asset) {
            $row = [ ];

            if (e(Input::get('company')) == '1') {
                $row[] = is_null($asset->company) ? '' : '"'.$asset->company->name.'"';
            }

            if (e(Input::get('asset_name')) == '1') {
                $row[] = '"' .e($asset->name) . '"';
            }
            if (e(Input::get('asset_tag')) == '1') {
                $row[] = e($asset->asset_tag);
            }
            if (e(Input::get('manufacturer')) == '1') {
                if ($asset->model->manufacturer) {
                    $row[] = '"' .e($asset->model->manufacturer->name) . '"';
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('model')) == '1') {
                $row[] = '"' . e($asset->model->name) . '"';
                $row[] = '"' . e($asset->model->model_number) . '"';
            }
            if (e(Input::get('category')) == '1') {
                $row[] = '"' .e($asset->model->category->name) . '"';
            }

            if (e(Input::get('serial')) == '1') {
                $row[] = e($asset->serial);
            }
            if (e(Input::get('purchase_date')) == '1') {
                $row[] = e($asset->purchase_date);
            }
            if (e(Input::get('purchase_cost')) == '1' && ( e(Input::get('depreciation')) != '1' )) {
                $row[] = '"' . Helper::formatCurrencyOutput($asset->purchase_cost) . '"';
            }
            if (e(Input::get('eol')) == '1') {
                $row[] = '"' .($asset->present()->eol_date()) ? $asset->present()->eol_date() : ''. '"';
            }
            if (e(Input::get('order')) == '1') {
                if ($asset->order_number) {
                    $row[] = e($asset->order_number);
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('supplier')) == '1') {
                if ($asset->supplier) {
                    $row[] = '"' .e($asset->supplier->name) . '"';
                } else {
                    $row[] = '';
                }
            }

            if (e(Input::get('location')) == '1') {
                if($asset->location) {
                    $show_loc = $asset->location->present()->name();
                } else {
                    $show_loc = 'Default location '.$asset->rtd_location_id.' is invalid';
                }
                $row[] = $show_loc;
            }


            if (e(Input::get('assigned_to')) == '1') {
                if ($asset->assignedto) {
                    $row[] = '"' .e($asset->assignedto->present()->name()). '"';
                } else {
                    $row[] = ''; // Empty string if unassigned
                }
            }

            if (e(Input::get('username')) == '1') {
                // Only works if we're checked out to a user, not anything else.
                if ($asset->checkedOutToUser()) {
                    $row[] = '"' .e($asset->assignedto->username). '"';
                } else {
                    $row[] = ''; // Empty string if unassigned
                }
            }

            if (e(Input::get('employee_num')) == '1') {
                // Only works if we're checked out to a user, not anything else.
                if ($asset->checkedOutToUser()) {
                    $row[] = '"' .e($asset->assignedto->employee_num). '"';
                } else {
                    $row[] = ''; // Empty string if unassigned
                }
            }

            if (e(Input::get('status')) == '1') {
                if (( $asset->status_id == '0' ) && ( $asset->assigned_to == '0' )) {
                    $row[] = trans('general.ready_to_deploy');
                } elseif (( $asset->status_id == '' ) && ( $asset->assigned_to == '0' )) {
                    $row[] = trans('general.pending');
                } elseif ($asset->assetstatus) {
                    $row[] = '"' .e($asset->assetstatus->name). '"';
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('warranty')) == '1') {
                if ($asset->warranty_months) {
                    $row[] = $asset->warranty_months;
                    $row[] = $asset->present()->warrantee_expires();
                } else {
                    $row[] = '';
                    $row[] = '';
                }
            }
            if (e(Input::get('depreciation')) == '1') {
                $depreciation = $asset->getDepreciatedValue();
                $row[]        = '"' . Helper::formatCurrencyOutput($asset->purchase_cost) . '"';
                $row[]        = '"' . Helper::formatCurrencyOutput($depreciation) . '"';
                $row[]        = '"' . Helper::formatCurrencyOutput($asset->purchase_cost) . '"';
            }
            if (e(Input::get('expected_checkin')) == '1') {
                if ($asset->expected_checkin) {
                    $row[] = '"' .e($asset->expected_checkin). '"';
                } else {
                    $row[] = ''; // Empty string if blankd
                }
            }

            if (e(Input::get('notes')) == '1') {
                if ($asset->notes) {
                    $row[] = '"' .$asset->notes . '"';
                } else {
                    $row[] = '';
                }
            }

            foreach ($customfields as $customfield) {
                $column_name = $customfield->db_column_name();
                if (e(Input::get($customfield->db_column_name())) == '1') {
                    $row[] = str_replace(",", "\,", $asset->$column_name);
                }
            }


            $rows[] = implode($row, ',');
        }

        // spit out a csv
        if (array_filter($rows)) {
            $csv      = implode($rows, "\n");
            $response = Response::make($csv, 200);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition', 'attachment;filename='.date('Y-m-d-His').'-custom-asset-report.csv');

            return $response;
        } else {
            return redirect()->to("reports/custom")
                ->with('error', trans('admin/reports/message.error'));
        }
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
