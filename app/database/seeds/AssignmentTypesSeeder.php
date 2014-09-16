<?php

class AssignmentTypesSeeder extends Seeder
{
     public function run()
    {

        // Initialize empty array
        $assignmentTypes = array();

        $date = new DateTime;
        
        $assignmentTypes[] = array(
            'id'                        => 1,
            'name'                      => 'End-User Asset',
            'applies_to'                => 'Physical Asset',
            'assignable_to'             => 'Location',
            'notes'                     => 'Equipment used to provide infrastructure (router, server, rack, firewall, LAN switch, WiFi AP, etc.)',
            'user_id'                   => 1,
            'assignment_definition_id'  => 1,
            'created_at'=> $date,
            'updated_at'=> $date,
        );
        
        $assignmentTypes[] = array(
            'id'                        => 2,
            'name'                      => 'End-User Asset',
            'applies_to'                => 'Physical Asset',
            'assignable_to'             => 'User',
            'notes'                     => 'A standard end-user assigned asset (laptop, desktop, monitor, etc.)',
            'user_id'                   => 1,
            'assignment_definition_id'  => 2,
            'created_at'=> $date,
            'updated_at'=> $date,
        );
       
        $assignmentTypes[] = array(
            'id'                        => 3,
            'name'                      => 'Shared Asset',
            'applies_to'                => 'Physical Asset',
            'assignable_to'             => 'Location',
            'notes'                     => 'A device actively shared/used by end-users (printer, projector, scanner, video conf system, etc.)',
            'user_id'                   => 1,
            'assignment_definition_id'  => 2,
            'created_at'=> $date,
            'updated_at'=> $date,
        );
        
        $assignmentTypes[] = array(
            'id'                        => 4,
            'name'                      => 'Installed Software',
            'applies_to'                => 'License Seat',
            'assignable_to'             => 'Asset',
            'notes'                     => 'Standard, PC installed software license',
            'user_id'                   => 1,
            'assignment_definition_id'  => 3,
            'created_at'=> $date,
            'updated_at'=> $date,
        );        
       	
        $assignmentTypes[] = array(
            'id'                        => 5,
            'name'                      => 'Software Subscription',
            'applies_to'                => 'License Seat',
            'assignable_to'             => 'User',
            'notes'                     => 'Subscription type SAS or Cloud access (salesforce, google Apps, etc.)',
            'user_id'                   => 1,
            'assignment_definition_id'  => 4,
            'created_at'=> $date,
            'updated_at'=> $date,
        );
        
        $assignmentTypes[] = array(
            'id'                        => 6,
            'name'                      => 'Infrastructure Software',
            'applies_to'                => 'License Seat',
            'assignable_to'             => 'Asset',
            'notes'                     => 'Server OS, Exchange, Oracle DB, etc.',
            'user_id'                   => 1,
            'assignment_definition_id'  => 3,
            'created_at'=> $date,
            'updated_at'=> $date,
        );
       	
        $assignmentTypes[] = array(
            'id'                        => 7,
            'name'                      => 'Shared Software',
            'applies_to'                => 'License Seat',
            'assignable_to'             => 'Location',
            'notes'                     => 'Subscription shared by users, software shared by location, etc',
            'user_id'                   => 1,
            'assignment_definition_id'  => 5,
            'created_at'=> $date,
            'updated_at'=> $date,
        );
        
        $assignmentTypes[] = array(
            'id'                        => 8,
            'name'                      => 'Service Contract',
            'applies_to'                => 'License Seat',
            'assignable_to'             => 'Asset',
            'notes'                     => 'Hardware support, maintenance contracts or agreements',
            'user_id'                   => 1,
            'assignment_definition_id'  => 3,
            'created_at'=> $date,
            'updated_at'=> $date,
        );
        	
        $assignmentTypes[] = array(
            'id'                        => 9,
            'name'                      => 'Hardware Feature',
            'applies_to'                => 'License Seat',
            'assignable_to'             => 'Asset',
            'notes'                     => 'License key to enable or extend hardware features or functionality',
            'user_id'                   => 1,
            'assignment_definition_id'  => 3,
            'created_at'=> $date,
            'updated_at'=> $date,
        );

        
        // Delete all the old data
        DB::table('assignment_types')->truncate();

        // Insert the new posts
        AssignmentType::insert($assignmentTypes);
    }
}