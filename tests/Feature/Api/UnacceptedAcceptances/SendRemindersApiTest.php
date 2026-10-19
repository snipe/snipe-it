<?php

namespace Tests\Feature\Api\UnacceptedAcceptances;

use App\Mail\UnacceptedAssetReminderMail;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * API coverage for POST /api/v1/unaccepted-acceptances/send-reminders,
 * the scheduler-friendly surface added for #19811.
 *
 * Shape:
 *   - no ids in body: delegates to the snipeit:acceptance-reminder
 *     console command (one grouped email per assignee).
 *   - ids in body: iterates each, applies FMCS, dispatches per-row.
 */
class SendRemindersApiTest extends TestCase
{
    #[Test]
    public function user_without_checkout_grant_is_rejected(): void
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.unaccepted-acceptances.send-reminders'))
            ->assertForbidden();
    }

    #[Test]
    public function missing_ids_delegates_to_the_artisan_command(): void
    {
        Mail::fake();
        Artisan::spy();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.unaccepted-acceptances.send-reminders'))
            ->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('payload.mode', 'all');

        Artisan::shouldHaveReceived('call')->with('snipeit:acceptance-reminder')->once();
    }

    #[Test]
    public function empty_ids_array_also_delegates_to_the_artisan_command(): void
    {
        // Explicitly-empty array arrives from well-formed clients that
        // always include the key. Should behave the same as missing.
        Artisan::spy();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.unaccepted-acceptances.send-reminders'), ['ids' => []])
            ->assertOk()
            ->assertJsonPath('payload.mode', 'all');

        Artisan::shouldHaveReceived('call')->with('snipeit:acceptance-reminder')->once();
    }

    #[Test]
    public function ids_in_body_sends_per_row_and_bypasses_the_console_command(): void
    {
        Mail::fake();
        Artisan::spy();

        $assignee = User::factory()->create(['email' => 'target@example.test']);
        $asset = Asset::factory()->create();
        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for($asset, 'checkoutable')
            ->for($assignee, 'assignedTo')
            ->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.unaccepted-acceptances.send-reminders'), ['ids' => [$acceptance->id]])
            ->assertOk()
            ->assertJsonPath('payload.mode', 'ids')
            ->assertJsonPath('payload.sent', 1)
            ->assertJsonPath('payload.skipped.not_found', 0)
            ->assertJsonPath('payload.skipped.fmcs', 0)
            ->assertJsonPath('payload.skipped.no_email', 0);

        Mail::assertSent(UnacceptedAssetReminderMail::class);
        Artisan::shouldNotHaveReceived('call');
    }

    #[Test]
    public function id_pointing_at_a_non_pending_acceptance_is_counted_as_not_found(): void
    {
        Mail::fake();

        $assignee = User::factory()->create(['email' => 'target@example.test']);
        $asset = Asset::factory()->create();
        $acceptance = CheckoutAcceptance::factory()
            ->for($asset, 'checkoutable')
            ->for($assignee, 'assignedTo')
            ->create(['accepted_at' => now()]);

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.unaccepted-acceptances.send-reminders'), ['ids' => [$acceptance->id]])
            ->assertOk()
            ->assertJsonPath('payload.sent', 0)
            ->assertJsonPath('payload.skipped.not_found', 1);

        Mail::assertNothingSent();
    }

    #[Test]
    public function acceptance_without_assignee_email_is_counted_as_no_email(): void
    {
        Mail::fake();

        $assignee = User::factory()->create(['email' => '']);
        $asset = Asset::factory()->create();
        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for($asset, 'checkoutable')
            ->for($assignee, 'assignedTo')
            ->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.unaccepted-acceptances.send-reminders'), ['ids' => [$acceptance->id]])
            ->assertOk()
            ->assertJsonPath('payload.sent', 0)
            ->assertJsonPath('payload.skipped.no_email', 1);

        Mail::assertNothingSent();
    }

    #[Test]
    public function fmcs_blocks_cross_company_ids_without_leaking_to_the_mail_queue(): void
    {
        Mail::fake();
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $assignee = User::factory()->create(['email' => 'target@example.test']);
        $assetInB = Asset::factory()->create(['company_id' => $companyB->id]);
        $acceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for($assetInB, 'checkoutable')
            ->for($assignee, 'assignedTo')
            ->create();

        $callerInA = User::factory()
            ->checkoutAccessories()
            ->forCompany($companyA)
            ->create();

        $this->actingAsForApi($callerInA)
            ->postJson(route('api.unaccepted-acceptances.send-reminders'), ['ids' => [$acceptance->id]])
            ->assertOk()
            ->assertJsonPath('payload.sent', 0)
            ->assertJsonPath('payload.skipped.fmcs', 1);

        Mail::assertNothingSent();
    }

    #[Test]
    public function mixed_batch_reports_each_outcome_separately(): void
    {
        Mail::fake();

        $goodAssignee = User::factory()->create(['email' => 'good@example.test']);
        $noEmailAssignee = User::factory()->create(['email' => '']);

        $goodAcceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for(Asset::factory(), 'checkoutable')
            ->for($goodAssignee, 'assignedTo')
            ->create();

        $noEmailAcceptance = CheckoutAcceptance::factory()
            ->pending()
            ->for(Asset::factory(), 'checkoutable')
            ->for($noEmailAssignee, 'assignedTo')
            ->create();

        $this->actingAsForApi(User::factory()->superuser()->create())
            ->postJson(route('api.unaccepted-acceptances.send-reminders'), [
                'ids' => [$goodAcceptance->id, $noEmailAcceptance->id, 999999],
            ])
            ->assertOk()
            ->assertJsonPath('payload.sent', 1)
            ->assertJsonPath('payload.skipped.no_email', 1)
            ->assertJsonPath('payload.skipped.not_found', 1);

        Mail::assertSent(UnacceptedAssetReminderMail::class, 1);
    }
}
