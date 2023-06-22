<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class RequestableAssetsTest extends TestCase
{
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
        $this->getJson(route('api.assets.requestable'))
            ->assertOk()
            ->assertResponseContainsInRows($requestableAsset, 'asset_tag')
            ->assertResponseDoesNotContainInRows($nonRequestableAsset, 'asset_tag');
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
        $this->getJson(route('api.assets.requestable'))
            ->assertResponseContainsInRows($assetA, 'asset_tag')
            ->assertResponseContainsInRows($assetB, 'asset_tag');

        Passport::actingAs($userInCompanyA);
        $this->getJson(route('api.assets.requestable'))
            ->assertResponseContainsInRows($assetA, 'asset_tag')
            ->assertResponseContainsInRows($assetB, 'asset_tag');

        Passport::actingAs($userInCompanyB);
        $this->getJson(route('api.assets.requestable'))
            ->assertResponseContainsInRows($assetA, 'asset_tag')
            ->assertResponseContainsInRows($assetB, 'asset_tag');

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $this->getJson(route('api.assets.requestable'))
            ->assertResponseContainsInRows($assetA, 'asset_tag')
            ->assertResponseContainsInRows($assetB, 'asset_tag');

        Passport::actingAs($userInCompanyA);
        $this->getJson(route('api.assets.requestable'))
            ->assertResponseContainsInRows($assetA, 'asset_tag')
            ->assertResponseDoesNotContainInRows($assetB, 'asset_tag');

        Passport::actingAs($userInCompanyB);
        $this->getJson(route('api.assets.requestable'))
            ->assertResponseDoesNotContainInRows($assetA, 'asset_tag')
            ->assertResponseContainsInRows($assetB, 'asset_tag');
    }
}
