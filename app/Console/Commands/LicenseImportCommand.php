<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use League\Csv\Reader;
use App\Models\User;
use App\Models\Supplier;
use App\Models\License;
use App\Models\LicenseSeat;

class LicenseImportCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'snipeit:license-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Licenses from CSV';

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
    public function fire()
    {
        $filename = $this->argument('filename');


        if (!$this->option('testrun')=='true') {
            $this->comment('======= Importing Licenses from '.$filename.' =========');
        } else {
            $this->comment('====== TEST ONLY License Import for '.$filename.' ====');
            $this->comment('============== NO DATA WILL BE WRITTEN ==============');
        }

        if (! ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');
        }

        $csv = Reader::createFromPath($this->argument('filename'));
        $csv->setNewline("\r\n");
        $csv->setOffset(1);
        $duplicates = '';

        // Loop through the records
        $nbInsert = $csv->each(function ($row) use ($duplicates) {
            $status_id = 1;

            // Let's just map some of these entries to more user friendly words

            if (array_key_exists('0', $row)) {
                $user_name = trim($row[0]);
            } else {
                $user_name = '';
            }

            if (array_key_exists('1', $row)) {
                $user_email = trim($row[1]);
            } else {
                $user_email = '';
            }

            if (array_key_exists('2', $row)) {
                $user_username = trim($row[2]);
            } else {
                $user_username = '';
            }

            if (array_key_exists('3', $row)) {
                $user_license_name = trim($row[3]);
            } else {
                $user_license_name = '';
            }

            if (array_key_exists('4', $row)) {
                $user_license_serial = trim($row[4]);
            } else {
                $user_license_serial = '';
            }

            if (array_key_exists('5', $row)) {
                $user_licensed_to_name = trim($row[5]);
            } else {
                $user_licensed_to_name = '';
            }

            if (array_key_exists('6', $row)) {
                $user_licensed_to_email = trim($row[6]);
            } else {
                $user_licensed_to_email = '';
            }

            if (array_key_exists('7', $row)) {
                $user_license_seats = trim($row[7]);
            } else {
                $user_license_seats = '';
            }

            if (array_key_exists('8', $row)) {
                $user_license_reassignable = trim($row[8]);
                if ($user_license_reassignable!='') {
                    if ((strtolower($user_license_reassignable)=='yes') || (strtolower($user_license_reassignable)=='true') || ($user_license_reassignable=='1')) {
                        $user_license_reassignable = 1;
                    }
                } else {
                    $user_license_reassignable = 0;
                }
            } else {
                $user_license_reassignable = 0;
            }

            if (array_key_exists('9', $row)) {
                $user_license_supplier = trim($row[9]);
            } else {
                $user_license_supplier = '';
            }

            if (array_key_exists('10', $row)) {
                $user_license_maintained = trim($row[10]);

                if ($user_license_maintained!='') {
                    if ((strtolower($user_license_maintained)=='yes') || (strtolower($user_license_maintained)=='true') || ($user_license_maintained=='1')) {
                        $user_license_maintained = 1;
                    }
                } else {
                    $user_license_maintained = 0;
                }


            } else {
                $user_license_maintained = '';
            }

            if (array_key_exists('11', $row)) {
                $user_license_notes = trim($row[11]);
            } else {
                $user_license_notes = '';
            }

            if (array_key_exists('12', $row)) {
                if ($row[12]!='') {
                    $user_license_purchase_date = date("Y-m-d 00:00:01", strtotime($row[12]));
                } else {
                    $user_license_purchase_date = '';
                }
            } else {
                $user_license_purchase_date = 0;
            }

            // A number was given instead of a name
            if (is_numeric($user_name)) {
                $this->comment('User '.$user_name.' is not a name - assume this user already exists');
                $user_username = '';
            // No name was given

            } elseif ($user_name=='') {
                $this->comment('No user data provided - skipping user creation, just adding license');
                $first_name = '';
                $last_name = '';
                $user_username = '';

            } else {

                    $name = explode(" ", $user_name);
                    $first_name = $name[0];
                    $email_last_name = '';
                    $email_prefix = $first_name;

                if (!array_key_exists(1, $name)) {
                    $last_name='';
                    $email_last_name = $last_name;
                    $email_prefix = $first_name;
                } else {
                    $last_name = str_replace($first_name, '', $user_name);

                    if ($this->option('email_format')=='filastname') {
                        $email_last_name.=str_replace(' ', '', $last_name);
                        $email_prefix = $first_name[0].$email_last_name;

                    } elseif ($this->option('email_format')=='firstname.lastname') {
                        $email_last_name.=str_replace(' ', '', $last_name);
                        $email_prefix = $first_name.'.'.$email_last_name;

                    } elseif ($this->option('email_format')=='firstname') {
                        $email_last_name.=str_replace(' ', '', $last_name);
                        $email_prefix = $first_name;
                    }


                }


                    $user_username = $email_prefix;

                    // Generate an email based on their name if no email address is given
                if ($user_email=='') {
                    if ($first_name=='Unknown') {
                        $status_id = 7;
                    }
                    $email = strtolower($email_prefix).'@'.$this->option('domain');
                    $user_email = str_replace("'", '', $email);
                }
            }

            $this->comment('Full Name: '.$user_name);
            $this->comment('First Name: '.$first_name);
            $this->comment('Last Name: '.$last_name);
            $this->comment('Username: '.$user_username);
            $this->comment('Email: '.$user_email);
            $this->comment('License Name: '.$user_license_name);
            $this->comment('Serial No: '.$user_license_serial);
            $this->comment('Licensed To Name: '.$user_licensed_to_name);
            $this->comment('Licensed To Email: '.$user_licensed_to_email);
            $this->comment('Seats: '.$user_license_seats);
            $this->comment('Reassignable: '.$user_license_reassignable);
            $this->comment('Supplier: '.$user_license_supplier);
            $this->comment('Maintained: '.$user_license_maintained);
            $this->comment('Notes: '.$user_license_notes);
            $this->comment('Purchase Date: '.$user_license_purchase_date);

            $this->comment('------------- Action Summary ----------------');

            if ($user_username!='') {
                if ($user = User::where('username', $user_username)->whereNotNull('username')->first()) {
                    $this->comment('User '.$user_username.' already exists');
                } else {

                    $user = new \App\Models\User;
                    $password  = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);

                    $user->first_name = $first_name;
                    $user->last_name = $last_name;
                    $user->username = $user_username;
                    $user->email = $user_email;
                    $user->permissions = '{user":1}';
                    $user->password = bcrypt($password);
                    $user->activated = 1;
                    if ($user->save()) {
                        $this->comment('User '.$first_name.' created');
                    } else {
                        $this->error('ERROR CREATING User '.$first_name.' '.$last_name);
                        $this->error($user->getErrors());
                    }

                    $this->comment('User '.$first_name.' created');
                }
            } else {
                $user = new User;
                $user->user_id = null;
            }


            // Check for the supplier match and create it if it doesn't exist
            if ($supplier = Supplier::where('name', $user_license_supplier)->first()) {
                $this->comment('Supplier '.$user_license_supplier.' already exists');
            } else {
                $supplier = new Supplier();
                $supplier->name = e($user_license_supplier);
                $supplier->user_id = 1;

                if ($supplier->save()) {
                    $this->comment('Supplier '.$user_license_supplier.' was created');
                } else {
                    $this->comment('Something went wrong! Supplier '.$user_license_supplier.' was NOT created');
                }

            }


            // Add the license
            $license = new License();
            $license->name = e($user_license_name);
            if ($user_license_purchase_date!='') {
                $license->purchase_date = $user_license_purchase_date;
            } else {
                $license->purchase_date = null;
            }
            $license->serial = e($user_license_serial);
            $license->seats = e($user_license_seats);
            $license->supplier_id = $supplier->id;
            $license->user_id = 1;
            if ($user_license_purchase_date!='') {
                $license->purchase_date = $user_license_purchase_date;
            } else {
                $license->purchase_date = null;
            }
            $license->license_name = $user_licensed_to_name;
            $license->license_email = $user_licensed_to_email;
            $license->notes = e($user_license_notes);

            if ($license->save()) {
                $this->comment('License '.$user_license_name.' with serial number '.$user_license_serial.' was created');


                $license_seat_created = 0;

                for ($x = 0; $x < $user_license_seats; $x++) {
                    // Create the license seat entries
                    $license_seat = new LicenseSeat();
                    $license_seat->license_id = $license->id;

                    // Only assign the first seat to the user
                    if ($x==0) {
                        $license_seat->assigned_to = $user->id;
                    } else {
                        $license_seat->assigned_to = null;
                    }

                    if ($license_seat->save()) {
                        $license_seat_created++;
                    }
                }

                if ($license_seat_created > 0) {
                    $this->comment($license_seat_created.' seats were created');
                } else {
                    $this->comment('Something went wrong! NO seats for '.$user_license_name.' were created');
                }



            } else {
                $this->comment('Something went wrong! License '.$user_license_name.' was NOT created');
            }


            $this->comment('=====================================');

            return true;

        });


    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('filename', InputArgument::REQUIRED, 'File for the CSV import.'),
        );
    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('domain', null, InputOption::VALUE_REQUIRED, 'Email domain for generated email addresses.', null),
            array('email_format', null, InputOption::VALUE_REQUIRED, 'The format of the email addresses that should be generated. Options are firstname.lastname, firstname, filastname', null),
            array('testrun', null, InputOption::VALUE_REQUIRED, 'Test the output without writing to the database or not.', null),
        );
    }
}
