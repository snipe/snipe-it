<?php

namespace Tests\Feature\Notes;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class CreateNotesTest extends TestCase
{
    public function testRequiresPermission()
    {
        $this->markTestIncomplete();

        $this->actingAs(User::factory()->create())
            ->post(route('notes.store'))
            ->assertForbidden();
    }

    public function testValidation()
    {
        $this->markTestIncomplete();
    }

    public function testCanCreateNote()
    {
        // @todo: make dynamic?

        $actor = User::factory()->editAssets()->create();

        $asset = Asset::factory()->create();

        $this->actingAs($actor)
            ->post(route('notes.store'), [
                'id' => $asset->id,
                'type' => 'asset',
                'note' => 'my special note',
            ])
            ->assertRedirect(route('hardware.show', $asset->id) . '#history');

        // @todo: assert action log created with expected data
    }
}
