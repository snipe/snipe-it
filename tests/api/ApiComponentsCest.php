<?php

use App\Helpers\Helper;
use App\Http\Transformers\ComponentsTransformer;
use App\Models\Component;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ApiComponentsCest
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
    public function indexComponents(ApiTester $I)
    {
        $I->wantTo('Get a list of components');

        // call
        $I->sendGET('/components?limit=10');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        // sample verify
        $component = App\Models\Component::orderByDesc('created_at')->take(10)->get()->shuffle()->first();

        $I->seeResponseContainsJson($I->removeTimestamps((new ComponentsTransformer)->transformComponent($component)));
    }

    /** @test */
    public function createComponent(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new component');

        $temp_component = factory(\App\Models\Component::class)->states('ram-crucial4')->make([
            'name' => "Test Component Name",
            'company_id' => 2
        ]);

        // setup
        $data = [
            'category_id' => $temp_component->category_id,
            'company_id' => $temp_component->company->id,
            'location_id' => $temp_component->location_id,
            'manufacturer_id' => $temp_component->manufacturer_id,
            'model_number' => $temp_component->model_number,
            'name' => $temp_component->name,
            'order_number' => $temp_component->order_number,
            'purchase_cost' => $temp_component->purchase_cost,
            'purchase_date' => $temp_component->purchase_date,
            'qty' => $temp_component->qty,
            'serial' => $temp_component->serial
        ];

        // create
        $I->sendPOST('/components', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    // Put is routed to the same method in the controller
    // DO we actually need to test both?
    /** @test */
    public function updateComponentWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update an component with PATCH');

        // create
        $component = factory(\App\Models\Component::class)->states('ram-crucial4')->create([
            'name' => 'Original Component Name',
            'company_id' => 2,
            'location_id' => 3
        ]);
        $I->assertInstanceOf(\App\Models\Component::class, $component);

        $temp_component = factory(\App\Models\Component::class)->states('ssd-crucial240')->make([
            'company_id' => 3,
            'name' => "updated component name",
            'location_id' => 1,
        ]);

        $data = [
            'category_id' => $temp_component->category_id,
            'company_id' => $temp_component->company->id,
            'location_id' => $temp_component->location_id,
            'min_amt' => $temp_component->min_amt,
            'name' => $temp_component->name,
            'order_number' => $temp_component->order_number,
            'purchase_cost' => $temp_component->purchase_cost,
            'purchase_date' => $temp_component->purchase_date,
            'qty' => $temp_component->qty,
            'serial' => $temp_component->serial,
        ];

        $I->assertNotEquals($component->name, $data['name']);

        // update
        $I->sendPATCH('/components/' . $component->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());

        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/components/message.update.success'), $response->messages);
        $I->assertEquals($component->id, $response->payload->id); // component id does not change
        $I->assertEquals($temp_component->company_id, $response->payload->company_id); // company_id updated
        $I->assertEquals($temp_component->name, $response->payload->name); // component name updated
        $I->assertEquals($temp_component->location_id, $response->payload->location_id); // component location_id updated
        $temp_component->created_at = Carbon::parse($response->payload->created_at);
        $temp_component->updated_at = Carbon::parse($response->payload->updated_at);
        $temp_component->id = $component->id;
        // verify
        $I->sendGET('/components/' . $component->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson((new ComponentsTransformer)->transformComponent($temp_component));
    }

    /** @test */
    public function deleteComponentTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an component');

        // create
        $component = factory(\App\Models\Component::class)->states('ram-crucial4')->create([
            'name' => "Soon to be deleted"
        ]);
        $I->assertInstanceOf(\App\Models\Component::class, $component);

        // delete
        $I->sendDELETE('/components/' . $component->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        // dd($response);
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/components/message.delete.success'), $response->messages);

        // verify, expect a 200
        $I->sendGET('/components/' . $component->id);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
