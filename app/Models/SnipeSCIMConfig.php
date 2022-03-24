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
        $config['class'] = SCIMUser::class;

        unset($config['mapping']['example:name:space']);

        $core = 'urn:ietf:params:scim:schemas:core:2.0:User:';
        $mappings =& $config['mapping']['urn:ietf:params:scim:schemas:core:2.0:User']; //grab this entire key, we don't want to be repeating ourselves

        //username - *REQUIRED*
        $config['validations'][$core.'userName'] = 'required';
        $mappings['userName'] = AttributeMapping::eloquent('username');

        //human name - *FIRST NAME REQUIRED*
        $config['validations'][$core.'name.givenName'] = 'required';
        $config['validations'][$core.'name.familyName'] = 'string'; //not required

        $mappings['name']['familyName'] = AttributeMapping::eloquent("last_name");
        $mappings['name']['givenName'] = AttributeMapping::eloquent("first_name");
        $mappings['name']['formatted'] = null;
        $mappings['name']['displayName'] = AttributeMapping::constant("n/a")->ignoreWrite(); // TODO - another weird one here
        //active
        $config['validations'][$core.'active'] = 'boolean';

        $mappings['active'] = AttributeMapping::eloquent('activated');//blah blah blah (maybe we can just say 'boolean' and be done with it?)

        //phone
        $config['validations'][$core.'phoneNumbers'] = 'nullable|array';
        $config['validations'][$core.'phoneNumbers.*.value'] = 'required';

        $mappings['phoneNumbers'] = [[
            "value" => AttributeMapping::eloquent("phone"),
            "display" => null,
            "type" => AttributeMapping::constant("work")->ignoreWrite(),
            "primary" => AttributeMapping::constant(true)->ignoreWrite()
        ]];

        //address
        $config['validations'][$core.'addresses'] = 'nullable|array';
        $config['validations'][$core.'addresses.*.streetAddress'] = 'required';
        $config['validations'][$core.'addresses.*.locality'] = 'string';
        $config['validations'][$core.'addresses.*.region'] = 'string';
        $config['validations'][$core.'addresses.*.postalCode'] = 'string';
        $config['validations'][$core.'addresses.*.country'] = 'string';

        $mappings['addresses'] = [[
            'type' => AttributeMapping::constant("other")->ignoreWrite(),
            'formatted' => AttributeMapping::constant("n/a")->ignoreWrite(), // TODO - is this right? This doesn't look right.
            'streetAddress' => AttributeMapping::eloquent("address"),
            'locality' => AttributeMapping::eloquent("city"),
            'region' => AttributeMapping::eloquent("state"),
            'postalCode' => AttributeMapping::eloquent("zip"),
            'country' => AttributeMapping::eloquent("country"),
            'primary' => AttributeMapping::constant(true)->ignoreWrite() //this isn't in the example?
        ]];

        //title
        $config['validations'][$core.'title'] = 'string';
        $mappings['title'] = AttributeMapping::eloquent('jobtitle');

        /* 
          more snipe-it attributes I'd like to check out (to map to 'enterprise' maybe?):
          (namespace) "urn:ietf:params:scim:schemas:extension:enterprise:2.0:User"
         - website
         - manager_id ? manager (how to handle?!)
         - employee_num ? employeeNumber
         - notes?
         - remote???
         - location_id ?
         - department_id ? department
         - company_id to "organization?"
        */

        //finally, write our temp $mappings back to $config['mappings']
        //$config['mapping']['urn:ietf:params:scim:schemas:core:2.0:User'] = $mappings; //FIXME - try references?

        // \Log::error("Config is: ".print_r($config,true));
        return $config;
    }

}
