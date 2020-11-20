<?php

declare(strict_types=1);

namespace App\Services;

use Adldap\Adldap;
use Adldap\Models\User as AdldapUser;
use Adldap\Query\Paginator;
use Adldap\Schemas\Schema;
use App\Helpers\Helper;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * LDAP queries.
 *
 * @author Wes Hulette <jwhulette@gmail.com>
 *
 * @since 5.0.0
 */
class LdapAd extends LdapAdConfiguration
{
    /* The following is _probably_ the correct logic, but we can't use it because
       some users may have been dependent upon the previous behavior, and this
       could cause additional access to be available to users they don't want
       to allow to log in.
    $useraccountcontrol = $results[$i]['useraccountcontrol'][0];
    if(
        // based on MS docs at: https://support.microsoft.com/en-us/help/305144/how-to-use-useraccountcontrol-to-manipulate-user-account-properties
        ($useraccountcontrol & 0x200) && // is a NORMAL_ACCOUNT
        !($useraccountcontrol & 0x02) && // *and* _not_ ACCOUNTDISABLE
        !($useraccountcontrol & 0x10)    // *and* _not_ LOCKOUT
    ) {
        $user->activated = 1;
    } else {
        $user->activated = 0;
    } */
    const AD_USER_ACCOUNT_CONTROL_FLAGS = [
      '512',    // 0x200    NORMAL_ACCOUNT
      '544',    // 0x220    NORMAL_ACCOUNT, PASSWD_NOTREQD
      '66048',  // 0x10200  NORMAL_ACCOUNT, DONT_EXPIRE_PASSWORD
      '66080',  // 0x10220  NORMAL_ACCOUNT, PASSWD_NOTREQD, DONT_EXPIRE_PASSWORD
      '262656', // 0x40200  NORMAL_ACCOUNT, SMARTCARD_REQUIRED
      '262688', // 0x40220  NORMAL_ACCOUNT, PASSWD_NOTREQD, SMARTCARD_REQUIRED
      '328192', // 0x50200  NORMAL_ACCOUNT, SMARTCARD_REQUIRED, DONT_EXPIRE_PASSWORD
      '328224', // 0x50220  NORMAL_ACCOUNT, PASSWD_NOT_REQD, SMARTCARD_REQUIRED, DONT_EXPIRE_PASSWORD
      '4260352',// 0x410200 NORMAL_ACCOUNT, DONT_EXPIRE_PASSWORD, DONT_REQ_PREAUTH
      '1049088',// 0x100200 NORMAL_ACCOUNT, NOT_DELEGATED
      '1114624',// 0x110200 NORMAL_ACCOUNT, NOT_DELEGATED, DONT_EXPIRE_PASSWORD
    ];

    /**
     * The LDAP results per page.
     */
    const PAGE_SIZE = 500;

    /**
     * A base dn.
     *
     * @var string
     */
    public $baseDn = null;

    /**
     * Adldap instance.
     *
     * @var \Adldap\Adldap
     */
    protected $ldap;

    /**
     * Initialize LDAP from user settings
     *
     * @since 5.0.0
     *
     * @return void
     */
    public function init()
    {
        // Already initialized
        if ($this->ldap) {
            return true;
        }

        parent::init();
        if($this->isLdapEnabled()) {
            if($this->ldapSettings['is_ad'] == 0 ) { //only for NON-AD setups!
                $this->ldapConfig['account_prefix'] = $this->ldapSettings['ldap_auth_filter_query'];
                $this->ldapConfig['account_suffix'] = ','.$this->ldapConfig['base_dn'];
            } /*
            To the point mentioned in ldapLogin(), we might want to add an 'else' clause here that
            sets up an 'account_suffix' of '@'.$this->ldapSettings['ad_domain'] *IF* the user has
            $this->ldapSettings['ad_append_domain'] enabled.
            That code in ldapLogin gets simplified, in exchange for putting all the weirdness here only.
            */
            $this->ldap = new Adldap();
            $this->ldap->addProvider($this->ldapConfig);
            return true;
        }
        return false;
    }

    public function __construct() {
        $this->init();
    }

