<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class AuditAssetTest extends TestCase
{
    public function testPermissionRequiredToCreateAssetModel()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('clone/hardware', Asset::factory()->create()))
            ->assertForbidden();
    }

    public function testPageCanBeAccessed(): void
    {
        $this->actingAs(User::factory()->auditAssets()->create())
            ->get(route('asset.audit.create', Asset::factory()->create()))
            ->assertStatus(200);
    }

    public function testAssetCanBeAudited()
    {
        $this->actingAs(User::factory()->auditAssets()->create())
            ->post(route('asset.audit.store', Asset::factory()->create()))
            ->assertStatus(302)
            ->assertRedirect(route('assets.audit.due'));
    }
}
