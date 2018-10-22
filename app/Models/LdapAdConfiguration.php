<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use Illuminate\Support\Collection;

/**
 * LDAP configuration merge for Adldap2.
 *
 * @see https://github.com/Adldap2/Adldap2
 *
 * @author Wes Hulette <jwhulette@gmail.com>
 *
 * @since 5.0.0
 */
class LdapAdConfiguration
{
    const LDAP_PORT             = 389;
    const CONNECTION_TIMEOUT    = 5;
    const DEFAULT_LDAP_VERSION  = 3;
    const LDAP_BOOLEAN_SETTINGS = ['ldap_enabled', 'ldap_server_cert_ignore', 'ldap_active_flag', 'ldap_tls', 'ldap_tls', 'ldap_pw_sync', 'is_ad'];

    /**
     * Ldap Settings.
     *
     * @var Collection
     */
    public $ldapSettings;

    /**
     * LDAP Config.
     *
     * @var array
     */
    public $ldapConfig;

    /**
     * __construct.
     */
    public function __construct()
    {
        $this->ldapSettings = $this->getSnipeItLdapSettings();
        $this->setSnipeItConfig();
    }

    /**
     * Merge the default Adlap config with the SnipeIT config.
     */
    private function setSnipeItConfig()
    {
        $this->ldapConfig = $this->setLdapConnectionConfiguration();
        $this->certificateCheck();
    }

    /**
     * Get the LDAP settings from the Settings model.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     */
    private function getSnipeItLdapSettings(): Collection
    {
        $settings     = Setting::getSettings();
        $ldapSettings = collect($settings->first()->toArray())
            ->filter(function ($value, $key) {
                // Get the ldap named settings
                return false !== strpos($key, 'ldap_');
            })->merge([
                'is_ad' => $settings->is_ad,
                'ad_domain' => $settings->ad_domain,
            ])->map(function ($item, $key) {
                // trim the items
                if (is_string($item)) {
                    $item = trim($item);
                }
                // Get the boolean value of the LDAP setting, makes it easier to work with them
                if (in_array($key, self::LDAP_BOOLEAN_SETTINGS)) {
                    return boolval($item);
                }
                // Decrypt the admin password
                if ('ldap_pword' === $key) {
                    try {
                        return decrypt($item);
                    } catch (Exception $e) {
                        throw new Exception('Your app key has changed! Could not decrypt LDAP password using your current app key, so LDAP authentication has been disabled. Login with a local account, update the LDAP password and re-enable it in Admin > Settings.');
                    }
                }

                return $item;
            });

        return $ldapSettings;
    }

    /**
     * Set the server certificate environment variable.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     */
    private function certificateCheck(): void
    {
        // If we are ignoring the SSL cert we need to setup the environment variable
        // before we create the connection
        if ($this->ldapSettings['ldap_server_cert_ignore']) {
            putenv('LDAPTLS_REQCERT=never');
        }

        // If the user specifies where CA Certs are, make sure to use them
        if (env('LDAPTLS_CACERT')) {
            putenv('LDAPTLS_CACERT='.env('LDAPTLS_CACERT'));
        }
    }

    /**
     * Set the Adlap2 connection configuration values based on SnipeIT settings.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     * 
     * @return array
     */
    private function setLdapConnectionConfiguration(): array
    {
        // Create the configuration array.
        return [
            // Mandatory Configuration Options
            'hosts'            => $this->getServerUrlBase(),
            'base_dn'          => $this->ldapSettings['ldap_basedn'],
            'username'         => $this->ldapSettings['ldap_uname'],
            'password'         => $this->ldapSettings['ldap_pword'],

            // Optional Configuration Options
            'schema'           => $this->getSchema(),
            'account_prefix'   => '',
            'account_suffix'   => '',
            'port'             => $this->getPort(),
            'follow_referrals' => false,
            'use_ssl'          => $this->getSslUse(),
            'use_tls'          => $this->ldapSettings['ldap_tls'],
            'version'          => $this->ldapSettings['ldap_version'] ?? self::DEFAULT_LDAP_VERSION,
            'timeout'          => self::CONNECTION_TIMEOUT,

            // Custom LDAP Options
            'custom_options'   => [
                // See: http://php.net/ldap_set_option
                // LDAP_OPT_X_TLS_REQUIRE_CERT => LDAP_OPT_X_TLS_HARD,
            ],
        ];
    }

    /**
     * Get the schema to use for the connection.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return string
     */
    private function getSchema(): string
    {
        $schema = \Adldap\Schemas\OpenLDAP::class;
        if ($this->ldapSettings['is_ad']) {
            $schema = \Adldap\Schemas\ActiveDirectory::class;
        }

        return $schema;
    }

    /**
     * Get the port number from the connection url.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return int
     */
    private function getPort(): int
    {
        $ldapUrl = $this->ldapSettings['ldap_server'];
        if ($ldapUrl) {
            $port = parse_url($ldapUrl, PHP_URL_PORT);

            if (is_int($port)) {
                return $port;
            }
        }

        return self::LDAP_PORT;
    }

    /**
     * Get ldap scheme from url to determin ssl use.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return bool
     */
    private function getSslUse(): bool
    {
        if ($this->ldapSettings['ldap_server']) {
            $scheme = explode('://', $this->ldapSettings['ldap_server']);
            if ('ldap' === strtolower($scheme[0])) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * Return the base url to the LDAP server.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return array
     */
    private function getServerUrlBase(): array
    {
        if ($this->ldapSettings['is_ad']) {
            return collect(explode(',', $this->ldapSettings['ad_domain']))->map(function ($item, $key) {
                return trim($item);
            })->toArray();
        }

        $parts = explode('//', $this->ldapSettings['ldap_server']);

        return [
            $parts[1],
        ];
    }
}
