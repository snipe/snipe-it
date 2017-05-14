<?php
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Hash;

class AssetTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseTransactions;

    protected function _before()
    {
        Artisan::call('migrate');
    }

    public function testAssetAdd()
    {
        $asset = factory(Asset::class)->make();
        $values = [
            'name' => $asset->name,
            'model_id' => $asset->model_id,
            'status_id' => $asset->status_id,
            'asset_tag' => $asset->asset_tag,
        ];

        Asset::create($values);
        $this->tester->seeRecord('assets', $values);
    }

    public function testFailsEmptyValidation()
    {
       // An Asset requires a name, a qty, and a category_id.
        $a = Asset::create();
        $this->assertFalse($a->isValid());

        $fields = [
            'model_id' => 'model id',
            'status_id' => 'status id',
            'asset_tag' => 'asset tag'
        ];
        $errors = $a->getErrors();
        foreach ($fields as $field => $fieldTitle) {
            $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
        }
    }


    /**
     * @test
     */
    public function testWarrantyExpiresAttribute()
    {
        $asset = factory(\App\Models\Asset::class)->create();

        $asset->purchase_date = \Carbon\Carbon::createFromDate(2017, 1, 1)->hour(0)->minute(0)->second(0);
        $asset->warranty_months = 24;
        $asset->save();

        $saved_asset = \App\Models\Asset::find($asset->id);

        $this->tester->assertInstanceOf(\DateTime::class, $saved_asset->purchase_date);
        $this->tester->assertEquals(
            \Carbon\Carbon::createFromDate(2017, 1, 1)->format('Y-m-d'),
            $saved_asset->purchase_date->format('Y-m-d')
        );
        $this->tester->assertEquals(
            \Carbon\Carbon::createFromDate(2017, 1, 1)->setTime(0, 0, 0),
            $saved_asset->purchase_date
        );
        $this->tester->assertEquals(24, $saved_asset->warranty_months);
        $this->tester->assertInstanceOf(\DateTime::class, $saved_asset->warranty_expires);
        $this->tester->assertEquals(
            \Carbon\Carbon::createFromDate(2019, 1, 1)->format('Y-m-d'),
            $saved_asset->warranty_expires->format('Y-m-d')
        );
        $this->tester->assertEquals(
            \Carbon\Carbon::createFromDate(2019, 1, 1)->setTime(0, 0, 0),
            $saved_asset->warranty_expires
        );
    }

    public function testModelIdMustExist()
    {
        $model = factory(AssetModel::class)->create();
        $asset = factory(Asset::class)->make(['model_id' => $model->id]);
        $asset->save();
        $this->assertTrue($asset->isValid());
        $newId = $model->id + 1;
        $asset = factory(Asset::class)->make(['model_id' => $newId]);
        $asset->save();

        $this->assertFalse($asset->isValid());
    }

    public function testAnAssetBelongsToAModel()
    {
        $asset = factory(Asset::class)->create();
        $this->assertInstanceOf(AssetModel::class, $asset->model);
    }

    public function testAnAssetBelongsToACompany()
    {
        $asset = factory(Asset::class)->create();
        $this->assertInstanceOf(Company::class, $asset->company);
    }

    public function testAnAssetCanBeAvailableForCheckout()
    {
        // Logic: If the asset is not assigned to anyone,
        // and the statuslabel type is "deployable"
        // and the asset is not deleted
        // Then it is available for checkout

        // An asset assigned to someone should not be available for checkout.
        $user = factory(App\Models\User::class)->create();
        $assetAssigned = factory(Asset::class)->create(['assigned_to' => $user->id]);
        $this->assertFalse($assetAssigned->availableForCheckout());

        // An asset with a non deployable statuslabel should not be available for checkout.
        $status = factory(App\Models\Statuslabel::class)->states('archived')->create();
        $assetUndeployable = factory(Asset::class)->create(['status_id' => $status->id]);
        $this->assertFalse($assetUndeployable->availableForCheckout());

        // An asset that has been deleted is not avaiable for checkout.
        $assetDeleted = factory(Asset::class)->states('deleted')->create();
        $this->assertFalse($assetDeleted->availableForCheckout());

        // A ready to deploy asset that isn't assigned to anyone is available for checkout
        $status = factory(App\Models\Statuslabel::class)->states('rtd')->create();
        $asset = factory(Asset::class)->create(['status_id' => $status->id]);
        $this->assertTrue($asset->availableForCheckout());
    }
}
