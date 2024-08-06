<?php

namespace Tests\Feature\Consumables\Ui;

use App\Models\Consumable;
use App\Models\User;
use Tests\TestCase;

final class ConsumableViewTest extends TestCase
{
    public function testPermissionRequiredToViewConsumable(): void
    {
        $consumable = Consumable::factory()->create();
        $this->actingAs(User::factory()->create())
            ->get(route('consumables.show', $consumable))
            ->assertForbidden();
    }

    public function testUserCanListConsumables(): void
    {
        $consumable = Consumable::factory()->create();
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('consumables.show', $consumable))
            ->assertOk();
    }
}
