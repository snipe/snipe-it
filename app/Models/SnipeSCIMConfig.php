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

        $config['map_unmapped'] = false; // anything we don't explicitly map will _not_ show up.

        $core_namespace = 'urn:ietf:params:scim:schemas:core:2.0:User';
        $core = $core_namespace.':'; 
        $mappings =& $config['mapping'][$core_namespace]; //grab this entire key, we don't want to be repeating ourselves

        //username - *REQUIRED*
        $config['validations'][$core.'userName'] = 'required';
        $mappings['userName'] = AttributeMapping::eloquent('username');

        //human name - *FIRST NAME REQUIRED*
        $config['validations'][$core.'name.givenName'] = 'required';
        $config['validations'][$core.'name.familyName'] = 'string'; //not required

        $mappings['name']['familyName'] = AttributeMapping::eloquent("last_name");
        $mappings['name']['givenName'] = AttributeMapping::eloquent("first_name");
        $mappings['name']['formatted'] = (new AttributeMapping())->ignoreWrite()->setRead(
            function (&$object) {
                return $object->getFullNameAttribute();
            } 
        );

        $config['validations'][$core.'emails'] = 'nullable|array';         // emails are not required in Snipe-IT...
        $config['validations'][$core.'emails.*.value'] = 'email'; // ...(had to remove the recommended 'required' here)

        $mappings['emails'] = [[
            "value" => AttributeMapping::eloquent("email"),
            "display" => null,
            "type" => AttributeMapping::constant("work")->ignoreWrite(),
            "primary" => AttributeMapping::constant(true)->ignoreWrite()
        ]];

        //active
        $config['validations'][$core.'active'] = 'boolean';

        $mappings['active'] = AttributeMapping::eloquent('activated');

        //phone
        $config['validations'][$core.'phoneNumbers'] = 'nullable|array';
        $config['validations'][$core.'phoneNumbers.*.value'] = 'string'; // another one where want to say 'we don't _need_ a phone number, but if you have one it better have a value.

        $mappings['phoneNumbers'] = [[
            "value" => AttributeMapping::eloquent("phone"),
            "display" => null,
            "type" => AttributeMapping::constant("work")->ignoreWrite(),
            "primary" => AttributeMapping::constant(true)->ignoreWrite()
        ]];

        //address
        $config['validations'][$core.'addresses'] = 'nullable|array';
        $config['validations'][$core.'addresses.*.streetAddress'] = 'string';
        $config['validations'][$core.'addresses.*.locality'] = 'string';
        $config['validations'][$core.'addresses.*.region'] = 'nullable|string';
        $config['validations'][$core.'addresses.*.postalCode'] = 'nullable|string';
        $config['validations'][$core.'addresses.*.country'] = 'string';

        $mappings['addresses'] = [[
            'type' => AttributeMapping::constant("work")->ignoreWrite(),
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

        //Preferred Language
        $config['validations'][$core.'preferredLanguage'] = 'string';
        $mappings['preferredLanguage'] = AttributeMapping::eloquent('locale');

        /* 
          more snipe-it attributes I'd like to check out (to map to 'enterprise' maybe?):
         - website
         - notes?
         - remote???
         - location_id ?
         - company_id to "organization?"
        */

        $enterprise_namespace = 'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User';
        $ent = $enterprise_namespace.':';

        // we remove the 'example' namespace and add the Enterprise one
        $config['mapping']['schemas'] = AttributeMapping::constant( [$core_namespace, $enterprise_namespace] )->ignoreWrite();

        $config['validations'][$ent.'employeeNumber'] = 'string';
        $config['validations'][$ent.'department'] = 'string';
        $config['validations'][$ent.'manager'] = 'nullable';
        $config['validations'][$ent.'manager.value'] = 'string';

        $config['mapping'][$enterprise_namespace] = [
            'employeeNumber' => AttributeMapping::eloquent('employee_num'),
            'department' =>(new AttributeMapping())->setAdd( // FIXME parent?
                function ($value, &$object) {
                    $department = Department::where("name", $value)->first();
                    if ($department) {
                        $object->department_id = $department->id;
                    }
                }
                )->setReplace(
                    function ($value, &$object) {
                        $department = Department::where("name", $value)->first();
                        if ($department) {
                            $object->department_id = $department->id;
                        }
                    }
                )->setRead(
                    function (&$object) {
                        return $object->department ? $object->department->name : null;
                    } 
                ),
            'manager' => [
                // FIXME - manager writes are disabled. This kinda works but it leaks errors all over the place. Not cool.
                // '$ref' => (new AttributeMapping())->ignoreWrite()->ignoreRead(),
                // 'displayName' => (new AttributeMapping())->ignoreWrite()->ignoreRead(),
                // NOTE: you could probably do a 'plain' Eloquent mapping here, but we don't for future-proofing
                'value' => (new AttributeMapping())->setAdd(
                    function ($value, &$object) {
                        $manager = User::find($value);
                        if ($manager) {
                            $object->manager_id = $manager->id;
                        }
                    }
                    )->setReplace(
                        function ($value, &$object) {
                            $manager = User::find($value);
                            if ($manager) {
                                $object->manager_id = $manager->id;
                            }
                        }
                    )->setRead(
                        function (&$object) {
                            return $object->manager_id;
                        } 
                    ),
            ]
        ];

        return $config;
    }

}
