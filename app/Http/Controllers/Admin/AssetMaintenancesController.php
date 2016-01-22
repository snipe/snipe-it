<?php

    namespace Controllers\Admin;

    use AdminController;
    use AssetMaintenance;
    use Carbon\Carbon;
    use Company;
    use DB;
    use Input;
    use Lang;
    use Log;
    use Mail;
    use Redirect;
    use Response;
    use Sentry;
    use Slack;
    use Str;
    use Supplier;
    use TCPDF;
    use Validator;
    use View;
    use Setting;
    use Asset;

    class AssetMaintenancesController extends AdminController
    {
        private static function getInsufficientPermissionsRedirect()
        {
            return Redirect::to( 'admin/asset_maintenances')
                ->with('error', Lang::get( 'general.insufficient_permissions' ) );
        }

        /**
         * getIndex
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function getIndex()
        {

            return View::make( 'backend/asset_maintenances/index' );
        }

        /**
         * getDatatable
         * Gets the datatable for the index page
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */

     public function getDatatable()
     {
        $maintenances = AssetMaintenance::with('asset','supplier','asset.company')
         ->whereNull('deleted_at');

         if (Input::has('search')) {
             $maintenances = $maintenances->TextSearch(e(Input::get('search')));
         }

         if (Input::has('offset')) {
             $offset = e(Input::get('offset'));
         } else {
             $offset = 0;
         }

         if (Input::has('limit')) {
             $limit = e(Input::get('limit'));
         } else {
             $limit = 50;
         }

         $allowed_columns = ['id','title','asset_maintenance_time','asset_maintenance_type','cost','start_date','completion_date','notes'];
         $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
         $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

         $maintenances->orderBy($sort, $order);

         $maintenancesCount = $maintenances->count();
         $maintenances = $maintenances->skip($offset)->take($limit)->get();

         $rows = array();
         $settings = Setting::getSettings();

         foreach($maintenances as $maintenance) {

            $actions = '<nobr><a href="'.route('update/asset_maintenance', $maintenance->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/asset_maintenance', $maintenance->id).'" data-content="'.Lang::get('admin/asset_maintenances/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($maintenance->title).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></nobr>';

            if (($maintenance->cost) && ($maintenance->asset->assetloc) &&  ($maintenance->asset->assetloc->currency!='')) {
                $maintenance_cost = $maintenance->asset->assetloc->currency.$maintenance->cost;
            } else {
                $maintenance_cost = $settings->default_currency.$maintenance->cost;
            }

            $company = $maintenance->asset->company;

             $rows[] = array(
                 'id'            => $maintenance->id,
                 'asset_name'    =>  link_to('/hardware/'.$maintenance->asset->id.'/view', $maintenance->asset->showAssetName()) ,
                 'title'         => $maintenance->title,
                 'notes'         => $maintenance->notes,
                 'supplier'      => $maintenance->supplier->name,
                 'cost'          => $maintenance_cost,
                 'asset_maintenance_type'          => e($maintenance->asset_maintenance_type),
                 'start_date'         => $maintenance->start_date,
                 'asset_maintenance_time'          => $maintenance->asset_maintenance_time,
                 'completion_date'     => $maintenance->completion_date,
                 'actions'       => $actions,
                 'companyName'   => is_null($company) ? '' : $company->name
             );
         }

         $data = array('total' => $maintenancesCount, 'rows' => $rows);

         return $data;

     }

        /**
         * getCreate
         *
         * @param null $assetId
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function getCreate( $assetId = null )
        {
            // Prepare Asset Maintenance Type List
            $assetMaintenanceType = [
                                        '' => 'Select an asset maintenance type',
                                    ] + AssetMaintenance::getImprovementOptions();
            // Mark the selected asset, if it came in
            $selectedAsset = $assetId;
            // Get the possible assets using a left join to get a list of assets and some other helpful info
            $asset               = Company::scopeCompanyables( DB::table( 'assets' ), 'assets.company_id' )
                                     ->leftJoin( 'users', 'users.id', '=', 'assets.assigned_to' )
                                     ->leftJoin( 'models', 'assets.model_id', '=', 'models.id' )
                                     ->select( 'assets.id', 'assets.name', 'first_name', 'last_name', 'asset_tag',
                                         DB::raw( 'concat(first_name," ",last_name) as full_name, assets.id as id, models.name as modelname' ) )
                                     ->whereNull( 'assets.deleted_at' )
                                     ->get();
            $asset_array         = json_decode( json_encode( $asset ), true );
            $asset_element[ '' ] = 'Please select an asset';
            // Build a list out of the data results
            for ($x = 0; $x < count( $asset_array ); $x++) {

                if ($asset_array[ $x ][ 'full_name' ] != '') {
                    $full_name = ' (' . $asset_array[ $x ][ 'full_name' ] . ') ' . $asset_array[ $x ][ 'modelname' ];
                } else {
                    $full_name = ' (Unassigned) ' . $asset_array[ $x ][ 'modelname' ];
                }
                $asset_element[ $asset_array[ $x ][ 'id' ] ] =
                    $asset_array[ $x ][ 'asset_tag' ] . ' - ' . $asset_array[ $x ][ 'name' ] . $full_name;
            }
            // Get Supplier List
            $supplier_list = [ '' => 'Select Supplier' ] + Supplier::orderBy( 'name', 'asc' )
                                                                   ->lists( 'name', 'id' );

            // Render the view
            return View::make( 'backend/asset_maintenances/edit' )
                       ->with( 'asset_list', $asset_element )
                       ->with( 'selectedAsset', $selectedAsset )
                       ->with( 'supplier_list', $supplier_list )
                       ->with( 'assetMaintenanceType', $assetMaintenanceType )
                       ->with( 'assetMaintenance', new AssetMaintenance );
        }

        /**
         * postCreate
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function postCreate()
        {

            // get the POST data
            $new = Input::all();

            // create a new model instance
            $assetMaintenance = new AssetMaintenance();

            // attempt validation
            if ($assetMaintenance->validate( $new )) {

                if (e( Input::get( 'supplier_id' ) ) == '') {
                    $assetMaintenance->supplier_id = null;
                } else {
                    $assetMaintenance->supplier_id = e( Input::get( 'supplier_id' ) );
                }

                if (e( Input::get( 'is_warranty' ) ) == '') {
                    $assetMaintenance->is_warranty = 0;
                } else {
                    $assetMaintenance->is_warranty = e( Input::get( 'is_warranty' ) );
                }

                if (e( Input::get( 'cost' ) ) == '') {
                    $assetMaintenance->cost = '';
                } else {
                    $assetMaintenance->cost = ParseFloat( e( Input::get( 'cost' ) ) );
                }

                if (e( Input::get( 'notes' ) ) == '') {
                    $assetMaintenance->notes = null;
                } else {
                    $assetMaintenance->notes = e( Input::get( 'notes' ) );
                }

                $asset = Asset::find( e( Input::get( 'asset_id' ) ) );

                if (!Company::isCurrentUserHasAccess($asset)) {
                    return static::getInsufficientPermissionsRedirect();
                }

                // Save the asset maintenance data
                $assetMaintenance->asset_id               = e( Input::get( 'asset_id' ) );
                $assetMaintenance->asset_maintenance_type = e( Input::get( 'asset_maintenance_type' ) );
                $assetMaintenance->title                  = e( Input::get( 'title' ) );
                $assetMaintenance->start_date             = e( Input::get( 'start_date' ) );
                $assetMaintenance->completion_date        = e( Input::get( 'completion_date' ) );

                if (( $assetMaintenance->completion_date == "" )
                    || ( $assetMaintenance->completion_date == "0000-00-00" )
                ) {
                    $assetMaintenance->completion_date = null;
                }

                if (( $assetMaintenance->completion_date !== "" )
                    && ( $assetMaintenance->completion_date !== "0000-00-00" )
                    && ( $assetMaintenance->start_date !== "" )
                    && ( $assetMaintenance->start_date !== "0000-00-00" )
                ) {
                    $startDate                                = Carbon::parse( $assetMaintenance->start_date );
                    $completionDate                           = Carbon::parse( $assetMaintenance->completion_date );
                    $assetMaintenance->asset_maintenance_time = $completionDate->diffInDays( $startDate );
                }

                // Was the asset maintenance created?
                if ($assetMaintenance->save()) {

                    // Redirect to the new asset maintenance page
                    return Redirect::to( "admin/asset_maintenances" )
                                   ->with( 'success', Lang::get( 'admin/asset_maintenances/message.create.success' ) );
                }
            } else {
                // failure
                $errors = $assetMaintenance->errors();

                return Redirect::back()
                               ->withInput()
                               ->withErrors( $errors );
            }

            // Redirect to the asset maintenance create page
            return Redirect::to( 'admin/asset_maintenances/edit' )
                           ->with( 'error', Lang::get( 'admin/asset_maintenances/message.create.error' ) )
                           ->with( 'assetMaintenance', new AssetMaintenance );

        }

        /**
         * getEdit
         *
         * @param null $assetMaintenanceId
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function getEdit( $assetMaintenanceId = null )
        {
            // Check if the asset maintenance exists
            if (is_null( $assetMaintenance = AssetMaintenance::find( $assetMaintenanceId ) )) {
                // Redirect to the improvement management page
                return Redirect::to( 'admin/asset_maintenances' )
                               ->with( 'error', Lang::get( 'admin/asset_maintenances/message.not_found' ) );
            }
            else if (!Company::isCurrentUserHasAccess( $assetMaintenance->asset )) {
                return static::getInsufficientPermissionsRedirect();
            }

            if ($assetMaintenance->completion_date == '0000-00-00') {
                $assetMaintenance->completion_date = null;
            }

            if ($assetMaintenance->start_date == '0000-00-00') {
                $assetMaintenance->start_date = null;
            }

            if ($assetMaintenance->cost == '0.00') {
                $assetMaintenance->cost = null;
            }

            // Prepare Improvement Type List
            $assetMaintenanceType = [
                                        '' => 'Select an improvement type',
                                    ] + AssetMaintenance::getImprovementOptions();

            // Get the possible assets using a left join to get a list of assets and some other helpful info
            $asset               = Company::scopeCompanyables( DB::table( 'assets' ), 'assets.company_id' )
                                     ->leftJoin( 'users', 'users.id', '=', 'assets.assigned_to' )
                                     ->leftJoin( 'models', 'assets.model_id', '=', 'models.id' )
                                     ->select( 'assets.id', 'assets.name', 'first_name', 'last_name', 'asset_tag',
                                         DB::raw( 'concat(first_name," ",last_name) as full_name, assets.id as id, models.name as modelname' ) )
                                     ->whereNull( 'assets.deleted_at' )
                                     ->get();
            $asset_array         = json_decode( json_encode( $asset ), true );
            $asset_element[ '' ] = 'Please select an asset';
            // Build a list out of the data results
            for ($x = 0; $x < count( $asset_array ); $x++) {

                if ($asset_array[ $x ][ 'full_name' ] != '') {
                    $full_name = ' (' . $asset_array[ $x ][ 'full_name' ] . ') ' . $asset_array[ $x ][ 'modelname' ];
                } else {
                    $full_name = ' (Unassigned) ' . $asset_array[ $x ][ 'modelname' ];
                }
                $asset_element[ $asset_array[ $x ][ 'id' ] ] =
                    $asset_array[ $x ][ 'asset_tag' ] . ' - ' . $asset_array[ $x ][ 'name' ] . $full_name;
            }
            // Get Supplier List
            $supplier_list = [ '' => 'Select Supplier' ] + Supplier::orderBy( 'name', 'asc' )
                                                                   ->lists( 'name', 'id' );

            // Render the view
            return View::make( 'backend/asset_maintenances/edit' )
                       ->with( 'asset_list', $asset_element )
                       ->with( 'selectedAsset', null )
                       ->with( 'supplier_list', $supplier_list )
                       ->with( 'assetMaintenanceType', $assetMaintenanceType )
                       ->with( 'assetMaintenance', $assetMaintenance );

        }

        /**
         * postEdit
         *
         * @param null $assetMaintenanceId
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function postEdit( $assetMaintenanceId = null )
        {

            // get the POST data
            $new = Input::all();

            // Check if the asset maintenance exists
            if (is_null( $assetMaintenance = AssetMaintenance::find( $assetMaintenanceId ) )) {
                // Redirect to the asset maintenance management page
                return Redirect::to( 'admin/asset_maintenances' )
                               ->with( 'error', Lang::get( 'admin/asset_maintenances/message.not_found' ) );
            }
            else if (!Company::isCurrentUserHasAccess( $assetMaintenance->asset )) {
                return static::getInsufficientPermissionsRedirect();
            }

            // attempt validation
            if ($assetMaintenance->validate( $new )) {

                if (e( Input::get( 'supplier_id' ) ) == '') {
                    $assetMaintenance->supplier_id = null;
                } else {
                    $assetMaintenance->supplier_id = e( Input::get( 'supplier_id' ) );
                }

                if (e( Input::get( 'is_warranty' ) ) == '') {
                    $assetMaintenance->is_warranty = 0;
                } else {
                    $assetMaintenance->is_warranty = e( Input::get( 'is_warranty' ) );
                }

                if (e( Input::get( 'cost' ) ) == '') {
                    $assetMaintenance->cost = '';
                } else {
                    $assetMaintenance->cost = ParseFloat( e( Input::get( 'cost' ) ) );
                }

                if (e( Input::get( 'notes' ) ) == '') {
                    $assetMaintenance->notes = null;
                } else {
                    $assetMaintenance->notes = e( Input::get( 'notes' ) );
                }

                $asset = Asset::find( e( Input::get( 'asset_id' ) ) );

                if (!Company::isCurrentUserHasAccess($asset)) {
                    return static::getInsufficientPermissionsRedirect();
                }

                // Save the asset maintenance data
                $assetMaintenance->asset_id               = e( Input::get( 'asset_id' ) );
                $assetMaintenance->asset_maintenance_type = e( Input::get( 'asset_maintenance_type' ) );
                $assetMaintenance->title                  = e( Input::get( 'title' ) );
                $assetMaintenance->start_date             = e( Input::get( 'start_date' ) );
                $assetMaintenance->completion_date        = e( Input::get( 'completion_date' ) );

                if (( $assetMaintenance->completion_date == "" )
                    || ( $assetMaintenance->completion_date == "0000-00-00" )
                ) {
                    $assetMaintenance->completion_date = null;
                    if (( $assetMaintenance->asset_maintenance_time !== 0 )
                        || ( !is_null( $assetMaintenance->asset_maintenance_time ) )
                    ) {
                        $assetMaintenance->asset_maintenance_time = null;
                    }
                }

                if (( $assetMaintenance->completion_date !== "" )
                    && ( $assetMaintenance->completion_date !== "0000-00-00" )
                    && ( $assetMaintenance->start_date !== "" )
                    && ( $assetMaintenance->start_date !== "0000-00-00" )
                ) {
                    $startDate                                = Carbon::parse( $assetMaintenance->start_date );
                    $completionDate                           = Carbon::parse( $assetMaintenance->completion_date );
                    $assetMaintenance->asset_maintenance_time = $completionDate->diffInDays( $startDate );
                }

                // Was the asset maintenance created?
                if ($assetMaintenance->save()) {

                    // Redirect to the new asset maintenance page
                    return Redirect::to( "admin/asset_maintenances" )
                                   ->with( 'success', Lang::get( 'admin/asset_maintenances/message.create.success' ) );
                }
            } else {
                // failure
                $errors = $assetMaintenance->errors();

                return Redirect::back()
                               ->withInput()
                               ->withErrors( $errors );
            }

            // Redirect to the improvement create page
            return Redirect::to( 'admin/asset_maintenances/edit' )
                           ->with( 'error', Lang::get( 'admin/asset_maintenances/message.create.error' ) )
                           ->with( 'assetMaintenance', $assetMaintenance );

        }

        /**
         * getDelete
         *
         * @param $assetMaintenanceId
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function getDelete( $assetMaintenanceId )
        {
            // Check if the asset maintenance exists
            if (is_null( $assetMaintenance = AssetMaintenance::find( $assetMaintenanceId ) )) {
                // Redirect to the asset maintenance management page
                return Redirect::to( 'admin/asset_maintenances' )
                               ->with( 'error', Lang::get( 'admin/asset_maintenances/message.not_found' ) );
            }
            else if (!Company::isCurrentUserHasAccess( $assetMaintenance->asset )) {
                return static::getInsufficientPermissionsRedirect();
            }

            // Delete the asset maintenance
            $assetMaintenance->delete();

            // Redirect to the asset_maintenance management page
            return Redirect::to( 'admin/asset_maintenances' )
                           ->with( 'success', Lang::get( 'admin/asset_maintenances/message.delete.success' ) );
        }

        /**
         * getView
         *
         * @param $assetMaintenanceId
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function getView( $assetMaintenanceId )
        {
            // Check if the asset maintenance exists
            if (is_null( $assetMaintenance = AssetMaintenance::find( $assetMaintenanceId ) )) {
                // Redirect to the asset maintenance management page
                return Redirect::to( 'admin/asset_maintenances' )
                               ->with( 'error', Lang::get( 'admin/asset_maintenances/message.not_found' ) );
            }
            else if (!Company::isCurrentUserHasAccess( $assetMaintenance->asset )) {
                return static::getInsufficientPermissionsRedirect();
            }

            return View::make( 'backend/asset_maintenances/view')->with('assetMaintenance', $assetMaintenance);
        }

    }
