<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Symfony\Component\Mailer\Exception\TransportException;
use Tests\TestCase;

class SendUpcomingAuditReportTest extends TestCase
{
    public function test_survives_transport_exception_and_logs_warning(): void
    {
        $this->settings->set([
            'alert_email' => 'ops@example.test',
            'audit_warning_days' => 30,
        ]);

        // AssetFactory's afterMaking hook may overwrite next_audit_date, so set it after create.
        $asset = Asset::factory()->create();
        $asset->next_audit_date = Carbon::now()->addDays(5);
        $asset->save();

        $pending = Mockery::mock();
        $pending->shouldReceive('send')->andThrow(new TransportException('SMTP auth failed'));
        Mail::shouldReceive('to')->andReturn($pending);

        Log::spy();

        $this->artisan('snipeit:upcoming-audits')->assertExitCode(0);

        Log::shouldHaveReceived('warning')->atLeast()->once();
    }
}
