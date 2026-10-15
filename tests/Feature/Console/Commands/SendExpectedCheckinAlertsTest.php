<?php

namespace Tests\Feature\Console\Commands;

use App\Models\Asset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportException;
use Tests\TestCase;

class SendExpectedCheckinAlertsTest extends TestCase
{
    public function test_command_survives_transport_exception_and_logs_warning(): void
    {
        $user = User::factory()->create(['email' => 'test@example.org']);
        $asset = Asset::factory()->assignedToUser($user)->create([
            'expected_checkin' => Carbon::now()->subDay(),
        ]);

        $this->mock(ChannelManager::class, function ($mock) {
            $mock->shouldReceive('send')->andThrow(new TransportException('SMTP auth failed'));
            $mock->shouldReceive('sendNow')->andThrow(new TransportException('SMTP auth failed'));
        });

        Log::spy();

        $this->artisan('snipeit:expected-checkin')->assertExitCode(0);

        Log::shouldHaveReceived('warning')->atLeast()->once();
    }

    public function test_command_reports_success_count_on_happy_path(): void
    {
        $user = User::factory()->create(['email' => 'test@example.org']);
        Asset::factory()->assignedToUser($user)->create([
            'expected_checkin' => Carbon::now()->subDay(),
        ]);

        $this->mock(ChannelManager::class, function ($mock) {
            $mock->shouldReceive('send')->andReturnNull();
            $mock->shouldReceive('sendNow')->andReturnNull();
        });

        $this->artisan('snipeit:expected-checkin')
            ->expectsOutputToContain('Sent checkin reminders to 1 users.')
            ->assertExitCode(0);
    }
}
