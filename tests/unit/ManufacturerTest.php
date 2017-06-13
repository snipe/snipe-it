<?php
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ManufacturerTest extends \Codeception\TestCase\Test
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
