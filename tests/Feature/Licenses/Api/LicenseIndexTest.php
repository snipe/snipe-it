<?php

namespace Tests\Feature\Licenses\Api;

use App\Models\Company;
use App\Models\License;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LicenseIndexTest extends TestCase
{
    public function test_licenses_index_adheres_to_company_scoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $licenseA = License::factory()->for($companyA)->create();
        $licenseB = License::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->viewLicenses()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->viewLicenses()->make());

        $this->settings->disableMultipleFullCompanySupport();

        $this->actingAsForApi($superUser)
            ->getJson(route('api.licenses.index'))
            ->assertResponseContainsInRows($licenseA)
            ->assertResponseContainsInRows($licenseB);

        $this->actingAsForApi($userInCompanyA)
            ->getJson(route('api.licenses.index'))
            ->assertResponseContainsInRows($licenseA)
            ->assertResponseContainsInRows($licenseB);

        $this->actingAsForApi($userInCompanyB)
            ->getJson(route('api.licenses.index'))
            ->assertResponseContainsInRows($licenseA)
            ->assertResponseContainsInRows($licenseB);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAsForApi($superUser)
            ->getJson(route('api.licenses.index'))
            ->assertResponseContainsInRows($licenseA)
            ->assertResponseContainsInRows($licenseB);

        $this->actingAsForApi($userInCompanyA)
            ->getJson(route('api.licenses.index'))
            ->assertResponseContainsInRows($licenseA)
            ->assertResponseDoesNotContainInRows($licenseB);

        $this->actingAsForApi($userInCompanyB)
            ->getJson(route('api.licenses.index'))
            ->assertResponseDoesNotContainInRows($licenseA)
            ->assertResponseContainsInRows($licenseB);
    }

    public function test_returns_result_via_filter()
    {

        License::factory()->create(['name' => 'MY AWESOME LICENSE NAME 1']);
        License::factory()->count(2)->create(['name' => 'MY AWESOME LICENSE NAME 2']);
        License::factory()->count(2)->create(['name' => 'MY AWESOME LICENSE NAME 3']);
        License::factory()->count(2)->create(['name' => 'MY TERRIBLE LICENSE NAME']);

        $this->actingAsForApi(User::factory()->viewLicenses()->create())
            ->getJson(route('api.licenses.index', [
                'filter' => '{"name":"AWESOME LICENSE NAME"}',
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'total',
                'rows',
            ])
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 5)->etc());
    }

    public function test_returns_result_via_filter_for_manufacturer()
    {

        License::factory()->count(5)->office()->create();
        License::factory()->count(3)->indesign()->create();
        License::factory()->count(3)->acrobat()->create();

        $this->actingAsForApi(User::factory()->viewLicenses()->create())
            ->getJson(route('api.licenses.index', [
                'filter' => '{"manufacturer":"adobe"}',
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'total',
                'rows',
            ])
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 6)->etc());

        $this->actingAsForApi(User::factory()->viewLicenses()->create())
            ->getJson(route('api.licenses.index', [
                'filter' => '{"manufacturer":"blah"}',
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'total',
                'rows',
            ])
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 0)->etc());

        $this->actingAsForApi(User::factory()->viewLicenses()->create())
            ->getJson(route('api.licenses.index', [
                'filter' => '{"manufacturer":"microsoft"}',
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'total',
                'rows',
            ])
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 5)->etc());

        $this->actingAsForApi(User::factory()->viewLicenses()->create())
            ->getJson(route('api.licenses.index', [
                'search' => 'adobe',
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'total',
                'rows',
            ])
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 6)->etc());
    }

    public function test_product_key_filter_is_ignored_for_users_without_view_keys(): void
    {
        License::factory()->create(['name' => 'License A', 'serial' => 'KNOWN-KEY-VALUE-AAA']);
        License::factory()->create(['name' => 'License B', 'serial' => 'KNOWN-KEY-VALUE-BBB']);
        License::factory()->create(['name' => 'License C', 'serial' => 'KNOWN-KEY-VALUE-CCC']);

        // A viewKeys-less caller filtering by product_key must NOT get a differential
        // response between valid and invalid candidates, since that difference would
        // itself be an oracle on key existence. The filter is silently dropped and
        // the full unfiltered list is returned instead.
        $viewOnly = User::factory()->viewLicenses()->create();

        $this->actingAsForApi($viewOnly)
            ->getJson(route('api.licenses.index', ['product_key' => 'KNOWN-KEY-VALUE-AAA']))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('total', 3)->etc());

        $this->actingAsForApi($viewOnly)
            ->getJson(route('api.licenses.index', ['product_key' => 'DEFINITELY-NOT-A-REAL-KEY']))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('total', 3)->etc());
    }

    public function test_product_key_filter_is_honored_for_users_with_view_keys(): void
    {
        License::factory()->create(['name' => 'License A', 'serial' => 'REAL-KEY-VALUE-AAA']);
        License::factory()->create(['name' => 'License B', 'serial' => 'REAL-KEY-VALUE-BBB']);

        $keyHolder = User::factory()->viewLicenses()->viewKeysLicenses()->create();

        $this->actingAsForApi($keyHolder)
            ->getJson(route('api.licenses.index', ['product_key' => 'REAL-KEY-VALUE-AAA']))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('total', 1)->etc());

        $this->actingAsForApi($keyHolder)
            ->getJson(route('api.licenses.index', ['product_key' => 'DEFINITELY-NOT-A-REAL-KEY']))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('total', 0)->etc());
    }

    public function test_search_does_not_match_on_serial_for_users_without_view_keys(): void
    {
        License::factory()->create(['name' => 'Alpha One', 'serial' => 'ORACLE-CANDIDATE-XYZ']);
        License::factory()->create(['name' => 'Alpha Two', 'serial' => 'DIFFERENT-KEY-ABC']);
        License::factory()->create(['name' => 'Beta One', 'serial' => 'BETA-KEY-DEF']);

        $viewOnly = User::factory()->viewLicenses()->create();

        // Searching for a value that only appears in the serial column must not
        // return the row that owns that serial. Otherwise the presence of the row
        // in the response is a positive oracle on key existence.
        $this->actingAsForApi($viewOnly)
            ->getJson(route('api.licenses.index', ['search' => 'ORACLE-CANDIDATE-XYZ']))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('total', 0)->etc());

        // Searching for a name substring keeps working, so legitimate search behavior
        // is unaffected by the serial suppression.
        $this->actingAsForApi($viewOnly)
            ->getJson(route('api.licenses.index', ['search' => 'Alpha']))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('total', 2)->etc());
    }

    public function test_structured_filter_on_serial_returns_no_rows_for_users_without_view_keys(): void
    {
        License::factory()->create(['name' => 'Alpha One', 'serial' => 'ORACLE-CANDIDATE-XYZ']);
        License::factory()->create(['name' => 'Alpha Two', 'serial' => 'DIFFERENT-KEY-ABC']);

        $viewOnly = User::factory()->viewLicenses()->create();

        // Structured (JSON) advanced-search filter keyed on `serial`. When the caller
        // can't viewKeys, the TextSearchWithoutSerial scope strips 'serial' from the
        // searchable attribute set, so applySingleSearchFilter treats it as an
        // unknown key and adds no where-clause. The full list comes back and the
        // oracle collapses.
        $this->actingAsForApi($viewOnly)
            ->getJson(route('api.licenses.index', [
                'filter' => '{"serial":"ORACLE-CANDIDATE-XYZ"}',
            ]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('total', 2)->etc());
    }

    public function test_search_matches_on_serial_for_users_with_view_keys(): void
    {
        License::factory()->create(['name' => 'Alpha One', 'serial' => 'ORACLE-CANDIDATE-XYZ']);
        License::factory()->create(['name' => 'Alpha Two', 'serial' => 'DIFFERENT-KEY-ABC']);

        $keyHolder = User::factory()->viewLicenses()->viewKeysLicenses()->create();

        $this->actingAsForApi($keyHolder)
            ->getJson(route('api.licenses.index', ['search' => 'ORACLE-CANDIDATE-XYZ']))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('total', 1)->etc());
    }

    public function test_text_search_without_serial_scope_leaves_searchable_attributes_intact_after_the_call(): void
    {
        // Regression guard: TextSearchWithoutSerial mutates $searchableAttributes on
        // the query's model instance before delegating to TextSearch. The try/finally
        // block restores it. If the finally is ever dropped, subsequent queries on
        // the same model instance would silently lose serial from their search set.
        License::factory()->create(['name' => 'Restoration probe', 'serial' => 'STAYS-SEARCHABLE-AFTER']);

        $keyHolder = User::factory()->viewLicenses()->viewKeysLicenses()->create();

        $model = new License;
        $before = $model->searchableAttributes;

        License::query()->TextSearchWithoutSerial('probe')->get();

        $this->assertSame($before, (new License)->searchableAttributes);

        // And confirm the serial-based search still works post-scope for a caller
        // who is allowed to see keys.
        $this->actingAsForApi($keyHolder)
            ->getJson(route('api.licenses.index', ['search' => 'STAYS-SEARCHABLE-AFTER']))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->where('total', 1)->etc());
    }
}
