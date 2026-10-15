<?php

namespace Tests\Feature\Maintenances\Ui;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Company;
use App\Models\Maintenance;
use App\Models\User;
use Tests\TestCase;

class BulkMaintenanceActionsTest extends TestCase
{
    public function test_empty_selection_redirects_with_warning()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('maintenances.bulk'), ['bulk_actions' => 'delete', 'ids' => []])
            ->assertSessionHas('warning')
            ->assertRedirect(route('maintenances.index'));
    }

    public function test_bulk_delete_removes_selected_records()
    {
        $keeper = Maintenance::factory()->create();
        $doomed = Maintenance::factory()->count(3)->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('maintenances.bulk'), [
                'bulk_actions' => 'delete',
                'ids' => $doomed->pluck('id')->all(),
            ])
            ->assertRedirect(route('maintenances.index'))
            ->assertSessionHas('success');

        $doomed->each(fn ($m) => $this->assertSoftDeleted('maintenances', ['id' => $m->id]));
        $this->assertDatabaseHas('maintenances', ['id' => $keeper->id, 'deleted_at' => null]);
    }

    public function test_bulk_endpoint_requires_asset_edit_permission()
    {
        $maintenance = Maintenance::factory()->create();

        // Top-level authorize('update', Asset::class) in the controller
        // blocks users without any assets.edit rights from even reaching
        // the per-row policy checks — 403 rather than a "0 succeeded"
        // redirect.
        $this->actingAs(User::factory()->create())
            ->post(route('maintenances.bulk'), [
                'bulk_actions' => 'delete',
                'ids' => [$maintenance->id],
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('maintenances', ['id' => $maintenance->id, 'deleted_at' => null]);
    }

    public function test_bulk_delete_cannot_reach_maintenance_in_other_company_when_fmcs_enabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        // Actor is in company A with asset-edit permission (companyA
        // maintenance CRUD is fine, cross-company must be blocked).
        $actor = $companyA->users()->save(User::factory()->editAssets()->make());

        $maintenanceB = Maintenance::factory()->create();
        $maintenanceB->asset->update(['company_id' => $companyB->id]);

        $this->actingAs($actor)
            ->post(route('maintenances.bulk'), [
                'bulk_actions' => 'delete',
                'ids' => [$maintenanceB->id],
            ])
            ->assertRedirect(route('maintenances.index'));

        // Maintenance record from company B must NOT be touched — the
        // CompanyableChildTrait global scope on the whereIn lookup
        // excludes it, so the row never reaches the delete branch.
        $this->assertDatabaseHas('maintenances', ['id' => $maintenanceB->id, 'deleted_at' => null]);
    }

    public function test_bulk_complete_cannot_reach_maintenance_in_other_company_when_fmcs_enabled()
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();
        $actor = $companyA->users()->save(User::factory()->editAssets()->make());

        $maintenanceB = Maintenance::factory()->create(['completed_at' => null]);
        $maintenanceB->asset->update(['company_id' => $companyB->id]);

        $this->actingAs($actor)
            ->post(route('maintenances.bulk'), [
                'bulk_actions' => 'complete',
                'ids' => [$maintenanceB->id],
            ])
            ->assertRedirect(route('maintenances.index'));

        $maintenanceB->refresh();
        $this->assertNull($maintenanceB->completed_at, 'Cross-company maintenance must not be marked complete');
    }

    public function test_bulk_complete_marks_selected_and_logs()
    {
        $actor = User::factory()->superuser()->create();
        $maintenance = Maintenance::factory()->create();

        $this->actingAs($actor)
            ->post(route('maintenances.bulk'), [
                'bulk_actions' => 'complete',
                'ids' => [$maintenance->id],
            ])
            ->assertRedirect(route('maintenances.index'))
            ->assertSessionHas('success');

        $maintenance->refresh();
        $this->assertNotNull($maintenance->completed_at);
        $this->assertEquals($actor->id, $maintenance->completed_by);

        $this->assertDatabaseHas('action_logs', [
            'item_type' => Maintenance::class,
            'item_id' => $maintenance->id,
            'action_type' => ActionType::MaintenanceComplete->value,
        ]);
    }

    public function test_bulk_complete_skips_already_completed()
    {
        $alreadyDone = Maintenance::factory()->create([
            'completed_at' => now()->subDay(),
            'completed_by' => User::factory()->create()->id,
        ]);

        $existingLogs = Actionlog::where('item_type', Maintenance::class)
            ->where('item_id', $alreadyDone->id)
            ->count();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('maintenances.bulk'), [
                'bulk_actions' => 'complete',
                'ids' => [$alreadyDone->id],
            ])
            ->assertRedirect(route('maintenances.index'));

        // completed_at should stay untouched; no new completion log entry.
        $alreadyDone->refresh();
        $this->assertTrue($alreadyDone->completed_at->isYesterday());
        $this->assertEquals(
            $existingLogs,
            Actionlog::where('item_type', Maintenance::class)
                ->where('item_id', $alreadyDone->id)
                ->count(),
            'A second completion should not create another action-log entry'
        );
    }

    public function test_unknown_action_returns_error()
    {
        $maintenance = Maintenance::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('maintenances.bulk'), [
                'bulk_actions' => 'nuke-from-orbit',
                'ids' => [$maintenance->id],
            ])
            ->assertRedirect(route('maintenances.index'))
            ->assertSessionHas('error');
    }

    public function test_same_origin_referer_is_used_for_post_action_redirect()
    {
        $maintenance = Maintenance::factory()->create();
        $referer = config('app.url').'/maintenances?completed=true';

        $this->actingAs(User::factory()->superuser()->create())
            ->withHeader('referer', $referer)
            ->post(route('maintenances.bulk'), [
                'bulk_actions' => 'delete',
                'ids' => [$maintenance->id],
            ])
            ->assertRedirect($referer);
    }

    public function test_offsite_referer_is_rejected_and_falls_back_to_index()
    {
        $maintenance = Maintenance::factory()->create();

        // Attacker-controlled referer must not be honored — protects
        // against open-redirect / phishing hand-offs after the POST.
        $this->actingAs(User::factory()->superuser()->create())
            ->withHeader('referer', 'https://evil.example.com/steal-session')
            ->post(route('maintenances.bulk'), [
                'bulk_actions' => 'delete',
                'ids' => [$maintenance->id],
            ])
            ->assertRedirect(route('maintenances.index'));
    }
}
