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

    protected function _before()
    {
        Artisan::call('migrate');
    }

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
