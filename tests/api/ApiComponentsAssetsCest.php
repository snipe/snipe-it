<?php

class ApiComponentsAssetsCest
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
    public function indexComponentsAssets(ApiTester $I)
    {
        $I->wantTo('Get a list of assets related to a component');

        // generate
        $component = factory(\App\Models\Component::class, 'component')
                    ->create(['user_id' => $this->user->id, 'qty' => 20]);

        $assets = factory(\App\Models\Asset::class, 'asset', 2)
                    ->create(['user_id' => $this->user->id])
                    ->each(function ($asset) use ($component) {
                        $component->assets()->attach($component->id, [
                            'component_id' => $component->id,
                            'user_id' => $this->user->id,
                            'created_at' => date('Y-m-d H:i:s'),
                            'assigned_qty' => 2,
                            'asset_id' => $asset->id
                        ]);
                    });

        $I->sendGET('/components/' . $component->id . '/assets/');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $response = json_decode($I->grabResponse());

        $I->assertEquals(2, $response->total);
        $I->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $assets);

        $random_asset = $assets->random();
        $I->seeResponseContainsJson([
            'name' => $random_asset->name,
            'asset_tag' => $random_asset->asset_tag,
            'serial' => $random_asset->serial,
            'last_checkout' => $random_asset->last_checkout,
            'notes' => $random_asset->notes,
        ]);
    }
}
