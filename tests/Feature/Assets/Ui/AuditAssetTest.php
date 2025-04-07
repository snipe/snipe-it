<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class AuditAssetTest extends TestCase
{
    public function testPermissionRequiredToCreateAssetModel()
    {
        $asset = Asset::factory()->create();
        $this->actingAs(User::factory()->create())
            ->get(route('clone/hardware', $asset))
            ->assertForbidden();
    }

    public function testPageCanBeAccessed(): void
    {
        $asset = Asset::factory()->create();
        $response = $this->actingAs(User::factory()->auditAssets()->create())
            ->get(route('asset.audit.create', $asset));
        $response->assertStatus(200);
    }

    public function testAssetCanBeAudited()
    {
        $asset = Asset::factory()->create(['name'=>'Asset to clone']);
        $this->actingAs(User::factory()->auditAssets()->create())
            ->post(route('asset.audit.store', $asset))
            ->assertStatus(302)
            ->assertRedirect(route('assets.audit.due'));
    }
}
