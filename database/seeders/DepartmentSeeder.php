<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::truncate();
        Department::factory()->count(1)->deptHr()->create();
        Department::factory()->count(1)->deptEngineering()->create();
        Department::factory()->count(1)->deptMarketing()->create();
        Department::factory()->count(1)->deptClientServices()->create();
        Department::factory()->count(1)->deptProduct()->create();
        Department::factory()->count(1)->deptSillyWalks()->create();

    }
}
