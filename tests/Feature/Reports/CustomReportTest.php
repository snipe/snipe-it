<?php

namespace Tests\Feature\Reports;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use League\Csv\Reader;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class CustomReportTest extends TestCase
{
    use InteractsWithSettings;

    public function testCustomAssetReport()
    {
        Asset::factory()->create(['name' => 'Asset A']);
        Asset::factory()->create(['name' => 'Asset B']);

        $response = $this->actingAs(User::factory()->canViewReports()->create())
            ->post('reports/custom', [
                'asset_name' => '1',
                'asset_tag' => '1',
                'serial' => '1',
            ])->assertOk()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8');

        $this->assertResponseContains($response, 'Asset A');
        $this->assertResponseContains($response, 'Asset B');
    }

    public function testCustomAssetReportAdheresToCompanyScoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        Asset::factory()->for($companyA)->create(['name' => 'Asset A']);
        Asset::factory()->for($companyB)->create(['name' => 'Asset B']);

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->canViewReports()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->canViewReports()->make());

        $this->settings->disableMultipleFullCompanySupport();

        $response = $this->actingAs($superUser)
            ->post('reports/custom', [
                'asset_name' => '1',
                'asset_tag' => '1',
                'serial' => '1',
            ]);
        $this->assertResponseContains($response, 'Asset A');
        $this->assertResponseContains($response, 'Asset B');

        $response = $this->actingAs($userInCompanyA)
            ->post('reports/custom', [
                'asset_name' => '1',
                'asset_tag' => '1',
                'serial' => '1',
            ]);
        $this->assertResponseContains($response, 'Asset A');
        $this->assertResponseContains($response, 'Asset B');

        $response = $this->actingAs($userInCompanyB)
            ->post('reports/custom', [
                'asset_name' => '1',
                'asset_tag' => '1',
                'serial' => '1',
            ]);
        $this->assertResponseContains($response, 'Asset A');
        $this->assertResponseContains($response, 'Asset B');

        $this->settings->enableMultipleFullCompanySupport();

        $response = $this->actingAs($superUser)
            ->post('reports/custom', [
                'asset_name' => '1',
                'asset_tag' => '1',
                'serial' => '1',
            ]);
        $this->assertResponseContains($response, 'Asset A');
        $this->assertResponseContains($response, 'Asset B');

        $response = $this->actingAs($userInCompanyA)
            ->post('reports/custom', [
                'asset_name' => '1',
                'asset_tag' => '1',
                'serial' => '1',
            ]);
        $this->assertResponseContains($response, 'Asset A');
        $this->assertResponseDoesNotContain($response, 'Asset B');

        $response = $this->actingAs($userInCompanyB)
            ->post('reports/custom', [
                'asset_name' => '1',
                'asset_tag' => '1',
                'serial' => '1',
            ]);
        $this->assertResponseDoesNotContain($response, 'Asset A');
        $this->assertResponseContains($response, 'Asset B');
    }

    private function assertResponseContains(TestResponse $response, string $needle)
    {
        $this->assertTrue(
            collect(Reader::createFromString($response->streamedContent())->getRecords())
                ->pluck(0)
                ->contains($needle)
        );
    }

    private function assertResponseDoesNotContain(TestResponse $response, string $needle)
    {
        $this->assertFalse(
            collect(Reader::createFromString($response->streamedContent())->getRecords())
                ->pluck(0)
                ->contains($needle)
        );
    }
}
