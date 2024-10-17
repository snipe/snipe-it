<?php

namespace Tests\Feature\Notes;

use App\Events\NoteAdded;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AssetNotesTest extends TestCase
{
    public function testRequiresPermission()
    {
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.notes.store'), [
                'note' => 'New Note!',
                'type' => 'asset',
                'id' => $asset->id,
            ])
            ->assertForbidden();
    }

    public function testValidation()
    {
        $asset = Asset::factory()->create();

        $this->actingAsForApi(User::factory()->editAssets()->create())
            ->postJson(route('api.notes.store'), [
                // 'note' => '',
                'type' => 'a_type_not_asset',
                'id' => $asset->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('error')
            ->assertJsonValidationErrors(['note', 'type'], 'messages');
    }

    public function testRequiresExistingAsset()
    {
        $this->actingAsForApi(User::factory()->editAssets()->create())
            ->postJson(route('api.notes.store'), [
                'note' => 'New Note!',
                'type' => 'asset',
                'id' => 999_999,
            ])
            ->assertStatusMessageIs('error')
            ->assertMessagesAre('Asset not found');
    }

    public function testCanAddNoteToAsset()
    {
        Event::fake([NoteAdded::class]);

        $asset = Asset::factory()->create();
        $user = User::factory()->editAssets()->create();

        $this->actingAsForApi($user)
            ->postJson(route('api.notes.store'), [
                'note' => 'New Note!',
                'type' => 'asset',
                'id' => $asset->id,
            ])
            ->assertOk()
            ->assertStatusMessageIs('success');
        
        Event::assertDispatchedTimes(NoteAdded::class, 1);
        Event::assertDispatched(NoteAdded::class, function (NoteAdded $event) use ($asset, $user) {
            return $event->itemNoteAddedOn->is($asset)
                && $event->note === 'New Note!'
                && $event->noteAddedBy->is($user);
        });
    }
}
