<?php
class ServiceAgreementTypesSeeder extends Seeder
{
    public function run()
    {

        // Initialize empty array
        $servicetype = array();

        $date = new DateTime;

        $servicetype[] = array(
            'id'                        => '4',
            'name'      		=> 'Software Assurance',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
        );
                
        $servicetype[] = array(
            'id'                        => '3',
            'name'      		=> 'Support Contract',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
        );
        
        $servicetype[] = array(
            'id'                        => '2',
            'name'      		=> 'Hardware Extended Warrantee',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
        );
        
        $servicetype[] = array(
            'id'                        => '1',
            'name'      		=> 'Maintenance',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,

        );

        // Delete all the old data
        DB::table('service_agreement_types')->truncate();

        // Insert the new posts
        ServiceAgreementType::insert($servicetype);
    }

}

