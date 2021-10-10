<?php

namespace App\Console\Commands;

use App\LegacyEncrypter\McryptEncrypter;
use App\Models\Asset;
use App\Models\CustomField;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RecryptFromMcrypt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:legacy-recrypt 
                {--force : Force a re-crypt of encrypted data from MCRYPT.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command allows upgrading users to de-encrypt their deprecated mcrypt encrypted fields and re-encrypt them using the current OpenSSL encryption.';

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

        // Check and see if they have a legacy app key listed in their .env
        // If not, we can try to use the current APP_KEY if looks like it's old
        $legacy_key = env('LEGACY_APP_KEY');
        $key_parts = explode(':', $legacy_key);
        $legacy_cipher = env('LEGACY_CIPHER', 'rijndael-256');
        $errors = [];

        if (! $legacy_key) {
            $this->error('ERROR: You do not have a LEGACY_APP_KEY set in your .env file. Please locate your old APP_KEY and ADD a line to your .env file like: LEGACY_APP_KEY=YOUR_OLD_APP_KEY');

            return false;
        }

        // Do some basic legacy app key length checks
        if (strlen($legacy_key) == 32) {
            $legacy_length_check = true;
        } elseif (array_key_exists('1', $key_parts) && (strlen($key_parts[1]) == 44)) {
            $legacy_key = base64_decode($key_parts[1], true);
            $legacy_length_check = true;
        } else {
            $legacy_length_check = false;
        }

        // Check that the app key is 32 characters
        if ($legacy_length_check === true) {
            $this->comment('INFO: Your LEGACY_APP_KEY looks correct. Okay to continue.');
        } else {
            $this->error('ERROR: Your LEGACY_APP_KEY is not the correct length (32 characters or base64 followed by 44 characters for later versions). Please locate your old APP_KEY and use that as your LEGACY_APP_KEY in your .env file to continue.');

            return false;
        }

        $this->error('================================!!!! WARNING !!!!================================');
        $this->error('================================!!!! WARNING !!!!================================');
        $this->comment("This tool will attempt to decrypt your old Snipe-IT (mcrypt, now deprecated) encrypted data and re-encrypt it using OpenSSL. \n\nYou should only continue if you have backed up any and all old APP_KEYs and have backed up your data.");

        $force = ($this->option('force')) ? true : false;

        if ($force || ($this->confirm('Are you SURE you wish to continue?'))) {
            $backup_file = 'backups/env-backups/'.'app_key-'.date('Y-m-d-gis');

            try {
                Storage::disk('local')->put($backup_file, 'APP_KEY: '.config('app.key'));
                Storage::disk('local')->append($backup_file, 'LEGACY_APP_KEY: '.$legacy_key);
            } catch (\Exception $e) {
                $this->info('WARNING: Could not backup app keys');
            }

            if ($legacy_cipher) {
                $mcrypter = new McryptEncrypter($legacy_key, $legacy_cipher);
            } else {
                $mcrypter = new McryptEncrypter($legacy_key);
            }
            $settings = Setting::getSettings();

            if ($settings->ldap_pword == '') {
                $this->comment('INFO: No LDAP password found. Skipping... ');
            } else {
                $decrypted_ldap_pword = $mcrypter->decrypt($settings->ldap_pword);
                $settings->ldap_pword = \Crypt::encrypt($decrypted_ldap_pword);
                $settings->save();
            }
            /** @var CustomField[] $custom_fields */
            $custom_fields = CustomField::where('field_encrypted', '=', 1)->get();
            $this->comment('INFO: Retrieving encrypted custom fields...');

            $query = Asset::withTrashed();

            foreach ($custom_fields as $custom_field) {
                $this->comment('FIELD TO RECRYPT:  '.$custom_field->name.' ('.$custom_field->db_column.')');
                $query->orWhereNotNull($custom_field->db_column);
            }

            // Get all assets with a value in any of the fields that were encrypted
            /** @var Asset[] $assets */
            $assets = $query->get();

            $bar = $this->output->createProgressBar(count($assets));

            foreach ($assets as $asset) {
                foreach ($custom_fields as $encrypted_field) {
                    $columnName = $encrypted_field->db_column;

                    // Make sure the value isn't null
                    if ($asset->{$columnName} != '') {
                        // Try to decrypt the payload using the legacy app key
                        try {
                            $decrypted_field = $mcrypter->decrypt($asset->{$columnName});
                            $asset->{$columnName} = \Crypt::encrypt($decrypted_field);
                            $this->comment($decrypted_field);
                        } catch (\Exception $e) {
                            $errors[] = ' - ERROR: Could not decrypt field ['.$encrypted_field->name.']: '.$e->getMessage();
                        }
                    }
                }
                $asset->save();
                $bar->advance();
            }

            $bar->finish();

            if (count($errors) > 0) {
                $this->comment("\n\n");
                $this->error("The decrypter encountered some errors: \n");
                foreach ($errors as $error) {
                    $this->error($error);
                }
            }
        }
    }
}
