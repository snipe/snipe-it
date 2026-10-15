<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Symfony\Component\Mailer\Exception\TransportException;
use Tests\TestCase;

class SendExpirationAlertsTest extends TestCase
{
    public function test_survives_transport_exception_and_logs_warning(): void
    {
        $this->settings->set([
            'alerts_enabled' => 1,
            'alert_email' => 'ops@example.test',
            'alert_interval' => 60,
        ]);

        // AssetFactory's afterMaking hook overwrites asset_eol_date, so set it after create.
        $asset = Asset::factory()->create(['archived' => 0]);
        $asset->asset_eol_date = Carbon::now()->addDays(10);
        $asset->save();

        // Sanity check the fixture actually qualifies before asserting on side effects.
        $this->assertGreaterThan(0, Asset::getExpiringWarrantyOrEol(60)->count());

        $pending = Mockery::mock();
        $pending->shouldReceive('send')->andThrow(new TransportException('SMTP auth failed'));
        Mail::shouldReceive('to')->andReturn($pending);

        Log::spy();

        $this->artisan('snipeit:expiring-alerts')->assertExitCode(0);

        Log::shouldHaveReceived('warning')->atLeast()->once();
    }
}
