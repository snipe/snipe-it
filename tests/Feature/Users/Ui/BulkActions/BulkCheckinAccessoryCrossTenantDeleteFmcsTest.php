<?php

namespace Tests\Feature\Users\Ui\BulkActions;

use App\Models\Accessory;
use App\Models\Company;
use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;


class BulkCheckinAccessoryCrossTenantDeleteFmcsTest extends TestCase
{
    public function test_bulk_checkin_does_not_delete_foreign_company_accessory_checkout_rows_for_floater_target(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->set(['null_company_is_floater' => 1]);

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $attacker = User::factory()->editUsers()->checkinAccessories()->create();
        $attacker->companies()->sync([$companyA->id]);
        $attacker->syncLegacyCompanyIdMirror();

        // Floater target: no company pivot rows, visible cross-company under null_company_is_floater.
        $floater = User::factory()->create();

        $foreignAccessory = Accessory::factory()->create(['company_id' => $companyB->id]);
        $pivotId = DB::table('accessories_checkout')->insertGetId([
            'accessory_id' => $foreignAccessory->id,
            'assigned_to' => $floater->id,
            'assigned_type' => User::class,
            'created_by' => $floater->id,
            'created_at' => now(),
        ]);

        $this->actingAs($attacker)
            ->post(route('users/bulksave'), [
                'ids' => [$floater->id],
                'status_id' => Statuslabel::factory()->create()->id,
            ]);

        $this->assertDatabaseHas('accessories_checkout', [
            'id' => $pivotId,
            'accessory_id' => $foreignAccessory->id,
            'assigned_to' => $floater->id,
        ]);
    }

    public function test_bulk_checkin_still_deletes_in_company_accessory_checkout_rows(): void
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
        $pivotId = DB::table('accessories_checkout')->insertGetId([
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

        $this->assertDatabaseMissing('accessories_checkout', ['id' => $pivotId]);
    }
}
