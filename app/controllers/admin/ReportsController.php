<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use License;
use Asset;
use User;
use View;
use Location;
use Redirect;
use Response;
use Actionlog;

class ReportsController extends AdminController
{
    /**
     * Show Asset Report
     *
     * @return View
     */
    public function getAssetsReport()
    {
        // Grab all the assets
        $assets = Asset::with('model','assigneduser.userLoc','assetstatus','defaultLoc','assetlog','supplier','model.manufacturer')->orderBy('created_at', 'DESC')->get();
        return View::make('backend/reports/asset', compact('assets'));
    }

    /**
     * Export Asset Report as CSV
     *
     * @return file download
     */
    public function exportAssetReport()
    {
        // Grab all the assets
        $assets = Asset::orderBy('created_at', 'DESC')->get();

        $rows = array();

        // Create the header row
        $header = array(
            Lang::get('admin/hardware/table.asset_tag'),
            Lang::get('admin/hardware/form.manufacturer'),
            Lang::get('admin/hardware/form.model'),
            Lang::get('general.model_no'),
            Lang::get('general.name'),
            Lang::get('admin/hardware/table.serial'),
            Lang::get('general.status'),
            Lang::get('admin/hardware/table.purchase_date'),
            Lang::get('admin/hardware/table.purchase_cost'),
            Lang::get('admin/hardware/form.order'),
            Lang::get('admin/hardware/form.supplier'),
            Lang::get('admin/hardware/table.checkoutto'),
            Lang::get('admin/hardware/table.location')
        );
        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        // Create a row per asset
        foreach ($assets as $asset) {
            $row = array();
            $row[] = $asset->asset_tag;
            if ($asset->model->manufacturer) {
                $row[] = $asset->model->manufacturer->name;
            } else {
                $row[] = '';
            }
            $row[] = '"'.$asset->model->name.'"';
            $row[] = '"'.$asset->model->modelno.'"';
            $row[] = $asset->name;
            $row[] = $asset->serial;
            if ($asset->assetstatus) {
                $row[] = $asset->assetstatus->name;
            } else {
                $row[] = '';
            }
            $row[] = $asset->purchase_date;
            $row[] = '"'.number_format($asset->purchase_cost).'"';
            if ($asset->order_number) {
                $row[] = $asset->order_number;
            } else {
                $row[] = '';
            }
            if ($asset->supplier_id) {
                $row[] = $asset->supplier->name;
            } else {
                $row[] = '';
            }

            if ($asset->assigned_to > 0) {
                $user = User::find($asset->assigned_to);
                $row[] = $user->fullName();
            } else {
                $row[] = ''; // Empty string if unassigned
            }

            if (($asset->assigned_to > 0) && ($asset->assigneduser->location_id > 0)) {
                $location = Location::find($asset->assigneduser->location_id);
                if ($location->name) {
                    $row[] = $location->name;
                } else {
                    $row[] = '';
                }
            } elseif ($asset->rtd_location_id) {
                $location = Location::find($asset->rtd_location_id);
                if ($location->name) {
                    $row[] = $location->name;
                } else {
                    $row[] = '';
                }
            } else {
                $row[] = '';  // Empty string if location is not set
            }

            $rows[] = implode($row, ',');
        }

        // spit out a csv
        $csv = implode($rows, "\n");
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
     * Show Depreciation Report for Assets
     *
     * @return View
     */
    public function getDeprecationReport()
    {
        // Grab all the assets
        $assets = Asset::with('model','assigneduser','assetstatus','defaultLoc','assetlog')->orderBy('created_at', 'DESC')->get();
        return View::make('backend/reports/depreciation', compact('assets'));
    }

    /**
     * Export Depreciation Report as CSV
     *
     * @return file download
     */
    public function exportDeprecationReport()
    {
        // Grab all the assets
        $assets = Asset::with('model','assigneduser','assetstatus','defaultLoc','assetlog')->orderBy('created_at', 'DESC')->get();

        $rows = array();

        // Create the header row
        $header = array(
            Lang::get('admin/hardware/table.asset_tag'),
            Lang::get('admin/hardware/table.title'),
            Lang::get('admin/hardware/table.serial'),
            Lang::get('admin/hardware/table.checkoutto'),
            Lang::get('admin/hardware/table.location'),
            Lang::get('admin/hardware/table.purchase_date'),
            Lang::get('admin/hardware/table.purchase_cost'),
            Lang::get('admin/hardware/table.book_value'),
            Lang::get('admin/hardware/table.diff')
        );
        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        // Create a row per asset
        foreach ($assets as $asset) {
            $row = array();
            $row[] = $asset->asset_tag;
            $row[] = $asset->name;
            $row[] = $asset->serial;


            if ($asset->assigned_to > 0) {
              $user = User::find($asset->assigned_to);
              $row[] = $user->fullName();
              } else {
                $row[] = ''; // Empty string if unassigned
            }

            if (($asset->assigned_to > 0) && ($asset->assigneduser->location_id > 0)) {
                $location = Location::find($asset->assigneduser->location_id);
                if ($location->city) {
                    $row[] = '"'.$location->city . ', ' . $location->state.'"';
                } elseif ($location->name) {
                    $row[] = $location->name;
                } else {
                    $row[] = '';
                }
            } else {
                $row[] = '';  // Empty string if location is not set
            }

			
            
            

            $row[] = $asset->purchase_date;
            $row[] = '"'.Lang::get('general.currency').number_format($asset->purchase_cost).'"';
            $row[] = '"'.Lang::get('general.currency').number_format($asset->getDepreciatedValue()).'"';
            $row[] = '"-'.Lang::get('general.currency').number_format(($asset->purchase_cost - $asset->getDepreciatedValue())).'"';
            $rows[] = implode($row, ',');
        }

        // spit out a csv
        $csv = implode($rows, "\n");

        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

	/**
     * Show Report for Activity
     *
     * @return View
     */

	public function getActivityReport()
    {
        $log_actions = Actionlog::orderBy('created_at', 'DESC')
        ->with('adminlog')
        ->with('accessorylog')
        ->with('assetlog')
        ->with('licenselog')
        ->with('userlog')
        ->orderBy('created_at','DESC')
        ->get();
        return View::make('backend/reports/activity', compact('log_actions'));
    }
    
    
    /**
     * Show Report for Licenses
     *
     * @return View
     */
    public function getLicenseReport()
    {
        $licenses = License::orderBy('created_at', 'DESC')->get();
        return View::make('backend/reports/licenses', compact('licenses'));
    }

    /**
     * Export License Report as CSV
     *
     * @return file download
     */
    public function exportLicenseReport()
    {
        $licenses = License::orderBy('created_at', 'DESC')->get();
        $rows = array();
        $header = array(
            Lang::get('admin/licenses/table.title'),
            Lang::get('admin/licenses/table.serial'),
            Lang::get('admin/licenses/form.seats'),
            Lang::get('admin/licenses/form.remaining_seats'),
            Lang::get('admin/licenses/form.expiration'),
            Lang::get('admin/licenses/form.date'),
            Lang::get('admin/licenses/form.cost')
        );

        $header = array_map('trim', $header);
        $rows[] = implode($header, ', ');

        // Row per license
        foreach ($licenses as $license) {
            $row = array();
            $row[] = $license->name;
            $row[] = $license->serial;
            $row[] = $license->seats;
            $row[] = $license->remaincount();
            $row[] = $license->expiration_date;
            $row[] = $license->purchase_date;
            $row[] = '"'.number_format($license->purchase_cost).'"';

            $rows[] = implode($row, ',');
        }

        $csv = implode($rows, "\n");
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    public function getCustomReport()
    {
        return View::make('backend/reports/custom');
    }

    public function postCustom()
    {
        $assets = Asset::orderBy('created_at', 'DESC')->get();
        $rows = array();
        $header = array();

        if (e(Input::get('asset_name')) == '1')
        {
            $header[] = 'Asset Name';
        }
        if (e(Input::get('asset_tag')) == '1')
        {
            $header[] = 'Asset Tag';
        }
        if (e(Input::get('manufacturer')) == '1')
        {
            $header[] = 'Manufacturer';
        }
        if (e(Input::get('model')) == '1')
        {
            $header[] = 'Model';
            $header[] = 'Model Number';
        }
        if (e(Input::get('serial')) == '1')
        {
            $header[] = 'Serial';
        }
        if (e(Input::get('purchase_date')) == '1')
        {
            $header[] = 'Purchase Date';
        }
        if ((e(Input::get('purchase_cost')) == '1') && (e(Input::get('depreciation')) == '0'))
        {
            $header[] = 'Purchase Cost';
        }
        if (e(Input::get('order')) == '1')
        {
            $header[] = 'Order Number';
        }
        if (e(Input::get('supplier')) == '1')
        {
            $header[] = 'Supplier';
        }
        if (e(Input::get('location')) == '1')
        {
            $header[] = 'Location';
        }
        if (e(Input::get('assigned_to')) == '1')
        {
            $header[] = 'Assigned To';
        }
        if (e(Input::get('status')) == '1')
        {
            $header[] = 'Status';
        }
        if (e(Input::get('warranty')) == '1')
        {
            $header[] = 'Warranty';
            $header[] = 'Warranty Expires';
        }
        if (e(Input::get('depreciation')) == '1')
        {
            $header[] = 'Purchase Cost';
            $header[] = 'Value';
            $header[] = 'Diff';
        }

        $header = array_map('trim', $header);
        $rows[] = implode($header, ',');

        foreach($assets as $asset) {
            $row = array();
            if (e(Input::get('asset_name')) == '1') {
                $row[] = $asset->name;
            }
            if (e(Input::get('asset_tag')) == '1') {
                $row[] = $asset->asset_tag;
            }
            if (e(Input::get('manufacturer')) == '1') {
                if ($asset->model->manufacturer) {
                    $row[] = $asset->model->manufacturer->name;
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('model')) == '1') {
                $row[] = '"'.$asset->model->name.'"';
                $row[] = '"'.$asset->model->modelno.'"';
            }
            if (e(Input::get('serial')) == '1') {
                $row[] = $asset->serial;
            }
            if (e(Input::get('purchase_date')) == '1') {
                $row[] = $asset->purchase_date;
            }
            if (e(Input::get('purchase_cost')) == '1') {
                $row[] = '"'.number_format($asset->purchase_cost).'"';
            }
            if (e(Input::get('order')) == '1') {
                if ($asset->order_number) {
                    $row[] = $asset->order_number;
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('supplier')) == '1') {
                if ($asset->supplier_id) {
                    $row[] = $asset->supplier->name;
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('location')) == '1') {
                if (($asset->assigned_to > 0) && ($asset->assigneduser->location_id > 0)) {
                    $location = Location::find($asset->assigneduser->location_id);
                    if ($location->name) {
                        $row[] = $location->name;
                    } else {
                        $row[] = '';
                    }
                } elseif ($asset->rtd_location_id) {
                    $location = Location::find($asset->rtd_location_id);
                    if ($location->name) {
                        $row[] = $location->name;
                    } else {
                        $row[] = '';
                    }
                } else {
                    $row[] = '';  // Empty string if location is not set
                }
            }
            if (e(Input::get('assigned_to')) == '1') {
                if ($asset->assigned_to > 0) {
                    $user = User::find($asset->assigned_to);
                    $row[] = $user->fullName();
                } else {
                    $row[] = ''; // Empty string if unassigned
                }
            }
            if (e(Input::get('status')) == '1') {
                if (($asset->status_id == '0') && ($asset->assigned_to == '0')) {
                    $row[] = Lang::get('general.ready_to_deploy');
                } elseif (($asset->status_id == '') && ($asset->assigned_to == '0')) {
                    $row[] = Lang::get('general.pending');
                } elseif ($asset->assetstatus) {
                    $row[] = $asset->assetstatus->name;
                } else {
                    $row[] = '';
                }
            }
            if (e(Input::get('warranty')) == '1') {
                if ($asset->warranty_months) {
                    $row[] = $asset->warranty_months;
                    $row[] = $asset->warrantee_expires();
                } else {
                    $row[] = '';
                    $row[] = '';
                }
            }
            if (e(Input::get('depreciation')) == '1') {
                $depreciation = $asset->getDepreciatedValue();
                $row[] = '"'.number_format($asset->purchase_cost).'"';
                $row[] = '"'.number_format($depreciation).'"';
                $row[] = '"'.number_format($asset->purchase_cost - $depreciation).'"';
            }
            $rows[] = implode($row, ',');
        }

        // spit out a csv
        if (array_filter($rows)) {
            $csv = implode($rows, "\n");
            $response = Response::make($csv, 200);
            $response->header('Content-Type', 'text/csv');
            $response->header('Content-disposition', 'attachment;filename=report.csv');
            return $response;
        } else {
            return Redirect::to("reports/custom")->with('error', Lang::get('admin/reports/message.error'));
        }
    }
}
