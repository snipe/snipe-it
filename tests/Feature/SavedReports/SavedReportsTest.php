<?php

namespace Tests\Feature\SavedReports;

use App\Models\SavedReport;
use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class SavedReportsTest extends TestCase
{
    use InteractsWithSettings;

    public function testCanLoadCustomReportPage()
    {
        $this->actingAs(User::factory()->canViewReports()->create())
            ->get(route('reports/custom'))
            ->assertOk()
            ->assertViewHas(['savedReport' => function (SavedReport $report) {
                // the view should have an empty report by default
                return $report->exists() === false;
            }]);
    }

    public function testCanLoadASavedCustomReport()
    {
        $user = User::factory()->canViewReports()->create();
        $savedReport = SavedReport::factory()->make(['name' => 'My Awesome Report']);
        $user->savedReports()->save($savedReport);

        $this->actingAs($user)
            ->get(route('reports/custom', ['report' => $savedReport->id]))
            ->assertOk()
            ->assertViewHas(['savedReport' => function (SavedReport $viewReport) use ($savedReport) {
                return $viewReport->is($savedReport);
            }]);
    }

    public function testCanSaveACustomReport()
    {
        $this->markTestIncomplete();
    }

    public function testSavingReportRequiresValidFields()
    {
        $this->actingAs(User::factory()->canViewReports()->create())
            ->post(route('savedreports/store'), [
                //
            ])
            ->assertSessionHasErrors('name');
    }

    public function testSavingReportRequiresCorrectPermission()
    {
        $this->actingAs(User::factory()->create())
            ->post(route('savedreports/store'))
            ->assertForbidden();
    }
}
