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

        $config['map_unmapped'] = false; //not sure if this is helping?


        $core = 'urn:ietf:params:scim:schemas:core:2.0:User:'; //TODO - these paths *still* repeat too often - you can do better :)
        $mappings =& $config['mapping']['urn:ietf:params:scim:schemas:core:2.0:User']; //grab this entire key, we don't want to be repeating ourselves

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
                \Log::error("Weird name.formatted reader firing...");
                return $object->getFullNameAttribute();
            } 
        );
        $mappings['name']['displayName'] = (new AttributeMapping())->ignoreWrite()->ignoreRead(); // AttributeMapping::noMapping(); //AttributeMapping::constant("n/a")->ignoreWrite(); // TODO - another weird one here
        // ^^^^^^^ this 'displayName' is wrong - formatted is what I meant, and displayName is correctly done below...

        //display name (synthetic, ignore writes)
        // temp yanking *THIS* too
        // $mappings['displayName'] = (new AttributeMapping())->ignoreWrite()->setRead(
        //     function (&$object) {
        //         \Log::error("Weird displayName reader firing...");
        //         return $object->getFullNameAttribute();
        //     } 
        // );

        //external ID - what the heck is that? Are these people even *READING* my schema?!
        //temp yanking this?
        // $config['validations'][$core.'externalId'] = 'string'; //UGH. Ignored
        // $mappings['externalId'] = (new AttributeMapping())->ignoreWrite()->setRead(
        //     function (&$object) {
        //         \Log::error("external ID reader firing...");
        //         return $object->username; //uh, I guess?
        //     } 
        // );

        // let's maybe use the defaults from the library, I guess?
        $mappings['emails'] = [[
            "value" => AttributeMapping::eloquent("email"), // ->setSchema(['urn:ietf:params:scim:schemas:core:2.0:User']), // FIXME - if this works it's only because I patched the library! is *this* the thing that's blowing us up?
            "display" => null,
            "type" => AttributeMapping::constant("work")->ignoreWrite(),
            "primary" => AttributeMapping::constant(true)->ignoreWrite()
        ]];

        
        
        //AttributeMapping::noMapping(); //(new AttributeMapping())->ignoreWrite()->ignoreRead(); // AttributeMapping::noMapping(); //AttributeMapping::constant("n/a")->ignoreWrite(); // TODO - another weird one here

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

        $ent = "urn:ietf:params:scim:schemas:extension:enterprise:2.0:User:";

        // we remove the 'example' namespace and add the Enterprise one
        $config['mapping']['schemas'] = AttributeMapping::constant(
            [
            'urn:ietf:params:scim:schemas:core:2.0:User',
            'urn:ietf:params:scim:schemas:extension:enterprise:2.0:User'
            ]
        )->ignoreWrite();

        $config['validations'][$ent.'employeeNumber'] = 'string';
        $config['validations'][$ent.'department'] = 'string'; //I think *this* one is ok? (WEIRD!)
        $config['validations'][$ent.'manager'] = 'nullable';
        $config['validations'][$ent.'manager.value'] = 'string';

        // ALSO fixme, WRONG NAMESPACE!!!!! WEIRD FIXME
        // $mappings['department'] = (new AttributeMapping())->setAdd( // FIXME parent?
        //     function ($value, &$object) {
        //         \Log::error("Department-Add WRONG NAMESPACE: $value");
        //         $department = Department::firstOrCreate(["name" => $value]);
        //         $object->department_id = $department->id;
        //     }
        //     )->setReplace(
        //         function ($value, &$object) {
        //             \Log::error("Department-Replace WRONG NAMESPACE: $value");
        //             $department = Department::firstOrCreate(["name" => $value]);
        //             $object->department_id = $department->id;
        //         }
        //     )->setRead(
        //         function (&$object) {
        //             \Log::error("Weird department reader firing... WRONG NAMESPACE");
        //             return $object->department ? $object->department->name : null;
        //         } 
        //     );
//                          urn:ietf:params:scim:schemas:extension:enterprise:2.0:User //?
        $config['mapping']['urn:ietf:params:scim:schemas:extension:enterprise:2.0:User'] = [
            'employeeNumber' => AttributeMapping::eloquent('employee_num'),
            'department' =>(new AttributeMapping())->setAdd( // FIXME parent?
                function ($value, &$object) {
                    \Log::error("Department-Add: $value");
                    $department = Department::where("name", $value)->first();
                    if ($department) {
                        $object->department_id = $department->id;
                    }
                }
                )->setReplace(
                    function ($value, &$object) {
                        \Log::error("Department-Replace: $value");
                        $department = Department::where("name", $value)->first();
                        if ($department) {
                            $object->department_id = $department->id;
                        }
                    }
                )->setRead(
                    function (&$object) {
                        \Log::error("Weird department reader firing...");
                        return $object->department ? $object->department->name : null;
                    } 
                ),
                // wait should that be manager => { 'value' => ?}
            'manager' => [ 
                'value' => (new AttributeMapping())->setAdd( // FIXME parent?
                function ($value, &$object) {
                    \Log::error("Manager-Add: $value");
                    $manager = User::find($value);
                    if ($manager) {
                        $object->manager_id = $manager->id; //TODO - I might be able to strip this back down to a plain Eloquent relationship?
                    }
                }
                )->setReplace(
                    function ($value, &$object) {
                        \Log::error("Manager-Replace: $value");
                        $manager = User::find($value);
                        if ($manager) {
                            $object->manager_id = $manager->id;
                        }
                    }
                )->setRead(
                    function (&$object) {
                        \Log::error("Weird manager reader firing...");
                        return $object->manager_id;
                    } 
                ),
            ]];

        // \Log::error("Config is: ".print_r($config,true));
        return $config;
    }

}
