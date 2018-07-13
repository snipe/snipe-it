<?php
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends BaseTest
{
    /**
    * @var \UnitTester
    */
    protected $tester;

    // public function testAssetAdd()
    // {
    //     $location = factory(Location::class)->make();
    //     $values = [
    //     'name' => $location->name,
    //     ];

    //     Location::create($values);
    //     $this->tester->seeRecord('locations', $values);
    // }
}
