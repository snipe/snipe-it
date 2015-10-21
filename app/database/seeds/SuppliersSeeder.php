<?php
class SuppliersSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $supplier = array();

        $date = new DateTime;


        $supplier[] = array(
            'name'      	=> 'New Egg',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id'       => 1,
        );

        $supplier[] = array(
            'name'      	=> 'Microsoft',
            'created_at' 	=> $date->modify('-10 day'),
            'updated_at' 	=> $date->modify('-3 day'),
            'user_id'       => 1,
        );



        // Delete all the old data
        DB::table('suppliers')->truncate();

        // Insert the new posts
        Supplier::insert($supplier);
    }

}
