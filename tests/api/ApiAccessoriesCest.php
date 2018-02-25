<?php

use App\Helpers\Helper;
use App\Http\Transformers\AccessoriesTransformer;
use App\Models\Accessory;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ApiAccessoriesCest
{
    protected $user;
    protected $timeFormat;

    public function _before(ApiTester $I)
    {
        $this->user = \App\Models\User::find(1);
        $I->haveHttpHeader('Accept', 'application/json');
        $I->amBearerAuthenticated($I->getToken($this->user));
    }

    /** @test */
    public function indexAccessories(ApiTester $I)
    {

        $I->wantTo('Get a list of accessories');

        // call
        $I->sendGET('/accessories?limit=10');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        // sample verify
        $accessory = App\Models\Accessory::orderByDesc('created_at')->take(10)->get()->shuffle()->first();
        $I->seeResponseContainsJson((new AccessoriesTransformer)->transformAccessory($accessory));
    }

    /** @test */
    public function createAccessory(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new accessory');

        $temp_accessory = factory(\App\Models\Accessory::class)->states('apple-bt-keyboard')->make([
            'name' => "Test Accessory Name",
            'company_id' => 2
        ]);

        // setup
        $data = [
            'category_id' => $temp_accessory->category_id,
            'company_id' => $temp_accessory->company->id,
            'location_id' => $temp_accessory->location_id,
            'name' => $temp_accessory->name,
            'order_number' => $temp_accessory->order_number,
            'purchase_cost' => $temp_accessory->purchase_cost,
            'purchase_date' => $temp_accessory->purchase_date,
            'model_number' => $temp_accessory->model_number,
            'manufacturer_id' => $temp_accessory->manufacturer_id,
            'supplier_id' => $temp_accessory->supplier_id,
            'qty' => $temp_accessory->qty,
        ];

        // create
        $I->sendPOST('/accessories', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    // Put is routed to the same method in the controller
    // DO we actually need to test both?
    /** @test */
    public function updateAccessoryWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update an accessory with PATCH');

        // create
        $accessory = factory(\App\Models\Accessory::class)->states('apple-bt-keyboard')->create([
            'name' => 'Original Accessory Name',
            'company_id' => 2,
            'location_id' => 3
        ]);
        $I->assertInstanceOf(\App\Models\Accessory::class, $accessory);

        $temp_accessory = factory(\App\Models\Accessory::class)->states('microsoft-mouse')->make([
            'company_id' => 3,
            'name' => "updated accessory name",
            'location_id' => 1,
        ]);

        $data = [
            'category_id' => $temp_accessory->category_id,
            'company_id' => $temp_accessory->company->id,
            'location_id' => $temp_accessory->location_id,
            'name' => $temp_accessory->name,
            'order_number' => $temp_accessory->order_number,
            'purchase_cost' => $temp_accessory->purchase_cost,
            'purchase_date' => $temp_accessory->purchase_date,
            'model_number' => $temp_accessory->model_number,
            'manufacturer_id' => $temp_accessory->manufacturer_id,
            'supplier_id' => $temp_accessory->supplier_id,
            'qty' => $temp_accessory->qty,
        ];

        $I->assertNotEquals($accessory->name, $data['name']);

        // update
        $I->sendPATCH('/accessories/' . $accessory->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());

        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/accessories/message.update.success'), $response->messages);
        $I->assertEquals($accessory->id, $response->payload->id); // accessory id does not change
        $I->assertEquals($temp_accessory->company_id, $response->payload->company_id); // company_id updated
        $I->assertEquals($temp_accessory->name, $response->payload->name); // accessory name updated
        $I->assertEquals($temp_accessory->location_id, $response->payload->location_id); // accessory location_id updated
        $temp_accessory->created_at = Carbon::parse($response->payload->created_at);
        $temp_accessory->updated_at = Carbon::parse($response->payload->updated_at);
        $temp_accessory->id = $accessory->id;
        // verify
        $I->sendGET('/accessories/' . $accessory->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson((new AccessoriesTransformer)->transformAccessory($temp_accessory));
    }

    /** @test */
    public function deleteAccessoryTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an accessory');

        // create
        $accessory = factory(\App\Models\Accessory::class)->states('apple-bt-keyboard')->create([
            'name' => "Soon to be deleted"
        ]);
        $I->assertInstanceOf(\App\Models\Accessory::class, $accessory);

        // delete
        $I->sendDELETE('/accessories/' . $accessory->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/accessories/message.delete.success'), $response->messages);

        // verify, expect a 200
        $I->sendGET('/accessories/' . $accessory->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
