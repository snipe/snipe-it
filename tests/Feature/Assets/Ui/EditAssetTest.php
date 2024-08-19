<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\StatusLabel;
use App\Models\User;
use Tests\TestCase;

class EditAssetTest extends TestCase
{

    public function testPermissionRequiredToViewLicense()
    {
        $asset = Asset::factory()->create();
        $this->actingAs(User::factory()->create())
            ->get(route('hardware.edit', $asset))
            ->assertForbidden();
    }

    public function testPageCanBeAccessed(): void
    {
        $asset = Asset::factory()->create();
        $user = User::factory()->editAssets()->create();
        $response = $this->actingAs($user)->get(route('hardware.edit', $asset->id));
        $response->assertStatus(200);
    }

    public function testAssetEditPostIsRedirectedIfRedirectSelectionIsIndex()
    {
        $asset = Asset::factory()->assignedToUser()->create();

        $this->actingAs(User::factory()->viewAssets()->editAssets()->create())
            ->from(route('hardware.edit', $asset))
            ->put(route('hardware.update', $asset),
                [
                    'redirect_option' => 'index',
                    'name' => 'New name',
                    'asset_tags' => 'New Asset Tag',
                    'status_id' => StatusLabel::factory()->create()->id,
                    'model_id' => AssetModel::factory()->create()->id,
                ])
            ->assertStatus(302)
            ->assertRedirect(route('hardware.index'));
        $this->assertDatabaseHas('assets', ['asset_tag' => 'New Asset Tag']);
    }
    public function testAssetEditPostIsRedirectedIfRedirectSelectionIsItem()
    {
        $asset = Asset::factory()->create();

        $this->actingAs(User::factory()->viewAssets()->editAssets()->create())
            ->from(route('hardware.edit', $asset))
            ->put(route('hardware.update', $asset), [
                'redirect_option' => 'item',
                'name' => 'New name',
                'asset_tags' => 'New Asset Tag',
                'status_id' => StatusLabel::factory()->create()->id,
                'model_id' => AssetModel::factory()->create()->id,
            ])
            ->assertStatus(302)
            ->assertRedirect(route('hardware.show', ['hardware' => $asset->id]));

        $this->assertDatabaseHas('assets', ['asset_tag' => 'New Asset Tag']);
    }

}
