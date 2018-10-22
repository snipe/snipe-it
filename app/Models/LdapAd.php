<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use Adldap\Adldap;
use App\Traits\UserTrait;
use Adldap\Query\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Adldap\Models\User as AdldapUser;
use Adldap\Models\ModelNotFoundException;

/**
 * LDAP queries.
 *
 * @author Wes Hulette <jwhulette@gmail.com>
 *
 * @since 5.0.0
 */
class LdapAd extends LdapAdConfiguration
{
    use UserTrait;

    /**
     * @see https://wdmsb.wordpress.com/2014/12/03/descriptions-of-active-directory-useraccountcontrol-value/
     */
    const AD_USER_ACCOUNT_CONTROL_FLAGS = ['512', '544', '66048', '66080', '262656', '262688', '328192', '328224'];

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
     * __construct.
     */
    public function __construct()
    {
        parent::__construct();

        $this->ldap = new Adldap();
        $this->ldap->addProvider($this->ldapConfig);
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
        try {
            $this->ldap->auth()->attempt($username, $password);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Unable to validate user credentials!');
        }

        // Should we sync the logged in user
        if ($this->getLdapSyncStatus($record)) {
            try {
                Log::debug('Attempting to find user in LDAP directory');
                $record = $this->ldap->search()->findBy($this->ldapSettings['ldap_username_field'], $username);
            } catch (ModelNotFoundException $e) {
                Log::error($e->getMessage());
                throw new Exception('Unable to find user in LDAP directory!');
            }

            $this->syncUserLdapLogin($record, $password);
        } else {
            $user = User::where('username', $username)
                ->whereNull('deleted_at')->where('ldap_import', '=', 1)
                ->where('activated', '=', '1')->first();
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
    public function processUser(AdldapUser $user, ?Collection $defaultLocation = null, ?Collection $mappedLocations = null): ?User
    {
        // Only sync active users
        if ($this->getLdapSyncStatus($user)) {
            $snipeUser = [];
            $snipeUser['username']        = $user->{$this->ldapSettings['ldap_username_field']}[0] ?? '';
            $snipeUser['employee_number'] = $user->{$this->ldapSettings['ldap_emp_num']}[0] ?? '';
            $snipeUser['lastname']        = $user->{$this->ldapSettings['ldap_lname_field']}[0] ?? '';
            $snipeUser['firstname']       = $user->{$this->ldapSettings['ldap_fname_field']}[0] ?? '';
            $snipeUser['email']           = $user->{$this->ldapSettings['ldap_email']}[0] ?? '';
            $snipeUser['location_id']     = $this->getLocationId($user, $defaultLocation, $mappedLocations);
            $snipeUser['activated']       = $this->getActiveStatus($user);

            return $this->setUserModel($snipeUser);
        }

        // We are not syncing user info
        return null;
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
        $user->password     = $user->password ?? $this->generateEncyrptedPassword();
        $user->first_name   = trim($userInfo['firstname']);
        $user->last_name    = trim($userInfo['lastname']);
        $user->email        = trim($userInfo['email']);
        $user->employee_num = trim($userInfo['employee_number']);
        $user->activated    = $userInfo['activated'];
        $user->location_id  = $userInfo['location_id'];
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
            LOG::debug('Syncing users password with LDAP directory.');
            $user->password = bcrypt($password);
        }

        if (!$user->save()) {
            LOG::debug('Could not save user. '.$user->getErrors());
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
    private function getLdapSyncStatus(AdldapUser $user): bool
    {
        return (false === $this->ldapSettings['ldap_active_flag'])
            || ('true' == strtolower($user->{$this->ldapSettings['ldap_active_flag']}[0]));
    }

    /**
     * Set the active status of the user.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @param \Adldap\Models\User $user
     *
     * @return int
     */
    private function getActiveStatus(AdldapUser $user): int
    {
        $activeStatus = 0;
        /*
         * Check to see if we are connected to an AD server
         * if so, check the Active Directory User Account Control Flags
         */
        if ($this->ldapSettings['is_ad']) {
            $activeStatus = (in_array($user->getUserAccountControl(), self::AD_USER_ACCOUNT_CONTROL_FLAGS)) ? 1 : 0;
        } else {
            // If there is no activated flag, assume this is handled via the OU and activate the users
            if (false === $this->ldapSettings['ldap_active_flag']) {
                $activeStatus = 1;
            }
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
     * @param Adldap\Models\User $user
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
                if ($user->inGroup([$value], true)) {
                    return $key;
                }
            });

            if ($location->count() > 0) {
                $locationId = $location->keys()->first();
            }
        }

        return $locationId;
    }

    /**
     * Get the base dn for the query.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 1.0.0
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
        if ('' === $filter) {
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
        return [
            $this->ldapSettings['ldap_username_field'],
            $this->ldapSettings['ldap_fname_field'],
            $this->ldapSettings['ldap_lname_field'],
            $this->ldapSettings['ldap_email'],
            $this->ldapSettings['ldap_emp_num'],
            'memberOf',
            'useraccountcontrol',
        ];
    }

    /**
     * Test the bind user connection.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     */
    public function testLdapAdBindConnection(): void
    {
        try {
            $this->ldap->search()->ous()->get()->count();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            throw new \Exception('Unable to search LDAP directory!');
        }
    }

    /**
     * Test the user can connect to the LDAP server.
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     */
    public function testLdapAdUserConnection(): void
    {
        try {
            $this->ldap->connect();
        } catch (\Adldap\Auth\BindException $e) {
            Log::error($e);
            throw new \Exception('Unable to connect to LDAP directory!');
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
            return $testUsers->map(function ($item, $key) {
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
     * Query the LDAP server to get the users to process and return a page set
     *
     * @author Wes Hulette <jwhulette@gmail.com>
     *
     * @since 5.0.0
     *
     * @param int $page The paged results to get
     *
     * @return \Adldap\Query\Paginator
     */
    public function getLdapUsers(int $page = 0): Paginator
    {
        $search = $this->ldap->search()->users()->in($this->getBaseDn());

        $filter = $this->getFilter();
        if (!is_null($filter)) {
            $search = $search->rawFilter($filter);
        }

        return $search->select($this->getSelectedFields())
            ->paginate(self::PAGE_SIZE, $page);
    }
}
