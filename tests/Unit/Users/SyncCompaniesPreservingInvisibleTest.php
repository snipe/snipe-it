<?php

namespace Tests\Unit\Users;

use App\Models\Company;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Regression coverage for GH #19569: a scoped editor's user save
 * silently detached the target from every FMCS tenant the editor was
 * not a member of, because the update path did a full-replacement
 * sync on the editor's submitted list without folding the target's
 * invisible-to-editor memberships back in.
 */
class SyncCompaniesPreservingInvisibleTest extends TestCase
{
    #[Test]
    public function scoped_editor_save_preserves_target_memberships_editor_cannot_see(): void
    {
        // Editor is a member of Company A only; target belongs to
        // A + B + C + D. On save, the form only offered A so the
        // submission is [A]. Without the merge, sync would strip
        // B / C / D.
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB, $companyC, $companyD] = Company::factory()->count(4)->create();

        $editor = User::factory()->create();
        $editor->companies()->sync([$companyA->id]);

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id, $companyB->id, $companyC->id, $companyD->id]);

        $target->syncCompaniesPreservingInvisibleTo($editor, [$companyA->id]);

        $this->assertEqualsCanonicalizing(
            [$companyA->id, $companyB->id, $companyC->id, $companyD->id],
            $target->companies()->pluck('companies.id')->all(),
        );
    }

    #[Test]
    public function fmcs_off_bypasses_the_merge_and_does_a_straight_sync(): void
    {
        // FMCS is off, so every user can see every company. There's
        // no invisible-to-editor set to preserve, and the editor's
        // submission must land exactly as submitted even if the
        // editor's own pivot is empty.
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $editor = User::factory()->create();
        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id]);

        $target->syncCompaniesPreservingInvisibleTo($editor, [$companyB->id]);

        $this->assertSame([$companyB->id], $target->companies()->pluck('companies.id')->all());
    }

    #[Test]
    public function superuser_editor_gets_full_replacement_semantics(): void
    {
        [$companyA, $companyB, $companyC] = Company::factory()->count(3)->create();

        $editor = User::factory()->superuser()->create();
        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id, $companyB->id, $companyC->id]);

        $target->syncCompaniesPreservingInvisibleTo($editor, [$companyA->id]);

        $this->assertSame([$companyA->id], $target->companies()->pluck('companies.id')->all());
    }

    #[Test]
    public function editor_can_still_remove_a_company_they_are_a_member_of_from_target(): void
    {
        // Editor is in A + B, target in A + B + C. Editor drops B
        // from the picker and saves ([A]). Expected: pivot is [A, C].
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB, $companyC] = Company::factory()->count(3)->create();

        $editor = User::factory()->create();
        $editor->companies()->sync([$companyA->id, $companyB->id]);

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id, $companyB->id, $companyC->id]);

        $target->syncCompaniesPreservingInvisibleTo($editor, [$companyA->id]);

        $this->assertEqualsCanonicalizing(
            [$companyA->id, $companyC->id],
            $target->companies()->pluck('companies.id')->all(),
        );
    }

    #[Test]
    public function editor_cannot_smuggle_a_company_they_are_not_a_member_of(): void
    {
        // Editor is in A. Target is in A + B. Editor's form submits
        // [A, C] where C is a company the editor is not a member of.
        // C must be dropped; B must be preserved.
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB, $companyC] = Company::factory()->count(3)->create();

        $editor = User::factory()->create();
        $editor->companies()->sync([$companyA->id]);

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id, $companyB->id]);

        $target->syncCompaniesPreservingInvisibleTo($editor, [$companyA->id, $companyC->id]);

        $this->assertEqualsCanonicalizing(
            [$companyA->id, $companyB->id],
            $target->companies()->pluck('companies.id')->all(),
        );
    }

    #[Test]
    public function scoped_editor_acting_as_user_preserves_invisible_memberships_from_pivot_read(): void
    {
        // Regression for the second hit on GH #19569 (swift2512). The
        // earlier tests passed because they didn't set the acting
        // user, so Company's CompanyableScope short-circuited on the
        // no-auth branch and both editor + target reads through
        // Eloquent came back unscoped. In the controller path the
        // editor IS the acting user, so the scope filters Company
        // rows to the editor's own pivot before whereNotIn runs,
        // and the "invisible-to-editor" preservation set collapses
        // to empty. Reads must go through the pivot table directly.
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB, $companyC, $companyD, $companyE] = Company::factory()->count(5)->create();

        $editor = User::factory()->create();
        $editor->companies()->sync([$companyA->id, $companyB->id]);

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id, $companyC->id, $companyD->id, $companyE->id]);

        // Act AS the editor so the CompanyableScope on Company is
        // active. The old implementation lost target's [C, D, E]
        // memberships here.
        $this->actingAs($editor);

        // Submission mirrors swift's scenario: no changes, so the
        // form re-submits whatever the editor was able to see for
        // the target (Company A only, since scope filters everything
        // else out on the edit form's pre-populate query).
        $target->syncCompaniesPreservingInvisibleTo($editor, [$companyA->id]);

        // Assert directly against the pivot so the still-acting-as
        // editor doesn't pull the read back through
        // CompanyableScope and mask what the pivot actually holds.
        $pivotRows = \DB::table('company_user')
            ->where('user_id', $target->id)
            ->pluck('company_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $this->assertEqualsCanonicalizing(
            [$companyA->id, $companyC->id, $companyD->id, $companyE->id],
            $pivotRows,
        );
    }

    #[Test]
    public function editor_submitting_child_company_of_their_own_parent_lands_in_the_child_not_empty(): void
    {
        // Regression for GHSA-35hv-26vj-9445. Before the fix, the
        // editor's "visible" set was computed from direct pivot rows
        // only, while every upstream gate (parent_within_scope, the
        // SaveUserRequest floater gate, getIdsForCurrentUser) accepts
        // child-company ids as reachable. A scoped editor in [Parent]
        // could submit [Child], pass all gates, then this helper would
        // filter Child out as "invisible" and the sync would leave the
        // target with no company pivot at all. Under
        // null_company_is_floater that promoted the account to
        // system-wide floater (cross-tenant read + takeover). The fix
        // expands the editor-visible set to direct + their children,
        // matching the gates.
        $this->settings->enableMultipleFullCompanySupport();

        $parent = Company::factory()->create();
        $child = Company::factory()->create(['parent_id' => $parent->id]);

        $editor = User::factory()->create();
        $editor->companies()->sync([$parent->id]);

        $target = User::factory()->create();
        $target->companies()->sync([$parent->id]);

        $target->syncCompaniesPreservingInvisibleTo($editor, [$child->id]);

        $pivotRows = \DB::table('company_user')
            ->where('user_id', $target->id)
            ->pluck('company_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $this->assertSame(
            [$child->id],
            $pivotRows,
            'A scoped editor assigning a target to a child of their own parent must leave the target in that child, not with an empty pivot (which would promote the account to a cross-tenant floater under null_company_is_floater).'
        );
    }

    #[Test]
    public function editor_moving_target_back_from_child_to_parent_lands_in_the_parent_not_both(): void
    {
        // Mirror of the attack test on the legitimate path. Editor is
        // in [Parent], target is in [Child], editor submits [Parent].
        // Expected: pivot = [Parent]. The invisible-preserved set must
        // NOT re-insert Child, because the editor can see Child
        // (direct + children) and the submission dropped it.
        $this->settings->enableMultipleFullCompanySupport();

        $parent = Company::factory()->create();
        $child = Company::factory()->create(['parent_id' => $parent->id]);

        $editor = User::factory()->create();
        $editor->companies()->sync([$parent->id]);

        $target = User::factory()->create();
        $target->companies()->sync([$child->id]);

        $target->syncCompaniesPreservingInvisibleTo($editor, [$parent->id]);

        $pivotRows = \DB::table('company_user')
            ->where('user_id', $target->id)
            ->pluck('company_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $this->assertSame([$parent->id], $pivotRows);
    }

    #[Test]
    public function invisible_memberships_outside_parent_subtree_are_still_preserved(): void
    {
        // Belt-and-suspenders for #19569. The parent + children
        // expansion must NOT accidentally re-include companies that
        // are outside the editor's parent subtree. Editor is in
        // [Parent], target is in [Child, OutsideCompany], editor
        // submits [Parent]. Expected: final pivot = [Parent,
        // OutsideCompany]. Child is dropped because the editor can see
        // it and left it out of the submission. OutsideCompany is
        // preserved because the editor cannot see it.
        $this->settings->enableMultipleFullCompanySupport();

        $parent = Company::factory()->create();
        $child = Company::factory()->create(['parent_id' => $parent->id]);
        $outside = Company::factory()->create();

        $editor = User::factory()->create();
        $editor->companies()->sync([$parent->id]);

        $target = User::factory()->create();
        $target->companies()->sync([$child->id, $outside->id]);

        $target->syncCompaniesPreservingInvisibleTo($editor, [$parent->id]);

        $pivotRows = \DB::table('company_user')
            ->where('user_id', $target->id)
            ->pluck('company_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $this->assertEqualsCanonicalizing([$parent->id, $outside->id], $pivotRows);
    }

    #[Test]
    public function empty_submission_still_preserves_invisible_memberships(): void
    {
        // Editor is in A, target in A + B. Editor unchecks A and
        // saves ([]). Target pivot should end up [B].
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $editor = User::factory()->create();
        $editor->companies()->sync([$companyA->id]);

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id, $companyB->id]);

        $target->syncCompaniesPreservingInvisibleTo($editor, []);

        $this->assertSame([$companyB->id], $target->companies()->pluck('companies.id')->all());
    }
}
