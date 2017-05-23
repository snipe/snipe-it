<?php
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepartmentTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testDepartmentAdd()
    {
        $department = factory(Department::class, 'department')->make();
        $values = [
            'name' => $department->name,
        ];

        Department::create($values);
        $this->tester->seeRecord('departments', $values);
    }

}
