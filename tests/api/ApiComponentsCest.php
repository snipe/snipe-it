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
        $I->sendGET('/components');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    /** @test */
    public function createComponent(ApiTester $I)
    {
        $I->wantTo('Create a new component');

        // setup
        $category = factory(\App\Models\Category::class, 'category')->create(['user_id' => $this->user->id]);
        $location = factory(\App\Models\Location::class, 'location')->create(['user_id' => $this->user->id]);
        $company = factory(\App\Models\Company::class, 'company')->create();

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
            'id' => $id,
            'category' => [
                'id' => $data['category_id'],
                'name' => $category->name,
            ],
            'company' => [
                'id' => $data['company_id'],
                'name' => $company->name,
            ],
            'location' => [
                'id' => $data['location_id'],
                'name' => $location->name,
            ],
            'name' => $data['name'],
            'qty' => $data['qty'],
            'purchase_cost' => $data['purchase_cost'],
            'purchase_date' => $data['purchase_date'],
        ]);
    }

    /** @test */
    public function updateComponent(ApiTester $I)
    {
        $I->wantTo('Update a component');

        // create
        $component = factory(\App\Models\Component::class, 'component')->create();
        $I->assertInstanceOf(\App\Models\Component::class, $component);

        $data = [
            'name' => $this->faker->sentence(3),
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
        ]);

    }

    /** @test */
    public function deleteComponentTest(ApiTester $I)
    {
        $I->wantTo('Delete a component');

        // create
        $component = factory(\App\Models\Component::class, 'component')->create();
        $I->assertInstanceOf(\App\Models\Component::class, $component);

        // delete
        $I->sendDELETE('/components/' . $component->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        // verify, expect a 404
        $I->sendGET('/components/' . $component->id);
        // $I->seeResponseIsJson(); // @todo: response is not JSON
        $I->seeResponseCodeIs(404);
    }
}
