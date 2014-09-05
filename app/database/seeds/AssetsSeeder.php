<?php
class AssetsSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $asset = array();

        $date = new DateTime;

        // Pending (status_id is null, assigned_to = 0)
        $asset[] = array(
            'name'      	=> 'Macbook Pro Laptop',
            'asset_tag'         => 'L4-85409',
            'model_id'          => 1,
            'serial'      	=> 'WS90585666669',
            'purchase_date'     => '2013-10-02',
            'purchase_cost'     => '2435.99',
            'order_number'      => '987698576946',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 1,
            'assigned_to' 	=> 0,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'		=> '1',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> NULL,
            'depreciate' 	=> '0',
        );


        $asset[] = array(
            'name'      	=> 'Macbook Pro Laptop',
            'asset_tag'         => 'L4-85444',
            'model_id'          => 1,
            'serial'      	=> 'WS905823226672',
            'purchase_date'     => '2013-10-02',
            'purchase_cost'     => '2435.99',
            'order_number'      => '987698576946',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 1,
            'assigned_to' 	=> 2,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'         => '3',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> 24,
            'depreciate' 	=> '48',
        );


        // RTD (status_id =0, assigned_to = 0)
        $asset[] = array(
            'name'      	=> 'Macbook Pro Laptop',
            'asset_tag'         => 'L4-85586',
            'model_id'          => 2,
            'serial'      	=> 'WS905869046069',
            'purchase_date'     => '2013-10-02',
            'purchase_cost'     => '2435.99',
            'order_number'      => '987698576946',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 1,
            'assigned_to' 	=> 1,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'         => '2',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> 12,
            'depreciate' 	=> '48',
        );

        // RTD (status_id =0, assigned_to = 0)
        $asset[] = array(
            'name'      	=> 'Main File Server',
            'asset_tag'         => 'L4-85212',
            'model_id'          => 3,
            'serial'      	=> 'Z6454-23850',
            'purchase_date'     => '2012-01-02',
            'purchase_cost'     => '1999.99',
            'order_number'      => '657756',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 1,
            'assigned_to' 	=> 0,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'         => '2',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> 36,
            'depreciate' 	=> '48',
        );

        // RTD (status_id =0, assigned_to = 0)
        $asset[] = array(
            'name'      	=> 'Office shared printer',
            'asset_tag'         => 'L4-85108',
            'model_id'          => 6,
            'serial'      	=> 'LJP90786801',
            'purchase_date'     => '2012-01-02',
            'purchase_cost'     => '699.99',
            'order_number'      => '657756',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 2,
            'assigned_to' 	=> 0,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'         => '3',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> 12,
            'depreciate' 	=> '48',
        );


        // Deployed (status_id =0, assigned_to > 0)
        $asset[] = array(
            'name'      	=> 'Office LAN Switch 1',
            'asset_tag'         => 'L4-85265',
            'model_id'          => 4,
            'serial'      	=> 'WS8789798Q',
            'purchase_date'     => '2012-01-02',
            'purchase_cost'     => '1999.99',
            'order_number'      => '657756',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 2,
            'assigned_to' 	=> 0,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'         => '3',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> NULL,
            'depreciate' 	=> '0',
        );

        // Deployed (status_id =0, assigned_to > 0)
        $asset[] = array(
            'name'      	=> 'Office LAN Switch 2',
            'asset_tag'         => 'L4-85291',
            'model_id'          => 4,
            'serial'      	=> 'WS8908089L',
            'purchase_date'     => '2012-01-02',
            'purchase_cost'     => '1999.99',
            'order_number'      => '657756',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 2,
            'assigned_to' 	=> 0,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'         => '4',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> NULL,
            'depreciate' 	=> '0',
        );

        // Undeployable (status_id > 0, assigned_to = 0)
        $asset[] = array(
            'name'      	=> 'External Monitor 22-inch',
            'asset_tag'         => 'L4-85755',
            'model_id'          => 5,
            'serial'      	=> 'ZN5R560331',
            'purchase_date'     => '2012-01-02',
            'purchase_cost'     => '1999.99',
            'order_number'      => '657756',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 2,
            'assigned_to' 	=> 2,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'         => '3',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> NULL,
            'depreciate' 	=> '0',
        );

        // Undeployable (status_id > 0, assigned_to = 0)
        $asset[] = array(
            'name'      	=> 'Thinkpad X301 Laptop',
            'asset_tag'         => 'L4-85411',
            'model_id'          => 7,
            'serial'      	=> 'X878439088',
            'purchase_date'     => '2012-01-02',
            'purchase_cost'     => '1999.99',
            'order_number'      => '657756',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 1,
            'assigned_to' 	=> 0,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'         => '2',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> NULL,
            'depreciate' 	=> '0',
        );

        // Undeployable (status_id > 0, assigned_to = 0)
        $asset[] = array(
            'name'      	=> 'Thinkpad X301 Laptop',
            'asset_tag'         => 'L4-85463',
            'model_id'          => 7,
            'serial'      	=> 'X56564879',
            'purchase_date'     => '2012-01-02',
            'purchase_cost'     => '1999.99',
            'order_number'      => '657756',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 1,
            'assigned_to' 	=> 0,
            'physical' 		=> 1,
            'archived' 		=> 1,
            'status_id'         => '5',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> NULL,
            'depreciate' 	=> '0',
        );

        // Undeployable (status_id > 0, assigned_to = 0)
        $asset[] = array(
            'name'      	=> 'Thinkpad X301 Laptop',
            'asset_tag'         => 'L4-85540',
            'model_id'          => 7,
            'serial'      	=> 'X6597782',
            'purchase_date'     => '2012-01-02',
            'purchase_cost'     => '1999.99',
            'order_number'      => '657756',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 1,
            'assigned_to' 	=> 0,
            'physical' 		=> 1,
            'archived' 		=> 1,
            'status_id'         => '3',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> NULL,
            'depreciate' 	=> '0',
        );

        // Almost out of warranty example
        $asset[] = array(
            'name'      	=> 'Thinkpad X1 Laptop',
            'asset_tag'         => 'L4-85536',
            'model_id'          => 8,
            'serial'      	=> 'X4548897',
            'purchase_date'     => '2011-12-20',
            'purchase_cost'     => '699.99',
            'order_number'      => '657756',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id' 		=> 2,
            'assigned_to' 	=> 2,
            'physical' 		=> 1,
            'archived' 		=> 0,
            'status_id'         => '3',
            'notes'		=> '',
            'deleted_at' 	=> NULL,
            'archived'          => '0',
            'warranty_months' 	=> '24',
            'depreciate' 	=> '0',
        );



        // Delete all the old data
        DB::table('assets')->truncate();

        // Insert the new posts
        Asset::insert($asset);
    }

}
