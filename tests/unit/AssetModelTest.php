<?php
use App\Models\AssetModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AssetModelTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testAssetModelAdd()
    {
      $assetmodel = factory(AssetModel::class, 'assetmodel')->make();
      $values = [
        'name' => $assetmodel->name,
        'manufacturer_id' => $assetmodel->manufacturer_id,
        'category_id' => $assetmodel->category_id,
        'eol' => $assetmodel->eol,
      ];

      AssetModel::create($values);
      $this->tester->seeRecord('models', $values);
    }

}
