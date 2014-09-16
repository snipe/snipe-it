<?php


class AssignmentDefinitionsSeeder extends Seeder
{
     public function run()
    {

        // Initialize empty array
        $assignmentDefinitions = array();

        $date = new DateTime;        

        $assignmentDefinitions[] = array(
            'id'                => 1,
            'name'              => 'Asset-User',
            'applies_to'        => 'Asset',
            'assigned_object'   => 'User',  
            'created_at'        => $date,
            'updated_at'        => $date,
        );
        
        $assignmentDefinitions[] = array(
            'id'                => 2,
            'name'              => 'Asset-Location',
            'applies_to'        => 'Asset',
            'assigned_object'   => 'Location',  
            'created_at'        => $date,
            'updated_at'        => $date,
        );
        
        $assignmentDefinitions[] = array(
            'id'                => 3,
            'name'              => 'License-Asset',
            'applies_to'        => 'LicenseSeat',
            'assigned_object'   => 'Asset',  
            'created_at'        => $date,
            'updated_at'        => $date,
        );
        
        $assignmentDefinitions[] = array(
            'id'                => 4,
            'name'              => 'License-User',
            'applies_to'        => 'LicenseSeat',
            'assigned_object'   => 'User',  
            'created_at'        => $date,
            'updated_at'        => $date,
        );
        
        $assignmentDefinitions[] = array(
            'id'                => 5,
            'name'              => 'License-Location',
            'applies_to'        => 'LicenseSeat',
            'assigned_object'   => 'Location',  
            'created_at'        => $date,
            'updated_at'        => $date,
        );
    
          // Delete all the old data
        DB::table('assignment_definitions')->truncate();

        // Insert the new posts
        AssignmentDefinition::insert($assignmentDefinitions);
    }
}
    