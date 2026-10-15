<?php

namespace Tests\Feature\Users\Ui\BulkActions;

use App\Models\Accessory;
use App\Models\CheckoutAcceptance;
use App\Models\Company;
use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Regression coverage for the bulk-checkin CheckoutAcceptance cross-tenant
 * delete, companion to BulkCheckinAccessoryCrossTenantDeleteFmcsTest. Before
 * the fix the destroy path ran
 *     CheckoutAcceptance::pending()
 *         ->whereIn('assigned_to_id', $user_raw_array)
 *         ->delete()
 * which filtered on `assigned_to_id` alone and touched every pending
 * acceptance the target user held, including ones whose checkoutable
 * belonged to a company the caller could not see. Under FMCS floater mode
 * a company-A caller could silently clear pending acceptances the victim
 * company's checkout flow was waiting on, without any permission check
 * against the underlying checkoutable. This file locks in the fixed
 * behavior. Cross-company pending acceptances survive. Same-company
 * pending acceptances still get deleted (positive control).
 */
class BulkCheckinAcceptanceCrossTenantDeleteFmcsTest extends TestCase
{
    public function test_bulk_checkin_does_not_delete_foreign_company_pending_acceptance_for_floater_target(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->set(['null_company_is_floater' => 1]);

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $attacker = User::factory()->editUsers()->checkinAccessories()->create();
        $attacker->companies()->sync([$companyA->id]);
        $attacker->syncLegacyCompanyIdMirror();

        $floater = User::factory()->create();

        $foreignAccessory = Accessory::factory()->create(['company_id' => $companyB->id]);
        DB::table('accessories_checkout')->insert([
            'accessory_id' => $foreignAccessory->id,
            'assigned_to' => $floater->id,
            'assigned_type' => User::class,
            'created_by' => $floater->id,
            'created_at' => now(),
        ]);

        $foreignAcceptance = CheckoutAcceptance::factory()->pending()->create([
            'checkoutable_type' => Accessory::class,
            'checkoutable_id' => $foreignAccessory->id,
            'assigned_to_id' => $floater->id,
        ]);

        $this->actingAs($attacker)
            ->post(route('users/bulksave'), [
                'ids' => [$floater->id],
                'status_id' => Statuslabel::factory()->create()->id,
            ]);

        // Not just present but explicitly non-deleted: CheckoutAcceptance uses
        // SoftDeletes, so a row can remain in the table with deleted_at set
        // and still satisfy assertDatabaseHas.
        $this->assertDatabaseHas('checkout_acceptances', [
            'id' => $foreignAcceptance->id,
            'assigned_to_id' => $floater->id,
            'deleted_at' => null,
        ]);
    }

    public function test_bulk_checkin_still_deletes_in_company_pending_acceptance(): void
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

        $acceptance = CheckoutAcceptance::factory()->pending()->create([
            'checkoutable_type' => Accessory::class,
            'checkoutable_id' => $accessory->id,
            'assigned_to_id' => $target->id,
        ]);

        $this->actingAs($actor)
            ->post(route('users/bulksave'), [
                'ids' => [$target->id],
                'status_id' => Statuslabel::factory()->create()->id,
            ]);

        $this->assertSoftDeleted('checkout_acceptances', ['id' => $acceptance->id]);
    }
}
