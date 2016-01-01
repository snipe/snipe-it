
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

			$user_name = $this->array_smart_fetch($row,"name");
			$user_email = $this->array_smart_fetch($row,"email");
			$user_username = $this->array_smart_fetch($row,"username");
			$asset_name = $this->array_smart_fetch($row,"item name");
			$asset_category = $this->array_smart_fetch($row, "category");
			$asset_model_name = $this->array_smart_fetch($row, "model name");
			$asset_mfgr = $this->array_smart_fetch($row, "manufacturer");
			$asset_modelno = $this->array_smart_fetch($row, "model number");
			$asset_serial = $this->array_smart_fetch($row, "serial number");
			$asset_tag = $this->array_smart_fetch($row, "asset tag");
			$asset_location = $this->array_smart_fetch($row, "location");
			$asset_notes = $this->array_smart_fetch($row, "notes");
			$asset_purchase_date = $this->array_smart_fetch($row, "purchase date");
			$asset_purchase_cost = $this->array_smart_fetch($row, "purchase cost");
			$asset_company_name = $this->array_smart_fetch($row, "company name");


			// A number was given instead of a name
			if (is_numeric($user_name)) {
				$this->comment('User '.$user_name.' is a number - Assuming UID - hopefully this user already exists');
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

			$user = $this->createOrFetchUser($user_username, $user_email, $first_name, $last_name);
			$location = $this->createOrFetchLocation($asset_location);
			$category = $this->createOrFetchCategory($asset_category);
			$manufacturer = $this->createOrFetchManufacturer($asset_mfgr);
			// Check for the asset model match and create it if it doesn't exist
			$asset_model = $this->createOrFetchAssetModel($asset_model_name, $asset_modelno, $category, $manufacturer);
			$company = $this->createOrFetchCompany($asset_company_name);
			$this->createAssetIfNotExists($asset_tag, $asset_name, $asset_purchase_date, $asset_purchase_cost,
				$asset_serial, $asset_model, $user, $location, $status_id, $company, $asset_notes);


			$this->comment('=====================================');

			return true;

		}


	}

	/**
	 * Check to see if the given key exists in the array, and trim excess white space before returning it
	 * @param array $array
	 * @param $key Value which may or may not exist as a key in $array
	 * @param string $default Value to return if key doesn't exist in database
	 * @return string Value associated with $key if it exists, otherwise $default
     */
	public function array_smart_fetch(Array $array, $key, $default = ''){
		return array_key_exists($key,$array) ? trim($array[ $key ]) : $default;
	}

	/**
	 * @param $asset_location
	 * @return Location
	 */
	public function createOrFetchLocation($asset_location)
	{
// Check for the location match and create it if it doesn't exist
		if ($location = Location::where('name', $asset_location)->first()) {
			$this->comment('Location ' . $asset_location . ' already exists');
			return $location;
		} else {

			$location = new Location();

			if ($asset_location != '') {


				$location->name = e($asset_location);
				$location->address = '';
				$location->city = '';
				$location->state = '';
				$location->country = '';
				$location->user_id = 1;

				if (!$this->option('testrun') == 'true') {

					if ($location->save()) {
						$this->comment('Location ' . $asset_location . ' was created');
						return $location;
					} else {
						$this->comment('Something went wrong! Location ' . $asset_location . ' was NOT created');
						return $location;
					}

				} else {
					$this->comment('Location ' . $asset_location . ' was (not) created - test run only');
					return $location;
				}
			} else {
				$this->comment('No location given, so none created.');
				return $location;
			}

		}
	}

	/**
	 * @param $user_username
	 * @param $user_email
	 * @param $first_name
	 * @param $last_name
	 * @return User
	 */
	public function createOrFetchUser($user_username, $user_email, $first_name, $last_name)
	{
		if (!empty($user_username)) {
			if ($user = User::MatchEmailOrUsername($user_username, $user_email)
				->whereNotNull('username')->first()
			) {
				$this->comment('User ' . $user_username . ' already exists');
				return $user;
			} else {
				// Create the user
				$user = Sentry::createUser(array(
					'first_name' => $first_name,
					'last_name' => $last_name,
					'email' => $user_email,
					'username' => $user_username,
					'password' => substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 12),
					'activated' => true,
					'permissions' => array(
						'admin' => 0,
						'user' => 1,
					),
					'notes' => 'User imported through asset importer'
				));

				// Find the group using the group id
				$userGroup = Sentry::findGroupById(3);

				// Assign the group to the user
				$user->addGroup($userGroup);
				$this->comment('User ' . $first_name . ' created');
				return $user;
			}
		} else {
			$user = new User;
			return $user;
		}
	}

	/**
	 * @param $asset_category
	 * @return Category
	 */
	public function createOrFetchCategory($asset_category)
	{
		if (e($asset_category) == '') {
			$category_name = 'Unnamed Category';
		} else {
			$category_name = e($asset_category);
		}

		// Check for the category match and create it if it doesn't exist
		if ($category = Category::where('name', $category_name)->where('category_type', 'asset')->first()) {
			$this->comment('Category ' . $category_name . ' already exists');
			return $category;

		} else {
			$category = new Category();

			$category->name = $category_name;
			$category->category_type = 'asset';
			$category->user_id = 1;

			if ($category->save()) {
				$this->comment('Category ' . $asset_category . ' was created');
				return $category;
			} else {
				$this->comment('Something went wrong! Category ' . $asset_category . ' was NOT created');
				return $category;
			}

		}
	}

	/**
	 * @param $asset_mfgr
	 * @return Manufacturer
	 */
	public function createOrFetchManufacturer($asset_mfgr)
	{
// Check for the manufacturer match and create it if it doesn't exist
		if ($manufacturer = Manufacturer::where('name', $asset_mfgr)->first()) {
			$this->comment('Manufacturer ' . $asset_mfgr . ' already exists');
			return $manufacturer;
		} else {
			$manufacturer = new Manufacturer();
			$manufacturer->name = e($asset_mfgr);
			$manufacturer->user_id = 1;

			if ($manufacturer->save()) {
				$this->comment('Manufacturer ' . $asset_mfgr . ' was created');
				return $manufacturer;
			} else {
				$this->comment('Something went wrong! Manufacturer ' . $asset_mfgr . ' was NOT created');
				return $manufacturer;
			}

		}
	}

	/**
	 * @param $asset_model_name
	 * @param $asset_modelno
	 * @param $category
	 * @param $manufacturer
	 * @return Model
	 */
	public function createOrFetchAssetModel($asset_model_name, $asset_modelno, $category, $manufacturer)
	{
		if ($asset_model = Model::where('name', $asset_model_name)->where('modelno', $asset_modelno)->where('category_id', $category->id)->where('manufacturer_id', $manufacturer->id)->first()) {
			$this->comment('The Asset Model ' . $asset_model_name . ' with model number ' . $asset_modelno . ' already exists');
			return $asset_model;
		} else {
			$asset_model = new Model();
			$asset_model->name = e($asset_model_name);
			$asset_model->manufacturer_id = $manufacturer->id;
			$asset_model->modelno = e($asset_modelno);
			$asset_model->category_id = $category->id;
			$asset_model->user_id = 1;

			if ($asset_model->save()) {
				$this->comment('Asset Model ' . $asset_model_name . ' with model number ' . $asset_modelno . ' was created');
				return $asset_model;
			} else {
				$this->comment('Something went wrong! Asset Model ' . $asset_model_name . ' was NOT created');
				return $asset_model;
			}

		}
	}

	/**
	 * @param $asset_company_name
	 * @return Company
	 */
	public function createOrFetchCompany($asset_company_name)
	{
// Check for the asset company match and create it if it doesn't exist
		if ($company = Company::where('name', $asset_company_name)->first()) {
			$this->comment('Company ' . $asset_company_name . ' already exists');
			return $company;
		} else {
			$company = new Company();
			$company->name = e($asset_company_name);

			if ($company->save()) {
				$this->comment('Company ' . $asset_company_name . ' was created');
				return $company;
			} else {
				$this->comment('Something went wrong! Company ' . $asset_company_name . ' was NOT created');
				return $company;
			}
		}
	}

	/**
	 * @param $asset_tag
	 * @param $asset_name
	 * @param $asset_purchase_date
	 * @param $asset_purchase_cost
	 * @param $asset_serial
	 * @param $asset_model
	 * @param $user
	 * @param $location
	 * @param $status_id
	 * @param $company
	 * @param $asset_notes
	 */
	public function createAssetIfNotExists($asset_tag, $asset_name, $asset_purchase_date, $asset_purchase_cost, $asset_serial,
										   $asset_model, $user, $location, $status_id, $company, $asset_notes)
	{
// Check for the asset match and create it if it doesn't exist
		if ($asset = Asset::where('asset_tag', $asset_tag)->first()) {
			$this->comment('The Asset with asset tag ' . $asset_tag . ' already exists');
		} else {
			$asset = new Asset();
			$asset->name = e($asset_name);
			if ($asset_purchase_date != '') {
				$asset->purchase_date = $asset_purchase_date;
			} else {
				$asset->purchase_date = NULL;
			}
			if ($asset_purchase_cost != '') {
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
			if ($asset_purchase_date != '') {
				$asset->purchase_date = $asset_purchase_date;
			} else {
				$asset->purchase_date = NULL;
			}
			$asset->notes = e($asset_notes);

			if ($asset->save()) {
				$this->comment('Asset ' . $asset_name . ' with serial number ' . $asset_serial . ' was created');
			} else {
				$this->comment('Something went wrong! Asset ' . $asset_name . ' was NOT created');
			}

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