<?php

namespace Tests\Unit;

use App\Models\Ldap;
use Exception;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class LdapTest extends TestCase
{
    use InteractsWithSettings;
    use \phpmock\phpunit\PHPMock;

    public function testConnect()
    {
        $this->settings->enableLdap();

        $ldap_connect = $this->getFunctionMock("App\\Models", "ldap_connect");
        $ldap_connect->expects($this->once())->willReturn('hello');

        $ldap_set_option = $this->getFunctionMock("App\\Models", "ldap_set_option");
        $ldap_set_option->expects($this->exactly(3));


        $blah = Ldap::connectToLdap();
        $this->assertEquals('hello',$blah,"LDAP_connect should return 'hello'");
    }

    // other test cases - with/without client-side certs?
    // with/without LDAP version 3?
    // with/without ignore cert validation?
    // test (and mock) ldap_start_tls() ?

    public function testBindAdmin()
    {
        $this->settings->enableLdap();
        $this->getFunctionMock("App\\Models", "ldap_bind")->expects($this->once())->willReturn(true);
        $this->assertNull(Ldap::bindAdminToLdap("dummy"));
    }

    public function testBindBad()
    {
        $this->settings->enableLdap();
        $this->getFunctionMock("App\\Models", "ldap_bind")->expects($this->once())->willReturn(false);
        $this->getFunctionMock("App\\Models","ldap_error")->expects($this->once())->willReturn("exception");
        $this->expectExceptionMessage("Could not bind to LDAP:");

        $this->assertNull(Ldap::bindAdminToLdap("dummy"));
    }
    // other test cases - test donked password?

    public function testAnonymousBind()
    {
        //todo - would be nice to introspect somehow to make sure the right parameters were passed?
        $this->settings->enableAnonymousLdap();
        $this->getFunctionMock("App\\Models", "ldap_bind")->expects($this->once())->willReturn(true);
        $this->assertNull(Ldap::bindAdminToLdap("dummy"));
    }

    public function testBadAnonymousBind()
    {
        $this->settings->enableAnonymousLdap();
        $this->getFunctionMock("App\\Models", "ldap_bind")->expects($this->once())->willReturn(false);
        $this->getFunctionMock("App\\Models","ldap_error")->expects($this->once())->willReturn("exception");
        $this->expectExceptionMessage("Could not bind to LDAP:");

        $this->assertNull(Ldap::bindAdminToLdap("dummy"));
    }

    public function testBadEncryptedPassword()
    {
        $this->settings->enableBadPasswordLdap();

        $this->expectExceptionMessage("Your app key has changed");
        $this->assertNull(Ldap::bindAdminToLdap("dummy"));
    }

    public function testFindAndBind()
    {
        $this->settings->enableLdap();

        $ldap_connect = $this->getFunctionMock("App\\Models", "ldap_connect");
        $ldap_connect->expects($this->once())->willReturn('hello');

        $ldap_set_option = $this->getFunctionMock("App\\Models", "ldap_set_option");
        $ldap_set_option->expects($this->exactly(3));

        $this->getFunctionMock("App\\Models", "ldap_bind")->expects($this->once())->willReturn(true);

        $this->getFunctionMock("App\\Models", "ldap_search")->expects($this->once())->willReturn(true);

        $this->getFunctionMock("App\\Models", "ldap_first_entry")->expects($this->once())->willReturn(true);

        $this->getFunctionMock("App\\Models", "ldap_get_attributes")->expects($this->once())->willReturn(
            [
                "count" => 1,
                0 => [
                    'sn' => 'Surname',
                    'firstName' => 'FirstName'
                ]
            ]
        );

        $results = Ldap::findAndBindUserLdap("username","password");
        $this->assertEqualsCanonicalizing(["count" =>1,0 =>['sn' => 'Surname','firstname' => 'FirstName']],$results);
    }
}
