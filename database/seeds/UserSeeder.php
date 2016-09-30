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
        // Don't truncate the user column, that might suck.
        factory(User::class, 'valid-user', 10)->create();
    }
}
