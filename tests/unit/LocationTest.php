<?php
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testAssetAdd()
    {
      $location = factory(Location::class, 'location')->make();
      $values = [
        'name' => $location->name,
      ];

      Location::create($values);
      $this->tester->seeRecord('locations', $values);
    }

}
