<?php

use Illuminate\Support\Facades\Auth;

class ApiAssetsCest
{
    protected $faker;
    protected $user;

    public function _before(ApiTester $I)
    {
        $this->faker = \Faker\Factory::create();
        $this->user = \App\Models\User::find(1);

        $I->amBearerAuthenticated($I->getToken($this->user));
    }

    /** @test */
    public function indexAssets(ApiTester $I)
    {
        $I->wantTo('Get a list of assets');

        // setup
        $assets = factory(\App\Models\Asset::class, 'asset', 10)->create([
            'user_id' => $this->user->id,
        ]);

        // call
        $I->sendGET('/hardware');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());

        // sample verify
        $asset = $assets->random();

        $I->seeResponseContainsJson([
            'id' => $asset->id,
            'name' =>  e($asset->name),
            'asset_tag' =>  $asset->asset_tag,
            'serial' =>  $asset->serial,
            'model' =>  [
                'id' =>  $asset->model_id,
                'name' =>  e($asset->model->name),
            ],
            // TODO: model_label
            'last_checkout' =>  $asset->last_checkout,
            // TODO: category [id, name]
            // TODO: manufacturer [id, name]
            'notes' =>  $asset->notes,
            'expected_checkin' =>  $asset->expected_checkin,
            'order_number' =>  $asset->order_number,
            'company' =>  [
                'id' =>  $asset->company->id,
                'name' =>  $asset->company->name,
            ],
            // TODO: location [id, name]
            // TODO: rtd_location [id, name]
            'image' =>  $asset->image,
            'assigned_to' =>  $asset->assigned_to,
            'warranty' =>  $asset->warranty,
            'warranty_expires' =>  $asset->warranty_expires,
            // TODO: created_at
            'purchase_date' =>  $asset->purchase_date->format('Y-m-d'),
            'purchase_cost' =>  \App\Helpers\Helper::formatCurrencyOutput($asset->purchase_cost),
            // TODO: user_can_checkout
            // TODO: available actions
        ]);
    }

    /** @test */
    public function createAsset(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new asset');

        $temp_asset = factory(\App\Models\Asset::class, 'asset')->make();

        // setup
        $data = [
            'asset_tag' => $temp_asset->tag,
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

        $scenario->incomplete('When I POST to /hardware i am redirected to html login page 😰');
        // create
        $I->sendPOST('/hardware', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

    }

    /** @test */
    public function updateAssetWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update an asset with PATCH');

        // create and store an asset
        $asset = factory(\App\Models\Asset::class, 'asset')->create();
        $I->assertInstanceOf(\App\Models\Asset::class, $asset);

        // create a temporary asset to grab new data
        $temp_asset = factory(\App\Models\Asset::class, 'asset')->make();
        $data = [
            'asset_tag' => $temp_asset->tag,
            'assigned_to' => $temp_asset->assigned_to,
            'company_id' => $temp_asset->company->id,
            'image' => $temp_asset->image,
            'model_id' => $temp_asset->model_id,
            'name' => $temp_asset->name,
            'notes' => $temp_asset->notes,
            'purchase_cost' => $temp_asset->purchase_cost,
            'purchase_date' => $temp_asset->purchase_date->format('Y-m-d'),
            'rtd_location_id' => $temp_asset->rtd_location_id,
            'serial' => $temp_asset->serial,
            'status_id' => $temp_asset->status_id,
            'supplier_id' => $temp_asset->supplier_id,
            'warranty_months' => $temp_asset->warranty_months,
        ];

        // the asset name should be different
        $I->assertNotEquals($asset->name, $data['name']);

        // update
        $I->sendPATCH('/hardware/' . $asset->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);

        // verify
        $scenario->incomplete('[BadMethodCallException] Call to undefined method Illuminate\Database\Query\Builder::detail() 🤔');
        $I->sendGET('/hardware/' . $asset->id);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => $data['name'],
            'id' => $asset->id,
        ]);
    }

    /** @test */
/*    public function updateAssetWithPut(ApiTester $I)
    {
        $I->wantTo('Update a asset with PUT');

        // create
        $asset = factory(\App\Models\Asset::class, 'asset')->create();
        $I->assertInstanceOf(\App\Models\Asset::class, $asset);

        $data = [
            'name' => $this->faker->sentence(3),
        ];

        $I->assertNotEquals($asset->name, $data['name']);

        // update
        $I->sendPUT('/hardware/' . $asset->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);

        // verify
        $I->sendGET('/hardware/' . $asset->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => e($data['name']),
            'id' => e($asset->id),
            'qty' => e($asset->qty),
        ]);
    }

    /** @test */
/*    public function deleteAssetTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an asset');

        // create
        $asset = factory(\App\Models\Asset::class, 'asset')->create();
        $I->assertInstanceOf(\App\Models\Asset::class, $asset);

        // delete
        $I->sendDELETE('/hardware/' . $asset->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        // verify, expect a 404
        $I->sendGET('/hardware/' . $asset->id);
        $I->seeResponseCodeIs(404);
        // $I->seeResponseIsJson(); // @todo: response is not JSON
        $scenario->incomplete('404 response should be JSON, receiving HTML instead');
    } // */
}
