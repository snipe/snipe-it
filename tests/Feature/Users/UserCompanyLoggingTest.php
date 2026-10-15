<?php

namespace Tests\Feature\Users;

use App\Models\Actionlog;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

class UserCompanyLoggingTest extends TestCase
{
    public function test_field_and_company_changes_produce_single_log_entry()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $user = User::factory()->forCompany($companyA->id)->create(['jobtitle' => 'Engineer']);
        $user->companies()->sync([$companyA->id]);

        $actor = User::factory()->superuser()->create();

        $existingLogIds = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->pluck('id');

        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'jobtitle' => 'Senior Engineer',
                'company_ids' => [$companyB->id],
            ])
            ->assertOk();

        $newLogs = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->whereNotIn('id', $existingLogIds)
            ->get();

        $this->assertCount(1, $newLogs, 'Field and company changes should produce exactly one log entry');

        $meta = json_decode($newLogs->first()->log_meta, true);
        $this->assertArrayHasKey('jobtitle', $meta, 'Log should include field change');
        $this->assertArrayHasKey('companies', $meta, 'Log should include company change in same entry');
    }

    public function test_company_only_change_produces_standalone_log_entry()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $user = User::factory()->forCompany($companyA->id)->create();
        $user->companies()->sync([$companyA->id]);

        $actor = User::factory()->superuser()->create();

        $existingLogIds = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->pluck('id');

        // Patch with no field changes — only company_ids differs.
        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'company_ids' => [$companyB->id],
            ])
            ->assertOk();

        $newLogs = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->whereNotIn('id', $existingLogIds)
            ->get();

        $this->assertCount(1, $newLogs, 'Company-only change should produce one log entry');

        $meta = json_decode($newLogs->first()->log_meta, true);
        $this->assertArrayHasKey('companies', $meta, 'Log should record company change');
    }

    public function test_log_entry_records_old_and_new_company_ids()
    {
        [$companyA, $companyB, $companyC] = Company::factory()->count(3)->create();

        $user = User::factory()->forCompany($companyA->id)->create();
        $user->companies()->sync([$companyA->id, $companyB->id]);

        $actor = User::factory()->superuser()->create();

        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'company_ids' => [$companyC->id],
            ])
            ->assertOk();

        $log = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->where('action_type', 'update')
            ->latest('id')
            ->first();

        $meta = json_decode($log->log_meta, true);

        $this->assertEqualsCanonicalizing(
            [$companyA->id, $companyB->id],
            $meta['companies']['old'],
            'Log old company IDs should match previous pivot'
        );
        $this->assertEqualsCanonicalizing(
            [$companyC->id],
            $meta['companies']['new'],
            'Log new company IDs should match updated pivot'
        );
    }

    public function test_no_change_to_companies_does_not_create_extra_log_entry()
    {
        $company = Company::factory()->create();

        $user = User::factory()->forCompany($company->id)->create();
        $user->companies()->sync([$company->id]);

        $actor = User::factory()->superuser()->create();

        $existingLogIds = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->pluck('id');

        // Send the same company_ids — no field changes either.
        $this->actingAsForApi($actor)
            ->patchJson(route('api.users.update', $user), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'company_ids' => [$company->id],
            ])
            ->assertOk();

        $newLogs = Actionlog::where('item_type', User::class)
            ->where('item_id', $user->id)
            ->whereNotIn('id', $existingLogIds)
            ->count();

        $this->assertEquals(0, $newLogs, 'No changes should produce no new log entries');
    }

    /**
     * Regression for a Rollbar "Array to string conversion" on
     * /api/v1/users/{id} update. When a malformed payload landed a
     * nested array inside company_ids and the API path's intval coercion
     * didn't fully flatten it, ->sync() bound the sub-array as a query
     * param and PHP tripped array-to-string conversion. The method now
     * coerces to a flat list of positive-int scalar ids up front.
     */
    public function test_sync_coerces_non_scalar_company_ids()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $user = User::factory()->create();

        // Deliberately hostile payload: nested array, string that intvals
        // to a real id, string that intvals to zero (should drop), null,
        // boolean, plus real ints. sync() must never see the non-scalars.
        $user->syncCompaniesWithLogging([
            $companyA->id,
            [$companyB->id, 999],
            (string) $companyB->id,
            'not-a-number',
            null,
            true,
            $companyA->id,
        ]);

        $this->assertEqualsCanonicalizing(
            [$companyA->id, $companyB->id],
            $user->companies()->pluck('companies.id')->toArray(),
            'Only the scalar-coerceable real company ids should end up on the pivot'
        );
    }

    public function test_sync_with_only_non_scalar_ids_detaches_all()
    {
        $company = Company::factory()->create();

        $user = User::factory()->create();
        $user->companies()->sync([$company->id]);

        // Nothing scalar-coerceable to a positive int → an empty sync,
        // which detaches every existing pivot row. Verifies the coercion
        // reduces to [] rather than silently keeping the old set.
        $user->syncCompaniesWithLogging([
            [1, 2],
            null,
            'x',
            false,
        ]);

        $this->assertEmpty(
            $user->companies()->pluck('companies.id')->toArray(),
            'Payload with no scalar-coerceable ids should detach all pivot rows'
        );
    }
}
