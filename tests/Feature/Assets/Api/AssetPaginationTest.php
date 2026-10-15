<?php

namespace Tests\Feature\Assets\Api;

use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

class AssetPaginationTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->superuser()->create();
    }

    public function test_response_includes_pagination_fields()
    {
        Asset::factory()->count(3)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index'))
            ->assertOk()
            ->assertJsonStructure(['total', 'rows', 'current_page', 'per_page', 'total_pages']);
    }

    public function test_default_request_returns_page_one()
    {
        Asset::factory()->count(3)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index'))
            ->assertOk()
            ->assertJsonPath('current_page', 1);
    }

    public function test_offset_zero_returns_page_one()
    {
        Asset::factory()->count(10)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['offset' => 0, 'limit' => 5]))
            ->assertOk()
            ->assertJsonPath('current_page', 1);
    }

    public function test_offset_derives_correct_page_number()
    {
        Asset::factory()->count(10)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['offset' => 5, 'limit' => 5]))
            ->assertOk()
            ->assertJsonPath('current_page', 2);
    }

    public function test_page_one_returns_current_page_one()
    {
        Asset::factory()->count(10)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 1, 'limit' => 5]))
            ->assertOk()
            ->assertJsonPath('current_page', 1);
    }

    public function test_page_two_returns_current_page_two()
    {
        Asset::factory()->count(10)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 2, 'limit' => 5]))
            ->assertOk()
            ->assertJsonPath('current_page', 2);
    }

    public function test_page_one_returns_first_items()
    {
        foreach (range(1, 10) as $i) {
            Asset::factory()->create(['asset_tag' => sprintf('PAG-TEST-%03d', $i)]);
        }

        $tags = $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 1, 'limit' => 5, 'sort' => 'asset_tag', 'order' => 'asc']))
            ->assertOk()
            ->json('rows.*.asset_tag');

        $this->assertEquals(
            ['PAG-TEST-001', 'PAG-TEST-002', 'PAG-TEST-003', 'PAG-TEST-004', 'PAG-TEST-005'],
            $tags
        );
    }

    public function test_page_two_returns_second_set_of_items()
    {
        foreach (range(1, 10) as $i) {
            Asset::factory()->create(['asset_tag' => sprintf('PAG-TEST-%03d', $i)]);
        }

        $tags = $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 2, 'limit' => 5, 'sort' => 'asset_tag', 'order' => 'asc']))
            ->assertOk()
            ->json('rows.*.asset_tag');

        $this->assertEquals(
            ['PAG-TEST-006', 'PAG-TEST-007', 'PAG-TEST-008', 'PAG-TEST-009', 'PAG-TEST-010'],
            $tags
        );
    }

    public function test_offset_returns_correct_items()
    {
        foreach (range(1, 10) as $i) {
            Asset::factory()->create(['asset_tag' => sprintf('PAG-TEST-%03d', $i)]);
        }

        $tags = $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['offset' => 5, 'limit' => 5, 'sort' => 'asset_tag', 'order' => 'asc']))
            ->assertOk()
            ->json('rows.*.asset_tag');

        $this->assertEquals(
            ['PAG-TEST-006', 'PAG-TEST-007', 'PAG-TEST-008', 'PAG-TEST-009', 'PAG-TEST-010'],
            $tags
        );
    }

    public function test_page_param_respects_limit()
    {
        Asset::factory()->count(10)->create();

        $response = $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 1, 'limit' => 4]))
            ->assertOk();

        $this->assertCount(4, $response->json('rows'));
    }

    public function test_page_beyond_results_returns_empty_rows()
    {
        Asset::factory()->count(5)->create();

        $response = $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 99, 'limit' => 5]))
            ->assertOk();

        $this->assertCount(0, $response->json('rows'));
        $this->assertEquals(5, $response->json('total'));
    }

    public function test_offset_takes_precedence_over_page_when_both_provided()
    {
        Asset::factory()->count(10)->create();

        // offset=0 should win over page=3, giving current_page=1
        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['offset' => 0, 'page' => 3, 'limit' => 5]))
            ->assertOk()
            ->assertJsonPath('current_page', 1);
    }

    public function test_per_page_reflects_the_limit_parameter_as_an_integer()
    {
        Asset::factory()->count(3)->create();

        $response = $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['limit' => 25]))
            ->assertOk()
            ->assertJsonPath('per_page', 25);

        $this->assertIsInt($response->json('per_page'));
    }

    public function test_prev_page_url_is_null_on_first_page()
    {
        Asset::factory()->count(10)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 1, 'limit' => 5]))
            ->assertOk()
            ->assertJsonPath('prev_page_url', null);
    }

    public function test_next_page_url_is_null_on_last_page()
    {
        Asset::factory()->count(10)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 2, 'limit' => 5]))
            ->assertOk()
            ->assertJsonPath('next_page_url', null);
    }

    public function test_next_page_url_contains_correct_page_number()
    {
        Asset::factory()->count(10)->create();

        $url = $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 1, 'limit' => 5]))
            ->assertOk()
            ->json('next_page_url');

        $this->assertStringContainsString('page=2', $url);
        $this->assertStringContainsString('limit=5', $url);
    }

    public function test_prev_page_url_contains_correct_page_number()
    {
        Asset::factory()->count(10)->create();

        $url = $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 2, 'limit' => 5]))
            ->assertOk()
            ->json('prev_page_url');

        $this->assertStringContainsString('page=1', $url);
        $this->assertStringContainsString('limit=5', $url);
    }

    public function test_page_urls_do_not_include_limit_when_not_in_original_request()
    {
        // Since this test relies on app.max_results,
        // let's lower it temporarily to avoid having
        // to create a bunch of models.
        $newMaxResults = 1;

        config(['app.max_results' => $newMaxResults]);

        Asset::factory()->count($newMaxResults + 1)->create();

        $response = $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 1]))
            ->assertOk();

        // Guards the thin margin above: without a second page there is no URL to
        // inspect and the assertion below would pass vacuously.
        $this->assertNotNull($response->json('next_page_url'));
        $this->assertStringNotContainsString('limit=', $response->json('next_page_url'));
    }

    public function test_both_page_urls_null_when_single_page()
    {
        Asset::factory()->count(3)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['page' => 1, 'limit' => 50]))
            ->assertOk()
            ->assertJsonPath('prev_page_url', null)
            ->assertJsonPath('next_page_url', null);
    }

    public function test_total_pages_is_correct_for_even_division()
    {
        Asset::factory()->count(10)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['limit' => 5]))
            ->assertOk()
            ->assertJsonPath('total_pages', 2);
    }

    public function test_total_pages_rounds_up_for_uneven_division()
    {
        Asset::factory()->count(11)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['limit' => 5]))
            ->assertOk()
            ->assertJsonPath('total_pages', 3);
    }

    public function test_total_pages_is_one_when_results_fit_in_single_page()
    {
        Asset::factory()->count(3)->create();

        $this->actingAsForApi($this->user)
            ->getJson(route('api.assets.index', ['limit' => 5]))
            ->assertOk()
            ->assertJsonPath('total_pages', 1);
    }
}
