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

    /**
     * @test
     */
    public function it_zeros_blank_eol_but_not_others()
    {
        $am = new AssetModel;
        $am->eol = '';
        $this->assertTrue($am->eol === 0);
        $am->eol = '4';
        $this->assertTrue($am->eol==4);
    }
}
