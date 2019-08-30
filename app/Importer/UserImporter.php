<?php

namespace App\Importer;

use App\Helpers\Helper;
use App\Models\User;
use App\Notifications\WelcomeNotification;

/**
 * This is ONLY used for the User Import. When we are importing users
 * via an Asset/etc import, we use createOrFetchUser() in
 * App\Importer.php. [ALG]
 *
 * Class UserImporter
 * @package App\Importer
 *
 */
class UserImporter extends ItemImporter
{
    protected $users;
    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    protected function handle($row)
    {
        parent::handle($row);
        $this->createUserIfNotExists($row);
    }

    /**
     * Create a user if a duplicate does not exist.
     * @todo Investigate how this should interact with Importer::createOrFetchUser
     *
     * @author Daniel Melzter
     * @since 4.0
     * @param array $row
     */
    public function createUserIfNotExists(array $row)
    {
        // Pull the records from the CSV to determine their values
        $this->item['username'] = $this->findCsvMatch($row, 'username');
        $this->item['first_name'] = $this->findCsvMatch($row, 'first_name');
        $this->item['last_name'] = $this->findCsvMatch($row, 'last_name');
        \Log::debug('UserImporter.php  Name: '.$this->item['first_name'].' '.$this->item['last_name'].' ('.$this->item['username'].')');
        $this->item['email'] = $this->findCsvMatch($row, 'email');
        $this->item['phone'] = $this->findCsvMatch($row, 'phone_number');
        $this->item['jobtitle'] = $this->findCsvMatch($row, 'jobtitle');
        $this->item['activated'] =  ($this->fetchHumanBoolean($this->findCsvMatch($row, 'activated')) == 1) ? '1' : 0;

        \Log::debug('UserImporter.php Activated: '.$this->findCsvMatch($row, 'activated'));
        \Log::debug('UserImporter.php Activated fetchHumanBoolean: '. $this->fetchHumanBoolean($this->findCsvMatch($row, 'activated')));

        $this->item['employee_num'] = $this->findCsvMatch($row, 'employee_num');
        $this->item['department_id'] = $this->createOrFetchDepartment($this->findCsvMatch($row, 'department')) ? $this->createOrFetchDepartment($this->findCsvMatch($row, 'department')) : null;
        $this->item['manager_id'] = $this->fetchManager($this->findCsvMatch($row, 'manager_first_name'), $this->findCsvMatch($row, 'manager_last_name')) ? $this->fetchManager($this->findCsvMatch($row, 'manager_first_name'), $this->findCsvMatch($row, 'manager_last_name')) : null;


        $user = User::where('username', $this->item['username'])->first();
        if ($user) {
            if (!$this->updating) {
                $this->log('A matching User ' . $this->item["name"] . ' already exists.  ');
                \Log::debug('A matching User ' . $this->item["name"] . ' already exists.  ');
                return;
            }
            $this->log('Updating User');
            $user->update($this->sanitizeItemForUpdating($user));
            $user->save();
            // \Log::debug('UserImporter.php Updated User ' . print_r($user, true));
            return;
        }



        // This needs to be applied after the update logic, otherwise we'll overwrite user passwords
        // Issue #5408
        $this->item['password'] = $this->tempPassword;

        $this->log("No matching user, creating one");
        $user = new User();
        $user->fill($this->sanitizeItemForStoring($user));

        if ($user->save()) {
            $this->log("User " . $this->item["name"] . ' was created');

            if(($user->email) && ($user->activated=='1')) {
                $data = [
                    'email' => $user->email,
                    'username' => $user->username,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'password' => $this->tempPassword,
                ];

                if ($this->send_welcome) {
                    $user->notify(new WelcomeNotification($data));
                }

            }
            $user = null;
            $this->item = null;
            return;
        }

        $this->logError($user, 'User');
        return;
    }
}
