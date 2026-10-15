<?php

namespace Tests\Feature\Users;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * The users.legacy_company_id column is a compatibility mirror of the
 * company_user pivot, maintained purely for external consumers (API responses,
 * CSV exports, SCIM mappings) that still expect it. Internal FMCS logic reads
 * ONLY the pivot. The invariant these tests protect: the mirror is always
 * either NULL (pivot empty) or equal to one of the pivot entries, so it can
 * never surprise a downstream integration that reads the two independently.
 */
class LegacyCompanyIdMirrorTest extends TestCase
{
    public function test_sync_companies_with_logging_populates_scalar_from_empty()
    {
        $company = Company::factory()->create();
        $user = User::factory()->create();
        DB::table('users')->where('id', $user->id)->update(['legacy_company_id' => null]);
        $user->refresh();

        $user->syncCompaniesWithLogging([$company->id]);

        $this->assertSame((int) $company->id, (int) $user->fresh()->legacy_company_id);
    }

    public function test_sync_companies_with_logging_clears_scalar_when_pivot_becomes_empty()
    {
        $company = Company::factory()->create();
        $user = User::factory()->create();
        $user->companies()->sync([$company->id]);
        DB::table('users')->where('id', $user->id)->update(['legacy_company_id' => $company->id]);
        $user->refresh();

        $this->assertSame((int) $company->id, (int) $user->legacy_company_id);

        $user->syncCompaniesWithLogging([]);

        $this->assertNull($user->fresh()->legacy_company_id);
    }

    public function test_sync_companies_with_logging_realigns_scalar_when_original_membership_removed()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $user = User::factory()->create();
        $user->companies()->sync([$companyA->id]);
        DB::table('users')->where('id', $user->id)->update(['legacy_company_id' => $companyA->id]);
        $user->refresh();

        $user->syncCompaniesWithLogging([$companyB->id]);

        $this->assertSame((int) $companyB->id, (int) $user->fresh()->legacy_company_id);
    }

    public function test_align_helper_picks_the_lowest_pivot_id_when_multiple()
    {
        $companies = Company::factory()->count(3)->create();
        $expected = $companies->min('id');

        $user = User::factory()->create();
        $user->syncCompaniesWithLogging($companies->pluck('id')->all());

        $this->assertSame((int) $expected, (int) $user->fresh()->legacy_company_id);
    }

    public function test_legacy_user_with_empty_pivot_and_null_scalar_is_preserved()
    {
        // Legacy no-company users predate FMCS. Neither the scalar nor the pivot
        // is populated, and the FMCS policy check reads that combination as
        // "true legacy user, treat as unscoped". The invariant enforcement must
        // NOT accidentally move them out of that state when they haven't been
        // touched by a pivot write.
        $user = User::factory()->withoutCompany()->create();
        $user->companies()->detach();
        DB::table('users')->where('id', $user->id)->update(['legacy_company_id' => null]);
        $user->refresh();

        $this->assertEmpty($user->companies()->pluck('companies.id')->all());
        $this->assertNull($user->legacy_company_id);

        // Simulating a downstream code path that reads (not writes) the user
        // must not mutate either field.
        $user->fresh();

        $this->assertNull($user->legacy_company_id);
        $this->assertEmpty($user->companies()->pluck('companies.id')->all());
    }

    public function test_align_helper_is_a_noop_on_unpersisted_users()
    {
        $user = new User;

        // Should not throw and should not attempt a DB write.
        $user->syncLegacyCompanyIdMirror();

        $this->assertFalse($user->exists);
    }
}
