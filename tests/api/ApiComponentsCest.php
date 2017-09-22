<?php

use Illuminate\Support\Facades\Auth;

class ApiComponentsCest
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
    public function indexComponents(ApiTester $I)
    {
        $I->wantTo('Get a list of components');

        // setup
        $components = factory(\App\Models\Component::class, 10)->create();

        // call
        $I->sendGET('/components');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        // sample verify
        $component = $components->random();
        $I->seeResponseContainsJson([
            'name' => $component->name,
            'qty' => $component->qty,
        ]);

        $I->seeResponseContainsJson([
            'total' => \App\Models\Component::count(),
        ]);
    }

    /** @test */
    public function createComponent(ApiTester $I)
    {
        $I->wantTo('Create a new component');

        // setup
        $category = factory(\App\Models\Category::class)->create(['user_id' => $this->user->id]);
        $location = factory(\App\Models\Location::class)->create(['user_id' => $this->user->id]);
        $company = factory(\App\Models\Company::class)->create();

        $data = [
            'category_id' => $category->id,
            'company_id' => $company->id,
            'location_id' => $location->id,
            'name' => $this->faker->sentence(3),
            'purchase_cost' => $this->faker->randomFloat(2, 0),
            'purchase_date' => $this->faker->dateTime->format('Y-m-d'),
            'qty' => rand(1, 10),
        ];

        // create
        $I->sendPOST('/components', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $id = $response->payload->id;

        $I->assertEquals('success', $response->status);

        // verify
        $I->sendGET('/components/' . $id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'id' => (int) $id,
            'name' => e($data['name']),
            // 'serial_number' => e($component->serial),
            'location' => [
                'id' => (int) $data['location_id'],
                'name' => e($location->name),
            ],
            'qty' => number_format($data['qty']),
            // 'min_amt' => e($component->min_amt),
            'category' => [
                'id' => (int) $data['category_id'],
                'name' => e($category->name),
            ],
            // 'order_number'  => e($component->order_number),
            'purchase_date' =>  \App\Helpers\Helper::getFormattedDateObject($data['purchase_date'], 'date'),
            'purchase_cost' => \App\Helpers\Helper::formatCurrencyOutput($data['purchase_cost']),
            // 'remaining' => (int) $component->numRemaining(),
            'company' => [
                'id' => (int) $data['company_id'],
                'name' => e($company->name),
            ],
            // 'created_at' => Helper::getFormattedDateObject($component->created_at, 'datetime'),
            // 'updated_at' => Helper::getFormattedDateObject($component->updated_at, 'datetime'),
        ]);
    }

    /** @test */
    public function updateComponentWithPatch(ApiTester $I)
    {
        $I->wantTo('Update a component with PATCH');

        // create
        $component = factory(\App\Models\Component::class)->create();
        $I->assertInstanceOf(\App\Models\Component::class, $component);

        $data = [
            'name' => $this->faker->sentence(3),
            'qty' => $this->faker->randomDigit + 1,
        ];

        $I->assertNotEquals($component->name, $data['name']);

        // update
        $I->sendPATCH('/components/' . $component->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);

        // verify
        $I->sendGET('/components/' . $component->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => $data['name'],
            'id' => $component->id,
            'qty' => $data['qty'],
        ]);
    }

    /** @test */
    public function updateComponentWithPut(ApiTester $I)
    {
        $I->wantTo('Update a component with PUT');

        // create
        $component = factory(\App\Models\Component::class)->create();
        $I->assertInstanceOf(\App\Models\Component::class, $component);

        $data = [
            'name' => $this->faker->sentence(3),
        ];

        $I->assertNotEquals($component->name, $data['name']);

        // update
        $I->sendPUT('/components/' . $component->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);

        // verify
        $I->sendGET('/components/' . $component->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'name' => e($data['name']),
            'id' => e($component->id),
            'qty' => e($component->qty),
        ]);
    }

    /** @test */
    public function deleteComponentTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete a component');

        // create
        $component = factory(\App\Models\Component::class)->create();
        $I->assertInstanceOf(\App\Models\Component::class, $component);

        // delete
        $I->sendDELETE('/components/' . $component->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        // verify, expect a 200 with an error message
        $I->sendGET('/components/' . $component->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson(); // @todo: response is not JSON
        // $scenario->incomplete('Resource not found response should be JSON, receiving HTML instead');
    }
}
