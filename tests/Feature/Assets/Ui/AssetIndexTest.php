<?php

namespace Tests\Feature\Assets\Ui;

use App\Models\User;
use Tests\TestCase;

class AssetIndexTest extends TestCase
{
    public function test_page_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.index'))
            ->assertOk();
    }

    public function test_page_renders_with_array_query_inputs()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.index', [
                'status_type' => ['Deleted'],
                'order_number' => [123],
                'company_id' => [1],
                'status_id' => [1],
            ]))
            ->assertOk();
    }

    public function test_page_renders_when_status_type_is_an_associative_array_probe()
    {
        // Regression pin for an array-shaped query probe like
        // ?status_type[$ptt]=RTD. request()->status_type returns an
        // associative array, the old breadcrumb branch compared it
        // to '' (truthy for arrays), then passed it to e(), which
        // crashed htmlspecialchars with a TypeError and surfaced as
        // a ViewException on the whole /hardware page. The guard
        // now requires is_string before the e() call.
        $this->actingAs(User::factory()->superuser()->create())
            ->get('/hardware?status_type[$ptt]=RTD')
            ->assertOk();
    }
}
