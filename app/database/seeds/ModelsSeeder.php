<?php

class ModelsSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $models = array();

        $date = new DateTime;
        $models[] = array(
            'name'      		=> 'MacBook Pro (13-inch, Mid 2012)',
            'manufacturer_id'           => '1',
            'category_id'               => '1',
            'modelno'      		=> 'MacBookPro9,2',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-3 day'),
            'depreciation_id'           => 1,
            'user_id'	 		=> 1,
            'eol' 			=> '36',
        );

        $models[] = array(
            'name'      		=> 'MacBook Pro (Retina, 13-inch, Early 2013)',
            'manufacturer_id'           => '1',
            'category_id'               => '1',
            'modelno'      		=> 'MacBookPro10,2',
            'created_at' 		=> $date->modify('-2 day'),
            'updated_at' 		=> $date,
            'depreciation_id'           => 1,
            'user_id' 			=> 1,
            'eol' 			=> '36',
        );

        $models[] = array(
            'name'      		=> 'DL360 G8 Server',
            'manufacturer_id'           => '10',
            'category_id'               => '9',
            'modelno'      		=> 'DL360 G8e Base',
            'created_at' 		=> $date->modify('-2 day'),
            'updated_at' 		=> $date,
            'depreciation_id'           => 1,
            'user_id' 			=> 1,
            'eol' 			=> '48',
        );

        $models[] = array(
            'name'     	 		=> 'Catalyst 2960-24PS',
            'manufacturer_id'           => '9',
            'category_id'               => '7',
            'modelno'      		=> 'WS2960-24-TS',
            'created_at' 		=> $date->modify('-2 day'),
            'updated_at' 		=> $date,
            'depreciation_id'           => 1,
            'user_id' 			=> 1,
            'eol' 			=> '36',
        );

        $models[] = array(
            'name'      		=> '22-inch T897',
            'manufacturer_id'           => '8',
            'category_id'               => '5',
            'modelno'      		=> '78FNCWC16B',
            'created_at' 		=> $date->modify('-2 day'),
            'updated_at' 		=> $date,
            'depreciation_id'           => 1,
            'user_id' 			=> 1,
            'eol' 			=> '60',
        );

        $models[] = array(
            'name'      		=> 'Laserjet 3015dn',
            'manufacturer_id'           => '10',
            'category_id'               => '8',
            'modelno'      		=> 'LJ3015DN01',
            'created_at' 		=> $date->modify('-2 day'),
            'updated_at' 		=> $date,
            'depreciation_id'           => 1,
            'user_id' 			=> 1,
            'eol' 			=> '60',
        );

        $models[] = array(
            'name'      		=> 'Thinkpad X302',
            'manufacturer_id'           => '6',
            'category_id'               => '1',
            'modelno'      		=> 'TP54-5620',
            'created_at' 		=> $date->modify('-2 day'),
            'updated_at' 		=> $date,
            'depreciation_id'           => 1,
            'user_id' 			=> 1,
            'eol' 			=> '60',
        );

        $models[] = array(
            'name'      		=> 'Thinkpad X1',
            'manufacturer_id'           => '6',
            'category_id'               => '1',
            'modelno'      		=> 'TPX1-2462',
            'created_at' 		=> $date->modify('-2 day'),
            'updated_at' 		=> $date,
            'depreciation_id'           => 1,
            'user_id' 			=> 1,
            'eol' 			=> '60',
        );
                
        // Delete all the old data
        DB::table('models')->truncate();

        // Insert the new posts
        Model::insert($models);
    }

}
