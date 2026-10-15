<?php

namespace Tests\Feature\Checkouts\Ui;

use App\Models\Asset;
use App\Models\Category;
use App\Models\CheckoutAcceptance;
use App\Models\Component;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Regression coverage for GH #19570: components with require_acceptance
 * on their category didn't produce a CheckoutAcceptance row when the
 * checkout target was an Asset. That left the recipient (the asset's
 * assigned user) with an email that had a broken accept link and no
 * pending row to accept from their profile.
 *
 * The fix routes any Asset target through the asset's assignedto to
 * pick the real acceptance target, and the mail template no longer
 * renders the "please accept" copy or button when no accept URL exists.
 */
class ComponentCheckoutAcceptanceTest extends TestCase
{
    #[Test]
    public function component_checkout_to_asset_creates_acceptance_for_the_assets_assigned_user(): void
    {
        $assignedUser = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($assignedUser)->create();

        $category = Category::factory()->componentRamCategory()->create([
            'require_acceptance' => true,
        ]);
        $component = Component::factory()->for($category)->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('components.checkout.store', $component), [
                'asset_id' => $asset->id,
                'assigned_qty' => '1',
                'redirect_option' => 'index',
            ]);

        $this->assertDatabaseHas('checkout_acceptances', [
            'checkoutable_type' => Component::class,
            'checkoutable_id' => $component->id,
            'assigned_to_id' => $assignedUser->id,
        ]);
    }

    #[Test]
    public function component_checkout_to_asset_with_no_assigned_user_skips_acceptance(): void
    {
        // Asset that's not checked out to anyone. No user to sign an
        // acceptance, so no row should land.
        $asset = Asset::factory()->create();

        $category = Category::factory()->componentRamCategory()->create([
            'require_acceptance' => true,
        ]);
        $component = Component::factory()->for($category)->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('components.checkout.store', $component), [
                'asset_id' => $asset->id,
                'assigned_qty' => '1',
                'redirect_option' => 'index',
            ]);

        $this->assertDatabaseMissing('checkout_acceptances', [
            'checkoutable_type' => Component::class,
            'checkoutable_id' => $component->id,
        ]);
    }

    #[Test]
    public function component_checkout_without_required_acceptance_writes_no_row(): void
    {
        // Regression guard on the pre-existing branch: if the
        // category does not require acceptance, no row is written
        // even when the target chain resolves to a real user.
        $assignedUser = User::factory()->create();
        $asset = Asset::factory()->assignedToUser($assignedUser)->create();

        $category = Category::factory()->componentRamCategory()->create([
            'require_acceptance' => false,
        ]);
        $component = Component::factory()->for($category)->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('components.checkout.store', $component), [
                'asset_id' => $asset->id,
                'assigned_qty' => '1',
                'redirect_option' => 'index',
            ]);

        $this->assertDatabaseMissing('checkout_acceptances', [
            'checkoutable_type' => Component::class,
            'checkoutable_id' => $component->id,
        ]);
    }
}
