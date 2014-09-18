<?php

class ManufacturersSeeder extends Seeder
{
    public function run()
    {

        $date = date("Y-m-d");
        $manufacturers[] = array(
            'name'     		 	=> 'Apple',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );

        $manufacturers[] = array(
            'name'     		 	=> 'Microsoft',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );

        $manufacturers[] = array(
            'name'     		 	=> 'ASUS',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );

        $manufacturers[] = array(
            'name'     		 	=> 'Dell',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );
        
        $manufacturers[] = array(
            'name'     		 	=> 'IBM',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );

        $manufacturers[] = array(
            'name'     		 	=> 'Lenovo',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );
        
        $manufacturers[] = array(
            'name'     		 	=> 'Symantec',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );
        
        $manufacturers[] = array(
            'name'     		 	=> 'Toshiba',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );
        
        $manufacturers[] = array(
            'name'     		 	=> 'Cisco',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );
        
        $manufacturers[] = array(
            'name'     		 	=> 'HP',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );

        $manufacturers[] = array(
            'name'     		 	=> 'Adobe Systems',
            'created_at' 		=> $date,
            'user_id' 			=> 1,
            'updated_at' 		=> $date,
            'deleted_at' 		=> NULL,
        );        
        
        // Delete all current entries
        DB::table('manufacturers')->truncate();

        // Insert the seeds
        Manufacturer::insert($manufacturers);
    }

}
