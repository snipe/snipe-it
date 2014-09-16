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
            'name'      		=> 'Adobe Photoshop CS6',
            'serial'      		=> 'Z68544SSQRM',
            'purchase_date'             => '2013-10-02',
            'purchase_cost'             => '2435.00',
            'order_number'              => '1451855',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-3 day'),
            'seats' 			=> 3,
            'license_name'		=> '',
            'license_email'		=> '',
            'manufacturer_id'           => 11,
            'family_id'                 => 4,
            'notes' 			=> '',
            'user_id'			=> 1,
            'depreciation_id'           => 2,
            'deleted_at' 		=> NULL,
            'depreciate' 		=> '0',
        );

        $service[] = array(
            'name'      		=> 'Office 2010 Professional',
            'serial'      		=> '78YN-56RT-FQ9B-8GYB',
            'purchase_date'             => '2012-05-22',
            'purchase_cost'             => '1295.20',
            'order_number'              => '1452005',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-3 day'),
            'seats' 			=> 4,
            'license_name'		=> '',
            'license_email'		=> '',
            'manufacturer_id'           => 2,
            'family_id'                 => 1,
            'notes' 			=> '',
            'user_id'			=> 1,
            'depreciation_id'           => 2,
            'deleted_at' 		=> NULL,
            'depreciate' 		=> '0',
        );

        $service[] = array(
            'name'      		=> 'Office 2011 for Mac',
            'serial'      		=> '9804989-3404',
            'purchase_date'             => '2013-02-01',
            'purchase_cost'             => '642.00',
            'order_number'              => '1452082',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-3 day'),
            'seats' 			=> 2,
            'license_name'		=> '',
            'license_email'		=> '',
            'manufacturer_id'           => 2,
            'family_id'                 => 1,
            'notes' 			=> '',
            'user_id'			=> 1,
            'depreciation_id'           => 2,
            'deleted_at' 		=> NULL,
            'depreciate' 		=> '0',
        );        
 
        $service[] = array(
            'name'      		=> 'Office 2013 Standard',
            'serial'      		=> 'F8M8-DMQ2-F6TY-4PYQ',
            'purchase_date'             => '2013-10-02',
            'purchase_cost'             => '858.50',
            'order_number'              => '1452124',
            'created_at' 		=> $date->modify('-10 day'),
            'updated_at' 		=> $date->modify('-3 day'),
            'seats' 			=> 2,
            'license_name'		=> '',
            'license_email'		=> '',
            'manufacturer_id'           => 2,
            'family_id'                 => 1,
            'notes' 			=> '',
            'user_id'			=> 1,
            'depreciation_id'           => 2,
            'deleted_at' 		=> NULL,
            'depreciate' 		=> '0',
        );                 
        
        // Delete all the old data
        DB::table('service_agreements')->truncate();

        // Insert the new posts
        License::insert($service);
    }

}

