<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\CustomField;
use App\Models\Setting;
use Artisan;
use Illuminate\Console\Command;
use Illuminate\Encryption\Encrypter;

class RotateAppKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:rotate-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm("\n****************************************************\nTHIS WILL MODIFY YOUR APP_KEY AND DE-CRYPT YOUR ENCRYPTED CUSTOM FIELDS AND \nRE-ENCRYPT THEM WITH A NEWLY GENERATED KEY. \n\nThere is NO undo. \n\nMake SURE you have a database backup and a backup of your .env generated BEFORE running this command. \n\nIf you do not save the newly generated APP_KEY to your .env in this process, \nyour encrypted data will no longer be decryptable. \n\nAre you SURE you wish to continue, and have confirmed you have a database backup and an .env backup? ")) {

            // Get the existing app_key and ciphers
            // We put them in a variable since we clear the cache partway through here.
            $old_app_key = config('app.key');
            $cipher = config('app.cipher');

            // Generate a new one
            Artisan::call('key:generate', ['--show' => true]);
            $new_app_key = Artisan::output();

            // Clear the config cache
            Artisan::call('config:clear');

            $this->warn('Your app cipher is: '.$cipher);
            $this->warn('Your old APP_KEY is: '.$old_app_key);
            $this->warn('Your new APP_KEY is: '.$new_app_key);

            // Write the new app key to the .env file
            $this->writeNewEnvironmentFileWith($new_app_key);

            // Manually create an old encrypter instance using the old app key
            // and also create a new encrypter instance so we can re-crypt the field
            // using the newly generated app key
            $oldEncrypter = new Encrypter(base64_decode(substr($old_app_key, 7)), $cipher);
            $newEncrypter = new Encrypter(base64_decode(substr($new_app_key, 7)), $cipher);

            $fields = CustomField::where('field_encrypted', '1')->get();

            foreach ($fields as $field) {
                $assets = Asset::whereNotNull($field->db_column)->get();

                foreach ($assets as $asset) {
                    $asset->{$field->db_column} = $oldEncrypter->decrypt($asset->{$field->db_column});
                    $this->line('DECRYPTED: '.$field->db_column);
                    $asset->{$field->db_column} = $newEncrypter->encrypt($asset->{$field->db_column});
                    $this->line('ENCRYPTED: '.$field->db_column);
                    $asset->save();
                }
            }

            // Handle the LDAP password if one is provided
            $setting = Setting::first();
            if ($setting->ldap_pword != '') {
                $setting->ldap_pword = $oldEncrypter->decrypt($setting->ldap_pword);
                $setting->ldap_pword = $newEncrypter->encrypt($setting->ldap_pword);
                $setting->save();
                $this->warn('LDAP password has been re-encrypted.');
            }
        } else {
            $this->info('This operation has been canceled. No changes have been made.');
        }
    }

    /**
     * Write a new environment file with the given key.
     *
     * @param  string  $key
     * @return void
     */
    protected function writeNewEnvironmentFileWith($key)
    {
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->keyReplacementPattern(),
            'APP_KEY='.$key,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    /**
     * Get a regex pattern that will match env APP_KEY with any random key.
     *
     * @return string
     */
    protected function keyReplacementPattern()
    {
        $escaped = preg_quote('='.$this->laravel['config']['app.key'], '/');

        return "/^APP_KEY{$escaped}/m";
    }
}
