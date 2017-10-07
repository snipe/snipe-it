<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        factory(User::class, 1)->states('first-admin')->create();
        factory(User::class, 1)->states('snipe-admin')->create();
        factory(User::class, 3)->states('superuser')->create();
        factory(User::class, 3)->states('admin')->create();
        factory(User::class, 1)->states('view-assets')->create();
//        factory(User::class, 1)->states('create-assets')->create();
//        factory(User::class, 1)->states('edit-assets')->create();
//        factory(User::class, 1)->states('delete-assets')->create();
//        factory(User::class, 1)->states('checkin-assets')->create();
//        factory(User::class, 1)->states('checkout-assets')->create();
//        factory(User::class, 1)->states('view-requestable-assets')->create();
//        factory(User::class, 1)->states('view-accessories')->create();
//        factory(User::class, 1)->states('create-accessories')->create();
//        factory(User::class, 1)->states('view-accessories')->create();
//        factory(User::class, 1)->states('delete-accessories')->create();
//        factory(User::class, 1)->states('edit-accessories')->create();
//        factory(User::class, 1)->states('checkout-accessories')->create();
//        factory(User::class, 1)->states('checkin-accessories')->create();
//        factory(User::class, 1)->states('view-consumables')->create();
//        factory(User::class, 1)->states('create-consumables')->create();
//        factory(User::class, 1)->states('edit-consumables')->create();
//        factory(User::class, 1)->states('delete-consumables')->create();
//        factory(User::class, 1)->states('checkout-consumables')->create();
//        factory(User::class, 1)->states('view-licenses')->create();
//        factory(User::class, 1)->states('edit-licenses')->create();
//        factory(User::class, 1)->states('delete-licenses')->create();
//        factory(User::class, 1)->states('create-licenses')->create();
//        factory(User::class, 1)->states('checkout-licenses')->create();
//        factory(User::class, 1)->states('view-keys-licenses')->create();
//        factory(User::class, 1)->states('view-components')->create();
//        factory(User::class, 1)->states('edit-components')->create();
//        factory(User::class, 1)->states('create-components')->create();
//        factory(User::class, 1)->states('delete-components')->create();
//        factory(User::class, 1)->states('checkout-components')->create();
//        factory(User::class, 1)->states('checkin-components')->create();
//        factory(User::class, 1)->states('view-users')->create();
//        factory(User::class, 1)->states('edit-users')->create();
//        factory(User::class, 1)->states('delete-users')->create();
//        factory(User::class, 1)->states('create-users')->create();
    }
}
