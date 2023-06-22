<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithResponses;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class RequestableAssetsTest extends TestCase
{
    use InteractsWithResponses;
    use InteractsWithSettings;

    public function testViewingRequestableAssetsRequiresCorrectPermission()
    {
        Passport::actingAs(User::factory()->create());
        $this->getJson(route('api.assets.requestable'))->assertForbidden();
    }

    public function testReturnsRequestableAssets()
    {
        $requestableAsset = Asset::factory()->requestable()->create(['asset_tag' => 'requestable']);
        $nonRequestableAsset = Asset::factory()->nonrequestable()->create(['asset_tag' => 'non-requestable']);

        Passport::actingAs(User::factory()->viewRequestableAssets()->create());
        $response = $this->getJson(route('api.assets.requestable'))->assertOk();

        $this->assertResponseContainsInRows($response, $requestableAsset, 'asset_tag');
        $this->assertResponseDoesNotContainInRows($response, $nonRequestableAsset, 'asset_tag');
    }

    public function testRequestableAssetsAreScopedToCompanyWhenMultipleCompanySupportEnabled()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $assetA = Asset::factory()->requestable()->for($companyA)->create(['asset_tag' => '0001']);
        $assetB = Asset::factory()->requestable()->for($companyB)->create(['asset_tag' => '0002']);

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewRequestableAssets()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewRequestableAssets()->make());

        $this->settings->disableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.assets.requestable'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.assets.requestable'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.assets.requestable'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('api.assets.requestable'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('api.assets.requestable'));
        $this->assertResponseContainsInRows($response, $assetA, 'asset_tag');
        $this->assertResponseDoesNotContainInRows($response, $assetB, 'asset_tag');

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('api.assets.requestable'));
        $this->assertResponseDoesNotContainInRows($response, $assetA, 'asset_tag');
        $this->assertResponseContainsInRows($response, $assetB, 'asset_tag');
    }
}
