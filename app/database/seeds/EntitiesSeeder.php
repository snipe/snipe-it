<?php
class EntitiesSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $entity = array();

        $date = new DateTime;
        $entity[] = array(
            'name'      		=> 'My Company',
            'common_name'     	 	=> 'My Company Ltd.',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        // Delete all the old data
        DB::table('entities')->truncate();

        // Insert the new posts
        Location::insert($entity);
    }

}

