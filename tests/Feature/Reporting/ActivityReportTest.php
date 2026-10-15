<?php

namespace Tests\Feature\Reporting;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ActivityReportTest extends TestCase
{
    public function test_requires_permission_to_view_activity()
    {
        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.activity.index'))
            ->assertForbidden();
    }

    public function test_can_view_activity_if_item_is_given_and_user_has_permissions()
    {
        $asset = Asset::factory()->create();
        $this->actingAsForApi(User::factory()->viewAssets()->create())
            ->getJson(route('api.activity.index',
                [
                    'item_type' => 'asset',
                    'item_id' => $asset->id,
                ]))
            ->assertOk()
            ->assertJsonStructure([
                'rows',
            ])
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 1)->etc());
    }

    public function test_can_view_activity_if_target_is_given_and_user_has_permissions()
    {

        $user = User::factory()->create();
        $user->update([
            'first_name' => 'Test Update',
        ]);
        $user->update([
            'first_name' => 'Test Update Again',
        ]);

        $this->actingAsForApi(User::factory()->viewUsers()->create())
            ->getJson(route('api.activity.index',
                [
                    'target_type' => 'user',
                    'target_id' => $user->id,
                ]))
            ->assertOk()
            ->assertJsonStructure([
                'rows',
            ])
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 2)->etc());
    }

    public function test_null_company_upload_logs_visible_in_activity_report_with_fmcs_enabled()
    {
        // AssetModel and Company objects have no company_id column, so their upload logs always
        // get company_id = null. With FMCS active the scope previously applied
        // WHERE company_id IN (...) which excluded NULLs, hiding these logs from the activity report.
        $this->settings->enableMultipleFullCompanySupport();

        $company = Company::factory()->create();
        $superUser = User::factory()->superuser()->create();

        $viewingUser = User::factory()
            ->canViewReports()
            ->forCompany($company)
            ->create();

        $model = AssetModel::factory()->create();

        // Superuser uploads a file to the AssetModel (log gets company_id = null)
        $this->actingAsForApi($superUser)
            ->post(
                route('api.files.store', ['object_type' => 'models', 'id' => $model->id]),
                ['file' => [UploadedFile::fake()->create('test.jpg', 100)]]
            )
            ->assertOk();

        // Non-superuser with activity.view (reports.view) should see the uploaded log
        $this->actingAsForApi($viewingUser)
            ->getJson(route('api.activity.index', [
                'action_type' => 'uploaded',
                'item_type' => 'AssetModel',
                'item_id' => $model->id,
            ]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 1)->etc());
    }

    public function test_upload_logs_for_another_companys_asset_not_visible_in_activity_report_with_fmcs()
    {
        // Our null-company fix adds OR company_id IS NULL to action_log queries.
        // Verify this does NOT leak logs that have a real company_id belonging to a different company.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $superUser = User::factory()->superuser()->create();
        $assetInCompanyA = Asset::factory()->create(['company_id' => $companyA->id]);

        $viewerInCompanyB = User::factory()
            ->canViewReports()
            ->forCompany($companyB)
            ->create();

        // Superuser uploads a file to company A's asset (log gets company_id = companyA->id)
        $this->actingAsForApi($superUser)
            ->post(
                route('api.files.store', ['object_type' => 'hardware', 'id' => $assetInCompanyA->id]),
                ['file' => [UploadedFile::fake()->create('test.jpg', 100)]]
            )
            ->assertOk();

        // User in company B should not see the upload log for company A's asset
        $this->actingAsForApi($viewerInCompanyB)
            ->getJson(route('api.activity.index', [
                'action_type' => 'uploaded',
                'item_type' => 'asset',
                'item_id' => $assetInCompanyA->id,
            ]))
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 0)->etc());
    }

    public function test_records_are_scoped_to_company_when_multiple_company_support_enabled()
    {
        // $this->markTestIncomplete('This test returns strange results. Need to figure out why.');
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $superUser = User::factory()->superuser()->make();

        $userInCompanyA = User::factory()
            ->viewUsers()
            ->viewAssets()
            ->canViewReports()
            ->forCompany($companyA)
            ->create();

        $userInCompanyB = User::factory()
            ->viewUsers()
            ->viewAssets()
            ->canViewReports()
            ->forCompany($companyB)
            ->create();

        Asset::factory()->count(5)->create(['company_id' => $companyA->id]);
        Asset::factory()->count(4)->create(['company_id' => $companyB->id]);
        Asset::factory()->count(3)->create();

        Actionlog::factory()->userUpdated()->count(5)->create(['company_id' => $companyA->id]);
        Actionlog::factory()->userUpdated()->count(4)->create(['company_id' => $companyB->id]);
        Actionlog::factory()->userUpdated()->count(3)->create(['company_id' => $companyB->id]);

        // I don't love this, since it doesn't test that we're actually storing the company ID appropriately
        // but it's better than what we had
        $this->actingAsForApi($userInCompanyA)
            ->getJson(route('api.activity.index', [
                'action_type' => 'update',
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'rows',
            ])
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 5)->etc());

        $this->actingAsForApi($userInCompanyB)
            ->getJson(
                route('api.activity.index', [
                    'action_type' => 'update',
                ]))
            ->assertOk()
            ->assertJsonStructure([
                'rows',
            ])
            ->assertJson(fn (AssertableJson $json) => $json->has('rows', 7)->etc());

    }

    public function test_activity_report_normalizes_lowercase_camelcase_input()
    {
        // Reg-test for the pre-existing `licenseseat` Fatal Error:
        // Helper::normalizeFullModelName uses ucwords(), which only
        // capitalizes the first letter of each space-delimited word.
        // A lowercase short name like `licenseseat` (which FilterRequest
        // accepts) came out as the nonexistent App\Models\Licenseseat
        // and Fatal'd when withTrashed()->find() called the class. The
        // resolver's case-insensitive lookup now returns the canonical
        // App\Models\LicenseSeat, so the request succeeds cleanly.
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.activity.index', [
                'item_type' => 'licenseseat',
                'item_id' => 999999,
            ]))
            ->assertOk();
    }

    public function test_activity_report_rejects_types_not_in_form_request_allowlist()
    {
        // FilterRequest already rejects arbitrary class names, but
        // Snipe-IT returns validation failures as HTTP 200 with body
        // status=error (project convention). Pinning that shape so a
        // refactor that changes either FilterRequest or the response
        // envelope shows up in tests before it ships.
        $this->actingAsForApi(User::factory()->superuser()->create())
            ->getJson(route('api.activity.index', [
                'item_type' => 'NotARealClass',
                'item_id' => 1,
            ]))
            ->assertOk()
            ->assertStatusMessageIs('error');
    }

    public function test_search_matches_target_asset_tag_on_component_checkout()
    {
        // Component checkouts store item=Component and target=Asset.
        // Actionlog's $searchableRelations only walks item_id, so
        // searching by the target asset's tag missed these rows
        // before the advancedTextSearch() override on Actionlog.
        // Same fix applied here for the general reports.view path.
        // Positive-membership assertion because the built-in
        // item_id-keyed searchRelations may also match the asset's
        // own create log, and both matches are legitimate.
        $actor = User::factory()->superuser()->create();

        $component = \App\Models\Component::factory()->create();
        $targetAsset = Asset::factory()->create(['asset_tag' => 'TARGET-TAG-4242']);

        $matchingLog = Actionlog::factory()->create([
            'action_type' => 'checkout',
            'item_type' => \App\Models\Component::class,
            'item_id' => $component->id,
            'target_type' => Asset::class,
            'target_id' => $targetAsset->id,
        ]);

        $ids = collect($this->actingAsForApi($actor)
            ->getJson(route('api.activity.index', ['search' => 'TARGET-TAG-4242']))
            ->assertOk()
            ->json('rows'))
            ->pluck('id')
            ->all();

        $this->assertContains($matchingLog->id, $ids);
    }

    public function test_search_matches_action_log_location_name()
    {
        // Activity Report eager-loads and shows the location on each
        // action_log row (e.g. checkouts to a location). Before adding
        // location to Actionlog's $searchableRelations, typing that
        // location's name into the report search silently returned
        // nothing.
        $actor = User::factory()->superuser()->create();

        $location = \App\Models\Location::factory()->create(['name' => 'Kraków Office']);
        $matchingLog = Actionlog::factory()->create([
            'action_type' => 'checkout',
            'item_type' => Asset::class,
            'item_id' => Asset::factory()->create()->id,
            'location_id' => $location->id,
        ]);
        $otherLog = Actionlog::factory()->create([
            'action_type' => 'checkout',
            'item_type' => Asset::class,
            'item_id' => Asset::factory()->create()->id,
            'location_id' => null,
        ]);

        $ids = collect($this->actingAsForApi($actor)
            ->getJson(route('api.activity.index', ['search' => 'Kraków']))
            ->assertOk()
            ->json('rows'))
            ->pluck('id')
            ->all();

        $this->assertContains($matchingLog->id, $ids);
        $this->assertNotContains($otherLog->id, $ids);
    }
}
