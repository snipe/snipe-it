<?php
use App\Models\Depreciation;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DepreciationTest extends \Codeception\TestCase\Test
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

    public function testDepreciationAdd()
    {
      $depreciations = factory(Depreciation::class)->make();
      $values = [
        'name' => $depreciations->name,
        'months' => $depreciations->months,
      ];

      Depreciation::create($values);
      $this->tester->seeRecord('depreciations', $values);
    }

}
