<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithResponses;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AssetsForSelectListTest extends TestCase
{
    use InteractsWithResponses;
    use InteractsWithSettings;

    public function testAssetsCanBeSearchedForByAssetTag()
    {
        Asset::factory()->create(['asset_tag' => '0001']);
        Asset::factory()->create(['asset_tag' => '0002']);

        Passport::actingAs(User::factory()->create());

        $response = $this->getJson(route('assets.selectlist', ['search' => '000']))->assertOk();

        $results = collect($response->json('results'));

        $this->assertEquals(2, $results->count());
        $this->assertTrue($results->pluck('text')->contains(fn($text) => str_contains($text, '0001')));
        $this->assertTrue($results->pluck('text')->contains(fn($text) => str_contains($text, '0002')));
    }

    public function testAssetsAreScopedToCompanyWhenMultipleCompanySupportEnabled()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $assetA = Asset::factory()->for($companyA)->create(['asset_tag' => '0001']);
        $assetB = Asset::factory()->for($companyB)->create(['asset_tag' => '0002']);

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewAssets()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewAssets()->make());

        $this->settings->disableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('assets.selectlist', ['search' => '000']));
        $this->assertResponseContainsInResults($response, $assetA);
        $this->assertResponseContainsInResults($response, $assetB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('assets.selectlist', ['search' => '000']));
        $this->assertResponseContainsInResults($response, $assetA);
        $this->assertResponseContainsInResults($response, $assetB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('assets.selectlist', ['search' => '000']));
        $this->assertResponseContainsInResults($response, $assetA);
        $this->assertResponseContainsInResults($response, $assetB);

        $this->settings->enableMultipleFullCompanySupport();

        Passport::actingAs($superUser);
        $response = $this->getJson(route('assets.selectlist', ['search' => '000']));
        $this->assertResponseContainsInResults($response, $assetA);
        $this->assertResponseContainsInResults($response, $assetB);

        Passport::actingAs($userInCompanyA);
        $response = $this->getJson(route('assets.selectlist', ['search' => '000']));
        $this->assertResponseContainsInResults($response, $assetA);
        $this->assertResponseDoesNotContainInResults($response, $assetB);

        Passport::actingAs($userInCompanyB);
        $response = $this->getJson(route('assets.selectlist', ['search' => '000']));
        $this->assertResponseDoesNotContainInResults($response, $assetA);
        $this->assertResponseContainsInResults($response, $assetB);
    }
}
