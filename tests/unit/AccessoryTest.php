<?php
use App\Models\Accessory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccessoryTest extends \Codeception\TestCase\Test
{
  /**
   * @var \UnitTester
   */
  protected $tester;
  use DatabaseMigrations;

  public function testAccessoryAdd()
  {
    $accessory = factory(Accessory::class, 'accessory')->make();
    $values = [
      'name' => $accessory->name,
      'category_id' => $accessory->category_id,
      'qty' => $accessory->qty,
    ];

    Accessory::create($values);
    $this->tester->seeRecord('accessories', $values);
  }

}
