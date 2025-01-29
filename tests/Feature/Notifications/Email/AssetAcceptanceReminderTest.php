<?php

namespace Tests\Feature\Notifications\Email;

use App\Mail\CheckoutAssetMail;
use App\Models\CheckoutAcceptance;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AssetAcceptanceReminderTest extends TestCase
{
    private CheckoutAcceptance $checkoutAcceptance;
    private User $actor;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->actor = User::factory()->canViewReports()->create();
        $this->checkoutAcceptance = CheckoutAcceptance::factory()->pending()->create();
    }

    public function testMustHavePermissionToSendReminder()
    {
        $userWithoutPermission = User::factory()->create();

        $this->actingAs($userWithoutPermission)
            ->post($this->routeFor($this->checkoutAcceptance))
            ->assertForbidden();
    }

    public function testReminderNotSentIfAcceptanceDoesNotExist()
    {
        $this->actingAs($this->actor)
            ->post(route('reports/unaccepted_assets_sent_reminder', [
                'acceptance_id' => 999999,
            ]));

        Mail::assertNotSent(CheckoutAssetMail::class);
    }

    public function testReminderNotSentIfAcceptanceAlreadyAccepted()
    {
        $checkoutAcceptanceAlreadyAccepted = CheckoutAcceptance::factory()->accepted()->create();

        $this->actingAs($this->actor)
            ->post($this->routeFor($checkoutAcceptanceAlreadyAccepted));

        Mail::assertNotSent(CheckoutAssetMail::class);
    }

    public function testUserWithoutEmailAddressHandledGracefully()
    {
        $userWithoutEmailAddress = User::factory()->create(['email' => null]);

        $this->checkoutAcceptance->assigned_to_id = $userWithoutEmailAddress->id;
        $this->checkoutAcceptance->save();

        $this->actingAs($this->actor)
            ->post($this->routeFor($this->checkoutAcceptance))
            // check we didn't crash...
            ->assertRedirect();

        Mail::assertNotSent(CheckoutAssetMail::class);
    }

    public function testReminderIsSentToUser()
    {
        $this->actingAs($this->actor)
            ->post($this->routeFor($this->checkoutAcceptance))
            ->assertRedirect(route('reports/unaccepted_assets'));

        Mail::assertSent(CheckoutAssetMail::class, 1);
        Mail::assertSent(CheckoutAssetMail::class, function (CheckoutAssetMail $mail) {
            return $mail->hasTo($this->checkoutAcceptance->assignedTo->email)
                // @todo:
                && $mail->hasSubject('Reminder: ' . trans('mail.Asset_Checkout_Notification'));
        });
    }

    private function routeFor(CheckoutAcceptance $checkoutAcceptance): string
    {
        return route('reports/unaccepted_assets_sent_reminder', [
            'acceptance_id' => $checkoutAcceptance->id,
        ]);
    }
}
