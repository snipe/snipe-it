<?php

namespace Tests\Feature\Users\Ui\BulkActions;

use App\Models\Company;
use App\Models\Consumable;
use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BulkCheckinConsumableFmcsTest extends TestCase
{
    public function test_bulk_checkin_cannot_delete_consumable_pivot_rows_across_fmcs_boundary()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $attacker = User::factory()->editUsers()->create();
        $attacker->companies()->sync([$companyA->id]);
        $attacker->syncLegacyCompanyIdMirror();

        $victim = User::factory()->create();
        $victim->companies()->sync([$companyB->id]);
        $victim->syncLegacyCompanyIdMirror();

        $companyBConsumable = Consumable::factory()->create(['company_id' => $companyB->id]);
        $victimAssignmentId = DB::table('consumables_users')->insertGetId([
            'consumable_id' => $companyBConsumable->id,
            'assigned_to' => $victim->id,
            'created_by' => $victim->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($attacker)
            ->post(route('users/bulksave'), [
                'ids' => [$victim->id],
                'status_id' => Statuslabel::factory()->create()->id,
            ]);

        $this->assertDatabaseHas('consumables_users', [
            'id' => $victimAssignmentId,
            'consumable_id' => $companyBConsumable->id,
            'assigned_to' => $victim->id,
        ]);
    }

    public function test_bulk_checkin_still_deletes_in_scope_consumable_pivot_rows()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();

        $actor = User::factory()->editUsers()->create();
        $actor->companies()->sync([$companyA->id]);
        $actor->syncLegacyCompanyIdMirror();

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id]);
        $target->syncLegacyCompanyIdMirror();

        $consumable = Consumable::factory()->create(['company_id' => $companyA->id]);
        $assignmentId = DB::table('consumables_users')->insertGetId([
            'consumable_id' => $consumable->id,
            'assigned_to' => $target->id,
            'created_by' => $actor->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($actor)
            ->post(route('users/bulksave'), [
                'ids' => [$target->id],
                'status_id' => Statuslabel::factory()->create()->id,
            ]);

        $this->assertDatabaseMissing('consumables_users', [
            'id' => $assignmentId,
        ]);
    }
}
