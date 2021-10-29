<?php

use App\Models\Supplier;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;

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
