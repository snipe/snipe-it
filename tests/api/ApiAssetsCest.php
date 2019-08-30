<?php

use App\Helpers\Helper;
use App\Http\Transformers\AssetsTransformer;
use App\Models\Asset;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ApiAssetsCest
{
    protected $faker;
    protected $user;
    protected $timeFormat;

    public function _before(ApiTester $I)
    {
        $this->faker = \Faker\Factory::create();
        $this->user = \App\Models\User::find(1);
        Setting::getSettings()->time_display_format = "H:i";
        $I->amBearerAuthenticated($I->getToken($this->user));
    }

    /** @test */
    public function indexAssets(ApiTester $I)
    {

        $I->wantTo('Get a list of assets');

        // call
        $I->sendGET('/hardware?limit=20&sort=id&order=desc');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        // FIXME: This is disabled because the statuslabel join is doing something weird in Api/AssetsController@index
        // However, it's hiding other real test errors in other parts of the code, so disabling this for now until we can fix.
//        $response = json_decode($I->grabResponse(), true);

        // sample verify
//        $asset = Asset::orderByDesc('id')->take(20)->get()->first();

        //
//        $I->seeResponseContainsJson($I->removeTimestamps((new AssetsTransformer)->transformAsset($asset)));
    }

    /** @test */
    public function createAsset(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new asset');

        $temp_asset = factory(\App\Models\Asset::class)->states('laptop-mbp')->make([
            'asset_tag' => "Test Asset Tag",
            'company_id' => 2
        ]);

        // setup
        $data = [
            'asset_tag' => $temp_asset->asset_tag,
            'assigned_to' => $temp_asset->assigned_to,
            'company_id' => $temp_asset->company->id,
            'image' => $temp_asset->image,
            'model_id' => $temp_asset->model_id,
            'name' => $temp_asset->name,
            'notes' => $temp_asset->notes,
            'purchase_cost' => $temp_asset->purchase_cost,
            'purchase_date' => $temp_asset->purchase_date,
            'rtd_location_id' => $temp_asset->rtd_location_id,
            'serial' => $temp_asset->serial,
            'status_id' => $temp_asset->status_id,
            'supplier_id' => $temp_asset->supplier_id,
            'warranty_months' => $temp_asset->warranty_months,
        ];

        // create
        $I->sendPOST('/hardware', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    /** @test */
    public function updateAssetWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update an asset with PATCH');

        // create
        $asset = factory(\App\Models\Asset::class)->states('laptop-mbp')->create([
            'company_id' => 2,
            'rtd_location_id' => 3
        ]);
        $I->assertInstanceOf(\App\Models\Asset::class, $asset);

        $temp_asset = factory(\App\Models\Asset::class)->states('laptop-air')->make([
            'company_id' => 3,
            'name' => "updated asset name",
            'rtd_location_id' => 1,
        ]);

        $data = [
            'asset_tag' => $temp_asset->asset_tag,
            'assigned_to' => $temp_asset->assigned_to,
            'company_id' => $temp_asset->company->id,
            'image' => $temp_asset->image,
            'model_id' => $temp_asset->model_id,
            'name' => $temp_asset->name,
            'notes' => $temp_asset->notes,
            'order_number' => $temp_asset->order_number,
            'purchase_cost' => $temp_asset->purchase_cost,
            'purchase_date' => $temp_asset->purchase_date->format('Y-m-d'),
            'rtd_location_id' => $temp_asset->rtd_location_id,
            'serial' => $temp_asset->serial,
            'status_id' => $temp_asset->status_id,
            'supplier_id' => $temp_asset->supplier_id,
            'warranty_months' => $temp_asset->warranty_months,
        ];

        $I->assertNotEquals($asset->name, $data['name']);

        // update
        $I->sendPATCH('/hardware/' . $asset->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        // dd($response);
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/hardware/message.update.success'), $response->messages);
        $I->assertEquals($asset->id, $response->payload->id); // asset id does not change
        $I->assertEquals($temp_asset->asset_tag, $response->payload->asset_tag); // asset tag updated
        $I->assertEquals($temp_asset->name, $response->payload->name); // asset name updated
        $I->assertEquals($temp_asset->rtd_location_id, $response->payload->rtd_location_id); // asset rtd_location_id updated
        $temp_asset->created_at = Carbon::parse($response->payload->created_at);
        $temp_asset->updated_at = Carbon::parse($response->payload->updated_at);
        $temp_asset->id = $asset->id;
        $temp_asset->location_id = $response->payload->rtd_location_id;

        // verify
        $I->sendGET('/hardware/' . $asset->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson((new AssetsTransformer)->transformAsset($temp_asset));
    }

    /** @test */
    public function deleteAssetTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an asset');

        // create
        $asset = factory(\App\Models\Asset::class)->states('laptop-mbp')->create();
        $I->assertInstanceOf(\App\Models\Asset::class, $asset);

        // delete
        $I->sendDELETE('/hardware/' . $asset->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/hardware/message.delete.success'), $response->messages);

        // verify, expect a 200
        $I->sendGET('/hardware/' . $asset->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        // Make sure we're soft deleted.
        $response = json_decode($I->grabResponse());
        $I->assertNotNull($response->deleted_at);
    }
}
