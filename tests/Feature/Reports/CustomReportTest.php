<?php

namespace Tests\Feature\Reports;

use App\Models\Asset;
use App\Models\User;
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

        $reader = Reader::createFromString($response->streamedContent());

        $this->assertTrue(collect($reader->getRecords())->pluck(0)->contains('Asset A'));
        $this->assertTrue(collect($reader->getRecords())->pluck(0)->contains('Asset B'));
    }
}
