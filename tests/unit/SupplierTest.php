<?php
use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SupplierTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // public function testSupplierAdd()
    // {
    //   $supplier = factory(Supplier::class)->make();
    //   $values = [
    //     'name' => $supplier->name,
    //   ];

    //   Supplier::create($values);
    //   $this->tester->seeRecord('suppliers', $values);
    // }

}
