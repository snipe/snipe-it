<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    |
    | URL for the LDAP server. This should start with ldap://, for example:
    | ldap://ldap.yourserver.com
    |
    */
    'url' => "",


    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | Username to use to connect authenticate to LDAP, for example:
    | cn=read-only-admin,dc=example,dc=com
    |
    */
	'username' => "",

	/*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    |
    | Password to use when authenticating to LDAP.
    |
    */
	'password' => "",

	/*
    |--------------------------------------------------------------------------
    | Basedn
    |--------------------------------------------------------------------------
    |
    | The base where the search for users will be executed, for example:
    | dc=example,dc=com
    |
    */
	'basedn'   => "",


	/*
    |--------------------------------------------------------------------------
    | Filter
    |--------------------------------------------------------------------------
    |
    | The search filter for the LDAP query. This probably does not have to be
    | changed.
    |
    */
	'filter' => "&(cn=*)",


	/*
    |--------------------------------------------------------------------------
    | LDAP field names that will be retrieved to create a user.
    |
    | Using the username as an example:
    | If I set 'result.username' => 'my-org-username', the code will connect to
    | LDAP as follows (where $results[$i] represents a row in the LDAP query:
    | $username-to-insert-in-snipe-it = $results[$i]["my-org-username"][0]
    |
    | Note: all these fields are required.
    |--------------------------------------------------------------------------
    |
    | The search filter for the LDAP query.
    |
    */
    'result.username' => "",
    'result.last.name'  => "",
    'result.first.name' => "",

    /*
    | These fields are optional as not all LDAP directories will have it.  If yours
    | does not have them, just leave these blank and the extra check will
    | be omitted.
    */
    'result.active.flag' => "",
    'result.emp.num'  => "",
    'result.email' => "",

    /*
    |--------------------------------------------------------------------------
    | LDAP filter query for authentication
    |--------------------------------------------------------------------------
    |
    | The LDAP query that we want to execute when authenticating a user. This
    | should not have to be changed.
    |
    */
    'authentication.filter.query' => "uid=",

    /*
    |--------------------------------------------------------------------------
    | LDAP Version
    |--------------------------------------------------------------------------
    |
    | Version of LDAP you are using.
    |
    */
    'version' => 3,


);