        /**
     * Create a user if they successfully login to the LDAP server.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @param string $username
     * @param string $password
     *
     * @return \App\Models\User
     *
     * @throws Exception
     */
    public function ldapLogin(string $username, string $password): User
    {
        if ($this->ldapSettings['ad_append_domain']) { //if you're using 'userprincipalname', don't check the ad_append_domain checkbox
            $login_username = $username . '@' . $this->ldapSettings['ad_domain']; // I feel like could can be solved with the 'suffix' feature? Then this would be easier.
        } else {
            $login_username = $username;
        }

        if ($this->ldap->auth()->attempt($login_username, $password, true) === false) {
            throw new Exception('Unable to validate user credentials!');
        }    

        // Should we sync the logged in user
        Log::debug('Attempting to find user in LDAP directory');
        $record = $this->ldap->search()->findBy($this->ldapSettings['ldap_username_field'], $username);

        if($record) {
            if ($this->isLdapSync($record)) {
                $this->syncUserLdapLogin($record, $password);
            }
        }
        else {
            throw new Exception('Unable to find user in LDAP directory!');
        }

        $user = User::where('username', $username)
                ->whereNull('deleted_at')->where('ldap_import', '=', 1)
                ->where('activated', '=', '1')->first();
        /* Above, I could've just done ->firstOrFail() which would've been cleaner, but it would've been miserable to
           troubleshoot if it ever came up (giving a really generic and untraceable error message)
        */
        if (!$user) {
            throw new Exception("User is either deleted, not activated (can't log in), not from LDAP, or can't be found in database");
        }

        return $user;
    }

    /**
     * Set the user information based on the LDAP settings.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @param \Adldap\Models\User $user
     * @param null|Collection     $defaultLocation
     * @param null|Collection     $mappedLocations
     *
     * @return null|\App\Models\User
     */
    public function processUser(AdldapUser $user, ?Collection $defaultLocation=null, ?Collection $mappedLocations=null): ?User
    {
        // Only sync active users <- I think this actually means 'existing', not 'activated/deactivated'
        if(!$user) {
            return null;
        }
        $snipeUser = [];
        $snipeUser['username']        = $user->{$this->ldapSettings['ldap_username_field']}[0] ?? '';
        $snipeUser['employee_number'] = $user->{$this->ldapSettings['ldap_emp_num']}[0] ?? '';
        $snipeUser['lastname']        = $user->{$this->ldapSettings['ldap_lname_field']}[0] ?? '';
        $snipeUser['firstname']       = $user->{$this->ldapSettings['ldap_fname_field']}[0] ?? '';
        $snipeUser['email']           = $user->{$this->ldapSettings['ldap_email']}[0] ?? '';
        $snipeUser['title']           = $user->getTitle() ?? '';
        $snipeUser['telephonenumber'] = $user->getTelephoneNumber() ?? '';

        /*
         * $locationId being 'null' means we have no per-OU location information,
         * but instead of explicitly setting it to null - which would override any admin-generated
         * location assignments - we just don't set it at all. For a brand new User, the 'default null'
         * on the column will cover us. For an already existing user, this will not override any
         * locations that were explicitly chosen by the administrators.
         *
         * When syncing with a particular 'default location' in mind, those should still be respected
         * and it *will* override the administrators previous choices. I think this is a fair compromise.
         */
        $locationId = $this->getLocationId($user, $defaultLocation, $mappedLocations);
        if ($locationId !== null ) {
            $snipeUser['location_id'] = $locationId;
        }

        $activeStatus = $this->getActiveStatus($user);
        if ($activeStatus !== null) {
            $snipeUser['activated'] = $activeStatus;
        }

        return $this->setUserModel($snipeUser);
    }

    /**
     * Set the User model information.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @param array $userInfo The user info to save to the database
     *
     * @return \App\Models\User
     */
    public function setUserModel(array $userInfo): User
    {
        // If the username exists, return the user object, otherwise create a new user object
        $user = User::firstOrNew([
                    'username' => $userInfo['username'],
                ]);
        $user->username     = $user->username ?? trim($userInfo['username']);
        $user->password     = $user->password ?? Helper::generateEncyrptedPassword();
        $user->first_name   = trim($userInfo['firstname']);
        $user->last_name    = trim($userInfo['lastname']);
        $user->email        = trim($userInfo['email']);
        $user->employee_num = trim($userInfo['employee_number']);
        $user->jobtitle     = trim($userInfo['title']);
        $user->phone        = trim($userInfo['telephonenumber']);
        if(array_key_exists('activated',$userInfo)) {
            $user->activated    = $userInfo['activated'];
        } else if ( !$user->exists ) { // no 'activated' flag was set or unset, *AND* this user is new - activate by default.
            $user->activated = 1;
        }
        if(array_key_exists('location_id',$userInfo)) {
            $user->location_id  = $userInfo['location_id'];
        }
        $user->notes        = 'Imported from LDAP';
        $user->ldap_import  = 1;

        return $user;
    }

