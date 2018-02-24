<?php

use App\Helpers\Helper;
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
        $this->timeFormat = Setting::getSettings()->date_display_format .' '. Setting::getSettings()->time_display_format;
        $this->dateFormat = Setting::getSettings()->date_display_format;
        $I->amBearerAuthenticated($I->getToken($this->user));
    }

    /** @test */
    public function indexAccessorys(ApiTester $I)
    {

        $I->wantTo('Get a list of accessories');

        // call
        $I->sendGET('/accessories?limit=10');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        // dd($response);
        // sample verify
        $accessory = App\Models\Accessory::orderByDesc('created_at')->take(10)->get()->shuffle()->first();

        $I->seeResponseContainsJson($this->generateJsonResponse($accessory, $accessory));
    }

    /** @test */
    public function createAccessory(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new accessory');

        $temp_accessory = factory(\App\Models\Accessory::class)->states('apple-bt-keyboard')->make([
            'accessory_tag' => "Test Accessory Tag",
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
        $I->assertEquals($temp_accessory->location_id, $response->payload->location_id); // accessory rtd_location_id updated

        // verify
        $I->sendGET('/accessories/' . $accessory->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($this->generateJsonResponse($temp_accessory, $accessory));
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
        $I->seeResponseCodeIs(404);

        $scenario->incomplete('not found response should be JSON, receiving HTML instead');
    }

    protected function generateJsonResponse($accessory, $orig_accessory)
    {
        return [
            'id' => (int) $orig_accessory->id,
            'name' => e($accessory->name),
            'company' => ($accessory->company) ? [
                'id' => (int) $accessory->company->id,
                'name'=> e($accessory->company->name)
            ] : null,
            'manufacturer' => ($accessory->manufacturer) ? [
                'id' => (int) $accessory->manufacturer->id,
                'name'=> e($accessory->manufacturer->name)
            ] : null,
            'supplier' => ($accessory->supplier) ? [
                'id' => (int) $accessory->supplier->id,
                'name'=> e($accessory->supplier->name)
            ] : null,
            'model_number' => ($accessory) ? e($accessory->model_number) : null,
            'category' => ($accessory->category) ? [
                'id' => (int) $accessory->category->id,
                'name'=> e($accessory->category->name)
            ]  : null,
            'location' => ($accessory->location) ? [
                'id' => (int) $accessory->location->id,
                'name'=> e($accessory->location->name)
            ]  : null,
            'notes' => ($accessory->notes) ? e($accessory->notes) : null,
            'qty' => $accessory->qty,
            'purchase_date' => Helper::getFormattedDateObject($accessory->purchase_date, 'date'),
            'purchase_cost' => ($accessory->purchase_cost) ? e($accessory->purchase_cost) : null,
            'order_number' => ($accessory->order_number) ? e($accessory->order_number) : null,
            'image' => ($accessory->image) ? url('/').'/uploads/accessories/'.e($accessory->image) : null,
            'created_at' => Helper::getFormattedDateObject($orig_accessory->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($orig_accessory->updated_at, 'datetime'),
            'available_actions' => [
                'checkout' => (bool) Gate::allows('checkout', Accessory::class),
                'checkin' => (bool) false,
                'update' => (bool) Gate::allows('update', Accessory::class),
                'delete' => (bool) Gate::allows('delete', Accessory::class),
            ],
        ];
    }
}
