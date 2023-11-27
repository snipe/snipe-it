<?php

namespace Tests\Unit;

use App\Models\Ldap;
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
}
