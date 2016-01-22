<?php namespace Controllers\Admin;

use Accessory;
use Actionlog;
use AdminController;
use Asset;
use AssetMaintenance;
use Carbon\Carbon;
use Category;
use Company;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Input;
use League\Csv\Reader;
use License;
use Location;
use Model;
use Redirect;
use Setting;
use User;

class ReportsController extends AdminController
{

    /**
     * Show Report for Accessories
     *
     * @return View
     */
    public function getAccessoryReport()
    {
        $accessories = Accessory::orderBy('created_at', 'DESC')->with('company')->get();

        return View::make('backend/reports/accessories', compact('accessories'));
    }

    /**
     * Export Accessories Report as CSV
     *
     * @return file download
     */
    public function exportAccessoryReport()
    {
        $accessories = Accessory::orderBy('created_at', 'DESC')->get();

        $rows = array();
        $header = array(
            Lang::get('admin/accessories/table.title'),
			Lang::get('admin/accessories/general.accessory_category'),
            Lang::get('admin/accessories/general.total'),
            Lang::get('admin/accessories/general.remaining')
        );
        $header = array_map('trim', $header);
        $rows[] = implode($header, ', ');

        // Row per accessory
        foreach ($accessories as $accessory) {
            $row = array();
            $row[] = $accessory->accessory_name;
			$row[] = $accessory->accessory_category;
            $row[] = $accessory->total;
            $row[] = $accessory->remaining;

            $rows[] = implode($row, ',');
        }

        $csv = implode($rows, "\n");
        $response = Response::make($csv, 200);
        $response->header('Content-Type', 'text/csv');
        $response->header('Content-disposition', 'attachment;filename=report.csv');

        return $response;
    }

    /**
     * Show Asset Report
     *
     * @return View
     */
    public function getAssetsReport()
    {
        // Grab all the assets
        $assets = Asset::with( 'model', 'assigneduser.userLoc', 'assetstatus', 'defaultLoc', 'assetlog', 'supplier',
            'model.manufacturer', 'company' )
                       ->orderBy( 'created_at', 'DESC' )
                       ->get();

        return View::make( 'backend/reports/asset', compact( 'assets' ) );
    }

    /**
     * Export Asset Report as CSV
     *
     * @return file download
     */
    public function exportAssetReport()
    {
        // Grab all the assets
        $assets = Asset::orderBy( 'created_at', 'DESC' )->get();

        $rows = [ ];

        // Create the header row
        $header = [
            Lang::get( 'admin/hardware/table.asset_tag' ),
            Lang::get( 'admin/hardware/form.manufacturer' ),
            Lang::get( 'admin/hardware/form.model' ),
            Lang::get( 'general.model_no' ),
            Lang::get( 'general.name' ),
            Lang::get( 'admin/hardware/table.serial' ),
            Lang::get( 'general.status' ),
            Lang::get( 'admin/hardware/table.purchase_date' ),
            Lang::get( 'admin/hardware/table.purchase_cost' ),
            Lang::get( 'admin/hardware/form.order' ),
            Lang::get( 'admin/hardware/form.supplier' ),
            Lang::get( 'admin/hardware/table.checkoutto' ),
            Lang::get( 'admin/hardware/table.location' ),
            Lang::get( 'general.notes' ),
        ];
        $header = array_map( 'trim', $header );
        $rows[] = implode( $header, ',' );

        // Create a row per asset
        foreach ($assets as $asset) {
            $row   = [ ];
            $row[] = $asset->asset_tag;
            if ($asset->model->manufacturer) {
                $row[] = $asset->model->manufacturer->name;
            } else {
                $row[] = '';
            }
            $row[] = '"' . $asset->model->name . '"';
            $row[] = '"' . $asset->model->modelno . '"';
            $row[] = $asset->name;
            $row[] = $asset->serial;
            if ($asset->assetstatus) {
                $row[] = $asset->assetstatus->name;
            } else {
                $row[] = '';
            }
            $row[] = $asset->purchase_date;
            $row[] = '"' . number_format( $asset->purchase_cost ) . '"';
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
                $user  = User::find( $asset->assigned_to );
                $row[] = $user->fullName();
            } else {
                $row[] = ''; // Empty string if unassigned
            }

            if (( $asset->assigned_to > 0 ) && ( $asset->assigneduser->location_id > 0 )) {
                $location = Location::find( $asset->assigneduser->location_id );
                if ($location) {
                    $row[] = $location->name;
                } else {
                    $row[] = '';
                }
            } elseif ($asset->rtd_location_id) {
                $location = Location::find( $asset->rtd_location_id );
                if ($location->name) {
                    $row[] = $location->name;
                } else {
                    $row[] = '';
                }
            } else {
                $row[] = '';  // Empty string if location is not set
            }

            if ($asset->notes) {
                $row[] = '"' . $asset->notes . '"';
            } else {
                $row[] = '';
            }

            $rows[] = implode( $row, ',' );
        }

