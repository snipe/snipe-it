<?php

use App\Models\Location;

class LocationTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAssetAdd()
    {
        $location = factory(Location::class)->make();
        $values = [
        'name' => $location->name,
        ];

        Location::create($values);
        $this->tester->seeRecord('locations', $values);
    }
}
