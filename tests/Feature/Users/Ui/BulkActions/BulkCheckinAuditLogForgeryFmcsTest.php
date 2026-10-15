<?php

namespace Tests\Feature\Users\Ui\BulkActions;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Company;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * GHSA-jh96-jm2x-38qp regression coverage. Before the fix, the bulk
 * user checkin endpoint iterated raw `DB::table('accessories_checkout')`
 * and `DB::table('license_seats')` rows straight into the audit-log
 * writers, so a company-A caller POSTing a company-B victim id
 * forged `'checkin from'` Actionlog entries into the victim tenant's
 * audit stream even though the underlying pivot rows stayed put.
 */
class BulkCheckinAuditLogForgeryFmcsTest extends TestCase
{
    public function test_bulk_checkin_does_not_write_action_logs_for_foreign_company_accessories(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $attacker = User::factory()->editUsers()->checkinAccessories()->create();
        $attacker->companies()->sync([$companyA->id]);
        $attacker->syncLegacyCompanyIdMirror();

        $victim = User::factory()->create();
        $victim->companies()->sync([$companyB->id]);
        $victim->syncLegacyCompanyIdMirror();

        $foreignAccessory = Accessory::factory()->create(['company_id' => $companyB->id]);
        DB::table('accessories_checkout')->insert([
            'accessory_id' => $foreignAccessory->id,
            'assigned_to' => $victim->id,
            'assigned_type' => User::class,
            'created_by' => $victim->id,
            'created_at' => now(),
        ]);

        $this->actingAs($attacker)
            ->post(route('users/bulksave'), [
                'ids' => [$victim->id],
                'status_id' => Statuslabel::factory()->create()->id,
            ]);

        $this->assertDatabaseMissing('action_logs', [
            'item_type' => Accessory::class,
            'item_id' => $foreignAccessory->id,
            'target_id' => $victim->id,
            'action_type' => 'checkin from',
        ]);
    }

    public function test_bulk_checkin_does_not_write_action_logs_for_foreign_company_license_seats(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $attacker = User::factory()->editUsers()->checkinLicenses()->create();
        $attacker->companies()->sync([$companyA->id]);
        $attacker->syncLegacyCompanyIdMirror();

        $victim = User::factory()->create();
        $victim->companies()->sync([$companyB->id]);
        $victim->syncLegacyCompanyIdMirror();

        $foreignLicense = License::factory()->create(['company_id' => $companyB->id, 'seats' => 3]);
        LicenseSeat::factory()->for($foreignLicense)->assignedToUser($victim)->create();

        $this->actingAs($attacker)
            ->post(route('users/bulksave'), [
                'ids' => [$victim->id],
                'status_id' => Statuslabel::factory()->create()->id,
            ]);

        $this->assertDatabaseMissing('action_logs', [
            'item_type' => License::class,
            'item_id' => $foreignLicense->id,
            'target_id' => $victim->id,
            'action_type' => 'checkin from',
        ]);
    }

    public function test_bulk_checkin_still_writes_action_logs_for_in_company_accessories(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();

        $actor = User::factory()->editUsers()->checkinAccessories()->create();
        $actor->companies()->sync([$companyA->id]);
        $actor->syncLegacyCompanyIdMirror();

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id]);
        $target->syncLegacyCompanyIdMirror();

        $accessory = Accessory::factory()->create(['company_id' => $companyA->id]);
        DB::table('accessories_checkout')->insert([
            'accessory_id' => $accessory->id,
            'assigned_to' => $target->id,
            'assigned_type' => User::class,
            'created_by' => $actor->id,
            'created_at' => now(),
        ]);

        $this->actingAs($actor)
            ->post(route('users/bulksave'), [
                'ids' => [$target->id],
                'status_id' => Statuslabel::factory()->create()->id,
            ]);

        $this->assertDatabaseHas('action_logs', [
            'item_type' => Accessory::class,
            'item_id' => $accessory->id,
            'target_id' => $target->id,
            'action_type' => 'checkin from',
        ]);
    }

    public function test_bulk_checkin_still_writes_action_logs_for_in_company_license_seats(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();

        $actor = User::factory()->editUsers()->checkinLicenses()->create();
        $actor->companies()->sync([$companyA->id]);
        $actor->syncLegacyCompanyIdMirror();

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id]);
        $target->syncLegacyCompanyIdMirror();

        $license = License::factory()->create(['company_id' => $companyA->id, 'seats' => 3]);
        LicenseSeat::factory()->for($license)->assignedToUser($target)->create();

        $this->actingAs($actor)
            ->post(route('users/bulksave'), [
                'ids' => [$target->id],
                'status_id' => Statuslabel::factory()->create()->id,
            ]);

        $this->assertDatabaseHas('action_logs', [
            'item_type' => License::class,
            'item_id' => $license->id,
            'target_id' => $target->id,
            'action_type' => 'checkin from',
        ]);
    }
}
