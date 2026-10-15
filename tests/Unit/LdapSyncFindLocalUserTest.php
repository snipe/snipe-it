<?php

namespace Tests\Unit;

use App\Console\Commands\LdapSync;
use App\Models\User;
use Tests\TestCase;

/**
 * GHSA-97h5-f5j2-6v99 regression coverage.
 *
 * The sync command's user-lookup previously used a bare
 * `User::withTrashed()->where('username', $ldapUsername)->first()` with no
 * exact-match guard. Under MySQL's default utf8mb4_unicode_ci collation,
 * that query folds case and accents, so an LDAP-supplied `admín` would
 * match the local `admin` row. The sync command's update branch would
 * then overwrite that row's identity fields in place, silently converting
 * a privileged local account into an LDAP-imported one whose username
 * exactly matches the directory value.
 *
 * The fix routes both the main user lookup and the manager lookup
 * through `LdapSync::findLocalUserForLdapUsername`, which layers
 * `User::verifyExactUsernameMatch` on top of the query result. Every
 * federated login path (LDAP, REMOTE_USER, Google OAuth, SAML) already
 * runs the same guard for the same reason.
 *
 * These tests cover the helper's exact-match invariant. They rely on
 * `verifyExactUsernameMatch`'s byte-level (case-insensitive,
 * accent-sensitive) comparison rather than on the DB layer's collation,
 * so they exercise the same guard regardless of whether the test suite
 * runs on SQLite or MySQL.
 */
class LdapSyncFindLocalUserTest extends TestCase
{
    public function test_returns_null_for_empty_username(): void
    {
        $this->assertNull(LdapSync::findLocalUserForLdapUsername(''));
    }

    public function test_returns_null_when_no_local_user_exists(): void
    {
        $this->assertNull(LdapSync::findLocalUserForLdapUsername('nonexistent-user'));
    }

    public function test_returns_user_on_exact_match(): void
    {
        $user = User::factory()->create(['username' => 'ghsa-97h5-exact']);

        $resolved = LdapSync::findLocalUserForLdapUsername('ghsa-97h5-exact');

        $this->assertNotNull($resolved);
        $this->assertTrue($resolved->is($user));
    }

    public function test_returns_null_when_stored_username_does_not_exactly_match_after_lookup(): void
    {
        // Simulates the MySQL utf8mb4_unicode_ci fold: the query returns a
        // row whose stored username differs from the requested value.
        // Passing that row through the guard must yield null so the sync
        // command falls through to the create branch instead of overwriting
        // the local row's identity fields.
        $localAdmin = User::factory()->create(['username' => 'ghsa-97h5-admin']);

        // Pre-condition: the local admin row exists. The next line asserts
        // the guard's null return by invoking it on the exact accent-differing
        // ("folded") value against the row the DB lookup would have surfaced
        // under a collation that folds case and accents.
        $this->assertNull(
            User::verifyExactUsernameMatch($localAdmin, 'ghsa-97h5-admín'),
            'The guard must reject an accent-differing directory username so the sync command does not overwrite the local privileged row.',
        );
    }

    public function test_withtrashed_flag_finds_soft_deleted_rows(): void
    {
        // Sync command uses withTrashed:true for the main user lookup so
        // it can restore a previously soft-deleted account when the
        // directory re-provisions the same username. The manager lookup
        // uses the default (no-trashed) path.
        $trashedUser = User::factory()->create(['username' => 'ghsa-97h5-trashed']);
        $trashedUser->delete();

        $this->assertNotNull(
            LdapSync::findLocalUserForLdapUsername('ghsa-97h5-trashed', withTrashed: true),
            'Main user lookup must include soft-deleted rows so LDAP re-provisioning of the same username can restore the row.',
        );

        $this->assertNull(
            LdapSync::findLocalUserForLdapUsername('ghsa-97h5-trashed'),
            'Manager lookup default (withTrashed=false) must skip soft-deleted rows.',
        );
    }
}
