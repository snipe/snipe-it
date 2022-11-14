<?php

namespace App\Importer;

use App\Models\Asset;
use App\Models\Department;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\WelcomeNotification;

/**
 * This is ONLY used for the User Import. When we are importing users
 * via an Asset/etc import, we use createOrFetchUser() in
 * App\Importer.php. [ALG]
 *
 * Class UserImporter
 */
class UserImporter extends ItemImporter
{
    protected $users;
    protected $send_welcome = false;

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
        $this->item['email'] = $this->findCsvMatch($row, 'email');
        $this->item['phone'] = $this->findCsvMatch($row, 'phone_number');
        $this->item['jobtitle'] = $this->findCsvMatch($row, 'jobtitle');
        $this->item['address'] = $this->findCsvMatch($row, 'address');
        $this->item['city'] = $this->findCsvMatch($row, 'city');
        $this->item['state'] = $this->findCsvMatch($row, 'state');
        $this->item['country'] = $this->findCsvMatch($row, 'country');
        $this->item['zip'] = $this->findCsvMatch($row, 'zip');
        $this->item['activated'] = ($this->fetchHumanBoolean($this->findCsvMatch($row, 'activated')) == 1) ? '1' : 0;
        $this->item['employee_num'] = $this->findCsvMatch($row, 'employee_num');
        $this->item['department_id'] = $this->createOrFetchDepartment($this->findCsvMatch($row, 'department'));
        $this->item['manager_id'] = $this->fetchManager($this->findCsvMatch($row, 'manager_first_name'), $this->findCsvMatch($row, 'manager_last_name'));

        $user_department = $this->findCsvMatch($row, 'department');
        if ($this->shouldUpdateField($user_department)) {
            $this->item['department_id'] = $this->createOrFetchDepartment($user_department);
        }

        if (is_null($this->item['username']) || $this->item['username'] == "") {
            $user_full_name = $this->item['first_name'] . ' ' . $this->item['last_name'];
            $user_formatted_array = User::generateFormattedNameFromFullName($user_full_name, Setting::getSettings()->username_format);
            $this->item['username'] = $user_formatted_array['username'];
        }
        
        $user = User::where('username', $this->item['username'])->first();
        if ($user) {
            if (! $this->updating) {
                $this->log('A matching User '.$this->item['name'].' already exists.  ');
                \Log::debug('A matching User '.$this->item['name'].' already exists.  ');

                return;
            }
            $this->log('Updating User');
            $user->update($this->sanitizeItemForUpdating($user));
            $user->save();

            // Update the location of any assets checked out to this user
            Asset::where('assigned_type', User::class)
                ->where('assigned_to', $user->id)
                ->update(['location_id' => $user->location_id]);
            
            // \Log::debug('UserImporter.php Updated User ' . print_r($user, true));
            return;
        }



        // This needs to be applied after the update logic, otherwise we'll overwrite user passwords
        // Issue #5408
        $this->item['password'] = bcrypt($this->tempPassword);

        $this->log('No matching user, creating one');
        $user = new User();
        $user->fill($this->sanitizeItemForStoring($user));

        if ($user->save()) {
            // $user->logCreate('Imported using CSV Importer');
            $this->log('User '.$this->item['name'].' was created');

            if (($user->email) && ($user->activated == '1')) {
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

    /**
     * Fetch an existing department, or create new if it doesn't exist
     *
     * @author Daniel Melzter
     * @since 5.0
     * @param $department_name string
     * @return int id of department created/found
     */
    public function createOrFetchDepartment($department_name)
    {
        if (is_null($department_name) || $department_name == ''){
            return null;
        }


        $department = Department::where(['name' => $department_name])->first();
        if ($department) {
            $this->log('A matching department ' . $department_name . ' already exists');
            return $department->id;
        }

        $department = new department();
        $department->name = $department_name;
        $department->user_id = $this->user_id;

        if ($department->save()) {
            $this->log('department ' . $department_name . ' was created');
            return $department->id;
        }

        $this->logError($department, 'Department');
        return null;
    }
    
    public function sendWelcome($send = true)
    {
        $this->send_welcome = $send;
    }
}
