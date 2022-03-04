<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Helper;
use ArieTimmerman\Laravel\SCIMServer\SCIM\Schema;
use ArieTimmerman\Laravel\SCIMServer\Attribute\AttributeMapping;


class SnipeSCIMConfig extends \ArieTimmerman\Laravel\SCIMServer\SCIMConfig
{
    public function __constructor(...$params)
    {
        \Log::info("CONSTRUCTOR CALLED!!@!!!! FOr my config thing");
        self::super(...$params);
    }

    public function getUserConfig()
    {
        // Much of this is copied verbatim from the library, then adjusted for our needs
        return [
                
            // Set to 'null' to make use of auth.providers.users.model (App\User::class)
            'class' => User::class,
            
            'validations' => [
    
                'urn:ietf:params:scim:schemas:core:2.0:User:userName' => 'required',
                'urn:ietf:params:scim:schemas:core:2.0:User:password' => 'nullable',
                'urn:ietf:params:scim:schemas:core:2.0:User:active' => 'boolean',
                'urn:ietf:params:scim:schemas:core:2.0:User:emails' => 'required|array',
                'urn:ietf:params:scim:schemas:core:2.0:User:emails.*.value' => 'required|email',
                'urn:ietf:params:scim:schemas:core:2.0:User:roles' => 'nullable|array',
                'urn:ietf:params:scim:schemas:core:2.0:User:roles.*.value' => 'required',
    
            ],
    
            'singular' => 'User',
            'schema' => [Schema::SCHEMA_USER],
    
            //eager loading
            'withRelations' => [],
            'map_unmapped' => true,
            'unmapped_namespace' => 'urn:ietf:params:scim:schemas:laravel:unmapped',
            'description' => 'User Account',
            
            // Map a SCIM attribute to an attribute of the object.
            'mapping' => [
                
                'id' => AttributeMapping::eloquent("id")->disableWrite(),
                
                'externalId' => null,
                
                'meta' => [
                    'created' => AttributeMapping::eloquent("created_at")->disableWrite(),
                    'lastModified' => AttributeMapping::eloquent("updated_at")->disableWrite(),
                    
                    'location' => (new AttributeMapping())->setRead(
                        function ($object) {
                            return route(
                                'scim.resource',
                                [
                                'resourceType' => 'Users',
                                'resourceObject' => $object->id
                                ]
                            );
                        }
                    )->disableWrite(),
                    
                    'resourceType' => AttributeMapping::constant("User")
                ],
                
                'schemas' => AttributeMapping::constant(
                    [
                    'urn:ietf:params:scim:schemas:core:2.0:User',
                    'example:name:space',
                    ]
                )->ignoreWrite(),
                
                // 'example:name:space' => [ //not really sure here?
                //     'cityPrefix' => AttributeMapping::eloquent('cityPrefix')
                // ],
                
                'urn:ietf:params:scim:schemas:core:2.0:User' => [
                    
                    'userName' => AttributeMapping::eloquent("username"),
                    
                    'name' => [
                        'formatted' => null, // Snipe-IT only has first_name, last_name, not "name" or "fullname"
                        'familyName' => AttributeMapping::eloquent("last_name"),
                        'givenName' => AttributeMapping::eloquent("first_name"),
                        'middleName' => null,
                        'honorificPrefix' => null,
                        'honorificSuffix' => null
                    ],
                    
                    'displayName' => null,
                    'nickName' => null,
                    'profileUrl' => null,
                    'title' => null,
                    'userType' => null,
                    'preferredLanguage' => null, // Section 5.3.5 of [RFC7231]
                    'locale' => null, // see RFC5646
                    'timezone' => null, // see RFC6557
                    'active' => null,
                    
                    'password' => AttributeMapping::eloquent('password')->disableRead(),
                    
                    // Multi-Valued Attributes
                    'emails' => [[
                            "value" => AttributeMapping::eloquent("email"),
                            "display" => null,
                            "type" => AttributeMapping::constant("other")->ignoreWrite(),
                            "primary" => AttributeMapping::constant(true)->ignoreWrite()
                    ],[
                            "value" => AttributeMapping::eloquent("email"),
                            "display" => null,
                            "type" => AttributeMapping::constant("work")->ignoreWrite(),
                            "primary" => AttributeMapping::constant(true)->ignoreWrite()
                    ]],
                    
                    'phoneNumbers' => [[
                        "value" => null,
                        "display" => null,
                        "type" => null,
                        "primary" => null
                    ]],
                    
                    'ims' => [[
                        "value" => null,
                        "display" => null,
                        "type" => null,
                        "primary" => null
                    ]], // Instant messaging addresses for the User
                    
                    'photos' => [[
                        "value" => null,
                        "display" => null,
                        "type" => null,
                        "primary" => null
                    ]],
                    
                    'addresses' => [[
                        'formatted' => null,
                        'streetAddress' => null,
                        'locality' => null,
                        'region' => null,
                        'postalCode' => null,
                        'country' => null
                    ]],
                    
                    'groups' => [[
                        'value' => null,
                        '$ref' => null,
                        'display' => null,
                        'type' => null,
                        'type' => null
                    ]],
                    
                    'entitlements' => null,
                    'roles' => null,
                    'x509Certificates' => null
                ],
                            
            ]
            ];
    }

}
