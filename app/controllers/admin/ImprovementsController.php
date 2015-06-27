<?php

    namespace Controllers\Admin;

    use AdminController;
    use Carbon\Carbon;
    use Datatable;
    use DB;
    use Improvement;
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

    class ImprovementsController extends AdminController
    {

        /**
         * getIndex
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function getIndex()
        {

            return View::make( 'backend/improvements/index' );
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

            $improvements = Improvement::orderBy( 'created_at', 'DESC' )
                                       ->get();

            $actions = new \Chumper\Datatable\Columns\FunctionColumn( 'actions', function ( $improvements ) {

                return '<a href="' . route( 'update/improvement', $improvements->id )
                       . '" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'
                       . route( 'delete/improvement', $improvements->id ) . '" data-content="'
                       . Lang::get( 'admin/improvements/message.delete.confirm' ) . '" data-title="'
                       . Lang::get( 'general.delete' ) . ' ' . htmlspecialchars( $improvements->title )
                       . '?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            } );

            return Datatable::collection( $improvements )
                            ->addColumn( 'asset', function ( $improvements ) {

                                return link_to( '/hardware/' . $improvements->asset_id . '/view',
                                    mb_strimwidth( $improvements->asset->name, 0, 50, "..." ) );
                            } )
                            ->addColumn( 'supplier', function ( $improvements ) {

                                return link_to( '/admin/settings/suppliers/' . $improvements->supplier_id . '/view',
                                    mb_strimwidth( $improvements->supplier->name, 0, 50, "..." ) );
                            } )
                            ->addColumn( 'improvement_type', function ( $improvements ) {

                                return $improvements->improvement_type;
                            } )
                            ->addColumn( 'title', function ( $improvements ) {

                                return link_to( '/admin/improvements/' . $improvements->id . '/view',
                                    mb_strimwidth( $improvements->title, 0, 50, "..." ) );
                            } )
                            ->addColumn( 'start_date', function ( $improvements ) {

                                return $improvements->start_date;
                            } )
                            ->addColumn( 'completion_date', function ( $improvements ) {

                                return $improvements->completion_date;
                            } )
                            ->addColumn( 'cost', function ( $improvements ) {

                                return sprintf( Lang::get( 'general.currency' ) . '%01.2f', $improvements->cost );
                            } )
                            ->addColumn( $actions )
                            ->searchColumns( 'asset', 'supplier', 'improvement_type', 'title', 'start_date',
                                'completion_date', 'cost', 'actions' )
                            ->orderColumns( 'asset', 'supplier', 'improvement_type', 'title', 'start_date',
                                'completion_date', 'cost', 'actions' )
                            ->make();
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

            // Prepare Improvement Type List
            $improvementType = [
                ''            => 'Select an improvement type',
                'Maintenance' => 'Maintenance',
                'Repair'      => 'Repair',
                'Upgrade'     => 'Upgrade'
            ];
            // Mark the selected asset, if it came in
            $selectedAsset = $assetId;
            // Get the possible assets using a left join to get a list of assets and some other helpful info
            $asset               = DB::table( 'assets' )
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
            return View::make( 'backend/improvements/edit' )
                       ->with( 'asset_list', $asset_element )
                       ->with( 'selectedAsset', $selectedAsset )
                       ->with( 'supplier_list', $supplier_list )
                       ->with( 'improvementType', $improvementType )
                       ->with( 'improvement', new Improvement );
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
            $improvement = new Improvement();

            // attempt validation
            if ($improvement->validate( $new )) {

                if (e( Input::get( 'supplier_id' ) ) == '') {
                    $improvement->supplier_id = null;
                } else {
                    $improvement->supplier_id = e( Input::get( 'supplier_id' ) );
                }

                if (e( Input::get( 'is_warranty' ) ) == '') {
                    $improvement->is_warranty = 0;
                } else {
                    $improvement->is_warranty = e( Input::get( 'is_warranty' ) );
                }

                if (e( Input::get( 'cost' ) ) == '') {
                    $improvement->cost = '';
                } else {
                    $improvement->cost = ParseFloat( e( Input::get( 'cost' ) ) );
                }

                if (e( Input::get( 'notes' ) ) == '') {
                    $improvement->notes = null;
                } else {
                    $improvement->notes = e( Input::get( 'notes' ) );
                }

                // Save the improvement data
                $improvement->asset_id         = e( Input::get( 'asset_id' ) );
                $improvement->improvement_type = e( Input::get( 'improvement_type' ) );
                $improvement->title            = e( Input::get( 'title' ) );
                $improvement->start_date       = e( Input::get( 'start_date' ) );
                $improvement->completion_date  = e( Input::get( 'completion_date' ) );

                if (( $improvement->completion_date == "" ) || ( $improvement->completion_date == "0000-00-00" )) {
                    $improvement->completion_date = null;
                }

                // Was the improvement created?
                if ($improvement->save()) {

                    // Redirect to the new improvement page
                    return Redirect::to( "admin/improvements" )
                                   ->with( 'success', Lang::get( 'admin/improvements/message.create.success' ) );
                }
            } else {
                // failure
                $errors = $improvement->errors();

                return Redirect::back()
                               ->withInput()
                               ->withErrors( $errors );
            }

            // Redirect to the improvement create page
            return Redirect::to( 'admin/improvements/edit' )
                           ->with( 'error', Lang::get( 'admin/improvements/message.create.error' ) )
                           ->with( 'improvement', new Improvement );

        }

        public function getEdit( $improvementId = null )
        {

            // Check if the improvement exists
            if (is_null( $improvement = Improvement::find( $improvementId ) )) {
                // Redirect to the improvement management page
                return Redirect::to( 'admin/improvements' )
                               ->with( 'error', Lang::get( 'admin/improvements/message.not_found' ) );
            }

            if ($improvement->completion_date == '0000-00-00') {
                $improvement->completion_date = null;
            }

            if ($improvement->start_date == '0000-00-00') {
                $improvement->start_date = null;
            }

            if ($improvement->cost == '0.00') {
                $improvement->cost = null;
            }

            // Prepare Improvement Type List
            $improvementType = [
                ''            => 'Select an improvement type',
                'Maintenance' => 'Maintenance',
                'Repair'      => 'Repair',
                'Upgrade'     => 'Upgrade'
            ];

            // Get the possible assets using a left join to get a list of assets and some other helpful info
            $asset               = DB::table( 'assets' )
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
            return View::make( 'backend/improvements/edit' )
                       ->with( 'asset_list', $asset_element )
                       ->with( 'selectedAsset', null )
                       ->with( 'supplier_list', $supplier_list )
                       ->with( 'improvementType', $improvementType )
                       ->with( 'improvement', $improvement );

        }

        public function postEdit( $improvementId = null )
        {

            // get the POST data
            $new = Input::all();

            // Check if the improvement exists
            if (is_null( $improvement = Improvement::find( $improvementId ) )) {
                // Redirect to the improvement management page
                return Redirect::to( 'admin/improvements' )
                               ->with( 'error', Lang::get( 'admin/improvements/message.not_found' ) );
            }

            // attempt validation
            if ($improvement->validate( $new )) {

                if (e( Input::get( 'supplier_id' ) ) == '') {
                    $improvement->supplier_id = null;
                } else {
                    $improvement->supplier_id = e( Input::get( 'supplier_id' ) );
                }

                if (e( Input::get( 'is_warranty' ) ) == '') {
                    $improvement->is_warranty = 0;
                } else {
                    $improvement->is_warranty = e( Input::get( 'is_warranty' ) );
                }

                if (e( Input::get( 'cost' ) ) == '') {
                    $improvement->cost = '';
                } else {
                    $improvement->cost = ParseFloat( e( Input::get( 'cost' ) ) );
                }

                if (e( Input::get( 'notes' ) ) == '') {
                    $improvement->notes = null;
                } else {
                    $improvement->notes = e( Input::get( 'notes' ) );
                }

                // Save the improvement data
                $improvement->asset_id         = e( Input::get( 'asset_id' ) );
                $improvement->improvement_type = e( Input::get( 'improvement_type' ) );
                $improvement->title            = e( Input::get( 'title' ) );
                $improvement->start_date       = e( Input::get( 'start_date' ) );
                $improvement->completion_date  = e( Input::get( 'completion_date' ) );

                if (( $improvement->completion_date == "" ) || ( $improvement->completion_date == "0000-00-00" )) {
                    $improvement->completion_date = null;
                    if (( $improvement->improvement_time !== 0 ) || ( !is_null( $improvement->improvement_time ) )) {
                        $improvement->improvement_time = null;
                    }
                }

                if (( $improvement->completion_date !== "" ) && ( $improvement->completion_date !== "0000-00-00" )
                    && ( $improvement->start_date !== "" )
                    && ( $improvement->start_date !== "0000-00-00" )
                ) {
                    $startDate                     = Carbon::parse( $improvement->start_date );
                    $completionDate                = Carbon::parse( $improvement->completion_date );
                    $improvement->improvement_time = $completionDate->diffInDays( $startDate );
                }

                // Was the improvement created?
                if ($improvement->save()) {

                    // Redirect to the new improvement page
                    return Redirect::to( "admin/improvements" )
                                   ->with( 'success', Lang::get( 'admin/improvements/message.create.success' ) );
                }
            } else {
                // failure
                $errors = $improvement->errors();

                return Redirect::back()
                               ->withInput()
                               ->withErrors( $errors );
            }

            // Redirect to the improvement create page
            return Redirect::to( 'admin/improvements/edit' )
                           ->with( 'error', Lang::get( 'admin/improvements/message.create.error' ) )
                           ->with( 'improvement', new Improvement );

        }

        /**
         * getDelete
         *
         * @param $improvementId
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function getDelete( $improvementId )
        {

            // Check if the improvement exists
            if (is_null( $improvement = Improvement::find( $improvementId ) )) {
                // Redirect to the improvement management page
                return Redirect::to( 'admin/improvements' )
                               ->with( 'error', Lang::get( 'admin/improvements/message.not_found' ) );
            }
            // Delete the improvement
            $improvement->delete();

            // Redirect to the improvements management page
            return Redirect::to( 'admin/improvements' )
                           ->with( 'success', Lang::get( 'admin/improvements/message.delete.success' ) );
        }

        /**
         * getView
         *
         * @param $improvementId
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function getView( $improvementId )
        {

            // Check if the improvement exists
            if (is_null( $improvement = Improvement::find( $improvementId ) )) {
                // Redirect to the improvement management page
                return Redirect::to( 'admin/improvements' )
                               ->with( 'error', Lang::get( 'admin/improvements/message.not_found' ) );
            }

            return View::make( 'backend/improvements/view')->with('improvement', $improvement);
        }

    }