<?php

use App\Models\Manufacturer;

class ManufacturerTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testManufacturerAdd()
    {
        $manufacturers = factory(Manufacturer::class)->make();
        $values = [
        'name' => $manufacturers->name,
      ];

        Manufacturer::create($values);
        $this->tester->seeRecord('manufacturers', $values);
    }
}
