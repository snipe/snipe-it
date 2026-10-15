<?php

namespace Tests\Feature\Requests\Ui;

use App\Models\Category;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

/**
 * Form-submit boundary coverage for the requestable checkbox on the
 * consumable / component / license edit + create screens. The
 * factory-create paths exercised by the sibling *RequestTest files
 * bypass the controller entirely, so a controller that silently
 * drops `requestable` on `$request->input(...)` would have every
 * request-flow test still pass. These POST through the actual
 * controller so an omitted field surfaces as a regression here.
 *
 * Unchecked checkbox coverage is important on its own: HTML forms
 * do not submit unchecked checkboxes at all. The controller must
 * coerce the missing key to false or "unchecking the box" would
 * silently do nothing.
 */
class RequestableCheckboxPersistenceTest extends TestCase
{
    private function commonPayload(): array
    {
        // Minimum-viable payload for the create + update forms. The
        // per-type methods below merge model-specific requireds in.
        return [
            'company_id' => Company::factory()->create()->id,
            'location_id' => Location::factory()->create()->id,
        ];
    }

    private function consumablePayload(): array
    {
        return array_merge($this->commonPayload(), [
            'name' => 'Test Consumable',
            'category_id' => Category::factory()->forConsumables()->create()->id,
            'qty' => 5,
        ]);
    }

    private function componentPayload(): array
    {
        return array_merge($this->commonPayload(), [
            'name' => 'Test Component',
            'category_id' => Category::factory()->forComponents()->create()->id,
            'qty' => 5,
            'serial' => 'C-'.uniqid(),
        ]);
    }

    private function licensePayload(): array
    {
        return array_merge($this->commonPayload(), [
            'name' => 'Test License',
            'category_id' => Category::factory()->forLicenses()->create()->id,
            'seats' => 3,
        ]);
    }

    public function test_consumable_create_form_persists_requestable_when_checked(): void
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('consumables.store'), $this->consumablePayload() + ['requestable' => '1'])
            ->assertRedirect();

        $this->assertTrue((bool) Consumable::where('name', 'Test Consumable')->sole()->requestable);
    }

    public function test_consumable_update_can_uncheck_requestable(): void
    {
        $consumable = Consumable::factory()->create(['requestable' => true]);

        $this->actingAs(User::factory()->superuser()->create())
            ->put(route('consumables.update', $consumable), array_merge(
                $this->consumablePayload(),
                ['name' => $consumable->name],
                // Deliberately no `requestable` key - matches the shape
                // a browser sends when the box is unchecked.
            ))
            ->assertRedirect();

        $this->assertFalse((bool) $consumable->fresh()->requestable);
    }

    public function test_component_create_form_persists_requestable_when_checked(): void
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('components.store'), $this->componentPayload() + ['requestable' => '1'])
            ->assertRedirect();

        $this->assertTrue((bool) Component::where('name', 'Test Component')->sole()->requestable);
    }

    public function test_component_update_can_uncheck_requestable(): void
    {
        $component = Component::factory()->create(['requestable' => true]);

        $this->actingAs(User::factory()->superuser()->create())
            ->put(route('components.update', $component), array_merge(
                $this->componentPayload(),
                ['name' => $component->name, 'serial' => $component->serial],
            ))
            ->assertRedirect();

        $this->assertFalse((bool) $component->fresh()->requestable);
    }

    public function test_license_create_form_persists_requestable_when_checked(): void
    {
        // License store() also needs a serial-shaped identity or seats
        // validation may bite - the payload's seats=3 handles it.
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('licenses.store'), $this->licensePayload() + ['requestable' => '1'])
            ->assertRedirect();

        $this->assertTrue((bool) License::where('name', 'Test License')->sole()->requestable);
    }

    public function test_license_update_can_uncheck_requestable(): void
    {
        $license = License::factory()->create(['requestable' => true]);

        $this->actingAs(User::factory()->superuser()->create())
            ->put(route('licenses.update', $license), array_merge(
                $this->licensePayload(),
                ['name' => $license->name, 'seats' => $license->seats],
            ))
            ->assertRedirect();

        $this->assertFalse((bool) $license->fresh()->requestable);
    }
}
