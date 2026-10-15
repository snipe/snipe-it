<?php

namespace Tests\Unit;

use App\Models\Department;
use App\Models\Group;
use App\Models\Ldap;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Group as PhpUnitGroup;
use Tests\TestCase;

/**
 * FD/#19206 regression coverage. Ldap::createUserFromLdap runs when a
 * user logs in via LDAP for the first time and no local User row
 * exists yet. Before this coverage landed the method only wrote
 * first_name / last_name / username / email / locale and skipped the
 * default permissions group, so first-login users came up short on
 * their mapped fields and unassigned to the configured Default
 * Permissions Group even though bulk `snipe-it:ldap-sync` set both.
 */
#[PhpUnitGroup('ldap')]
class LdapCreateUserFromLdapTest extends TestCase
{
    /**
     * Full synthetic LDAP payload keyed on the same attribute names the
     * setting mappings in configureLdapMappings() point at. Overrides
     * let a single test case flip one field without redeclaring the
     * whole payload.
     */
    private function ldapAttributes(array $overrides = []): array
    {
        return array_merge([
            'samaccountname' => ['jsmith'],
            'sn' => ['Smith'],
            'givenname' => ['Jane'],
            'displayname' => ['Jane Smith'],
            'mail' => ['jane@example.com'],
            'employeenumber' => ['E1234'],
            'telephonenumber' => ['555-0100'],
            'mobile' => ['555-0200'],
            'title' => ['Widget Wrangler'],
            'streetaddress' => ['1 Main St'],
            'l' => ['Springfield'],
            'st' => ['IL'],
            'postalcode' => ['62704'],
            'c' => ['US'],
            'department' => ['Widgets'],
            'physicaldeliveryofficename' => ['HQ'],
        ], $overrides);
    }

    private function configureLdapMappings(): void
    {
        $this->settings->enableLdap();
        $this->settings->set([
            'ldap_username_field' => 'samaccountname',
            'ldap_lname_field' => 'sn',
            'ldap_fname_field' => 'givenname',
            'ldap_display_name' => 'displayname',
            'ldap_email' => 'mail',
            'ldap_emp_num' => 'employeenumber',
            'ldap_phone_field' => 'telephonenumber',
            'ldap_mobile' => 'mobile',
            'ldap_jobtitle' => 'title',
            'ldap_address' => 'streetaddress',
            'ldap_city' => 'l',
            'ldap_state' => 'st',
            'ldap_zip' => 'postalcode',
            'ldap_country' => 'c',
            'ldap_dept' => 'department',
            'ldap_location' => 'physicaldeliveryofficename',
        ]);
    }

    public function test_populates_every_configured_scalar_field(): void
    {
        $this->configureLdapMappings();

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'pw');

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('jsmith', $user->username);
        $this->assertSame('Jane', $user->first_name);
        $this->assertSame('Smith', $user->last_name);
        $this->assertSame('Jane Smith', $user->display_name);
        $this->assertSame('jane@example.com', $user->email);
        $this->assertSame('E1234', $user->employee_num);
        $this->assertSame('555-0100', $user->phone);
        $this->assertSame('555-0200', $user->mobile);
        $this->assertSame('Widget Wrangler', $user->jobtitle);
        $this->assertSame('1 Main St', $user->address);
        $this->assertSame('Springfield', $user->city);
        $this->assertSame('IL', $user->state);
        $this->assertSame('62704', $user->zip);
        $this->assertSame('US', $user->country);
        $this->assertSame(1, (int) $user->activated);
        $this->assertSame(1, (int) $user->ldap_import);
    }

    public function test_creates_department_from_ldap_value(): void
    {
        $this->configureLdapMappings();

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'pw');

        $this->assertNotNull($user->department_id);
        $this->assertSame('Widgets', Department::find($user->department_id)->name);
    }

    public function test_reuses_existing_department_by_name(): void
    {
        $this->configureLdapMappings();
        $existing = Department::factory()->create(['name' => 'Widgets']);

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'pw');

        $this->assertSame($existing->id, $user->department_id);
    }

    public function test_creates_location_from_ldap_value(): void
    {
        $this->configureLdapMappings();

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'pw');

        $this->assertNotNull($user->location_id);
        $this->assertSame('HQ', Location::find($user->location_id)->name);
    }

    public function test_reuses_existing_location_by_name(): void
    {
        $this->configureLdapMappings();
        $existing = Location::factory()->create(['name' => 'HQ']);

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'pw');

        $this->assertSame($existing->id, $user->location_id);
    }

    public function test_skips_field_when_setting_mapping_is_blank(): void
    {
        $this->configureLdapMappings();
        $this->settings->set(['ldap_phone_field' => '']);

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'pw');

        $this->assertNull($user->phone);
    }

    public function test_skips_department_when_ldap_dept_mapping_blank(): void
    {
        $this->configureLdapMappings();
        $this->settings->set(['ldap_dept' => '']);

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'pw');

        $this->assertNull($user->department_id);
        $this->assertDatabaseMissing('departments', ['name' => 'Widgets']);
    }

    public function test_skips_department_when_ldap_value_is_missing(): void
    {
        $this->configureLdapMappings();
        // Mapping IS configured, but the LDAP payload for this user
        // simply doesn't carry the department attribute. A blank
        // "Department" row is worse than no row.
        $user = Ldap::createUserFromLdap(
            $this->ldapAttributes(['department' => []]),
            'pw',
        );

        $this->assertNull($user->department_id);
        $this->assertDatabaseMissing('departments', ['name' => '']);
    }

    public function test_attaches_default_permissions_group(): void
    {
        $this->configureLdapMappings();
        $group = Group::factory()->create();
        $this->settings->set(['ldap_default_group' => $group->id]);

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'pw');

        $this->assertTrue($user->groups()->where('group_id', $group->id)->exists());
    }

    public function test_does_not_attach_default_permissions_group_when_group_deleted(): void
    {
        $this->configureLdapMappings();
        $this->settings->set(['ldap_default_group' => 99999]);

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'pw');

        $this->assertSame(0, $user->groups()->count());
    }

    public function test_returns_false_when_ldap_username_missing(): void
    {
        $this->configureLdapMappings();

        $this->assertFalse(
            Ldap::createUserFromLdap($this->ldapAttributes(['samaccountname' => []]), 'pw'),
        );
    }

    public function test_sets_bcrypted_password_when_ldap_pw_sync_enabled(): void
    {
        $this->configureLdapMappings();
        $this->settings->set(['ldap_pw_sync' => 1]);

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'secret-password');

        $this->assertTrue(Hash::check('secret-password', $user->password));
    }

    public function test_password_is_unusable_when_ldap_pw_sync_disabled(): void
    {
        $this->configureLdapMappings();
        $this->settings->set(['ldap_pw_sync' => 0]);

        $user = Ldap::createUserFromLdap($this->ldapAttributes(), 'secret-password');

        $this->assertFalse(Hash::check('secret-password', $user->password));
    }
}