        // spit out a csv
        $csv      = implode( $rows, "\n" );
        $response = Response::make( $csv, 200 );
        $response->header( 'Content-Type', 'text/csv' );
        $response->header( 'Content-disposition', 'attachment;filename=report.csv' );

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
        $assets = Asset::with( 'model', 'assigneduser', 'assetstatus', 'defaultLoc', 'assetlog', 'company' )
                       ->orderBy( 'created_at', 'DESC' )->get();

        return View::make( 'backend/reports/depreciation', compact( 'assets' ) );
    }

    /**
     * Export Depreciation Report as CSV
     *
     * @return file download
     */
    public function exportDeprecationReport()
    {

        // Grab all the assets
        $assets = Asset::with( 'model', 'assigneduser', 'assetstatus', 'defaultLoc', 'assetlog' )
                       ->orderBy( 'created_at', 'DESC' )->get();

        $csv = \League\Csv\Writer::createFromFileObject( new \SplTempFileObject() );
        $csv->setOutputBOM( Reader::BOM_UTF16_BE );

        $rows = [ ];

        // Create the header row
        $header = [
            Lang::get( 'admin/hardware/table.asset_tag' ),
            Lang::get( 'admin/hardware/table.title' ),
            Lang::get( 'admin/hardware/table.serial' ),
            Lang::get( 'admin/hardware/table.checkoutto' ),
            Lang::get( 'admin/hardware/table.location' ),
            Lang::get( 'admin/hardware/table.purchase_date' ),
            Lang::get( 'admin/hardware/table.purchase_cost' ),
            Lang::get( 'admin/hardware/table.book_value' ),
            Lang::get( 'admin/hardware/table.diff' )
        ];

        //we insert the CSV header
        $csv->insertOne( $header );

        // Create a row per asset
        foreach ($assets as $asset) {
            $row   = [ ];
            $row[] = $asset->asset_tag;
            $row[] = $asset->name;
            $row[] = $asset->serial;

            if ($asset->assigned_to > 0) {
                $user  = User::find( $asset->assigned_to );
                $row[] = $user->fullName();
            } else {
                $row[] = ''; // Empty string if unassigned
            }

            if (( $asset->assigned_to > 0 ) && ( $asset->assigneduser->location_id > 0 )) {
                $location = Location::find( $asset->assigneduser->location_id );
                if ($location->city) {
                    $row[] = $location->city . ', ' . $location->state;
                } elseif ($location->name) {
                    $row[] = $location->name;
                } else {
                    $row[] = '';
                }
            } else {
                $row[] = '';  // Empty string if location is not set
            }

            if ($asset->assetloc) {
                $currency = $asset->assetloc->currency;
            } else {
                $currency = Setting::first()->default_currency;
            }

            $row[] = $asset->purchase_date;
            $row[] = $currency . number_format( $asset->purchase_cost );
            $row[] = $currency . number_format( $asset->getDepreciatedValue() );
            $row[] = $currency . number_format( ( $asset->purchase_cost - $asset->getDepreciatedValue() ) );
            $csv->insertOne( $row );
        }

        $csv->output( 'depreciation-report-' . date( 'Y-m-d' ) . '.csv' );
        die;

    }

    /**
     * Show Report for Activity
     *
     * @return View
     */
    public function getActivityReport()
    {
        $log_actions = Actionlog::orderBy( 'created_at', 'DESC' )
                                ->with( 'adminlog' )
                                ->with( 'accessorylog' )
                                ->with( 'assetlog' )
                                ->with( 'licenselog' )
                                ->with( 'userlog' )
                                ->orderBy( 'created_at', 'DESC' )
                                ->get();

        return View::make( 'backend/reports/activity', compact( 'log_actions' ) );
    }

    /**
     * Show Report for Licenses
     *
     * @return View
     */
    public function getLicenseReport()
    {

        $licenses = License::orderBy( 'created_at', 'DESC' )
                           ->with( 'company' )
                           ->get();

        return View::make( 'backend/reports/licenses', compact( 'licenses' ) );
    }

    /**
     * Export License Report as CSV
     *
     * @return file download
     */
    public function exportLicenseReport()
    {
        $licenses = License::orderBy( 'created_at', 'DESC' )->get();

        $rows     = [ ];
        $header   = [
            Lang::get( 'admin/licenses/table.title' ),
            Lang::get( 'admin/licenses/table.serial' ),
            Lang::get( 'admin/licenses/form.seats' ),
            Lang::get( 'admin/licenses/form.remaining_seats' ),
            Lang::get( 'admin/licenses/form.expiration' ),
            Lang::get( 'admin/licenses/form.date' ),
            Lang::get( 'admin/licenses/form.cost' )
        ];

        $header = array_map( 'trim', $header );
        $rows[] = implode( $header, ', ' );

        // Row per license
        foreach ($licenses as $license) {
            $row   = [ ];
            $row[] = $license->name;
            $row[] = $license->serial;
            $row[] = $license->seats;
            $row[] = $license->remaincount();
            $row[] = $license->expiration_date;
            $row[] = $license->purchase_date;
            $row[] = '"' . number_format( $license->purchase_cost ) . '"';

            $rows[] = implode( $row, ',' );
        }

        $csv      = implode( $rows, "\n" );
        $response = Response::make( $csv, 200 );
        $response->header( 'Content-Type', 'text/csv' );
        $response->header( 'Content-disposition', 'attachment;filename=report.csv' );

        return $response;
    }

    public function getCustomReport()
    {

        return View::make( 'backend/reports/custom' );
    }

    public function postCustom()
    {
        $assets = Asset::orderBy( 'created_at', 'DESC' )->get();

        $rows   = [ ];
        $header = [ ];

        if (e( Input::get( 'asset_name' ) ) == '1') {
            $header[] = 'Asset Name';
        }
        if (e( Input::get( 'asset_tag' ) ) == '1') {
            $header[] = 'Asset Tag';
        }
        if (e( Input::get( 'manufacturer' ) ) == '1') {
            $header[] = 'Manufacturer';
        }
        if (e( Input::get( 'model' ) ) == '1') {
            $header[] = 'Model';
            $header[] = 'Model Number';
        }
        if (e( Input::get( 'serial' ) ) == '1') {
            $header[] = 'Serial';
        }
        if (e( Input::get( 'purchase_date' ) ) == '1') {
            $header[] = 'Purchase Date';
        }
        if (( e( Input::get( 'purchase_cost' ) ) == '1' ) && ( e( Input::get( 'depreciation' ) ) != '1' )) {
            $header[] = 'Purchase Cost';
        }
        if (e( Input::get( 'order' ) ) == '1') {
            $header[] = 'Order Number';
        }
        if (e( Input::get( 'supplier' ) ) == '1') {
            $header[] = 'Supplier';
        }
        if (e( Input::get( 'location' ) ) == '1') {
            $header[] = 'Location';
        }
        if (e( Input::get( 'assigned_to' ) ) == '1') {
            $header[] = 'Assigned To';
        }
        if (e( Input::get( 'status' ) ) == '1') {
            $header[] = 'Status';
        }
        if (e( Input::get( 'warranty' ) ) == '1') {
            $header[] = 'Warranty';
            $header[] = 'Warranty Expires';
        }
        if (e( Input::get( 'depreciation' ) ) == '1') {
            $header[] = 'Purchase Cost';
            $header[] = 'Value';
            $header[] = 'Diff';
        }

        $header = array_map( 'trim', $header );
        $rows[] = implode( $header, ',' );

        foreach ($assets as $asset) {
            $row = [ ];
            if (e( Input::get( 'asset_name' ) ) == '1') {
                $row[] = $asset->name;
            }
            if (e( Input::get( 'asset_tag' ) ) == '1') {
                $row[] = $asset->asset_tag;
            }
            if (e( Input::get( 'manufacturer' ) ) == '1') {
                if ($asset->model->manufacturer) {
                    $row[] = $asset->model->manufacturer->name;
                } else {
                    $row[] = '';
                }
            }
            if (e( Input::get( 'model' ) ) == '1') {
                $row[] = '"' . $asset->model->name . '"';
                $row[] = '"' . $asset->model->modelno . '"';
            }
            if (e( Input::get( 'serial' ) ) == '1') {
                $row[] = $asset->serial;
            }
            if (e( Input::get( 'purchase_date' ) ) == '1') {
                $row[] = $asset->purchase_date;
            }
            if (e( Input::get( 'purchase_cost' ) ) == '1' && ( e( Input::get( 'depreciation' ) ) != '1' )) {
                $row[] = '"' . number_format( $asset->purchase_cost ) . '"';
            }
            if (e( Input::get( 'order' ) ) == '1') {
                if ($asset->order_number) {
                    $row[] = $asset->order_number;
                } else {
                    $row[] = '';
                }
            }
            if (e( Input::get( 'supplier' ) ) == '1') {
                if ($asset->supplier_id) {
                    $row[] = $asset->supplier->name;
                } else {
                    $row[] = '';
                }
            }
            if (e( Input::get( 'location' ) ) == '1') {
	            $show_loc = '';
                if (( $asset->assigned_to > 0 ) && ( $asset->assigneduser->location_id !='' )) {
                    $location = Location::find( $asset->assigneduser->location_id );
                    if ($location) {
                        $show_loc .= $location->name;
                    } else {
                        $show_loc .= 'User location '.$asset->assigneduser->location_id.' is invalid';
                    }
                } elseif ($asset->rtd_location_id!='') {
                    $location = Location::find( $asset->rtd_location_id );
                    if ($location) {
                        $show_loc .= $location->name;
                    } else {
                        $show_loc .= 'Default location '.$asset->rtd_location_id.' is invalid';
                    }
                }

                $row[] = $show_loc;

            }
            if (e( Input::get( 'assigned_to' ) ) == '1') {
                if ($asset->assigned_to > 0) {
                    $user  = User::find( $asset->assigned_to );
                    $row[] = $user->fullName();
                } else {
                    $row[] = ''; // Empty string if unassigned
                }
            }
            if (e( Input::get( 'status' ) ) == '1') {
                if (( $asset->status_id == '0' ) && ( $asset->assigned_to == '0' )) {
                    $row[] = Lang::get( 'general.ready_to_deploy' );
                } elseif (( $asset->status_id == '' ) && ( $asset->assigned_to == '0' )) {
                    $row[] = Lang::get( 'general.pending' );
                } elseif ($asset->assetstatus) {
                    $row[] = $asset->assetstatus->name;
                } else {
                    $row[] = '';
                }
            }
            if (e( Input::get( 'warranty' ) ) == '1') {
                if ($asset->warranty_months) {
                    $row[] = $asset->warranty_months;
                    $row[] = $asset->warrantee_expires();
                } else {
                    $row[] = '';
                    $row[] = '';
                }
            }
            if (e( Input::get( 'depreciation' ) ) == '1') {
                $depreciation = $asset->getDepreciatedValue();
                $row[]        = '"' . number_format( $asset->purchase_cost ) . '"';
                $row[]        = '"' . number_format( $depreciation ) . '"';
                $row[]        = '"' . number_format( $asset->purchase_cost - $depreciation ) . '"';
            }
            $rows[] = implode( $row, ',' );
        }

        // spit out a csv
        if (array_filter( $rows )) {
            $csv      = implode( $rows, "\n" );
            $response = Response::make( $csv, 200 );
            $response->header( 'Content-Type', 'text/csv' );
            $response->header( 'Content-disposition', 'attachment;filename=report.csv' );

            return $response;
        } else {
            return Redirect::to( "reports/custom" )
                           ->with( 'error', Lang::get( 'admin/reports/message.error' ) );
        }
    }

    /**
     * getImprovementsReport
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function getAssetMaintenancesReport()
    {
        // Grab all the improvements
        $assetMaintenances = \AssetMaintenance::with( 'asset', 'supplier', 'asset.company' )
                                              ->orderBy( 'created_at', 'DESC' )
                                              ->get();

        return View::make( 'backend/reports/asset_maintenances', compact( 'assetMaintenances' ) );

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
        $assetMaintenances = AssetMaintenance::with( 'asset', 'supplier' )
                                             ->orderBy( 'created_at', 'DESC' )
                                             ->get();

        $rows = [ ];

        $header = [
            Lang::get( 'admin/asset_maintenances/table.asset_name' ),
            Lang::get( 'admin/asset_maintenances/table.supplier_name' ),
            Lang::get( 'admin/asset_maintenances/form.asset_maintenance_type' ),
            Lang::get( 'admin/asset_maintenances/form.title' ),
            Lang::get( 'admin/asset_maintenances/form.start_date' ),
            Lang::get( 'admin/asset_maintenances/form.completion_date' ),
            Lang::get( 'admin/asset_maintenances/form.asset_maintenance_time' ),
            Lang::get( 'admin/asset_maintenances/form.cost' )
        ];

        $header = array_map( 'trim', $header );
        $rows[] = implode( $header, ',' );

        foreach ($assetMaintenances as $assetMaintenance) {
            $row   = [ ];
            $row[] = str_replace( ',', '', $assetMaintenance->asset->name );
            $row[] = str_replace( ',', '', $assetMaintenance->supplier->name );
            $row[] = $assetMaintenance->improvement_type;
            $row[] = $assetMaintenance->title;
            $row[] = $assetMaintenance->start_date;
            $row[] = $assetMaintenance->completion_date;
            if (is_null( $assetMaintenance->asset_maintenance_time )) {
                $improvementTime = intval( Carbon::now()
                                                 ->diffInDays( Carbon::parse( $assetMaintenance->start_date ) ) );
            } else {
                $improvementTime = intval( $assetMaintenance->asset_maintenance_time );
            }
            $row[]  = $improvementTime;
            $row[]  = Lang::get( 'general.currency' ) . number_format( $assetMaintenance->cost, 2 );
            $rows[] = implode( $row, ',' );
        }

        // spit out a csv
        $csv      = implode( $rows, "\n" );
        $response = Response::make( $csv, 200 );
        $response->header( 'Content-Type', 'text/csv' );
        $response->header( 'Content-disposition', 'attachment;filename=report.csv' );

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
        $assetsForReport = Asset::notYetAccepted()->with( 'company' )->get();

        return View::make( 'backend/reports/unaccepted_assets', compact( 'assetsForReport' ) );
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
        $assetsForReport = Actionlog::whereIn( 'id', $this->getAssetsNotAcceptedYet() )
                                    ->get();

        $rows = [ ];

        $header = [
            Lang::get( 'general.category' ),
            Lang::get( 'admin/hardware/form.model' ),
            Lang::get( 'admin/hardware/form.name' ),
            Lang::get( 'admin/hardware/table.asset_tag' ),
            Lang::get( 'admin/hardware/table.checkoutto' ),
        ];

        $header = array_map( 'trim', $header );
        $rows[] = implode( $header, ',' );

        foreach ($assetsForReport as $assetItem) {
            $row    = [ ];
            $row[]  = str_replace( ',', '', $assetItem->assetlog->model->category->name );
            $row[]  = str_replace( ',', '', $assetItem->assetlog->model->name );
            $row[]  = str_replace( ',', '', $assetItem->assetlog->showAssetName() );
            $row[]  = str_replace( ',', '', $assetItem->assetlog->asset_tag );
            $row[]  = str_replace( ',', '', $assetItem->assetlog->assigneduser->fullName() );
            $rows[] = implode( $row, ',' );
        }

        // spit out a csv
        $csv      = implode( $rows, "\n" );
        $response = Response::make( $csv, 200 );
        $response->header( 'Content-Type', 'text/csv' );
        $response->header( 'Content-disposition', 'attachment;filename=report.csv' );

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
    protected function getCheckedOutAssetsRequiringAcceptance( $modelsInCategoriesThatRequireAcceptance )
    {
        $assets = Asset::deployed()
                        ->inModelList( $modelsInCategoriesThatRequireAcceptance )
                        ->select( 'id' )
                        ->get()
                        ->toArray();

        return array_pluck( $assets, 'id' );
    }

    /**
     * getModelsInCategoriesThatRequireAcceptance
     *
     * @param $assetCategoriesRequiringAcceptance
     *
     * @return array
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    protected function getModelsInCategoriesThatRequireAcceptance( $assetCategoriesRequiringAcceptance )
    {

        return array_pluck( Model::inCategory( $assetCategoriesRequiringAcceptance )
                                 ->select( 'id' )
                                 ->get()
                                 ->toArray(), 'id' );
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

        return array_pluck( Category::requiresAcceptance()
                                    ->select( 'id' )
                                    ->get()
                                    ->toArray(), 'id' );
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
            $this->getModelsInCategoriesThatRequireAcceptance( $this->getCategoriesThatRequireAcceptance() )
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
