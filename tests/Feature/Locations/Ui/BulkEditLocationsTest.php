<?php

namespace Tests\Feature\Locations\Ui;

use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use Tests\TestCase;

class BulkEditLocationsTest extends TestCase
{
    public function test_permission_required_to_render_bulk_edit_form(): void
    {
        $locations = Location::factory()->count(2)->create();

        $this->actingAs(User::factory()->create())
            ->post(route('locations.bulkdelete.show'), [
                'bulk_actions' => 'edit',
                'ids' => $locations->pluck('id')->all(),
            ])
            ->assertForbidden();
    }

    public function test_renders_bulk_edit_form_when_edit_action_is_selected(): void
    {
        $locations = Location::factory()->count(2)->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkdelete.show'), [
                'bulk_actions' => 'edit',
                'ids' => $locations->pluck('id')->all(),
            ])
            ->assertOk()
            ->assertSee($locations->first()->name)
            ->assertSee($locations->last()->name)
            ->assertSee(route('locations.bulkedit.store'), false);
    }

    public function test_redirects_to_index_when_no_ids_submitted_to_bulk_edit(): void
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->from(route('locations.index'))
            ->post(route('locations.bulkdelete.show'), [
                'bulk_actions' => 'edit',
                'ids' => [],
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('error');
    }

    public function test_permission_required_to_save_bulk_edit(): void
    {
        $locations = Location::factory()->count(2)->create();

        $this->actingAs(User::factory()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => $locations->pluck('id')->all(),
                'currency' => 'EUR',
            ])
            ->assertForbidden();
    }

    public function test_applies_parent_id_to_every_selected_location(): void
    {
        $newParent = Location::factory()->create();
        $targets = Location::factory()->count(3)->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => $targets->pluck('id')->all(),
                'parent_id' => $newParent->id,
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        foreach ($targets as $target) {
            $this->assertSame($newParent->id, $target->fresh()->parent_id);
        }
    }

    public function test_skips_parent_id_on_the_row_that_would_become_its_own_parent(): void
    {
        // If the operator picks a location that is itself in the selection
        // as the new parent, that specific row must skip parent_id but
        // other rows in the selection still get moved under it. Other
        // fields on the self-picked row still apply.
        $selfPicked = Location::factory()->create();
        $sibling = Location::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$selfPicked->id, $sibling->id],
                'parent_id' => $selfPicked->id,
                'currency' => 'JPY',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $this->assertNull($selfPicked->fresh()->parent_id);
        $this->assertSame('JPY', $selfPicked->fresh()->currency);
        $this->assertSame($selfPicked->id, $sibling->fresh()->parent_id);
        $this->assertSame('JPY', $sibling->fresh()->currency);
    }

    public function test_applies_manager_id_and_currency_and_state_and_country(): void
    {
        $manager = User::factory()->create();
        $targets = Location::factory()->count(2)->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => $targets->pluck('id')->all(),
                'manager_id' => $manager->id,
                'currency' => 'CAD',
                'state' => 'ON',
                'country' => 'CA',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        foreach ($targets as $target) {
            $fresh = $target->fresh();
            $this->assertSame($manager->id, $fresh->manager_id);
            $this->assertSame('CAD', $fresh->currency);
            $this->assertSame('ON', $fresh->state);
            $this->assertSame('CA', $fresh->country);
        }
    }

    public function test_null_state_checkbox_clears_the_state_column(): void
    {
        $target = Location::factory()->create(['state' => 'CA']);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'null_state' => '1',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $this->assertNull($target->fresh()->state);
    }

    public function test_company_id_is_applied_only_when_fmcs_is_on(): void
    {
        $this->settings->enableMultipleFullCompanySupport();
        $company = Company::factory()->create();
        $target = Location::factory()->create(['company_id' => null]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'company_id' => $company->id,
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $this->assertSame($company->id, $target->fresh()->company_id);
    }

    public function test_company_id_is_ignored_when_fmcs_is_off(): void
    {
        $this->settings->disableMultipleFullCompanySupport();
        $company = Company::factory()->create();
        $target = Location::factory()->create(['company_id' => null]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'company_id' => $company->id,
                'currency' => 'USD',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $fresh = $target->fresh();
        $this->assertNull($fresh->company_id);
        $this->assertSame('USD', $fresh->currency);
    }

    public function test_blank_fields_are_skipped_so_other_columns_survive(): void
    {
        // Operator only wants to change the currency. Every other field
        // on the row must survive the bulk write untouched.
        $existingManager = User::factory()->create();
        $target = Location::factory()->create([
            'currency' => 'USD',
            'country' => 'US',
            'manager_id' => $existingManager->id,
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'currency' => 'GBP',
                'country' => '',
                'manager_id' => '',
                'parent_id' => '',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $fresh = $target->fresh();
        $this->assertSame('GBP', $fresh->currency);
        $this->assertSame('US', $fresh->country);
        $this->assertSame($existingManager->id, $fresh->manager_id);
    }

    public function test_all_blank_fields_returns_warning_and_updates_nothing(): void
    {
        $target = Location::factory()->create(['currency' => 'USD']);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'currency' => '',
                'country' => '',
                'manager_id' => '',
                'parent_id' => '',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('warning');

        $this->assertSame('USD', $target->fresh()->currency);
    }

    public function test_non_superuser_cannot_bulk_reassign_company_even_within_their_own_memberships(): void
    {
        // Bulk company reassignment is superuser-only under FMCS. A
        // company-scoped user with multi-membership can still reassign
        // via the single-location edit path, but bulk has amplified
        // blast radius and the more defensive default applies here.
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $editor = User::factory()->editLocations()->forCompany($companyA)->create();
        $editor->companies()->sync([$companyA->id, $companyB->id]);

        $target = Location::factory()->create(['company_id' => $companyA->id]);

        $this->actingAs($editor)
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'company_id' => $companyB->id,
                'currency' => 'EUR',
            ])
            ->assertRedirect(route('locations.index'));

        $fresh = $target->fresh();
        $this->assertSame($companyA->id, $fresh->company_id, 'Non-superuser cannot bulk-reassign company_id, even to a company they belong to.');
        $this->assertSame('EUR', $fresh->currency, 'Other fields still apply after the company_id is filtered out.');
    }

    public function test_non_superuser_cannot_null_company_in_bulk_when_fmcs_is_on(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();

        $editor = User::factory()->editLocations()->forCompany($companyA)->create();
        $editor->companies()->sync([$companyA->id]);

        $target = Location::factory()->create(['company_id' => $companyA->id]);

        $this->actingAs($editor)
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'null_company_id' => '1',
                'currency' => 'EUR',
            ])
            ->assertRedirect(route('locations.index'));

        $fresh = $target->fresh();
        $this->assertSame($companyA->id, $fresh->company_id, 'Non-superuser null_company_id checkbox must be a no-op.');
        $this->assertSame('EUR', $fresh->currency);
    }

    public function test_superuser_can_reassign_company_in_bulk_when_fmcs_is_on(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $target = Location::factory()->create(['company_id' => $companyA->id]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'company_id' => $companyB->id,
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $this->assertSame($companyB->id, $target->fresh()->company_id);
    }

    public function test_scope_locations_fmcs_skips_company_id_on_rows_with_cross_company_users(): void
    {
        // Under FMCS + location scoping, reassigning a location's
        // company to a company that doesn't match items or users at
        // that location would create visibility mismatches. The bulk
        // path skips company_id per row instead of failing the whole
        // batch, so other fields on that row still apply and a warning
        // flash tells the operator how many rows were skipped.
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $clean = Location::factory()->create(['company_id' => $companyA->id]);

        // conflicted: has a user pinned at that location whose company
        // pivot is Company A. Moving the location to Company B would
        // leave the user stranded at a location whose tenant they
        // can't receive from under strict FMCS.
        $conflicted = Location::factory()->create(['company_id' => $companyA->id]);
        $userAtConflicted = User::factory()->forCompany($companyA)->create(['location_id' => $conflicted->id]);
        $userAtConflicted->companies()->sync([$companyA->id]);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$clean->id, $conflicted->id],
                'company_id' => $companyB->id,
                'currency' => 'JPY',
            ])
            ->assertRedirect(route('locations.index'));

        $this->assertSame($companyB->id, $clean->fresh()->company_id);
        $this->assertSame('JPY', $clean->fresh()->currency);
        $this->assertSame($companyA->id, $conflicted->fresh()->company_id);
        $this->assertSame('JPY', $conflicted->fresh()->currency);

        $response->assertSessionHas('success');
        $response->assertSessionHas('warning');
    }

    public function test_parent_id_is_skipped_when_new_parent_belongs_to_a_different_company(): void
    {
        // FMCS on. Location A is in Company X; picking a Company Y
        // parent would violate the child.company == parent.company
        // invariant that single-edit enforces. Bulk skips parent_id
        // for that row and applies other fields normally.
        $this->settings->enableMultipleFullCompanySupport();

        $companyX = Company::factory()->create();
        $companyY = Company::factory()->create();

        $mismatchedParent = Location::factory()->create(['company_id' => $companyY->id]);
        $target = Location::factory()->create(['company_id' => $companyX->id, 'parent_id' => null]);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'parent_id' => $mismatchedParent->id,
                'currency' => 'USD',
            ])
            ->assertRedirect(route('locations.index'));

        $fresh = $target->fresh();
        $this->assertNull($fresh->parent_id, 'parent_id must be skipped when it would leave the child in a different company than its parent.');
        $this->assertSame('USD', $fresh->currency, 'Other fields still apply.');

        $response->assertSessionHas('warning');
    }

    public function test_company_id_is_skipped_when_existing_parent_would_be_in_different_company(): void
    {
        // FMCS on. Location has an existing parent in Company X.
        // Operator changes company_id to Company Y but leaves parent_id
        // untouched. That would violate the invariant, so company_id
        // is the skip (respect the existing hierarchy).
        $this->settings->enableMultipleFullCompanySupport();

        $companyX = Company::factory()->create();
        $companyY = Company::factory()->create();

        $existingParent = Location::factory()->create(['company_id' => $companyX->id]);
        $target = Location::factory()->create(['company_id' => $companyX->id, 'parent_id' => $existingParent->id]);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'company_id' => $companyY->id,
                'currency' => 'USD',
            ])
            ->assertRedirect(route('locations.index'));

        $fresh = $target->fresh();
        $this->assertSame($companyX->id, $fresh->company_id, 'company_id must be skipped when the existing parent is in a different company.');
        $this->assertSame($existingParent->id, $fresh->parent_id);
        $this->assertSame('USD', $fresh->currency);

        $response->assertSessionHas('warning');
    }

    public function test_parent_and_company_together_are_allowed_when_they_match(): void
    {
        // FMCS on. Operator submits both parent_id and company_id and
        // they line up. No mismatch, no skip.
        $this->settings->enableMultipleFullCompanySupport();

        $companyY = Company::factory()->create();
        $newParent = Location::factory()->create(['company_id' => $companyY->id]);
        $target = Location::factory()->create(['company_id' => Company::factory()->create()->id, 'parent_id' => null]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'parent_id' => $newParent->id,
                'company_id' => $companyY->id,
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success')
            ->assertSessionMissing('warning');

        $fresh = $target->fresh();
        $this->assertSame($companyY->id, $fresh->company_id);
        $this->assertSame($newParent->id, $fresh->parent_id);
    }

    public function test_scope_locations_fmcs_reports_all_skipped_when_every_row_has_cross_company_users(): void
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $target = Location::factory()->create(['company_id' => $companyA->id]);
        $user = User::factory()->forCompany($companyA)->create(['location_id' => $target->id]);
        $user->companies()->sync([$companyA->id]);

        // Only company_id was requested. Every row's company_id gets
        // skipped, so no updates apply anywhere and the operator sees
        // the "no locations were reassigned" warning instead of the
        // generic "no fields changed" one.
        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'company_id' => $companyB->id,
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('warning')
            ->assertSessionMissing('success');

        $this->assertSame($companyA->id, $target->fresh()->company_id);
    }

    public function test_scoped_editor_cannot_bulk_edit_a_location_outside_their_scope(): void
    {
        // With scope_locations_fmcs on, the CompanyableScope hides
        // out-of-tenant locations from Location::whereIn(), so a POST
        // that names one silently drops it from the update batch.
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $editor = User::factory()->editLocations()->forCompany($companyA)->create();
        $editor->companies()->sync([$companyA->id]);

        $ownLocation = Location::factory()->create(['company_id' => $companyA->id, 'currency' => 'USD']);
        $otherTenantLocation = Location::factory()->create(['company_id' => $companyB->id, 'currency' => 'USD']);

        $this->actingAs($editor)
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$ownLocation->id, $otherTenantLocation->id],
                'currency' => 'JPY',
            ])
            ->assertRedirect(route('locations.index'));

        $this->assertSame('JPY', $ownLocation->fresh()->currency);
        $this->assertSame('USD', $otherTenantLocation->fresh()->currency, 'Location outside editor scope must not be touched.');
    }

    public function test_null_parent_id_checkbox_clears_the_parent_column(): void
    {
        $existingParent = Location::factory()->create();
        $target = Location::factory()->create(['parent_id' => $existingParent->id]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'null_parent_id' => '1',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $this->assertNull($target->fresh()->parent_id);
    }

    public function test_null_manager_id_checkbox_clears_the_manager_column(): void
    {
        $existingManager = User::factory()->create();
        $target = Location::factory()->create(['manager_id' => $existingManager->id]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'null_manager_id' => '1',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $this->assertNull($target->fresh()->manager_id);
    }

    public function test_null_currency_and_null_country_checkboxes_clear_those_columns(): void
    {
        $target = Location::factory()->create(['currency' => 'USD', 'country' => 'US']);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'null_currency' => '1',
                'null_country' => '1',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $fresh = $target->fresh();
        $this->assertNull($fresh->currency);
        $this->assertNull($fresh->country);
    }

    public function test_null_checkbox_wins_over_a_populated_field_value(): void
    {
        // Operator picked a manager AND also checked the null_manager_id
        // box. Clear intent wins over the picked value so the row ends
        // up null. Matches the users bulk-edit precedence.
        $picked = User::factory()->create();
        $existing = User::factory()->create();
        $target = Location::factory()->create(['manager_id' => $existing->id]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'manager_id' => $picked->id,
                'null_manager_id' => '1',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $this->assertNull($target->fresh()->manager_id);
    }

    public function test_null_company_id_is_ignored_when_fmcs_is_off(): void
    {
        // Consistent with the value-set path: company_id fields on the
        // bulk-edit form are silently dropped when FMCS is off, so the
        // matching null checkbox must also be a no-op.
        $this->settings->disableMultipleFullCompanySupport();
        $existingCompany = Company::factory()->create();
        $target = Location::factory()->create(['company_id' => $existingCompany->id]);

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$target->id],
                'null_company_id' => '1',
                'currency' => 'EUR',
            ])
            ->assertRedirect(route('locations.index'))
            ->assertSessionHas('success');

        $fresh = $target->fresh();
        $this->assertSame($existingCompany->id, $fresh->company_id);
        $this->assertSame('EUR', $fresh->currency);
    }

    public function test_scoped_editor_cannot_set_parent_id_to_a_location_outside_their_scope(): void
    {
        $this->settings->enableScopedLocationsWithFullMultipleCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $editor = User::factory()->editLocations()->forCompany($companyA)->create();
        $editor->companies()->sync([$companyA->id]);

        $ownLocation = Location::factory()->create(['company_id' => $companyA->id, 'parent_id' => null]);
        $otherTenantParent = Location::factory()->create(['company_id' => $companyB->id]);

        $this->actingAs($editor)
            ->post(route('locations.bulkedit.store'), [
                'ids' => [$ownLocation->id],
                'parent_id' => $otherTenantParent->id,
                'currency' => 'CAD',
            ])
            ->assertRedirect(route('locations.index'));

        $fresh = $ownLocation->fresh();
        $this->assertNull($fresh->parent_id, 'Cross-tenant parent_id must be dropped.');
        $this->assertSame('CAD', $fresh->currency, 'Other fields still apply after the parent_id is filtered out.');
    }
}
