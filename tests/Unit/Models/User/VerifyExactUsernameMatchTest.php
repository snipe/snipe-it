<?php

namespace Tests\Unit\Models\User;

use App\Models\User;
use Tests\TestCase;

/**
 * Coverage for User::verifyExactUsernameMatch, the SSO/federated-auth ATO
 * guard against DB collation folding. The MySQL/MariaDB default collation
 * utf8mb4_unicode_ci treats snipeitreport3 and snípeitreport3 as equal, so
 * `WHERE username = ?` can return the wrong row for an attacker-controlled
 * external identifier. The helper re-checks the resolved user's username
 * against the caller-provided identifier every federated auth callsite
 * (SAML, LDAP, REMOTE_USER, Google OAuth) runs before trusting the row.
 * Comparison is case-insensitive (both sides lowercased) because most IdPs
 * treat usernames case-insensitively and locking admins out on case-only
 * mismatches was a real support burden. Everything else (accents, whitespace,
 * unicode lookalikes) is still rejected. These tests instantiate the User
 * model without touching the DB because the helper is a pure function on the
 * resolved row plus the expected string.
 *
 * Original vulnerability report: whale120 (@whale120_tw), DEVCORE Internship
 * Program.
 */
class VerifyExactUsernameMatchTest extends TestCase
{
    public function test_null_user_returns_null()
    {
        $this->assertNull(User::verifyExactUsernameMatch(null, 'anything'));
    }

    public function test_null_user_returns_null_even_when_expected_is_empty()
    {
        $this->assertNull(User::verifyExactUsernameMatch(null, ''));
    }

    public function test_exact_byte_match_returns_the_user()
    {
        $user = new User(['username' => 'snipeitreport3']);

        $this->assertSame($user, User::verifyExactUsernameMatch($user, 'snipeitreport3'));
    }

    /**
     * The literal customer-report scenario: MySQL's utf8mb4_unicode_ci returns
     * the snipeitreport3 row when the query is snípeitreport3 (accented i).
     * The helper must reject that row so SAML/LDAP/etc. cannot log in as it.
     */
    public function test_accented_variant_is_rejected()
    {
        $user = new User(['username' => 'snipeitreport3']);

        $this->assertNull(User::verifyExactUsernameMatch($user, 'snípeitreport3'));
    }

    /**
     * Deliberate compromise: most IdPs treat usernames case-insensitively,
     * and admins were locking themselves out when the case in their IdP
     * didn't match the case in their Snipe-IT user row. The helper now
     * lowercases both sides before comparing, so `Admin` and `ADMIN` from
     * a SAML/LDAP assertion resolve to the local `admin` row. Accent-,
     * whitespace-, and lookalike-character folding are still rejected
     * because those aren't handled by strtolower.
     */
    public function test_case_variant_matches()
    {
        $user = new User(['username' => 'admin']);

        $this->assertSame($user, User::verifyExactUsernameMatch($user, 'Admin'));
    }

    public function test_uppercase_variant_matches()
    {
        $user = new User(['username' => 'admin']);

        $this->assertSame($user, User::verifyExactUsernameMatch($user, 'ADMIN'));
    }

    /**
     * Trailing/leading whitespace is a known family of collation-adjacent
     * traps (PADSPACE semantics for CHAR columns, though users.username is
     * VARCHAR); pin the behavior here so a future refactor can't drop into
     * a trim()-based comparison and reintroduce a folding side channel.
     */
    public function test_trailing_whitespace_variant_is_rejected()
    {
        $user = new User(['username' => 'snipeitreport3']);

        $this->assertNull(User::verifyExactUsernameMatch($user, 'snipeitreport3 '));
    }

    public function test_leading_whitespace_variant_is_rejected()
    {
        $user = new User(['username' => 'snipeitreport3']);

        $this->assertNull(User::verifyExactUsernameMatch($user, ' snipeitreport3'));
    }

    public function test_different_length_variant_is_rejected()
    {
        $user = new User(['username' => 'admin']);

        $this->assertNull(User::verifyExactUsernameMatch($user, 'administrator'));
    }

    public function test_prefix_variant_is_rejected()
    {
        $user = new User(['username' => 'administrator']);

        $this->assertNull(User::verifyExactUsernameMatch($user, 'admin'));
    }

    public function test_empty_expected_string_against_stored_username_is_rejected()
    {
        $user = new User(['username' => 'admin']);

        $this->assertNull(User::verifyExactUsernameMatch($user, ''));
    }

    public function test_empty_stored_username_against_empty_expected_returns_the_user()
    {
        // Not a realistic identity but the helper must not throw on empty
        // strings; hash_equals accepts them as long as both sides match.
        $user = new User(['username' => '']);

        $this->assertSame($user, User::verifyExactUsernameMatch($user, ''));
    }

    public function test_null_stored_username_is_rejected()
    {
        // users.username is nullable in the schema. Cast to string inside the
        // helper coerces null to '' before comparing, so a stored null must
        // never match any non-empty external identifier.
        $user = new User(['username' => null]);

        $this->assertNull(User::verifyExactUsernameMatch($user, 'anything'));
    }

    /**
     * Cyrillic а (U+0430) is a common lookalike for Latin a (U+0061). Some
     * collation configurations fold Cyrillic to Latin for confusable-detection
     * purposes; the byte-exact guard must reject regardless.
     */
    public function test_cyrillic_lookalike_variant_is_rejected()
    {
        $user = new User(['username' => 'admin']);

        // First 'а' is Cyrillic U+0430, not Latin U+0061.
        $this->assertNull(User::verifyExactUsernameMatch($user, 'аdmin'));
    }
}
