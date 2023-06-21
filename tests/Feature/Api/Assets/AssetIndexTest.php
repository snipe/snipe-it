<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithResponses;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AssetIndexTest extends TestCase
{
    use InteractsWithResponses;
    use InteractsWithSettings;

    public function testAssetIndexReturnsExpectedAssets()
    {
        Asset::factory()->count(3)->create();

        Passport::actingAs(User::factory()->superuser()->create());
        $this->getJson(
            route('api.assets.index', [
                'sort' => 'name',
                'order' => 'asc',
                'offset' => '0',
                'limit' => '20',
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'total',
                'rows',
            ])
            ->assertJson(fn(AssertableJson $json) => $json->has('rows', 3)->etc());
    }

    public function testAssetIndexAdheresToCompanyScoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $assetA = Asset::factory()->for($companyA)->create();
        $assetB = Asset::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewAssets()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewAssets()->make());

        $this->settings->disableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.assets.index'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.assets.index'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.assets.index'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.assets.index'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.assets.index'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseDoesNotContainInRows($response, $assetB, 'asset_tag');

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.assets.index'));
        $this->assertResponseDoesNotContainInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');
    }
}
