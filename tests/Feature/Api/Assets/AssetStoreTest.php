<?php

namespace Tests\Feature\Api\Assets;

use App\Models\User;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AssetStoreTest extends TestCase
{
    use InteractsWithSettings;

    public function testRequiresPermissionToCreateAsset()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.assets.store'))
            ->assertForbidden();
    }
}
