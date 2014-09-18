<?php

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        
        // Initialize empty array
        $category = array();
        
        $date = new DateTime;
        
        $category[] = array(
            'name'      => 'Laptop',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' => NULL,
        );

        $category[] = array(
            'name'      => 'Desktop',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' => NULL,
        );

        $category[] = array(
            'name'      => 'Tablet',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' => NULL,
        );

        $category[] = array(
            'name'      => 'VoIP Phone',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' => NULL,
        );

        $category[] = array(
            'name'      => 'Monitor',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' => NULL,
        );

        $category[] = array(
            'name'      => 'Router',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' => NULL,
        );
                
        $category[] = array(
            'name'      => 'LAN Switch',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' => NULL,
        );
        
        $category[] = array(
            'name'      => 'Printer',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' => NULL,
        );
 
        $category[] = array(
            'name'      => 'Server',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'deleted_at' => NULL,
        );
                
        // Delete all the blog posts
        DB::table('categories')->truncate();

        // Insert the blog posts
        Category::insert($category);
    }

}
