<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use League\Csv\Reader;

class ObjectImportCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'object-import:csv';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import Items from CSV';

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


		if ($this->option('testrun')=='true') {
			$this->comment('====== TEST ONLY Asset Import for '.$filename.' ====');
			$this->comment('============== NO DATA WILL BE WRITTEN ==============');
                        } else {

                        $this->comment('======= Importing Assets from '.$filename.' =========');
		}

		if (! ini_get("auto_detect_line_endings")) {
			ini_set("auto_detect_line_endings", '1');
		}

		$csv = Reader::createFromPath($this->argument('filename'));
		$csv->setNewline("\r\n");

                $results = $csv->fetchAssoc();


                $newarray = NULL;
                foreach( $results as $index => $arraytoNormalize) {
                    $internalnewarray = array_change_key_case($arraytoNormalize);
                    $newarray[$index] = $internalnewarray;
                }


		// Loop through the records
                foreach( $newarray as $row ) {
			$status_id = 1;

			// Let's just map some of these entries to more user friendly words
                        $user_name = $user_email = $user_username = $asset_name
                                   = $asset_category = $asset_model_name = $asset_mfgr
                                   = $asset_modelno = $asset_serial = $asset_tag = $asset_location
                                   = $asset_notes = $asset_purchase_date = $asset_purchase_cost
                                   = $asset_company_name = '';

                        if(array_key_exists("name", $row) ) {
                            $user_name = trim($row["name"]);
                        }
                        if(array_key_exists("email", $row) ) {
                            $user_email = trim($row["email"]);
                        }
                        if(array_key_exists("username", $row) ) {
                            $user_username = trim($row["username"]);
                        }
                        if(array_key_exists("item name", $row)) {
                            $asset_name = trim($row["item name"]);
                        }
                        if(array_key_exists("category", $row) ) {
                            $asset_category = trim($row["category"]);
                        }
                        if(array_key_exists("model name", $row) ) {
                            $asset_model_name = trim($row["model name"]);
                        }
                        if(array_key_exists("manufacturer", $row) ) {
                            $asset_mfgr = trim($row["manufacturer"]);
                        }
                        if(array_key_exists("model number", $row) ) {
                            $asset_modelno = trim($row["model number"]);
                        }
                        if(array_key_exists("serial number", $row) ) {
                            $asset_serial = trim($row["serial number"]);
                        }
                        if(array_key_exists("asset tag", $row) ) {
                            $asset_tag = trim($row["asset tag"]);
                        }
                        if(array_key_exists("location", $row) ) {
                            $asset_location = trim($row["location"]);
                        }
                        if(array_key_exists("notes", $row) ) {
                            $asset_notes = trim($row["notes"]);
                        }
                        if(array_key_exists("purchase date", $row) ) {
                            $asset_purchase_date = strtotime($row["purchase date"]);
                        }
                        if(array_key_exists("purchase cost", $row) ) {
                            $asset_purchase_cost = trim($row["purchase cost"]);
                        }
                        if(array_key_exists("company name", $row) ) {
                            $asset_company_name = trim($row["company name"]);
                        }


			// A number was given instead of a name
			if (is_numeric($user_name)) {
				$this->comment('User '.$user_name.' is not a name - assume this user already exists');
				$user_username = '';

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
					$user_email = $user_email_array['username'].'@'.Config::get('app.domain');
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
			$this->comment('Category Name: '.$asset_category);
                        $this->comment('Item: '.$asset_name);
                        $this->comment('Model: '.$asset_model_name);
			$this->comment('Manufacturer ID: '.$asset_mfgr);
			$this->comment('Model No: '.$asset_modelno);
			$this->comment('Serial No: '.$asset_serial);
			$this->comment('Asset Tag: '.$asset_tag);
			$this->comment('Location: '.$asset_location);
			$this->comment('Purchase Date: '.$asset_purchase_date);
			$this->comment('Purchase Cost: '.$asset_purchase_cost);
			$this->comment('Notes: '.$asset_notes);
                        $this->comment('Company Name: '.$asset_company_name);

			$this->comment('------------- Action Summary ----------------');

                        if($this->option('testrun') == true) {
                            continue; // We parsed and shared, now die.
                        }
			if ($user_username!='') {
				if ($user = User::MatchEmailOrUsername($user_username, $user_email)
					->whereNotNull('username')->first()) {
					$this->comment('User '.$user_username.' already exists');
				} else {
					// Create the user
					$user = Sentry::createUser(array(
						'first_name' => $first_name,
						'last_name' => $last_name,
						'email'     => $user_email,
						'username'     => $user_username,
						'password'  => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 12),
						'activated' => true,
						'permissions' => array(
							'admin' => 0,
							'user'  => 1,
						),
						'notes'         => 'User imported through asset importer'
					));

					// Find the group using the group id
					$userGroup = Sentry::findGroupById(3);

					// Assign the group to the user
					$user->addGroup($userGroup);
					$this->comment('User '.$first_name.' created');
				}
			} else {
				$user = new User;
			}

			// Check for the location match and create it if it doesn't exist
			if ($location = Location::where('name', $asset_location)->first()) {
				$this->comment('Location '.$asset_location.' already exists');
			} else {

        $location = new Location();

				if ($asset_location!='') {


					$location->name = e($asset_location);
					$location->address = '';
					$location->city = '';
					$location->state = '';
					$location->country = '';
					$location->user_id = 1;

					if (!$this->option('testrun')=='true') {

						if ($location->save()) {
							$this->comment('Location '.$asset_location.' was created');
			            } else {
							$this->comment('Something went wrong! Location '.$asset_location.' was NOT created');
						}

					} else {
						$this->comment('Location '.$asset_location.' was (not) created - test run only');
					}
				} else {
					$this->comment('No location given, so none created.');
				}

			}

      if (e($asset_category)=='') {
        $category_name = 'Unnamed Category';
      } else {
        $category_name = e($asset_category);
      }

			// Check for the category match and create it if it doesn't exist
			if ($category = Category::where('name', $category_name)->where('category_type', 'asset')->first()) {
				$this->comment('Category '.$category_name.' already exists');

			} else {
				$category = new Category();

                                $category->name = $category_name;
				$category->category_type = 'asset';
				$category->user_id = 1;

				if ($category->save()) {
					$this->comment('Category '.$asset_category.' was created');
                                } else {
					$this->comment('Something went wrong! Category '.$asset_category.' was NOT created');
				}

			}

			// Check for the manufacturer match and create it if it doesn't exist
			if ($manufacturer = Manufacturer::where('name', $asset_mfgr)->first()) {
				$this->comment('Manufacturer '.$asset_mfgr.' already exists');
			} else {
				$manufacturer = new Manufacturer();
				$manufacturer->name = e($asset_mfgr);
				$manufacturer->user_id = 1;

				if ($manufacturer->save()) {
					$this->comment('Manufacturer '.$asset_mfgr.' was created');
                                } else {
					$this->comment('Something went wrong! Manufacturer '.$asset_mfgr.' was NOT created');
				}

			}

			// Check for the asset model match and create it if it doesn't exist
                        if ($asset_model = Model::where('name', $asset_model_name)->where('modelno', $asset_modelno)->where('category_id', $category->id)->where('manufacturer_id', $manufacturer->id)->first()) {
                                $this->comment('The Asset Model '.$asset_model_name.' with model number '.$asset_modelno.' already exists');
			} else {
				$asset_model = new Model();
                                $asset_model->name = e($asset_model_name);
				$asset_model->manufacturer_id = $manufacturer->id;
				$asset_model->modelno = e($asset_modelno);
				$asset_model->category_id = $category->id;
				$asset_model->user_id = 1;

				if ($asset_model->save()) {
                                        $this->comment('Asset Model '.$asset_model_name.' with model number '.$asset_modelno.' was created');
                                } else {
                                        $this->comment('Something went wrong! Asset Model '.$asset_model_name.' was NOT created');
				}

			}

                        // Check for the asset company match and create it if it doesn't exist
                        if ($company = Company::where('name', $asset_company_name)->first()) {
                            $this->comment('Company '.$asset_company_name.' already exists');
                        } else {
                            $company = new Company();
                            $company->name = e($asset_company_name);

                            if ($company->save()) {
                                $this->comment('Company '.$asset_company_name.' was created');
                            } else {
                                    $this->comment('Something went wrong! Company '.$asset_company_name.' was NOT created');
                            }
                        }

			// Check for the asset match and create it if it doesn't exist
        if ($asset = Asset::where('asset_tag', $asset_tag)->first()) {
          $this->comment('The Asset with asset tag '.$asset_tag.' already exists');
        } else {
          $asset = new Asset();
          $asset->name = e($asset_name);
  				if ($asset_purchase_date!='') {
  					$asset->purchase_date = $asset_purchase_date;
  				} else {
  					$asset->purchase_date = NULL;
  				}
  				if ($asset_purchase_cost!='') {
  					$asset->purchase_cost = ParseFloat(e($asset_purchase_cost));
  				} else {
  					$asset->purchase_cost = 0.00;
  				}
  				$asset->serial = e($asset_serial);
  				$asset->asset_tag = e($asset_tag);
  				$asset->model_id = $asset_model->id;
  				$asset->assigned_to = $user->id;
  				$asset->rtd_location_id = $location->id;
  				$asset->user_id = 1;
  				$asset->status_id = $status_id;
                                $asset->company_id = $company->id;
  				if ($asset_purchase_date!='') {
  					$asset->purchase_date = $asset_purchase_date;
  				} else {
  					$asset->purchase_date = NULL;
  				}
  				$asset->notes = e($asset_notes);

  				if ($asset->save()) {
  					$this->comment('Asset '.$user_asset_name.' with serial number '.$asset_serial.' was created');
  	            } else {
  					$this->comment('Something went wrong! Asset '.$user_asset_name.' was NOT created');
  				}

        }



			$this->comment('=====================================');

			return true;

		}


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