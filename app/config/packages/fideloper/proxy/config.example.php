<?php
return array(

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | Set an array of trusted proxies, so Laravel knows to grab the client's
    | information via the X-Forwarded-* headers.
    |
    | To trust all proxies, use the value '*':
    |
    | 'proxies' => '*'
    |
    |
    | To trust only specific proxies (recommended), set an array of those
    | proxies' IP addresses:
    |
    | 'proxies' => array('192.168.1.1', '192.168.1.2')
    |
    |
    | Or use CIDR notation:
    |
    | 'proxies' => array('192.168.12.0/23')
    |
    */

    'proxies' => '*',

);
