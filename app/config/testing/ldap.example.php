<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    |
    | URL for the LDAP server.
    |
    */
    'url' => "",


    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | Username to use to connect authenticate to LDAP.
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
    | The base where the search for users will be executed.
    |
    */
	'basedn'   => "",


	/*
    |--------------------------------------------------------------------------
    | Filter
    |--------------------------------------------------------------------------
    |
    | The search filter for the LDAP query.
    |
    */
	'filter' => "",


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
    'result.emp.num'  => "",
    'result.last.name'  => "",
    'result.first.name' => "",
    'result.email' => "",

    /*
    | This field is optional as not all LDAP directories will have it.  If yours
    | does not have it, just leave this field blank and the extra check will
    | be omitted.
    */
    'result.active.flag' => "",

    /*
    |--------------------------------------------------------------------------
    | LDAP filter query for authentication
    |--------------------------------------------------------------------------
    |
    | The LDAP query that we want to execute when authenticating a user
    |
    */
    'authentication.filter.query' => "uid=",

    /*
    |--------------------------------------------------------------------------
    | LDAP Version
    |--------------------------------------------------------------------------
    |
    | The LDAP query that we want to execute when authenticating a user
    |
    */
    'ldap_version' => 3,


);
