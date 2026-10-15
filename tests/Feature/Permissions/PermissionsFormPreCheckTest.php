<?php

namespace Tests\Feature\Permissions;

use App\Models\Group;
use App\Models\User;
use Tests\TestCase;

/**
 * Regression coverage for #18830.
 *
 * The Reports permission is stored under the remapped key `reports.view`
 * (see resources/views/partials/forms/edit/permissions-base.blade.php lines
 * 5-13). The three radio inputs (allow / inherit / deny) previously used
 * inconsistent keys when pre-checking themselves on page load: allow read
 * $section_name (correct), but inherit and deny read str_slug($main_section)
 * (wrong for reports — that resolved to `reports`, which never appears in
 * the stored permissions). As a result, setting reports to DENY did not
 * pre-check the deny radio when the form was reopened, and the inherit
 * radio was checked via its "unset" fallback.
 *
 * The fix aligns all three radios on $section_name. These tests exercise
 * both the groups edit page (use_inherit = false) and the users edit page
 * (use_inherit = true) so the fix stays covered across both callsites.
 */
class PermissionsFormPreCheckTest extends TestCase
{
    /**
     * Assert the radio input with the given HTML id is (or is not) checked
     * in the rendered response HTML.
     *
     * Matches on the full <input …> tag containing the id and checks for
     * the `checked` attribute anywhere inside — the partial spreads the
     * attributes across multiple lines and the blade `@checked` directive
     * emits a bare `checked` keyword rather than `checked="checked"`, so a
     * simple substring assertion would be too loose or too tight depending
     * on formatting.
     */
    private function assertRadioChecked(string $html, string $id, bool $expected, string $context): void
    {
        $pattern = '/<input\b[^>]*\bid="'.preg_quote($id, '/').'"[^>]*>/is';
        $found = preg_match($pattern, $html, $matches);
        $this->assertSame(1, $found, "Could not find <input id=\"{$id}\"> in {$context}");

        $isChecked = preg_match('/\bchecked\b/i', $matches[0]) === 1;
        $expected
            ? $this->assertTrue($isChecked, "{$id} should be checked in {$context}")
            : $this->assertFalse($isChecked, "{$id} should NOT be checked in {$context}");
    }

    // -------------------------------------------------------------------
    // Groups edit page (use_inherit = false — only allow/deny rendered).
    // -------------------------------------------------------------------

    public function test_group_edit_pre_checks_deny_when_reports_is_denied()
    {
        $group = Group::factory()->create([
            'permissions' => json_encode(['reports.view' => '-1']),
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('groups.edit', $group))
            ->assertOk()
            ->getContent();

        $this->assertRadioChecked($html, 'reports_deny', true, 'group edit with reports.view = -1');
        $this->assertRadioChecked($html, 'reports_allow', false, 'group edit with reports.view = -1');
    }

    public function test_group_edit_pre_checks_allow_when_reports_is_allowed()
    {
        $group = Group::factory()->create([
            'permissions' => json_encode(['reports.view' => '1']),
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('groups.edit', $group))
            ->assertOk()
            ->getContent();

        $this->assertRadioChecked($html, 'reports_allow', true, 'group edit with reports.view = 1');
        $this->assertRadioChecked($html, 'reports_deny', false, 'group edit with reports.view = 1');
    }

    // -------------------------------------------------------------------
    // Users edit page (use_inherit = true — all three radios rendered).
    // -------------------------------------------------------------------

    public function test_user_edit_pre_checks_deny_when_reports_is_denied()
    {
        $target = User::factory()->create([
            'permissions' => json_encode(['reports.view' => '-1']),
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('users.edit', $target))
            ->assertOk()
            ->getContent();

        $this->assertRadioChecked($html, 'reports_deny', true, 'user edit with reports.view = -1');
        $this->assertRadioChecked($html, 'reports_allow', false, 'user edit with reports.view = -1');
        $this->assertRadioChecked($html, 'reports_inherit', false, 'user edit with reports.view = -1');
    }

    public function test_user_edit_pre_checks_allow_when_reports_is_allowed()
    {
        $target = User::factory()->create([
            'permissions' => json_encode(['reports.view' => '1']),
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('users.edit', $target))
            ->assertOk()
            ->getContent();

        $this->assertRadioChecked($html, 'reports_allow', true, 'user edit with reports.view = 1');
        $this->assertRadioChecked($html, 'reports_deny', false, 'user edit with reports.view = 1');
        $this->assertRadioChecked($html, 'reports_inherit', false, 'user edit with reports.view = 1');
    }

    public function test_user_edit_pre_checks_inherit_when_reports_is_unset()
    {
        // No reports.view key at all — inherit should be the fallback.
        $target = User::factory()->create([
            'permissions' => json_encode([]),
        ]);

        $html = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('users.edit', $target))
            ->assertOk()
            ->getContent();

        $this->assertRadioChecked($html, 'reports_inherit', true, 'user edit with no reports permission set');
        $this->assertRadioChecked($html, 'reports_allow', false, 'user edit with no reports permission set');
        $this->assertRadioChecked($html, 'reports_deny', false, 'user edit with no reports permission set');
    }
}
