<?php namespace Controllers\Admin;

use AdminController;
use Lang;
use License;
use Asset;
use User;
use View;
use Location;
use Response;

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
            Lang::get('admin/hardware/table.purchase_date'),
            Lang::get('admin/hardware/table.purchase_cost'),
            Lang::get('admin/hardware/form.order'),
            Lang::get('admin/hardware/form.supplier'),
            Lang::get('admin/hardware/table.checkoutto'),
            Lang::get('admin/hardware/table.location'),
            Lang::get('general.status')
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

            if (($asset->status_id == '0') && ($asset->assigned_to == '0')) {
                $row[] = Lang::get('general.ready_to_deploy');
            } elseif (($asset->status_id == '') && ($asset->assigned_to == '0')) {
                $row[] = Lang::get('general.pending');
            } elseif ($asset->assetstatus) {
                $row[] = $asset->assetstatus->name;
            } else {
                $row[] = '';
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
        // @todo - It may be worthwhile creating a separate controller for reporting

        // Grab all the assets
        $assets = Asset::orderBy('created_at', 'DESC')->get();

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

            $depreciation = $asset->depreciate();

            $row[] = $asset->purchase_date;
            $row[] = '"'.number_format($asset->purchase_cost).'"';
            $row[] = '"'.number_format($depreciation).'"';
            $row[] = '"'.number_format($asset->purchase_cost - $depreciation).'"';
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
}