    /**
     * Sync a user who has logged in by LDAP.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @param \Adldap\Models\User $record
     * @param string              $password
     *
     * @throws Exception
     */
    private function syncUserLdapLogin(AdldapUser $record, string $password): void
    {
        $user = $this->processUser($record);

        if (is_null($user->last_login)) {
            $user->notes = 'Imported on first login from LDAP2';
        }

        if ($this->ldapSettings['ldap_pw_sync']) {
            Log::debug('Syncing users password with LDAP directory.');
            $user->password = bcrypt($password);
        }

        if (!$user->save()) {
            Log::debug('Could not save user. '.$user->getErrors());
            throw new Exception('Could not save user: '.$user->getErrors());
        }
    }

    /**
     * Check to see if we should sync the user with the LDAP directory.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @param \Adldap\Models\User $user
     *
     * @return bool
     */
    private function isLdapSync(AdldapUser $user): bool
    {
        if ( !$this->ldapSettings['ldap_active_flag']) {
            return true; // always sync if you didn't define an 'active' flag
        }
       
        if ( $user->{$this->ldapSettings['ldap_active_flag']} &&                           // if your LDAP user has the aforementioned flag as an attribute *AND* 
             count($user->{$this->ldapSettings['ldap_active_flag']}) == 1 &&               // if that attribute has exactly one value *AND* 
             strtolower($user->{$this->ldapSettings['ldap_active_flag']}[0]) == 'false') { // that value is the string 'false' (regardless of case), 
            return false;                                                                  // then your user is *INACTIVE* - return false
        }
        // otherwise, return true
        return true;
    }

    /**
     * Set the active status of the user.
     * Returns 0 or 1 if the user is deactivated or activated
     * or returns null if we just don't know
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @param \Adldap\Models\User $user
     *
     * @return int (or null)
     */
    private function getActiveStatus(AdldapUser $user): ?int
    {
        /*
         * Check to see if we are connected to an AD server
         * if so, check the Active Directory User Account Control Flags
         * If the admin has set their own 'active flag' - respect that instead
         * (this may work to allow AD users to ignore the built-in UAC stuff that AD does)
         */
        if ($user->hasAttribute($user->getSchema()->userAccountControl()) && !$this->ldapSettings['ldap_active_flag']) {
            \Log::debug('This is AD - userAccountControl is'. $user->getSchema()->userAccountControl());
            $activeStatus = (in_array($user->getUserAccountControl(), self::AD_USER_ACCOUNT_CONTROL_FLAGS)) ? 1 : 0;
        } else {

            // If there is no activated flag, then we can't make any determination about activated/deactivated
            if (false == $this->ldapSettings['ldap_active_flag']) {
                \Log::debug('ldap_active_flag is false - no ldap_active_flag is set');
                return null;
            }

            // If there *is* an activated flag, then respect it *only* if it is actually present. If it's not there, ignore it.
            if (!$user->hasAttribute($this->ldapSettings['ldap_active_flag'])) {
                return null; // 'active' flag is defined, but does not exist on returned user record. So we don't know if they're active or not.
            }

            // if $user has the flag *AND* that flag has exactly one value -
            if ( $user->{$this->ldapSettings['ldap_active_flag']} && count($user->{$this->ldapSettings['ldap_active_flag']}) == 1 ) {

                $active_flag_value = $user->{$this->ldapSettings['ldap_active_flag']}[0];

                // if the value of that flag is case-insensitively the string 'false' or boolean false
                if ( strcasecmp($active_flag_value, "false") == 0 || $active_flag_value === false ) {
                    return 0; // then make them INACTIVE
                } else {
                    return 1; // otherwise active
                }
            }
            return 1; // fail 'open' (active) if we have the attribute and it's multivalued or empty; that's weird
        }

        return $activeStatus;
    }

