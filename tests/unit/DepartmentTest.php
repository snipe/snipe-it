<?php
use App\Models\Department;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;

class DepartmentTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // public function testDepartmentAdd()
    // {
    //     $department = factory(Department::class)->make();
    //     $values = [
    //         'name' => $department->name,
    //         'user_id' => $department->user_id,
    //         'manager_id' => $department->manager_id,
    //     ];

    //     Department::create($values);
    //     $this->tester->seeRecord('departments', $values);
    // }

}
