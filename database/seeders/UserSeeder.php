<?php
namespace Database\Seeders;

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
        User::factory()->count(1)->firstAdmin()->create();
        User::factory()->count(1)->snipeAdmin()->create();
        User::factory()->count(3)->superUserRole()->create();
        User::factory()->count(3)->adminRole()->create();
        User::factory()->count(50)->viewAssetsRole()->create();
        User::factory()->count(10)->createAssetsRole()->create();

    }
}
