<?php

namespace Tests\Feature\Licenses\Api;

use App\Models\License;
use App\Models\User;
use Tests\TestCase;

class LicensesForSelectListTest extends TestCase
{
    public function test_requires_view_selectlists_permission(): void
    {
        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.licenses.selectlist'))
            ->assertForbidden();
    }

    public function test_licenses_are_returned_for_select_list(): void
    {
        [$licenseA, $licenseB] = License::factory()->count(2)->create();

        $this->actingAsForApi(User::factory()->createLicenses()->create())
            ->getJson(route('api.licenses.selectlist'))
            ->assertOk()
            ->assertResponseContainsInResults($licenseA)
            ->assertResponseContainsInResults($licenseB);
    }
}
