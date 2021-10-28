<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::truncate();
        Department::factory()->count(1)->hr()->create(); // 1
        Department::factory()->count(1)->engineering()->create(); // 2
        Department::factory()->count(1)->marketing()->create(); // 3
        Department::factory()->count(1)->client()->create(); // 4
        Department::factory()->count(1)->product()->create(); // 5
        Department::factory()->count(1)->silly()->create(); // 6
    }
}
