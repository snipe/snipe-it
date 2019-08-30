<?php
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::truncate();
        factory(Department::class, 1)->states('hr')->create(); // 1
        factory(Department::class, 1)->states('engineering')->create(); // 2
        factory(Department::class, 1)->states('marketing')->create(); // 3
        factory(Department::class, 1)->states('client')->create(); // 4
        factory(Department::class, 1)->states('product')->create(); // 5
        factory(Department::class, 1)->states('silly')->create(); // 6
    }
}
