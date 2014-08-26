<?php
class DefaultsSeeder extends Seeder
{
    public function run()
    {

        // Initialize empty array
        $default = array();

        $date = new DateTime;
        
        $default[] = array(
            'name'      		=> 'entity',
            'table_name'     	 	=> 'locations',
            'column_name'               => 'entity_id',
            'value'      		=> '1',
            'source_table'      	=> 'entities',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        $default[] = array(
            'name'      		=> 'location',
            'table_name'     	 	=> 'users',
            'column_name'               => 'location_id',
            'value'      		=> '1',
            'source_table'      	=> 'locations',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        $default[] = array(
            'name'      		=> 'depr_software',
            'table_name'     	 	=> 'licenses',
            'column_name'               => 'depreciation_id',
            'value'      		=> '2',
            'source_table'      	=> 'depreciations',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        $default[] = array(
            'name'      		=> 'depr_asset',
            'table_name'     	 	=> 'assets',
            'column_name'               => 'depreciation_id',
            'value'      		=> '1',
            'source_table'      	=> 'depreciations',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        $default[] = array(
            'name'      		=> 'asset_status',
            'table_name'     	 	=> 'assets',
            'column_name'               => 'stats_id',
            'value'      		=> '1',
            'source_table'      	=> 'status_labels',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        $default[] = array(
            'name'      		=> 'supplier_software',
            'table_name'     	 	=> 'licenses',
            'column_name'               => 'supplier_id',
            'value'      		=> '1',
            'source_table'      	=> 'suppliers',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        $default[] = array(
            'name'      		=> 'supplier_asset',
            'table_name'     	 	=> 'assets',
            'column_name'               => 'supplier_id',
            'value'      		=> '1',
            'source_table'      	=> 'suppliers',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );
        
        // Delete all the old data
        DB::table('defaults')->truncate();

        // Insert the new posts
        Default::insert($default);
    }

}

