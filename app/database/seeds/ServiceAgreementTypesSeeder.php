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
            'name'      		=> 'Unavailable',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
        );
                
        $servicetype[] = array(
            'id'                        => '3',
            'name'      		=> 'Assigned',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
        );
        
        $servicetype[] = array(
            'id'                        => '2',
            'name'      		=> 'Available',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,
        );
        
        $servicetype[] = array(
            'id'                        => '1',
            'name'      		=> 'Pending',
            'notes'                     => 'Automatic seeded entry',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-1 day'),
            'user_id' 			=> 1,

        );

        // Delete all the old data
        DB::table('service_agreement_type')->truncate();

        // Insert the new posts
        ServiceAgreementType::insert($servicetype);
    }

}

