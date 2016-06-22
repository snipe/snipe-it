<?php
namespace App\Console\Commands;

use App\Models\User;
use App\Models\Location;
use App\Models\Category;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Asset;
use App\Models\Manufacturer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Console\Command;
use League\Csv\Reader;

class AssetImportCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'snipeit:asset-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Assets from CSV';

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
            $this->comment('======= Importing Assets from '.$filename.' =========');
        } else {
            $this->comment('====== TEST ONLY Asset Import for '.$filename.' ====');
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

            // User's name
            if (array_key_exists('0', $row)) {
                $user_name = trim($row[0]);
            } else {
                $user_name = '';
            }

            // User's email
            if (array_key_exists('1', $row)) {
                $user_email = trim($row[1]);
            } else {
                $user_email = '';
            }

            // User's email
            if (array_key_exists('2', $row)) {
                $user_username = trim($row[2]);
            } else {
                $user_username = '';
            }

            // Asset Name
            if (array_key_exists('3', $row)) {
                $user_asset_asset_name = trim($row[3]);
            } else {
                $user_asset_asset_name = '';
            }

            // Asset Category
            if (array_key_exists('4', $row)) {
                $user_asset_category = trim($row[4]);
            } else {
                $user_asset_category = '';
            }

            // Asset Name
            if (array_key_exists('5', $row)) {
                $user_asset_name = trim($row[5]);
            } else {
                $user_asset_name = '';
            }

            // Asset Manufacturer
            if (array_key_exists('6', $row)) {
                $user_asset_mfgr = trim($row[6]);
            } else {
                $user_asset_mfgr = '';
            }

            // Asset model number
            if (array_key_exists('7', $row)) {
                $user_asset_modelno = trim($row[7]);
            } else {
                $user_asset_modelno = '';
            }

            // Asset serial number
            if (array_key_exists('8', $row)) {
                $user_asset_serial = trim($row[8]);
            } else {
                $user_asset_serial = '';
            }

            // Asset tag
            if (array_key_exists('9', $row)) {
                $user_asset_tag = trim($row[9]);
            } else {
                $user_asset_tag = '';
            }

            // Asset location
            if (array_key_exists('10', $row)) {
                $user_asset_location = trim($row[10]);
            } else {
                $user_asset_location = '';
            }

            // Asset notes
            if (array_key_exists('11', $row)) {
                $user_asset_notes = trim($row[11]);
            } else {
                $user_asset_notes = '';
            }

            // Asset purchase date
            if (array_key_exists('12', $row)) {
                if ($row[12]!='') {
                    $user_asset_purchase_date = date("Y-m-d 00:00:01", strtotime($row[12]));
                } else {
                    $user_asset_purchase_date = '';
                }
            } else {
                $user_asset_purchase_date = '';
            }

            // Asset purchase cost
            if (array_key_exists('13', $row)) {
                if ($row[13]!='') {
                    $user_asset_purchase_cost = trim($row[13]);
                } else {
                    $user_asset_purchase_cost = '';
                }
            } else {
                $user_asset_purchase_cost = '';
            }

       // Asset Company Name
            if (array_key_exists('14', $row)) {
                if ($row[14]!='') {
                    $user_asset_company_name = trim($row[14]);
                } else {
                        $user_asset_company_name= '';
                }
            } else {
                   $user_asset_company_name = '';
            }


        // A number was given instead of a name
            if (is_numeric($user_name)) {
                $this->comment('User '.$user_name.' is not a name - assume this user already exists');
                $user_username = '';
                $first_name = '';
                $last_name = '';

            // No name was given
            } elseif ($user_name=='') {
                $this->comment('No user data provided - skipping user creation, just adding asset');
                $first_name = '';
                $last_name = '';
                //$user_username = '';

            } else {
                $user_email_array = User::generateFormattedNameFromFullName($this->option('email_format'), $user_name);
                $first_name = $user_email_array['first_name'];
                $last_name = $user_email_array['last_name'];

                if ($user_email=='') {
                    $user_email = $user_email_array['username'].'@'.config('app.domain');
                }

                if ($user_username=='') {
                    if ($this->option('username_format')=='email') {
                        $user_username = $user_email;
                    } else {
                        $user_name_array = User::generateFormattedNameFromFullName($this->option('username_format'), $user_name);
                        $user_username = $user_name_array['username'];
                    }

                }

            }

            $this->comment('Full Name: '.$user_name);
            $this->comment('First Name: '.$first_name);
            $this->comment('Last Name: '.$last_name);
            $this->comment('Username: '.$user_username);
            $this->comment('Email: '.$user_email);
            $this->comment('Category Name: '.$user_asset_category);
            $this->comment('Item: '.$user_asset_name);
            $this->comment('Manufacturer ID: '.$user_asset_mfgr);
            $this->comment('Model No: '.$user_asset_modelno);
            $this->comment('Serial No: '.$user_asset_serial);
            $this->comment('Asset Tag: '.$user_asset_tag);
            $this->comment('Location: '.$user_asset_location);
            $this->comment('Purchase Date: '.$user_asset_purchase_date);
            $this->comment('Purchase Cost: '.$user_asset_purchase_cost);
            $this->comment('Notes: '.$user_asset_notes);
            $this->comment('Company Name: '.$user_asset_company_name);

            $this->comment('------------- Action Summary ----------------');

            if ($user_username!='') {
                if ($user = User::MatchEmailOrUsername($user_username, $user_email)
                ->whereNotNull('username')->first()) {
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

                }
            } else {
                $user = new User;
            }

        // Check for the location match and create it if it doesn't exist
            if ($location = Location::where('name', e($user_asset_location))->first()) {
                $this->comment('Location '.$user_asset_location.' already exists');
            } else {

                $location = new Location();

                if ($user_asset_location!='') {
                    $location->name = e($user_asset_location);
                    $location->address = '';
                    $location->city = '';
                    $location->state = '';
                    $location->country = '';
                    $location->user_id = 1;

                    if (!$this->option('testrun')=='true') {

                        if ($location->save()) {
                            $this->comment('Location '.$user_asset_location.' was created');
                        } else {
                            $this->error('Something went wrong! Location '.$user_asset_location.' was NOT created');
                            $this->error($location->getErrors());
                        }

                    } else {
                        $this->comment('Location '.$user_asset_location.' was (not) created - test run only');
                    }
                } else {
                    $this->comment('No location given, so none created.');
                }

            }

            if (e($user_asset_category)=='') {
                $category_name = 'Unnamed Category';
            } else {
                $category_name = e($user_asset_category);
            }

        // Check for the category match and create it if it doesn't exist
            if ($category = Category::where('name', e($category_name))->where('category_type', 'asset')->first()) {
                $this->comment('Category '.$category_name.' already exists');

            } else {
                $category = new Category();
                $category->name = e($category_name);
                $category->category_type = 'asset';
                $category->user_id = 1;

                if ($category->save()) {
                    $this->comment('Category '.$user_asset_category.' was created');
                } else {
                    $this->error('Something went wrong! Category '.$user_asset_category.' was NOT created');
                    $this->error($category->getErrors());
                }

            }

        // Check for the manufacturer match and create it if it doesn't exist
            if ($manufacturer = Manufacturer::where('name', e($user_asset_mfgr))->first()) {
                $this->comment('Manufacturer '.$user_asset_mfgr.' already exists');
            } else {
                $manufacturer = new Manufacturer();
                $manufacturer->name = e($user_asset_mfgr);
                $manufacturer->user_id = 1;

                if ($manufacturer->save()) {
                    $this->comment('Manufacturer '.$user_asset_mfgr.' was created');
                } else {
                    $this->error('Something went wrong! Manufacturer '.$user_asset_mfgr.' was NOT created: '. $manufacturer->getErrors()->first());
                }

            }

        // Check for the asset model match and create it if it doesn't exist
            if ($asset_model = AssetModel::where('name', e($user_asset_name))->where('modelno', e($user_asset_modelno))->where('category_id', $category->id)->where('manufacturer_id', $manufacturer->id)->first()) {
                $this->comment('The Asset Model '.$user_asset_name.' with model number '.$user_asset_modelno.' already exists');
            } else {
                $asset_model = new AssetModel();
                $asset_model->name = e($user_asset_name);
                $asset_model->manufacturer_id = $manufacturer->id;
                $asset_model->modelno = e($user_asset_modelno);
                $asset_model->category_id = $category->id;
                $asset_model->user_id = 1;

                if ($asset_model->save()) {
                    $this->comment('Asset Model '.$user_asset_name.' with model number '.$user_asset_modelno.' was created');
                } else {
                    $this->error('Something went wrong! Asset Model '.$user_asset_name.' was NOT created: '.$asset_model->getErrors()->first());
                }

            }

        // Check for the asset company match and create it if it doesn't exist
            if ($user_asset_company_name!='') {
                if ($company = Company::where('name', e($user_asset_company_name))->first()) {
                    $this->comment('Company '.$user_asset_company_name.' already exists');
                } else {
                    $company = new Company();
                    $company->name = e($user_asset_company_name);

                    if ($company->save()) {
                        $this->comment('Company '.$user_asset_company_name.' was created');
                    } else {
                        $this->error('Something went wrong! Company '.$user_asset_company_name.' was NOT created: '.$company->getErrors()->first());
                    }
                }

            } else {
                $company = new Company();
            }

            // Check for the asset match and create it if it doesn't exist
            if ($asset = Asset::where('asset_tag', e($user_asset_tag))->first()) {
                $this->comment('The Asset with asset tag '.$user_asset_tag.' already exists');
            } else {
                $asset = new Asset();
                $asset->name = e($user_asset_asset_name);
                if ($user_asset_purchase_date!='') {
                    $asset->purchase_date = $user_asset_purchase_date;
                } else {
                    $asset->purchase_date = null;
                }
                if ($user_asset_purchase_cost!='') {
                    $asset->purchase_cost = ParseFloat(e($user_asset_purchase_cost));
                } else {
                    $asset->purchase_cost = 0.00;
                }
                    $asset->serial = e($user_asset_serial);
                    $asset->asset_tag = e($user_asset_tag);
                    $asset->model_id = $asset_model->id;
                    $asset->assigned_to = $user->id;
                    $asset->rtd_location_id = $location->id;
                    $asset->user_id = 1;
                    $asset->status_id = $status_id;
                    $asset->company_id = $company->id;
                if ($user_asset_purchase_date!='') {
                    $asset->purchase_date = $user_asset_purchase_date;
                } else {
                    $asset->purchase_date = null;
                }
                    $asset->notes = e($user_asset_notes);

                if ($asset->save()) {
                    $this->comment('Asset '.$user_asset_name.' with serial number '.$user_asset_serial.' was created');
                } else {
                    $this->error('Something went wrong! Asset '.$user_asset_name.' was NOT created: '.$asset->getErrors()->first());
                }

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
        array('email_format', null, InputOption::VALUE_REQUIRED, 'The format of the email addresses that should be generated. Options are firstname.lastname, firstname, filastname', null),
        array('username_format', null, InputOption::VALUE_REQUIRED, 'The format of the username that should be generated. Options are firstname.lastname, firstname, filastname, email', null),
        array('testrun', null, InputOption::VALUE_REQUIRED, 'Test the output without writing to the database or not.', null),
        );
    }
}
