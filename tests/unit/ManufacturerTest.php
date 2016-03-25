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

    public function testManufacturerAdd()
    {
      $manufacturers = factory(Manufacturer::class, 'manufacturer')->make();
      $values = [
        'name' => $manufacturers->name,
      ];

      Manufacturer::create($values);
      $this->tester->seeRecord('manufacturers', $values);
    }

}
