<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
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
    const LDAP_BOOLEAN_SETTINGS = [
        'ldap_enabled',
        'ldap_server_cert_ignore',
        'ldap_tls',
        'ldap_tls',
        'ldap_pw_sync',
        'is_ad',
        'ad_append_domain',
    ];

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
     * Initialize LDAP from user settings
     *
     * @since 5.0.0
     */
    public function init() {

        // This try/catch is dumb, but is necessary to run initial migrations, since
        // this service provider is booted even during migrations. :( - snipe
        try {
            $this->ldapSettings = $this->getSnipeItLdapSettings();
            if ($this->isLdapEnabled()) {
                $this->setSnipeItConfig();
            }
        } catch (\Exception $e) {
            \Log::debug($e);
            $this->ldapSettings = null;
        }

    }

    /**
     * Merge the default Adlap config with the SnipeIT config.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
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
     *
     * @return \Illuminate\Support\Collection
     */
    private function getSnipeItLdapSettings(): Collection
    {
        $ldapSettings = collect();
        if(Setting::first()) { // during early migration steps, there may be no settings table entry to start with
            $ldapSettings = Setting::getLdapSettings()
                ->map(function ($item, $key) {
                    // Trim the items
                    if (is_string($item)) {
                        $item = trim($item);
                    }
                    // Get the boolean value of the LDAP setting, makes it easier to work with them
                    if (in_array($key, self::LDAP_BOOLEAN_SETTINGS)) {
                        return boolval($item);
                    }

                    // Decrypt the admin password
                    if ('ldap_pword' === $key && !empty($item)) {
                        try {
                            return decrypt($item);
                        } catch (Exception $e) {
                            throw new Exception('Your app key has changed! Could not decrypt LDAP password using your current app key, so LDAP authentication has been disabled. Login with a local account, update the LDAP password and re-enable it in Admin > Settings.');
                        }
                    }

                    if ($item && 'ldap_server' === $key) {
                        return collect(parse_url($item));
                    }

                    return $item;
                });
        }
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
            'schema'           => $this->getSchema(), // FIXME - we probably ought not to be using this, right?
            'account_prefix'   => '',
            'account_suffix'   => '',
            'port'             => $this->getPort(),
            'follow_referrals' => false,
            'use_ssl'          => $this->isSsl(),
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
    private function getSchema(): string //wait, what? This is a little weird, since we have completely separate variables for this; we probably shoulnd't be using any 'schema' at all
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
        $port = $this->getLdapServerData('port');
        if ($port && is_int($port)) {
            return $port;
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
    private function isSsl(): bool
    {
        $scheme = $this->getLdapServerData('scheme');
        if ($scheme && 'ldaps' === strtolower($scheme)) {
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
        /* if ($this->ldapSettings['is_ad']) {
            return collect(explode(',', $this->ldapSettings['ad_domain']))->map(function ($item) {
                return trim($item);
            })->toArray();
        } */ // <- this was the *original* intent of the PR for AdLdap2, but we've been moving away from having
             // two separate fields - one for "ldap_host" and one for "ad_domain" - towards just using "ldap_host"
             // ad_domain for us just means "append this domain to your usernames for login, if you click that checkbox"
             // that's all, nothing more (I hope).

        $url = $this->getLdapServerData('host');
        return $url ? [$url] : [];
    }

    /**
     * Get ldap enabled setting
     *
     * @author Steffen Buehl <sb@sbuehl.com>
     *
     * @since 5.0.0
     *
     * @return bool
     */
    public function isLdapEnabled(): bool
    {
        return $this->ldapSettings && $this->ldapSettings->get('ldap_enabled');
    }

    /**
     * Get parsed ldap server information
     *
     * @author Steffen Buehl <sb@sbuehl.com>
     *
     * @since 5.0.0
     *
     * @param $key
     * @return mixed|null
     */
    protected function getLdapServerData($key)
    {
        if ($this->ldapSettings) {
            $ldapServer = $this->ldapSettings->get('ldap_server');
            if ($ldapServer && $ldapServer instanceof Collection) {
                return $ldapServer->get($key);
            }
        }

        return null;
    }
}
