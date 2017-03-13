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


    /**
     * @test
     */
    public function testWarrantyExpiresAttribute()
    {
        $asset = factory(\App\Models\Asset::class, 'asset')->create();

        $asset->purchase_date = \Carbon\Carbon::createFromDate(2017, 1, 1);
        $asset->warranty_months = 24;
        $asset->save();

        $saved_asset = \App\Models\Asset::find($asset->id);

        $this->tester->assertInstanceOf(\DateTime::class, $saved_asset->purchase_date);
        $this->tester->assertEquals(
            \Carbon\Carbon::createFromDate(2017,1,1)->format('Y-m-d'),
            $saved_asset->purchase_date->format('Y-m-d')
        ); 
        $this->tester->assertEquals(
            \Carbon\Carbon::createFromDate(2017,1,1)->setTime(0,0,0),
            $saved_asset->purchase_date
        );        
        $this->tester->assertEquals(24, $saved_asset->warranty_months);
        $this->tester->assertInstanceOf(\DateTime::class, $saved_asset->warranty_expires);
        $this->tester->assertEquals(
            \Carbon\Carbon::createFromDate(2019,1,1)->format('Y-m-d'),
            $saved_asset->warranty_expires->format('Y-m-d')
        );
        $this->tester->assertEquals(
            \Carbon\Carbon::createFromDate(2019,1,1)->setTime(0,0,0),
            $saved_asset->warranty_expires
        );
    }
}
