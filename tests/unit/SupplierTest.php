<?php
use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SupplierTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testSupplierAdd()
    {
      $supplier = factory(Supplier::class, 'supplier')->make();
      $values = [
        'name' => $supplier->name,
      ];

      Supplier::create($values);
      $this->tester->seeRecord('suppliers', $values);
    }

}
