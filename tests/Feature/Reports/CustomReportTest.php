<?php

namespace Tests\Feature\Reports;

use App\Models\Asset;
use App\Models\Company;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use League\Csv\Reader;
use PHPUnit\Framework\Assert;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class CustomReportTest extends TestCase
{
    use InteractsWithSettings;

    protected function setUp(): void
    {
        parent::setUp();

        TestResponse::macro(
            'assertSeeTextInStreamedResponse',
            function (string $needle) {
                Assert::assertTrue(
                    collect(Reader::createFromString($this->streamedContent())->getRecords())
                        ->pluck(0)
                        ->contains($needle)
                );

                return $this;
            }
        );

        TestResponse::macro(
            'assertDontSeeTextInStreamedResponse',
            function (string $needle) {
                Assert::assertFalse(
                    collect(Reader::createFromString($this->streamedContent())->getRecords())
                        ->pluck(0)
                        ->contains($needle)
                );

                return $this;
            }
        );
    }

    public function testCustomAssetReport()
    {
        Asset::factory()->create(['name' => 'Asset A']);
        Asset::factory()->create(['name' => 'Asset B']);

        $this->actingAs(User::factory()->canViewReports()->create())
            ->post('reports/custom', [
                'asset_name' => '1',
                'asset_tag' => '1',
                'serial' => '1',
            ])->assertOk()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8')
            ->assertSeeTextInStreamedResponse('Asset A')
            ->assertSeeTextInStreamedResponse('Asset B');
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

        $this->actingAs($superUser)
            ->post('reports/custom', ['asset_name' => '1', 'asset_tag' => '1', 'serial' => '1'])
            ->assertSeeTextInStreamedResponse('Asset A')
            ->assertSeeTextInStreamedResponse('Asset B');

        $this->actingAs($userInCompanyA)
            ->post('reports/custom', ['asset_name' => '1', 'asset_tag' => '1', 'serial' => '1'])
            ->assertSeeTextInStreamedResponse('Asset A')
            ->assertSeeTextInStreamedResponse('Asset B');

        $this->actingAs($userInCompanyB)
            ->post('reports/custom', ['asset_name' => '1', 'asset_tag' => '1', 'serial' => '1'])
            ->assertSeeTextInStreamedResponse('Asset A')
            ->assertSeeTextInStreamedResponse('Asset B');

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($superUser)
            ->post('reports/custom', ['asset_name' => '1', 'asset_tag' => '1', 'serial' => '1'])
            ->assertSeeTextInStreamedResponse('Asset A')
            ->assertSeeTextInStreamedResponse('Asset B');

        $this->actingAs($userInCompanyA)
            ->post('reports/custom', ['asset_name' => '1', 'asset_tag' => '1', 'serial' => '1'])
            ->assertSeeTextInStreamedResponse('Asset A')
            ->assertDontSeeTextInStreamedResponse('Asset B');

        $this->actingAs($userInCompanyB)
            ->post('reports/custom', ['asset_name' => '1', 'asset_tag' => '1', 'serial' => '1'])
            ->assertDontSeeTextInStreamedResponse('Asset A')
            ->assertSeeTextInStreamedResponse('Asset B');
    }

    public function testCanLimitAssetsByLastCheckIn()
    {
        Asset::factory()->create(['name' => 'Asset A', 'last_checkin' => '2023-08-01']);
        Asset::factory()->create(['name' => 'Asset B', 'last_checkin' => '2023-08-02']);
        Asset::factory()->create(['name' => 'Asset C', 'last_checkin' => '2023-08-03']);
        Asset::factory()->create(['name' => 'Asset D', 'last_checkin' => '2023-08-04']);
        Asset::factory()->create(['name' => 'Asset E', 'last_checkin' => '2023-08-05']);

        $this->actingAs(User::factory()->canViewReports()->create())
            ->post('reports/custom', [
                'asset_name' => '1',
                'asset_tag' => '1',
                'serial' => '1',
                'checkin_date' => '1',
                'checkin_date_start' => '2023-08-02',
                'checkin_date_end' => '2023-08-04',
            ])->assertOk()
            ->assertHeader('content-type', 'text/csv; charset=UTF-8')
            ->assertDontSeeTextInStreamedResponse('Asset A')
            ->assertSeeTextInStreamedResponse('Asset B')
            ->assertSeeTextInStreamedResponse('Asset C')
            ->assertSeeTextInStreamedResponse('Asset D')
            ->assertDontSeeTextInStreamedResponse('Asset E');
    }
}
