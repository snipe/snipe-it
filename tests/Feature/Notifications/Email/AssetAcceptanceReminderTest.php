<?php

namespace Tests\Feature\Notifications\Email;

use App\Mail\CheckoutAssetMail;
use App\Models\CheckoutAcceptance;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AssetAcceptanceReminderTest extends TestCase
{
    private User $actor;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();

        $this->actor = User::factory()->canViewReports()->create();
    }

    public function testMustHavePermissionToSendReminder()
    {
        $checkoutAcceptance = CheckoutAcceptance::factory()->pending()->create();
        $userWithoutPermission = User::factory()->create();

        $this->actingAs($userWithoutPermission)
            ->post($this->routeFor($checkoutAcceptance))
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
        $checkoutAcceptance = CheckoutAcceptance::factory()
            ->pending()
            ->forAssignedTo(['email' => null])
            ->create();

        $this->actingAs($this->actor)
            ->post($this->routeFor($checkoutAcceptance))
            // check we didn't crash...
            ->assertRedirect();

        Mail::assertNotSent(CheckoutAssetMail::class);
    }

    public static function acceptances()
    {
        yield 'User with locale set' => [
            function () {
                return CheckoutAcceptance::factory()->pending()->create();
            }
        ];

        yield 'User without locale set' => [
            function () {
                $checkoutAcceptance = CheckoutAcceptance::factory()->pending()->create();
                $checkoutAcceptance->assignedTo->update(['locale' => null]);

                return $checkoutAcceptance;
            }
        ];
    }

    #[DataProvider('acceptances')]
    public function testReminderIsSentToUser($callback)
    {
        $checkoutAcceptance = $callback();

        $this->actingAs($this->actor)
            ->post($this->routeFor($checkoutAcceptance))
            ->assertRedirect(route('reports/unaccepted_assets'));

        Mail::assertSent(CheckoutAssetMail::class, 1);
        Mail::assertSent(CheckoutAssetMail::class, function (CheckoutAssetMail $mail) use ($checkoutAcceptance) {
            return $mail->hasTo($checkoutAcceptance->assignedTo->email)
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
