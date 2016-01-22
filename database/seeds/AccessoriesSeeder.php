<?php
class AccessoriesSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $accessory = array();

        $date = new DateTime;


        $accessory[] = array(
            'name'      	=> 'Cisco Desktop Phone',
            'category_id'      => 4,
            'qty'      	=> '20',
            'requestable' => '0',
            'user_id' => 1,
        );

        $accessory[] = array(
            'name'      	=> 'ASUS 23-inch',
            'category_id'      => 5,
            'qty'      	=> '20',
            'requestable' => '0',
            'user_id' => 1,
        );



        // Delete all the old data
        DB::table('accessories')->truncate();

        // Insert the new posts
        Accessory::insert($accessory);
    }

}
