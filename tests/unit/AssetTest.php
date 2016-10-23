<?php
use App\Models\Asset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssetTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testAssetAdd()
    {
      $asset = factory(Asset::class, 'asset')->make();
      $values = [
        'name' => $asset->name,
        'model_id' => $asset->model_id,
        'status_id' => $asset->status_id,
        'asset_tag' => $asset->asset_tag,
      ];

      Asset::create($values);
      $this->tester->seeRecord('assets', $values);
    }

}
