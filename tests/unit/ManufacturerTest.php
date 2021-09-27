<?php

use App\Models\Manufacturer;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;

class ManufacturerTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // public function testManufacturerAdd()
    // {
    //   $manufacturers = factory(Manufacturer::class)->make();
    //   $values = [
    //     'name' => $manufacturers->name,
    //   ];

    //   Manufacturer::create($values);
    //   $this->tester->seeRecord('manufacturers', $values);
    // }
}
