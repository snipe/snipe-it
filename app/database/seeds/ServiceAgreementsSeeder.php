<?php
class ServiceAgreementsSeeder extends Seeder
{
    public function run()
    {

        // Initialize empty array
        $service = array();

        $date = new DateTime;

        // Pending (status_id is null, assigned_to = 0)
        $service[] = array(
            'name'      		=> 'Office 2013 Assurance',
            'contract_number'           => 'Z68544SSQRM',
            'purchase_date'             => '2014-10-02',
            'purchase_cost'             => '135.00',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-3 day'),
            'term_months'               => 12,
            'service_agreement_type_id' => 4,
            'notes' 			=> 'Seeded entry',
            'location_id'		=> 1,
            'strict_assignment'         => 1,
            'deleted_at' 		=> NULL,
            'user_id'                   => 1,
        );

        $service[] = array(
            'name'      		=> 'HP CarePaq - DL380',
            'contract_number'           => 'Q5324-244',
            'purchase_date'             => '2013-10-02',
            'purchase_cost'             => '980.00',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-3 day'),
            'term_months'               => 36,
            'service_agreement_type_id' => 2,
            'notes' 			=> 'Seeded entry',
            'location_id'		=> 1,
            'strict_assignment'         => 1,
            'deleted_at' 		=> NULL,
            'user_id'                   => 1,
        );

        $service[] = array(
            'name'      		=> 'Cisco SmartNet 2960',
            'contract_number'           => '2424-4321-866',
            'purchase_date'             => '2014-04-26',
            'purchase_cost'             => '328.00',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-3 day'),
            'term_months'               => 24,
            'service_agreement_type_id' => 3,
            'notes' 			=> 'Seeded entry',
            'location_id'		=> 1,
            'strict_assignment'         => 1,
            'deleted_at' 		=> NULL,
            'user_id'                   => 1,
        );      
 
        $service[] = array(
            'name'      		=> 'SAP Support and Maintenance',
            'contract_number'           => '982.25487',
            'purchase_date'             => '2013-04-26',
            'purchase_cost'             => '2496.00',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-3 day'),
            'term_months'               => 12,
            'service_agreement_type_id' => 1,
            'notes' 			=> 'Seeded entry',
            'location_id'		=> 1,
            'strict_assignment'         => 1,
            'deleted_at' 		=> NULL,
            'user_id'                   => 1,
        );              
        
        // Delete all the old data
        DB::table('service_agreements')->truncate();

        // Insert the new posts
        ServiceAgreement::insert($service);
    }

}

