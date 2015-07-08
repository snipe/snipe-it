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

			if (is_numeric($row[0])) {
				$this->comment('User '.$row[0].' is not a name - assume this user already exists');
			} elseif ($row[0]=='') {
				$this->comment('No user data provided - skipping user creation, just adding asset');
			} else {

				// Generate an email based on their name
				$name = explode(" ", $row[0]);
				$first_name = $name[0];
				$last_name = '';
				$email_last_name = '';

				if ($first_name=='Unknown') {
					$status_id = 7;
				}

				if (!array_key_exists(1, $name)) {
					$last_name='';
					$email_last_name = $last_name;
					$email_prefix = $first_name;
				} else {
					// Loop through the rest of the explode so you don't truncate
					for ($x=0; $x < count($name); $x++) {
						if (($x > 0) && ($name[$x]!='')) {
							$last_name.=' '.$name[$x];
							$email_last_name.=$name[$x];
						}
					}
					$email_prefix = $first_name[0].$email_last_name;
				}

				$email = strtolower(str_replace('.','',$email_prefix)).'@'.$this->option('domain');
				$email = str_replace("'",'',$email);

				$this->comment('Full Name: '.$row[0]);
				$this->comment('First Name: '.$first_name);
				$this->comment('Last Name: '.$last_name);
				$this->comment('Email: '.$email);
				$this->comment('Category Name: '.$row[1]);
				$this->comment('Item: '.$row[2]);
				$this->comment('Manufacturer ID: '.$row[3]);
				$this->comment('Model No: '.$row[4]);
				$this->comment('Serial No: '.$row[5]);
				$this->comment('Asset Tag: '.$row[6]);
				$this->comment('Location: '.$row[7]);
			}

			$this->comment('------------- Action Summary ----------------');

			if (isset($email)) {
				if ($user = User::where('email', $email)->first()) {
					$this->comment('User '.$email.' already exists');
				} else {
					// Create the user
					$user = Sentry::createUser(array(
						'first_name' => $first_name,
						'last_name' => $last_name,
						'email'     => $email,
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
			if ($location = Location::where('name', $row[7])->first()) {
				$this->comment('Location '.$row[7].' already exists');
			} else {
				$location = new Location();
				$location->name = e($row[7]);
				$location->address = '';
				$location->city = '';
				$location->state = '';
				$location->country = '';
				$location->user_id = 1;

				if (!$this->option('testrun')=='true') {

					if ($location->save()) {
						$this->comment('Location '.$row[7].' was created');
		            } else {
						$this->comment('Something went wrong! Location '.$row[1].' was NOT created');
					}

				} else {
					$this->comment('Location '.$row[7].' was (not) created - test run only');
				}

			}

			// Check for the category match and create it if it doesn't exist
			if ($category = Category::where('name', $row[1])->where('category_type', 'asset')->first()) {
				$this->comment('Category '.$row[1].' already exists');
			} else {
				$category = new Category();
				$category->name = e($row[1]);
				$category->category_type = 'asset';
				$category->user_id = 1;

				if ($category->save()) {
					$this->comment('Category '.$row[1].' was created');
	            } else {
					$this->comment('Something went wrong! Category '.$row[1].' was NOT created');
				}

			}

			// Check for the manufacturer match and create it if it doesn't exist
			if ($manufacturer = Manufacturer::where('name', $row[3])->first()) {
				$this->comment('Manufacturer '.$row[3].' already exists');
			} else {
				$manufacturer = new Manufacturer();
				$manufacturer->name = e($row[3]);
				$manufacturer->user_id = 1;

				if ($manufacturer->save()) {
					$this->comment('Manufacturer '.$row[3].' was created');
	            } else {
					$this->comment('Something went wrong! Manufacturer '.$row[3].' was NOT created');
				}

			}

			// Check for the asset model match and create it if it doesn't exist
			if ($asset_model = Model::where('name', $row[2])->where('modelno', $row[4])->where('category_id', $category->id)->where('manufacturer_id', $manufacturer->id)->first()) {
				$this->comment('The Asset Model '.$row[2].' with model number '.$row[4].' already exists');
			} else {
				$asset_model = new Model();
				$asset_model->name = e($row[2]);
				$asset_model->manufacturer_id = $manufacturer->id;
				$asset_model->modelno = e($row[4]);
				$asset_model->category_id = $category->id;
				$asset_model->user_id = 1;

				if ($asset_model->save()) {
					$this->comment('Asset Model '.$row[2].' with model number '.$row[4].' was created');
	            } else {
					$this->comment('Something went wrong! Asset Model '.$row[2].' was NOT created');
				}

			}

			// Check for the asset match and create it if it doesn't exist

				$asset = new Asset();
				$asset->name = e($row[2]);
				$asset->serial = e($row[5]);
				$asset->asset_tag = e($row[6]);
				$asset->model_id = $asset_model->id;
				$asset->assigned_to = $user->id;
				$asset->rtd_location_id = $location->id;
				$asset->user_id = 1;
				$asset->status_id = $status_id;

				if ($asset->save()) {
					$this->comment('Asset '.$row[2].' with serial number '.$row[5].' was created');
	            } else {
					$this->comment('Something went wrong! Asset '.$row[5].' was NOT created');
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
			array('testrun', null, InputOption::VALUE_REQUIRED, 'Test the output without writing to the database or not.', null),
		);
	}


}
