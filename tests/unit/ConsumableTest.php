<?php
use App\Models\Consumable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ConsumableTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testConsumableAdd()
    {
      $consumable = factory(Consumable::class, 'consumable')->make();
      $values = [
        'name' => $consumable->name,
        'qty' => $consumable->qty,
        'category_id' => $consumable->category_id,
        'company_id' => $consumable->company_id,
      ];

      Consumable::create($values);
      $this->tester->seeRecord('consumables', $values);
    }

}
