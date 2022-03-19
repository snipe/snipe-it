<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Helper;
use ArieTimmerman\Laravel\SCIMServer\SCIM\Schema;
use ArieTimmerman\Laravel\SCIMServer\Attribute\AttributeMapping;


class SnipeSCIMConfig extends \ArieTimmerman\Laravel\SCIMServer\SCIMConfig
{
    public function getUserConfig()
    {
        $config = parent::getUserConfig();

        // Much of this is copied verbatim from the library, then adjusted for our needs
        $config['class'] = User::class;
        unset($config['mapping']['example:name:space']);
        $config['mapping']['urn:ietf:params:scim:schemas:core:2.0:User']['userName'] = AttributeMapping::eloquent("username");
        $config['mapping']['urn:ietf:params:scim:schemas:core:2.0:User']['formatted'] = null; // Snipe-IT only has first_name, last_name, not "name" or "fullname"
        $config['mapping']['urn:ietf:params:scim:schemas:core:2.0:User']['familyName'] = AttributeMapping::eloquent("last_name");
        $config['mapping']['urn:ietf:params:scim:schemas:core:2.0:User']['givenName'] = AttributeMapping::eloquent("first_name");

        return $config;
    }

}