    /**
     * Get a default selected location, or a OU mapped location if available.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @param \Adldap\Models\User $user
     * @param Collection|null    $defaultLocation
     * @param Collection|null    $mappedLocations
     *
     * @return null|int
     */
    private function getLocationId(AdldapUser $user, ?Collection $defaultLocation, ?Collection $mappedLocations): ?int
    {
        $locationId = null;
        // Set the users default locations, if set
        if ($defaultLocation) {
            $locationId = $defaultLocation->keys()->first();
        }

        // Check to see if the user is in a mapped location
        if ($mappedLocations) {
            $location = $mappedLocations->filter(function ($value, $key) use ($user) {
                //if ($user->inOu($value)) { // <----- *THIS* seems not to be working, and it seems more 'intelligent' - but it's literally just a strpos() call, and it doesn't work quite right against plain strings
                $user_ou = substr($user->getDn(), -strlen($value)); // get the LAST chars of the user's DN, the count of those chars being the length of the thing we're checking against
                if(strcasecmp($user_ou, $value) === 0) { // case *IN*sensitive comparision - some people say OU=blah, some say ou=blah. returns 0 when strings are identical (which is a little odd, yeah)
                    return $key; // WARNING: we are doing a 'filter' - not a regular for-loop. So the answer(s) get "return"ed into the $location array
                }
            });

            if ($location->count() > 0) {
                $locationId = $location->keys()->first(); // from the returned $location array from the ->filter() method above, we return the first match - there should be only one
            }
        }

        return $locationId;
    }

    /**
     * Get the base dn for the query.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return string
     */
    private function getBaseDn(): string
    {
        if (!is_null($this->baseDn)) {
            return $this->baseDn;
        }

        return $this->ldapSettings['ldap_basedn'];
    }

    /**
     * Format the ldap filter if needed.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return null|string
     */
    private function getFilter(): ?string
    {
        $filter = $this->ldapSettings['ldap_filter'];
        if (!$filter) {
            return null;
        }
        // Add surrounding parentheses as needed
        $paren = mb_substr($filter, 0, 1, 'utf-8');
        if ('(' !== $paren) {
            return '('.$filter.')';
        }

        return $filter;
    }

    /**
     * Get the selected fields to return
     *  This should help with memory on large result sets as we are not returning all fields.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return array
     */
    private function getSelectedFields(): array
    {
        /** @var Schema $schema */
        $schema = new $this->ldapConfig['schema'];
        return array_values(array_filter([
            $this->ldapSettings['ldap_username_field'],
            $this->ldapSettings['ldap_fname_field'],
            $this->ldapSettings['ldap_lname_field'],
            $this->ldapSettings['ldap_email'],
            $this->ldapSettings['ldap_emp_num'],
            $this->ldapSettings['ldap_active_flag'],
            $schema->memberOf(),
            $schema->userAccountControl(),
            $schema->title(),
            $schema->telephone(),
        ]));
    }

    /**
     * Test the bind user connection.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     * @throws \Exception
     * @since 5.0.0
     */
    public function testLdapAdBindConnection(): void
    {
        try {
            $this->ldap->search()->ous()->get()->count(); //it's saying this is null?
        } catch (Exception $th) {
            Log::error($th->getMessage());
            throw new Exception('Unable to search LDAP directory!');
        }
    }

    /**
     * Test the user can connect to the LDAP server.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     * @throws \Exception
     * @since 5.0.0
     */
    public function testLdapAdUserConnection(): void
    {
        try {
            $this->ldap->connect();
        } catch (\Adldap\Auth\BindException $e) {
            Log::error($e);
            throw new Exception('Unable to connect to LDAP directory!');
        }
    }

    /**
     * Test the LDAP configuration by returning up to 10 users.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return Collection
     */
    public function testUserImportSync(): Collection
    {
        $testUsers = collect($this->getLdapUsers()->getResults())->chunk(10)->first();
        if ($testUsers) {
            return $testUsers->map(function ($item) {
                return (object) [
                    'username'        => $item->{$this->ldapSettings['ldap_username_field']}[0] ?? null,
                    'employee_number' => $item->{$this->ldapSettings['ldap_emp_num']}[0] ?? null,
                    'lastname'        => $item->{$this->ldapSettings['ldap_lname_field']}[0] ?? null,
                    'firstname'       => $item->{$this->ldapSettings['ldap_fname_field']}[0] ?? null,
                    'email'           => $item->{$this->ldapSettings['ldap_email']}[0] ?? null,
                ];
            });
        }

        return collect();
    }

    /**
     * Query the LDAP server to get the users to process and return a page set.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @return \Adldap\Query\Paginator
     */
    public function getLdapUsers(): Paginator
    {
        $search = $this->ldap->search()->users()->in($this->getBaseDn()); //this looks wrong; we should instead have a passable parameter that does this, and use this as a 'sane' default, yeah?

        $filter = $this->getFilter();
        if (!is_null($filter)) {
            $search = $search->rawFilter($filter);
        }

        return $search->select($this->getSelectedFields())
            ->paginate(self::PAGE_SIZE);
    }
}
