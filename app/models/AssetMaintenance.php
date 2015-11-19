<?php

    use Illuminate\Database\Eloquent\SoftDeletingTrait;
    use Illuminate\Support\Facades\Lang;

    class AssetMaintenance extends Elegant implements ICompanyableChild
    {
        use CompanyableChildTrait;
        use SoftDeletingTrait;

        protected $dates = [ 'deleted_at' ];
        protected $table = 'asset_maintenances';

        // Declaring rules for form validation
        protected $rules = [
            'asset_id'               => 'required|integer',
            'supplier_id'            => 'required|integer',
            'asset_maintenance_type' => 'required',
            'title'                  => 'required|max:100',
            'is_warranty'            => 'boolean',
            'start_date'             => 'required|date_format:Y-m-d',
            'completion_date'        => 'date_format:Y-m-d',
            'notes'                  => 'string',
            'cost'                   => 'numeric'
        ];

        public function getCompanyableParents()
        {
            return [ 'asset' ];
        }

        /**
         * getImprovementOptions
         *
         * @return array
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public static function getImprovementOptions()
        {

            return [
                Lang::get( 'admin/asset_maintenances/general.maintenance' ) => Lang::get( 'admin/asset_maintenances/general.maintenance' ),
                Lang::get( 'admin/asset_maintenances/general.repair' )      => Lang::get( 'admin/asset_maintenances/general.repair' ),
                Lang::get( 'admin/asset_maintenances/general.upgrade' )     => Lang::get( 'admin/asset_maintenances/general.upgrade' )
            ];
        }

        /**
         * asset
         * Get asset for this improvement
         *
         * @return mixed
         * @author  Vincent Sposato <vincent.sposato@gmail.com>
         * @version v1.0
         */
        public function asset()
        {

            return $this->belongsTo( 'Asset', 'asset_id' )
                        ->withTrashed();
        }

        public function supplier()
        {

            return $this->belongsTo( 'Supplier', 'supplier_id' )
                        ->withTrashed();
        }

        /**
         * -----------------------------------------------
         * BEGIN QUERY SCOPES
         * -----------------------------------------------
         **/

        /**
         * Query builder scope for Deleted assets
         *
         * @param  Illuminate\Database\Query\Builder $query Query builder instance
         *
         * @return Illuminate\Database\Query\Builder          Modified query builder
         */

        public function scopeDeleted( $query )
        {

            return $query->whereNotNull( 'deleted_at' );
        }

        /**
        * Query builder scope to search on text
        *
        * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
        * @param  text                              $search      Search term
        *
        * @return Illuminate\Database\Query\Builder          Modified query builder
        */
        public function scopeTextSearch($query, $search)
        {

             return $query->where(function($query) use ($search)
             {
                    $query->where('title', 'LIKE', '%'.$search.'%')
                    ->orWhere('notes', 'LIKE', '%'.$search.'%')
                    ->orWhere('asset_maintenance_type', 'LIKE', '%'.$search.'%')
                    ->orWhere('cost', 'LIKE', '%'.$search.'%')
                    ->orWhere('start_date', 'LIKE', '%'.$search.'%')
                    ->orWhere('completion_date', 'LIKE', '%'.$search.'%');
             });
        }
    }
