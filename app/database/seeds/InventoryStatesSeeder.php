<?php
class InventoryStatesSeeder extends Seeder
{
    public function run()
    {

        // Initialize empty array
        $inventory = array();

        $date = new DateTime;

        $inventory[] = array(
            'id'                        => '4',
            'name'      		=> 'Unavailable',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );
                
        $inventory[] = array(
            'id'                        => '3',
            'name'      		=> 'Assigned',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );
        
        $inventory[] = array(
            'id'                        => '2',
            'name'      		=> 'Available',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );
        
        $inventory[] = array(
            'id'                        => '1',
            'name'      		=> 'Pending',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
            'deleted_at' 		=> NULL,
        );

        // Delete all the old data
        DB::table('inventory_states')->truncate();

        // Insert the new posts
        InventoryState::insert($inventory);
    }

}

