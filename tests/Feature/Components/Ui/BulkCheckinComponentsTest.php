<?php

namespace Tests\Feature\Components\Ui;

use App\Events\CheckoutableCheckedIn;
use App\Models\Asset;
use App\Models\Component;
use App\Models\ComponentAssignment;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BulkCheckinComponentsTest extends TestCase
{
    private function attachCheckout(Component $component, Asset $asset, int $qty = 1): int
    {
        $component->assets()->attach($asset->id, [
            'assigned_qty' => $qty,
            'created_at' => now(),
            'created_by' => 1,
        ]);

        return (int) ComponentAssignment::where('component_id', $component->id)
            ->where('asset_id', $asset->id)
            ->latest('id')
            ->value('id');
    }

    public function test_requires_checkin_permission(): void
    {
        $component = Component::factory()->create(['qty' => 5]);
        $asset = Asset::factory()->create();
        $pivotId = $this->attachCheckout($component, $asset);

        $this->actingAs(User::factory()->viewComponents()->create())
            ->post(route('components.bulkcheckin.selected'), ['ids' => [$pivotId]])
            ->assertForbidden();

        $this->assertDatabaseHas('components_assets', ['id' => $pivotId]);
    }

    public function test_removes_pivot_rows_and_fires_event(): void
    {
        Event::fake([CheckoutableCheckedIn::class]);

        $component = Component::factory()->create(['qty' => 10]);
        $assetA = Asset::factory()->create();
        $assetB = Asset::factory()->create();

        $pivotA = $this->attachCheckout($component, $assetA, 2);
        $pivotB = $this->attachCheckout($component, $assetB, 3);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('components.bulkcheckin.selected'), ['ids' => [$pivotA, $pivotB]])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('components_assets', ['id' => $pivotA]);
        $this->assertDatabaseMissing('components_assets', ['id' => $pivotB]);

        // Fully-returned pivots mean the component is now entirely
        // back in stock.
        $this->assertSame(0, (int) $component->fresh()->numCheckedOut(true));

        Event::assertDispatchedTimes(CheckoutableCheckedIn::class, 2);
    }

    public function test_warns_when_no_rows_selected(): void
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('components.bulkcheckin.selected'), ['ids' => []])
            ->assertRedirect()
            ->assertSessionHas('warning');
    }

    public function test_success_message_reports_total_units_not_just_pivot_rows(): void
    {
        // Regression: a pivot row can represent many units via
        // assigned_qty, so "3 rows checked in" might really mean
        // 25 units returned. The success message must surface the
        // units total, not just the row count. Pin so a refactor
        // can't quietly drop the per-row qty sum.
        $component = Component::factory()->create(['qty' => 50]);

        $pivotA = $this->attachCheckout($component, Asset::factory()->create(), 4);
        $pivotB = $this->attachCheckout($component, Asset::factory()->create(), 11);
        $pivotC = $this->attachCheckout($component, Asset::factory()->create(), 7);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('components.bulkcheckin.selected'), ['ids' => [$pivotA, $pivotB, $pivotC]])
            ->assertRedirect()
            ->assertSessionHas('success', trans_choice(
                'admin/components/message.bulk.checkin_selected.success',
                3,
                ['count' => 3, 'unit_count' => 22],
            ));
    }

    public function test_success_message_handles_single_unit_single_row(): void
    {
        // Covers the singular side of the trans_choice branch for the
        // simplest checkin: one row, one unit.
        $component = Component::factory()->create(['qty' => 5]);
        $pivot = $this->attachCheckout($component, Asset::factory()->create(), 1);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('components.bulkcheckin.selected'), ['ids' => [$pivot]])
            ->assertRedirect()
            ->assertSessionHas('success', trans_choice(
                'admin/components/message.bulk.checkin_selected.success',
                1,
                ['count' => 1, 'unit_count' => 1],
            ));
    }

    public function test_unknown_pivot_ids_are_silently_skipped(): void
    {
        // Mirrors the LicenseCheckinController flow: stale pivot ids
        // posted from a dropdown-swap race just get skipped so the
        // real selections still check in cleanly.
        Event::fake([CheckoutableCheckedIn::class]);

        $component = Component::factory()->create(['qty' => 10]);
        $asset = Asset::factory()->create();
        $pivotId = $this->attachCheckout($component, $asset);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('components.bulkcheckin.selected'), ['ids' => [$pivotId, 999999]])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('components_assets', ['id' => $pivotId]);
        Event::assertDispatchedTimes(CheckoutableCheckedIn::class, 1);
    }
}
