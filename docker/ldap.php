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
    'url' => isset($_ENV['LDAP_URL']) ? $_ENV['LDAP_URL'] : "",


    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | Username to use to connect authenticate to LDAP, for example:
    | cn=read-only-admin,dc=example,dc=com
    |
    */
	'username' => isset($_ENV['LDAP_USERNAME']) ? $_ENV['LDAP_USERNAME'] : "",

	/*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    |
    | Password to use when authenticating to LDAP.
    |
    */
	'password' => isset($_ENV['LDAP_PASSWORD']) ? $_ENV['LDAP_PASSWORD'] : "",

	/*
    |--------------------------------------------------------------------------
    | Basedn
    |--------------------------------------------------------------------------
    |
    | The base where the search for users will be executed, for example:
    | dc=example,dc=com
    |
    */
	'basedn' => isset($_ENV['LDAP_BASEDN']) ? $_ENV['LDAP_BASEDN'] : "",


	/*
    |--------------------------------------------------------------------------
    | Filter
    |--------------------------------------------------------------------------
    |
    | The search filter for the LDAP query. This probably does not have to be
    | changed.
    |
    */
	'filter' => isset($_ENV['LDAP_FILTER']) ? $_ENV['LDAP_FILTER'] : "&(cn=*)",


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
    'result.username' => isset($_ENV['LDAP_RESULT_USERNAME']) ? $_ENV['LDAP_RESULT_USERNAME'] : "",
    'result.last.name' => isset($_ENV['LDAP_RESULT_LAST_NAME']) ? $_ENV['LDAP_RESULT_LAST_NAME'] : "",
    'result.first.name' => isset($_ENV['LDAP_RESULT_FIRST_NAME']) ? $_ENV['LDAP_RESULT_FIRST_NAME'] : "",

    /*
    | These fields are optional as not all LDAP directories will have it.  If yours
    | does not have them, just leave these blank and the extra check will
    | be omitted.
    */
    'result.active.flag' => isset($_ENV['LDAP_RESULT_ACTIVE_FLAG']) ? $_ENV['LDAP_RESULT_ACTIVE_FLAG'] : "",
    'result.emp.num' => isset($_ENV['LDAP_RESULT_EMP_NUM']) ? $_ENV['LDAP_RESULT_EMP_NUM'] : "",
    'result.email' => isset($_ENV['LDAP_RESULT_EMAIL']) ? $_ENV['LDAP_RESULT_EMAIL'] : "",

    /*
    |--------------------------------------------------------------------------
    | LDAP filter query for authentication
    |--------------------------------------------------------------------------
    |
    | The LDAP query that we want to execute when authenticating a user. This
    | should not have to be changed.
    |
    */
    'authentication.filter.query' => isset($_ENV['LDAP_AUTHENTICATION_FILTER_QUERY']) ? $_ENV['LDAP_AUTHENTICATION_FILTER_QUERY'] : "uid=",

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
