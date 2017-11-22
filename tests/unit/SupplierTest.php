<?php

use App\Models\Supplier;

class SupplierTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSupplierAdd()
    {
        $supplier = factory(Supplier::class)->make();
        $values = [
        'name' => $supplier->name,
      ];

        Supplier::create($values);
        $this->tester->seeRecord('suppliers', $values);
    }
}
