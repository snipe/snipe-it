<?php

namespace App\Importer;

use App\Helpers\Helper;
use App\Models\User;
use App\Notifications\WelcomeNotification;

class UserImporter extends ItemImporter
{
    protected $users;
    public function __construct($filename)
    {
        parent::__construct($filename);
        // $this->users = User::all();
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
        // User Specific Bits
        $this->item['username'] = $this->findCsvMatch($row, 'username');
        $this->item['first_name'] = $this->findCsvMatch($row, 'first_name');
        $this->item['last_name'] = $this->findCsvMatch($row, 'last_name');
        $this->item['email'] = $this->findCsvMatch($row, 'email');
        $this->item['phone'] = $this->findCsvMatch($row, 'phone_number');
        $this->item['jobtitle'] = $this->findCsvMatch($row, 'jobtitle');
        $this->item['employee_num'] = $this->findCsvMatch($row, 'employee_num');
        $user = User::where('username', $this->item['username'])->first();
        if ($user) {
            if (!$this->updating) {
                $this->log('A matching User ' . $this->item["name"] . ' already exists.  ');
                return;
            }
            $this->log('Updating User');
            $user->update($this->sanitizeItemForUpdating($user));
            $user->save();
            return;
        }
        // This needs to be applied after the update logic, otherwise we'll overwrite user passwords
        // Issue #5408
        $this->item['password'] = $this->tempPassword;

        $this->log("No matching user, creating one");
        $user = new User();
        $user->fill($this->sanitizeItemForStoring($user));
        if ($user->save()) {
            // $user->logCreate('Imported using CSV Importer');
            $this->log("User " . $this->item["name"] . ' was created');
            if($user->email) {
                $data = [
                    'email' => $user->email,
                    'username' => $user->username,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'password' => $this->tempPassword,
                ];

                // UNCOMMENT this to re-enable sending email notifications on user import
                // $user->notify(new WelcomeNotification($data));
            }
            $user = null;
            $this->item = null;
            return;
        }

        $this->logError($user, 'User');
        return;
    }
}
