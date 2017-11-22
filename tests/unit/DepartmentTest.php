<?php

use App\Models\Department;

class DepartmentTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testDepartmentAdd()
    {
        $department = factory(Department::class)->make();
        $values = [
            'name' => $department->name,
            'user_id' => $department->user_id,
            'manager_id' => $department->manager_id,
        ];

        Department::create($values);
        $this->tester->seeRecord('departments', $values);
    }
}
