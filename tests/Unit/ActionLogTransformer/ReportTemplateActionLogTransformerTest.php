<?php

namespace Tests\Unit\ActionLogTransformer;

use App\Http\Transformers\ActionlogsTransformer;
use App\Models\Actionlog;
use App\Models\ReportTemplate;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

#[Group('activity-logging')]
class ReportTemplateActionLogTransformerTest extends TestCase
{
    public function testLogEntryForCreatingReportTemplateCanBeTransformed()
    {
        ReportTemplate::factory()->create();

        $actionLogs = Actionlog::whereMorphedTo('item', ReportTemplate::class)->get();

        // should be created when ActionLog is created
        $this->assertCount(1, $actionLogs);

        $results = (new ActionlogsTransformer())->transformActionlogs($actionLogs, 10);

        $this->assertArrayHasKey('rows', $results);
        $this->assertCount(1, $results['rows']);
    }

    public function testLogEntryForUpdatingReportTemplateCanBeDisplayedTransformed()
    {
        $this->markTestIncomplete();
    }

    public function testLogEntryForDeletingReportTemplateCanBeDisplayedTransformed()
    {
        $this->markTestIncomplete();
    }

    public function testLogsScopedProperly()
    {
        $this->markTestIncomplete();
    }
}
