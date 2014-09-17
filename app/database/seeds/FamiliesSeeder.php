<?php

class FamiliesSeeder extends Seeder
{
    public function run()
    {

        // Initialize empty array
        $family = array();
        
        $date = new DateTime;
        
        $family[] = array(
            'name'      => 'Microsoft Office Suite',
            'common_name' => 'MS Office',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'notes'      => 'Added by seeder',
            'deleted_at' => NULL,
        );

        $family[] = array(
            'name'      => 'Windows OS - Workstation',
            'common_name'=> 'Windows',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'notes'      => 'Added by seeder',
            'deleted_at' => NULL,
        );

        $family[] = array(
            'name'      => 'Windows OS - Server',
            'common_name'=> 'Windows Server',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'notes'      => 'Added by seeder',
            'deleted_at' => NULL,
        );
                
        $family[] = array(
            'name'      => 'Adobe Master Suite',
            'common_name'=> 'Master Suite',            
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id'       => 1,
            'notes'      => 'Added by seeder',
            'deleted_at' => NULL,
        );

        $family[] = array(
            'name'      => 'Backup Exec Server',
            'common_name'=> 'Backup Exec',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'notes'      => 'Added by seeder',
            'deleted_at' => NULL,
        );

        $family[] = array(
            'name'      => 'Norton Antivirus',
            'common_name'=> 'Norton AV',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'notes'      => 'Added by seeder',
            'deleted_at' => NULL,
        );
                
        // Delete all the blog posts
        DB::table('families')->truncate();

        // Insert the blog posts
        Family::insert($family);
    }

}
