<?php

namespace Tests\Feature\Checkins\Ui;

use App\Models\Asset;
use App\Models\Component;
use App\Models\User;
use Tests\TestCase;

final class ComponentsCheckoutTest extends TestCase
{
    public function testCheckingOutComponentRequiresCorrectPermission(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('components.checkout.store', [
                'componentID' => Component::factory()->checkedOutToAsset()->create()->id,
            ]))
            ->assertForbidden();
    }

    public function testComponentCheckoutPagePostIsRedirectedIfRedirectSelectionIsIndex(): void
    {
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->from(route('components.index'))
            ->post(route('components.checkout.store', $component), [
                'asset_id' => Asset::factory()->create()->id,
                'redirect_option' => 'index',
                'assigned_qty' => 1,
            ])
            ->assertStatus(302)
            ->assertRedirect(route('components.index'));
    }

    public function testComponentCheckoutPagePostIsRedirectedIfRedirectSelectionIsItem(): void
    {
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->from(route('components.index'))
            ->post(route('components.checkout.store' , $component), [
                'asset_id' =>  Asset::factory()->create()->id,
                'redirect_option' => 'item',
                'assigned_qty' => 1,
            ])
            ->assertStatus(302)
            ->assertRedirect(route('components.show', ['component' => $component->id]));
    }

    public function testComponentCheckoutPagePostIsRedirectedIfRedirectSelectionIsTarget(): void
    {
        $asset = Asset::factory()->create();
        $component = Component::factory()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->from(route('components.index'))
            ->post(route('components.checkout.store' , $component), [
                'asset_id' => $asset->id,
                'redirect_option' => 'target',
                'assigned_qty' => 1,
            ])
            ->assertStatus(302)
            ->assertRedirect(route('hardware.show', ['hardware' => $asset]));
    }


}
