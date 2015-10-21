<?php

class CategoriesSeeder extends Seeder
{
    public function run()
    {


        $date = new DateTime;
        $category[] = array(
            'name'      => 'Laptops',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'use_default_eula'	=>	0,
            'require_acceptance'	=> 0,
            'deleted_at' => NULL,
            'eula_text'	=> NULL,
            'category_type' => 'asset',
        );

        $date = new DateTime;
        $category[] = array(
            'name'      => 'Desktops',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'use_default_eula'	=>	0,
            'require_acceptance'	=> 0,
            'deleted_at' => NULL,
            'eula_text'	=> NULL,
            'category_type' => 'asset',
        );

        $date = new DateTime;
        $category[] = array(
            'name'      => 'Tablets',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'use_default_eula'	=>	0,
            'require_acceptance'	=> 0,
            'deleted_at' => NULL,
            'eula_text'	=> NULL,
            'category_type' => 'asset',
        );

        $date = new DateTime;
        $category[] = array(
            'name'      => 'Phones',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'use_default_eula'	=>	0,
            'require_acceptance'	=> 0,
            'deleted_at' => NULL,
            'eula_text'	=> NULL,
            'category_type' => 'accessory',
        );

        $date = new DateTime;
        $category[] = array(
            'name'      => 'Monitors',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'use_default_eula'	=>	0,
            'require_acceptance'	=> 0,
            'deleted_at' => NULL,
            'eula_text'	=> NULL,
            'category_type' => 'accessory',
        );

        $date = new DateTime;
        $category[] = array(
            'name'      => 'Printer Ink',
            'created_at' => $date->modify('-10 day'),
            'updated_at' => $date->modify('-3 day'),
            'user_id' => 1,
            'use_default_eula'	=>	0,
            'require_acceptance'	=> 0,
            'deleted_at' => NULL,
            'eula_text'	=> NULL,
            'category_type' => 'consumable',
        );


        // Delete all the blog posts
        DB::table('categories')->truncate();

        // Insert the blog posts
        Category::insert($category);
    }

}
