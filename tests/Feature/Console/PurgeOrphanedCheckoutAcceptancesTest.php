<?php

namespace Tests\Feature\Console;

use App\Models\CheckoutAcceptance;
use Tests\TestCase;

class PurgeOrphanedCheckoutAcceptancesTest extends TestCase
{
    public function testPurgeOrphanedCheckoutAcceptances()
    {
        [$pendingForAccessory, $pendingForAccessoryWithDeletedUser] = CheckoutAcceptance::factory()->count(2)->pending()->forAccessory()->create();
        [$pendingForAsset, $pendingForAssetWithDeletedUser] = CheckoutAcceptance::factory()->count(2)->pending()->forAsset()->create();
        [$pendingForConsumable, $pendingForConsumableWithDeletedUser] = CheckoutAcceptance::factory()->count(2)->pending()->forConsumable()->create();
        [$pendingForLicenseSeat, $pendingForLicenseSeatWithDeletedUser] = CheckoutAcceptance::factory()->count(2)->pending()->forLicenseSeat()->create();

        [$acceptedForAccessory, $acceptedForAccessoryWithDeletedUser] = CheckoutAcceptance::factory()->count(2)->accepted()->forAccessory()->create();
        [$acceptedForAsset, $acceptedForAssetWithDeletedUser] = CheckoutAcceptance::factory()->count(2)->accepted()->forAsset()->create();
        [$acceptedForConsumable, $acceptedForConsumableWithDeletedUser] = CheckoutAcceptance::factory()->count(2)->accepted()->forConsumable()->create();
        [$acceptedForLicenseSeat, $acceptedForLicenseSeatWithDeletedUser] = CheckoutAcceptance::factory()->count(2)->accepted()->forLicenseSeat()->create();

        $this->assertDatabaseCount('checkout_acceptances', 16);

        $pendingForAccessoryWithDeletedUser->assignedTo->delete();
        $pendingForAssetWithDeletedUser->assignedTo->delete();
        $pendingForConsumableWithDeletedUser->assignedTo->forceDelete();
        $pendingForLicenseSeatWithDeletedUser->assignedTo->forceDelete();

        $acceptedForAccessoryWithDeletedUser->assignedTo->delete();
        $acceptedForAssetWithDeletedUser->assignedTo->delete();
        $acceptedForConsumableWithDeletedUser->assignedTo->forceDelete();
        $acceptedForLicenseSeatWithDeletedUser->assignedTo->forceDelete();

        $this->assertDatabaseCount('checkout_acceptances', 16);

        $this->artisan('snipeit:purge-orphaned-checkout-acceptances')->assertSuccessful();

        $this->assertDatabaseHas('checkout_acceptances', ['id' => $pendingForAccessory->id]);
        $this->assertDatabaseHas('checkout_acceptances', ['id' => $pendingForAsset->id]);
        $this->assertDatabaseHas('checkout_acceptances', ['id' => $pendingForConsumable->id]);
        $this->assertDatabaseHas('checkout_acceptances', ['id' => $pendingForLicenseSeat->id]);

        $this->assertDatabaseHas('checkout_acceptances', ['id' => $acceptedForAccessory->id]);
        $this->assertDatabaseHas('checkout_acceptances', ['id' => $acceptedForAsset->id]);
        $this->assertDatabaseHas('checkout_acceptances', ['id' => $acceptedForConsumable->id]);
        $this->assertDatabaseHas('checkout_acceptances', ['id' => $acceptedForLicenseSeat->id]);

        $this->assertDatabaseHas('checkout_acceptances', ['id' => $acceptedForAccessoryWithDeletedUser->id]);
        $this->assertDatabaseHas('checkout_acceptances', ['id' => $acceptedForAssetWithDeletedUser->id]);
        $this->assertDatabaseHas('checkout_acceptances', ['id' => $acceptedForConsumableWithDeletedUser->id]);
        $this->assertDatabaseHas('checkout_acceptances', ['id' => $acceptedForLicenseSeatWithDeletedUser->id]);

        $this->assertDatabaseMissing('checkout_acceptances', ['id' => $pendingForAccessoryWithDeletedUser->id]);
        $this->assertDatabaseMissing('checkout_acceptances', ['id' => $pendingForAssetWithDeletedUser->id]);
        $this->assertDatabaseMissing('checkout_acceptances', ['id' => $pendingForConsumableWithDeletedUser->id]);
        $this->assertDatabaseMissing('checkout_acceptances', ['id' => $pendingForLicenseSeatWithDeletedUser->id]);

        $this->assertDatabaseCount('checkout_acceptances', 12);
    }
}
