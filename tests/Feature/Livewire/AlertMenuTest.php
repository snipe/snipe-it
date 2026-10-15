<?php

namespace Tests\Feature\Livewire;

use App\Livewire\AlertMenu;
use App\Models\Accessory;
use App\Models\Consumable;
use App\Models\Setting;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class AlertMenuTest extends TestCase
{
    public function test_the_component_renders(): void
    {
        Livewire::actingAs(User::factory()->superuser()->create())
            ->test(AlertMenu::class)
            ->assertStatus(200);
    }

    public function test_normal_user_without_inventory_permissions_sees_no_low_stock_rows(): void
    {
        // Regression test for AlertMenu disclosure.
        Accessory::factory()->create([
            'name' => 'CAND06-LOW-STOCK-SECRET',
            'qty' => 1,
            'min_amt' => 2,
        ]);

        Livewire::withoutLazyLoading()
            ->actingAs(User::factory()->create())
            ->test(AlertMenu::class)
            ->assertSet('alert_count', 0)
            ->assertDontSee('CAND06-LOW-STOCK-SECRET');
    }

    public function test_user_with_only_accessories_view_sees_only_accessory_rows(): void
    {
        Accessory::factory()->create([
            'name' => 'ALERTBELL-ACCESSORY',
            'qty' => 1,
            'min_amt' => 2,
        ]);
        Consumable::factory()->create([
            'name' => 'ALERTBELL-CONSUMABLE',
            'qty' => 1,
            'min_amt' => 2,
        ]);

        Livewire::withoutLazyLoading()
            ->actingAs(User::factory()->viewAccessories()->create())
            ->test(AlertMenu::class)
            ->assertSee('ALERTBELL-ACCESSORY')
            ->assertDontSee('ALERTBELL-CONSUMABLE');
    }

    public function test_normal_user_does_not_see_ms_teams_deprecation_notice(): void
    {
        // The MS Teams webhook-deprecation message leaks the admin's
        // webhook_selected configuration. Gate on admin so a normal
        // user doesn't learn which provider the admin configured.
        $settings = Setting::getSettings();
        $settings->webhook_selected = 'microsoft';
        $settings->webhook_endpoint = 'https://outlook.office.com/webhook/legacy-non-workflows';
        $settings->save();

        Livewire::withoutLazyLoading()
            ->actingAs(User::factory()->create())
            ->test(AlertMenu::class)
            ->assertDontSee('workflows')
            ->assertDontSee('deprecated');
    }

    public function test_placeholder_reserves_bell_footprint(): void
    {
        $placeholder = (new AlertMenu)->placeholder();

        // Placeholder icon deliberately matches whatever glyph the
        // loaded view (livewire/alert-menu.blade.php) renders via
        // <x-icon type="alerts"/>. IconHelper maps "alerts" to
        // fa-flag, so the placeholder uses fa-flag too — otherwise
        // hydration would visibly swap the icon on first paint.
        $this->assertStringContainsString('dropdown', $placeholder);
        $this->assertStringContainsString('fa-flag', $placeholder);
    }

    public function test_placeholder_reserves_badge_footprint(): void
    {
        $placeholder = (new AlertMenu)->placeholder();

        // The hidden .label reserves badge width so hydration with
        // alerts does not push the surrounding top-nav items sideways.
        $this->assertStringContainsString('label label-danger', $placeholder);
        $this->assertStringContainsString('visibility: hidden', $placeholder);
    }
}
