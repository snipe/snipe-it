<?php

namespace Tests\Feature\Api\Assets;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class AssetIndexTest extends TestCase
{
    use InteractsWithSettings;

    public function testAssetIndexReturnsExpectedAssets()
    {
        Asset::factory()->count(3)->create();

        Passport::actingAs(User::factory()->superuser()->create());
        $this->getJson(
            route('api.assets.index', [
                'sort' => 'name',
                'order' => 'asc',
                'offset' => '0',
                'limit' => '20',
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'total',
                'rows',
            ])
            ->assertJson(fn(AssertableJson $json) => $json->has('rows', 3)->etc());
    }
}
