<?php

class ApiComponentsAssetsCest
{
    protected $faker;
    protected $user;

    // public function _before(ApiTester $I)
    // {
    //     $this->faker = \Faker\Factory::create();
    //     $this->user = \App\Models\User::find(1);

    //     $I->amBearerAuthenticated($I->getToken($this->user));
    // }

    // // /** @test */
    // // public function indexComponentsAssets(ApiTester $I)
    // // {
    // //     $I->wantTo('Get a list of assets related to a component');

    // //     // generate component
    // //     $component = factory(\App\Models\Component::class)
    // //                 ->create(['user_id' => $this->user->id, 'qty' => 20]);

    // //     // generate assets and associate component
    // //     $assets = factory(\App\Models\Asset::class, 2)
    // //                 ->create(['user_id' => $this->user->id])
    // //                 ->each(function ($asset) use ($component) {
    // //                     $component->assets()->attach($component->id, [
    // //                         'component_id' => $component->id,
    // //                         'user_id' => $this->user->id,
    // //                         'created_at' => date('Y-m-d H:i:s'),
    // //                         'assigned_qty' => 2,
    // //                         'asset_id' => $asset->id
    // //                     ]);
    // //                 });

    // //     // verify
    // //     $I->sendGET('/components/' . $component->id . '/assets/');
    // //     $I->seeResponseIsJson();
    // //     $I->seeResponseCodeIs(200);

    // //     $response = json_decode($I->grabResponse());
    // //     $I->assertEquals(2, $response->total);

    // //     $I->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $assets);

    // //     $I->seeResponseContainsJson(['rows' => [
    // //             0 => [
    // //                 'name' => $assets[0]->name,
    // //                 'id' => $assets[0]->id,
    // //                 'created_at' => $assets[0]->created_at->format('Y-m-d'),
    // //             ],
    // //             1 => [
    // //                 'name' => $assets[1]->name,
    // //                 'id' => $assets[1]->id,
    // //                 'created_at' => $assets[1]->created_at->format('Y-m-d'),
    // //             ],
    // //         ]
    // //     ]);
    // // }

    // // /** @test */
    // // public function expectEmptyResponseWithoutAssociatedAssets(ApiTester $I, $scenario)
    // // {
    // //     $I->wantTo('See an empty response when there are no associated assets to a component');

    // //     $component = factory(\App\Models\Component::class)
    // //                 ->create(['user_id' => $this->user->id, 'qty' => 20]);

    // //     $I->sendGET('/components/' . $component->id . '/assets');
    // //     $I->seeResponseCodeIs(200);
    // //     $I->seeResponseIsJson();

    // //     $response = json_decode($I->grabResponse());
    // //     $I->assertEquals(0, $response->total);
    // //     $I->assertEquals([], $response->rows);
    // //     $I->seeResponseContainsJson(['total' => 0, 'rows' => []]);
    // // }
}
