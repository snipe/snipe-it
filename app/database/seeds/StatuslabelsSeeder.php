<?php
class StatuslabelsSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $status = array();

        $date = new DateTime;
                
        $status[] = array(
            'id'        => '1',
            'name'      => 'Out for Diagnostics',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '4',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );


        $status[] = array(
            'id'        => '2',
            'name'      => 'Out for Repair',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '4',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );


        $status[] = array(
            'id'        => '3',
            'name'      => 'Broken - Not Fixable',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '4',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );

        $status[] = array(
            'id'        => '4',
            'name'      => 'Lost/Stolen',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '4',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );

        $status[] = array(
            'id'        => '5',
            'name'      => 'Decommissioned',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'inventory_state_id' => '4',
            'user_id' => 1,
            'deleted_at' 		=> NULL,
        );


        // Delete all the old data
        DB::table('status_labels')->truncate();

        // Insert the new posts
        Statuslabel::insert($status);
    }

}
