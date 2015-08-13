<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use League\Csv\Reader;

class ImportCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'import:csv';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import from CSV';

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
			$this->comment('======= Importing '.$filename.' =========');
		} else {
			$this->comment('====== TEST ONLY Import for '.$filename.' ====');
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

			if (array_key_exists('0',$row)) {
				$user_name = trim($row[0]);
			} else {
				$user_name = '';
			}

			if (array_key_exists('1',$row)) {
				$user_email = trim($row[1]);
			} else {
				$user_email = '';
			}

			if (array_key_exists('2',$row)) {
				$user_asset_category = trim($row[2]);
			} else {
				$user_asset_category = '';
			}

			if (array_key_exists('3',$row)) {
				$user_asset_name = trim($row[3]);
			} else {
				$user_asset_name = '';
			}

			if (array_key_exists('4',$row)) {
				$user_asset_mfgr = trim($row[4]);
			} else {
				$user_asset_mfgr = '';
			}

			if (array_key_exists('5',$row)) {
				$user_asset_modelno = trim($row[5]);
			} else {
				$user_asset_modelno = '';
			}

			if (array_key_exists('6',$row)) {
				$user_asset_serial = trim($row[6]);
			} else {
				$user_asset_serial = '';
			}

			if (array_key_exists('7',$row)) {
				$user_asset_tag = trim($row[7]);
			} else {
				$user_asset_tag = '';
			}

			if (array_key_exists('8',$row)) {
				$user_asset_location = trim($row[8]);
			} else {
				$user_asset_location = '';
			}

			if (array_key_exists('9',$row)) {
				$user_asset_notes = trim($row[9]);
			} else {
				$user_asset_notes = '';
			}

			if (array_key_exists('10',$row)) {
				if ($row[10]!='') {
					$user_asset_purchase_date = date("Y-m-d 00:00:01", strtotime($row[10]));
				} else {
					$user_asset_purchase_date = '';
				}
			} else {
				$user_asset_purchase_date = '';
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
						$last_name = str_replace($first_name,'',$user_name);

						if ($this->option('email_format')=='filastname') {
							$email_last_name.=str_replace(' ','',$last_name);
							$email_prefix = $first_name[0].$email_last_name;

						} elseif ($this->option('email_format')=='firstname.lastname') {
							$email_last_name.=str_replace(' ','',$last_name);
							$email_prefix = $first_name.'.'.$email_last_name;

						} elseif ($this->option('email_format')=='firstname') {
							$email_last_name.=str_replace(' ','',$last_name);
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
						$user_email = str_replace("'",'',$email);
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
			$this->comment('Notes: '.$user_asset_notes);

			$this->comment('------------- Action Summary ----------------');

			if ($user_username!='') {
				if ($user = User::where('username', $user_username)->whereNotNull('username')->first()) {
					$this->comment('User '.$user_username.' already exists');
				} else {
					// Create the user
					$user = Sentry::createUser(array(
						'first_name' => $first_name,
						'last_name' => $last_name,
						'email'     => $user_email,
						'username'     => $user_username,
						'password'  => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10),
						'activated' => true,
						'permissions' => array(
							'admin' => 0,
							'user'  => 1,
						),
						'notes'         => 'Imported user'
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
			if ($location = Location::where('name', $user_asset_location)->first()) {
				$this->comment('Location '.$user_asset_location.' already exists');
			} else {
				$location = new Location();
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
						$this->comment('Something went wrong! Location '.$user_asset_location.' was NOT created');
					}

				} else {
					$this->comment('Location '.$user_asset_location.' was (not) created - test run only');
				}

			}

			// Check for the category match and create it if it doesn't exist
			if ($category = Category::where('name', $user_asset_category)->where('category_type', 'asset')->first()) {
				$this->comment('Category '.$user_asset_category.' already exists');
			} else {
				$category = new Category();
				$category->name = e($user_asset_category);
				$category->category_type = 'asset';
				$category->user_id = 1;

				if ($category->save()) {
					$this->comment('Category '.$user_asset_category.' was created');
	            } else {
					$this->comment('Something went wrong! Category '.$user_asset_category.' was NOT created');
				}

			}

			// Check for the manufacturer match and create it if it doesn't exist
			if ($manufacturer = Manufacturer::where('name', $user_asset_mfgr)->first()) {
				$this->comment('Manufacturer '.$user_asset_mfgr.' already exists');
			} else {
				$manufacturer = new Manufacturer();
				$manufacturer->name = e($user_asset_mfgr);
				$manufacturer->user_id = 1;

				if ($manufacturer->save()) {
					$this->comment('Manufacturer '.$user_asset_mfgr.' was created');
	            } else {
					$this->comment('Something went wrong! Manufacturer '.$user_asset_mfgr.' was NOT created');
				}

			}

			// Check for the asset model match and create it if it doesn't exist
			if ($asset_model = Model::where('name', $user_asset_name)->where('modelno', $user_asset_modelno)->where('category_id', $category->id)->where('manufacturer_id', $manufacturer->id)->first()) {
				$this->comment('The Asset Model '.$user_asset_name.' with model number '.$user_asset_modelno.' already exists');
			} else {
				$asset_model = new Model();
				$asset_model->name = e($user_asset_name);
				$asset_model->manufacturer_id = $manufacturer->id;
				$asset_model->modelno = e($user_asset_modelno);
				$asset_model->category_id = $category->id;
				$asset_model->user_id = 1;

				if ($asset_model->save()) {
					$this->comment('Asset Model '.$user_asset_name.' with model number '.$user_asset_modelno.' was created');
	            } else {
					$this->comment('Something went wrong! Asset Model '.$user_asset_name.' was NOT created');
				}

			}

			// Check for the asset match and create it if it doesn't exist

				$asset = new Asset();
				$asset->name = e($user_asset_name);
				if ($user_asset_purchase_date!='') {
					$asset->purchase_date = $user_asset_purchase_date;
				} else {
					$asset->purchase_date = NULL;
				}
				$asset->serial = e($user_asset_serial);
				$asset->asset_tag = e($user_asset_tag);
				$asset->model_id = $asset_model->id;
				$asset->assigned_to = $user->id;
				$asset->rtd_location_id = $location->id;
				$asset->user_id = 1;
				$asset->status_id = $status_id;
				if ($user_asset_purchase_date!='') {
					$asset->purchase_date = $user_asset_purchase_date;
				} else {
					$asset->purchase_date = NULL;
				}
				$asset->notes = e($user_asset_notes);

				if ($asset->save()) {
					$this->comment('Asset '.$user_asset_name.' with serial number '.$user_asset_serial.' was created');
	            } else {
					$this->comment('Something went wrong! Asset '.$user_asset_name.' was NOT created');
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
