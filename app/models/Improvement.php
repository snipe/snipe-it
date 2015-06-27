<?php

    use Illuminate\Database\Eloquent\SoftDeletingTrait;

    class Improvement extends Elegant
    {

        use SoftDeletingTrait;
        protected $dates = [ 'deleted_at', 'start_date', 'completion_date' ];
        protected $table = 'improvements';

        // Declaring rules for form validation
        protected $rules = [
            'asset_id'         => 'required|integer',
            'improvement_type' => 'required|in:Maintenance,Repair,Upgrade',
            'title'            => 'required|max:100',
            'is_warranty'      => 'boolean',
            'start_date'       => 'required|date_format:Y-m-d',
            'completion_date'  => 'date_format:Y-m-d',
            'notes'            => 'string',
            'cost'             => 'numeric'
        ];

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
    }