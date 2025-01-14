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

        $actionLogs = Actionlog::query()
            ->whereMorphedTo('item', ReportTemplate::class)
            ->where('action_type', 'create')
            ->get();

        // should be created when ActionLog is created
        $this->assertCount(1, $actionLogs);

        $results = (new ActionlogsTransformer())->transformActionlogs($actionLogs, 10);

        $this->assertArrayHasKey('rows', $results);
        $this->assertCount(1, $results['rows']);
    }

    public function testLogEntryForUpdatingReportTemplateCanBeDisplayedTransformed()
    {
        $reportTemplate = ReportTemplate::factory()->create();

        $reportTemplate->update([
            'options' => ['new' => 'value']
        ]);

        $actionLogs = Actionlog::query()
            ->whereMorphedTo('item', ReportTemplate::class)
            ->where('action_type', 'update')
            ->get();

        $this->assertCount(1, $actionLogs);

        $results = (new ActionlogsTransformer())->transformActionlogs($actionLogs, 10);

        $this->assertArrayHasKey('rows', $results);
        $this->assertCount(1, $results['rows']);
    }

    public function testLogEntryForDeletingReportTemplateCanBeDisplayedTransformed()
    {
        $reportTemplate = ReportTemplate::factory()->create();

        $reportTemplate->delete();

        $actionLogs = Actionlog::query()
            ->whereMorphedTo('item', ReportTemplate::class)
            ->where('action_type', 'delete')
            ->get();

        $this->assertCount(1, $actionLogs);

        $results = (new ActionlogsTransformer())->transformActionlogs($actionLogs, 10);

        $this->assertArrayHasKey('rows', $results);
        $this->assertCount(1, $results['rows']);
    }
}
