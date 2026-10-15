<?php

namespace Tests\Feature\Consumables\Api;

use App\Models\Consumable;
use App\Models\User;
use Tests\TestCase;

class ConsumablesForSelectListTest extends TestCase
{
    public function test_requires_view_selectlists_permission(): void
    {
        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.consumables.selectlist'))
            ->assertForbidden();
    }

    public function test_consumables_are_returned_for_select_list(): void
    {
        [$consumableA, $consumableB] = Consumable::factory()->count(2)->create();

        $this->actingAsForApi(User::factory()->createConsumables()->create())
            ->getJson(route('api.consumables.selectlist'))
            ->assertOk()
            ->assertResponseContainsInResults($consumableA)
            ->assertResponseContainsInResults($consumableB);
    }
}
