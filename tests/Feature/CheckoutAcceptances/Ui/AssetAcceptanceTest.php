<?php

namespace Tests\Feature\CheckoutAcceptances\Ui;

use App\Events\CheckoutAccepted;
use App\Models\CheckoutAcceptance;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AssetAcceptanceTest extends TestCase
{
    public function testAssetCheckoutAcceptPageRenders()
    {
        $checkoutAcceptance = CheckoutAcceptance::factory()->pending()->create();

        $this->actingAs($checkoutAcceptance->assignedTo)
            ->get(route('account.accept.item', $checkoutAcceptance))
            ->assertViewIs('account.accept.create');
    }

    public function testCannotAcceptAssetAlreadyAccepted()
    {
        $this->markTestIncomplete();
    }

    public function testCannotAcceptAssetForAnotherUser()
    {
        $this->markTestIncomplete();
    }

    public function testUserCanAcceptAssetCheckout()
    {
        Event::fake([CheckoutAccepted::class]);

        $checkoutAcceptance = CheckoutAcceptance::factory()->pending()->create();

        $this->assertTrue($checkoutAcceptance->isPending());

        $this->actingAs($checkoutAcceptance->assignedTo)
            ->post(route('account.store-acceptance', $checkoutAcceptance), [
                'asset_acceptance' => 'accepted',
                'note' => 'my note',
            ])
            ->assertRedirectToRoute('account.accept');

        $this->assertFalse($checkoutAcceptance->fresh()->isPending());

        Event::assertDispatched(CheckoutAccepted::class);
    }

    public function testActionLoggedWhenAcceptingAsset()
    {
        $this->markTestIncomplete();
    }


}
