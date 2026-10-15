<?php

namespace Tests\Feature\Console;

use App\Mail\UnacceptedAssetReminderMail;
use App\Models\CheckoutAcceptance;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Symfony\Component\Mailer\Exception\TransportException;
use Tests\TestCase;

class SendAcceptanceReminderTest extends TestCase
{
    public function test_acceptance_reminder_command()
    {
        Mail::fake();
        $userA = User::factory()->create(['email' => 'userA@test.com']);
        $userB = User::factory()->create(['email' => 'userB@test.com']);

        CheckoutAcceptance::factory()->pending()->count(2)->create([
            'assigned_to_id' => $userA->id,
        ]);
        CheckoutAcceptance::factory()->pending()->create([
            'assigned_to_id' => $userB->id,
        ]);

        $this->artisan('snipeit:acceptance-reminder')->assertExitCode(0);

        Mail::assertSent(UnacceptedAssetReminderMail::class, function ($mail) {
            return $mail->hasTo('userA@test.com');
        });

        Mail::assertSent(UnacceptedAssetReminderMail::class, function ($mail) {
            return $mail->hasTo('userB@test.com');
        });

        Mail::assertSent(UnacceptedAssetReminderMail::class, 2);
    }

    public function test_acceptance_reminder_command_handles_user_without_email()
    {
        Mail::fake();
        $userA = User::factory()->create(['email' => '']);

        CheckoutAcceptance::factory()->pending()->create([
            'assigned_to_id' => $userA->id,
        ]);
        $headers = ['ID', 'Name'];
        $rows = [
            [$userA->id, $userA->display_name],
        ];
        $this->artisan('snipeit:acceptance-reminder')
            ->expectsOutput('The following users do not have an email address:')
            ->expectsTable($headers, $rows)
            ->assertExitCode(0);

        Mail::assertNotSent(UnacceptedAssetReminderMail::class);
    }

    public function test_survives_transport_exception_and_logs_warning(): void
    {
        $user = User::factory()->create(['email' => 'transport-fail@test.com']);
        CheckoutAcceptance::factory()->pending()->create(['assigned_to_id' => $user->id]);

        $pending = Mockery::mock();
        $pending->shouldReceive('send')->andThrow(new TransportException('SMTP auth failed'));
        Mail::shouldReceive('to')->andReturn($pending);

        Log::spy();

        $this->artisan('snipeit:acceptance-reminder')->assertExitCode(0);

        Log::shouldHaveReceived('warning')->atLeast()->once();
    }
}
