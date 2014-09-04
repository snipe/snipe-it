<?php
class StatuslabelsSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $status = array();

        $date = new DateTime;

        $status[] = array(
            'id'        => '2',
            'name'      => 'Ready to Deploy',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '3',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );
        
        $status[] = array(
            'id'        => '3',
            'name'      => 'Assigned In Use',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '2',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );

        $status[] = array(
            'id'        => '1',
            'name'      => 'In Preparations',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '2',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );
                
        $status[] = array(
            'id'        => '4',
            'name'      => 'Out for Diagnostics',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '1',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );


        $status[] = array(
            'id'        => '5',
            'name'      => 'Out for Repair',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '1',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );


        $status[] = array(
            'id'        => '6',
            'name'      => 'Broken - Not Fixable',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '1',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );

        $status[] = array(
            'id'        => '7',
            'name'      => 'Lost/Stolen',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '1',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );

        $status[] = array(
            'id'        => '8',
            'name'      => 'Decommissioned',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '1',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );


        // Delete all the old data
        DB::table('status_labels')->truncate();

        // Insert the new posts
        Statuslabel::insert($status);
    }

}
