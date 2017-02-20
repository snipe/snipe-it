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

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjRjMDMyMDYyN2FkNTg1YzZiYTVkZTAzOThlMGMzYmQyNzZlNzA2YzAxMDk4ODA2NzE4YjcyNWIzNDkzODc3YzQzNWQ0Zjg1MjAxYWU1MzMzIn0.eyJhdWQiOiIxIiwianRpIjoiNGMwMzIwNjI3YWQ1ODVjNmJhNWRlMDM5OGUwYzNiZDI3NmU3MDZjMDEwOTg4MDY3MThiNzI1YjM0OTM4NzdjNDM1ZDRmODUyMDFhZTUzMzMiLCJpYXQiOjE0ODc1ODc0NzUsIm5iZiI6MTQ4NzU4NzQ3NSwiZXhwIjoxODAzMTIwMjc1LCJzdWIiOiIxMiIsInNjb3BlcyI6W119.MrRaor9nSKmndbOBjpGtAzUmk3WGfRKD4LUJTr3eepj-c5gv2A5bOO6pJ47YLZ5tqGyt7jgxErW5J3OOogSRipuIn-eRzW_pSgGj3qbOXDdEGU5HXHFGhoEpKW8Uk00eNbl1Mt-Dl-tj02rOxslhDYrXv3rZzcreeT9HJKZGZAkaRQZPWPmuAiYF06YBf4bKVogrtlG4LOFjhGnl9rsYygmylfzGhHlfq0jH9R9vNurWbQ2JEJVFFyDMK7_95jCvWrlXNQ5KncUSDrHzV3TI2UM0LWMYrTEF8CC0Em5UwUNEnG7BBpf2f-QWwt7KSR4NVdUn6hVADWWD1c1iRNbvlVehPm4fpmQ_QpODE-fg6v7cu58loePTPTd5BpXxDKXERRKxuQ47v-9iesc0YqsHFj15yuKrHodge96zIsbWasNw8gZ5q9WN7HOjK4OKXpnyHSx1s_U_XrQKZz_a6GgagQ21WABoOgBPozlbtlCVSc1uGwHnThVZKiJ4qIy1-8NDiObi6E3ncC_e3zvGRHreqZ7H5t_lCK45aEvJDxKTCgHPhNXEMvYmp5dclhhpNgybreNrVH7S2yCCkY5vdjMqjej0HIhpHBTWfvOIC7Kjh1PQkg_u7KkXUDXQw_VTAIOO7WaO5FouAMsUWnuMk88eU3kjGFHtW83wCuo6pdA73x8';

        $I->amBearerAuthenticated($token);
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
            'name' => $this->faker->word,
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
