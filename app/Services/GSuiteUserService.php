<?php

namespace App\Services;

use Carbon\Carbon;
use Google_Client;
use Google_IO_Exception;
use Google_Service_Directory;
use Google_Service_Directory_User;
use Google_Service_Directory_UserName;
use Google_Service_Exception;

class GSuiteUserService
{
    const USERLIMIT = 20;
    protected $name;
    protected $joinedOn;
    protected $designation;
    protected $users;

    public function __construct()
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject(env('GOOGLE_SERVICE_ACCOUNT_IMPERSONATE'));
        $client->addScope([
            Google_Service_Directory::ADMIN_DIRECTORY_USER,
            Google_Service_Directory::ADMIN_DIRECTORY_USER_READONLY,
        ]);
        $this->service = new Google_Service_Directory($client);
    }

    public function fetch($email)
    {
        $this->setUsers([$this->service->users->get($email)]);
    }

    public function fetchAll()
    {
        $optParams = [
            'domain' => env('GOOGLE_CLIENT_HD'),
        ];
        $users = $this->service->users->listUsers($optParams)->getUsers();
        $this->setUsers($users);
    }

    public function create($name, $email, $password, $params = array())
    {
        $user = new Google_Service_Directory_User;
        $userName = new Google_Service_Directory_UserName;

        $userName->setGivenName($name['firstName']);
        $userName->setFamilyName($name['lastName']);
        $user->setName($userName);

        $user->setPrimaryEmail($email);
        // Need to use a better hash function than MD5. Also, there should be a place
        // where this hash type is stored. Can be a CONST.
        $user->setHashFunction('MD5');
        $user->setPassword(hash('md5', $password));
        $user->setChangePasswordAtNextLogin(true);

        if (isset($params['designation'])) {
            $user->setOrganizations([
                [
                    'title' => $params['designation'],
                ],
            ]);
        }

        try {
            $gsuiteUser = $this->service->users->insert($user);
            $this->setName($gsuiteUser->getName()->fullName);
            $this->setJoinedOn(Carbon::parse($gsuiteUser->getCreationTime())->format(config('constants.date_format')));
            if (isset($params['designation'])) {
                $this->setDesignation($params['designation']);
            }
        } catch (Google_IO_Exception $gioe) {
            echo "Error in connection: " . $gioe->getMessage();
        } catch (Google_Service_Exception $gse) {
            echo $gse->getMessage();
        }
    }

    public function setJoinedOn($joinedOn)
    {
        $this->joinedOn = $joinedOn;
    }

    public function getJoinedOn()
    {
        return $this->joinedOn;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

    public function getDesignation()
    {
        return $this->designation;
    }

    public function setUsers(array $users)
    {
        $this->users = $users;
    }

    public function getUsers()
    {
        return $this->users;
    }
}