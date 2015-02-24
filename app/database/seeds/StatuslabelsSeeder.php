<?php
class StatuslabelsSeeder extends Seeder
{
    public function run()
    {


        // Initialize empty array
        $status = array();

        $date = new DateTime;

		 $status[] = array(
            'name'      => 'Ready to Deploy',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' 		=> NULL,
            'deployable'	=> 1,
            'pending'	=> 0,
            'archived' => 0,
            'notes' => ''
        );

         $status[] = array(
            'name'      => 'Pending',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' 		=> NULL,
            'deployable'	=> 0,
            'pending'	=> 1,
            'archived' => 0,
            'notes' => ''
        );

        $status[] = array(
            'name'      => 'Archived',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' 		=> NULL,
            'deployable'	=> 0,
            'pending'	=> 0,
            'archived' => 1,
            'notes' => 'These assets are permanently undeployable'
        );


        $status[] = array(
            'name'      => 'Out for Diagnostics',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' 		=> NULL,
            'deployable'	=> 0,
            'pending'	=> 0,
            'archived' => 0,
            'notes' => ''
        );


        $status[] = array(
            'name'      => 'Out for Repair',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' 		=> NULL,
            'deployable'	=> 0,
            'pending'	=> 0,
            'archived' => 0,
             'notes' => ''
        );


        $status[] = array(
            'name'      => 'Broken - Not Fixable',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' 		=> NULL,
            'deployable'	=> 0,
            'pending'	=> 0,
            'archived' => 1,
             'notes' => ''
        );

        $status[] = array(
            'name'      => 'Lost/Stolen',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' 		=> NULL,
            'deployable'	=> 0,
            'pending'	=> 0,
            'archived' => 1,
            'notes' => '',
        );



        // Delete all the old data
        DB::table('status_labels')->truncate();

        // Insert the new posts
        Statuslabel::insert($status);
    }

}
