<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AppCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var	string
	 */
	protected $name = 'app:install';

	/**
	 * The console command description.
	 *
	 * @var	string
	 */
	protected $description = '';

	/**
	 * Holds the user information.
	 *
	 * @var array
	 */
	protected $userData = array(
		'first_name' => null,
		'last_name'  => null,
		'email'      => null,
		'password'   => null
	);

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
	 * @return void
	 */
	public function fire()
	{
		$this->comment('=====================================');
		$this->comment('');
		$this->info('  Step: 1');
		$this->comment('');
		$this->info('    Please follow the following');
		$this->info('    instructions to create your');
		$this->info('    default user.');
		$this->comment('');
		$this->comment('-------------------------------------');
		$this->comment('');


		// Let's ask the user some questions, shall we?
		$this->askUserFirstName();
		$this->askUserLastName();
		$this->askUserEmail();
		$this->askUserPassword();


		$this->comment('');
		$this->comment('');
		$this->comment('=====================================');
		$this->comment('');
		$this->info('  Step: 2');
		$this->comment('');
		$this->info('    Preparing your Application');
		$this->comment('');
		$this->comment('-------------------------------------');
		$this->comment('');

		// Generate the Application Encryption key
		$this->call('key:generate');

		// Create the migrations table
		$this->call('migrate:install');

		// Run the Sentry Migrations
		$this->call('migrate', array('--package' => 'cartalyst/sentry'));

		// Run the Migrations
		$this->call('migrate');

		// Create the default user and default groups.
		$this->sentryRunner();

		// Seed the tables with dummy data
		$this->call('db:seed');
	}

	/**
	 * Asks the user for the first name.
	 *
	 * @return void
	 * @todo   Use the Laravel Validator
	 */
	protected function askUserFirstName()
	{
		do
		{
			// Ask the user to input the first name
			$first_name = $this->ask('Please enter your first name: ');

			// Check if the first name is valid
			if ($first_name == '')
			{
				// Return an error message
				$this->error('Your first name is invalid. Please try again.');
			}

			// Store the user first name
			$this->userData['first_name'] = $first_name;
		}
		while( ! $first_name);
	}

	/**
	 * Asks the user for the last name.
	 *
	 * @return void
	 * @todo   Use the Laravel Validator
	 */
	protected function askUserLastName()
	{
		do
		{
			// Ask the user to input the last name
			$last_name = $this->ask('Please enter your last name: ');

			// Check if the last name is valid.
			if ($last_name == '')
			{
				// Return an error message
				$this->error('Your last name is invalid. Please try again.');
			}

			// Store the user last name
			$this->userData['last_name'] = $last_name;
		}
		while( ! $last_name);
	}

	/**
	 * Asks the user for the user email address.
	 *
	 * @return void
	 * @todo   Use the Laravel Validator
	 */
	protected function askUserEmail()
	{
		do
		{
			// Ask the user to input the email address
			$email = $this->ask('Please enter your user email: ');

			// Check if email is valid
			if ($email == '')
			{
				// Return an error message
				$this->error('Email is invalid. Please try again.');
			}

			// Store the email address
			$this->userData['email'] = $email;
		}
		while ( ! $email);
	}

	/**
	 * Asks the user for the user password.
	 *
	 * @return void
	 * @todo   Use the Laravel Validator
	 */
	protected function askUserPassword()
	{
		do
		{
			// Ask the user to input the user password
			$password = $this->ask('Please enter your user password (at least 8 characters): ');

			// Check if email is valid
			if ($password == '')
			{
				// Return an error message
				$this->error('Password is invalid. Please try again.');
			}

			// Store the password
			$this->userData['password'] = $password;
		}
		while( ! $password);
	}

	/**
	 * Runs all the necessary Sentry commands.
	 *
	 * @return void
	 */
	protected function sentryRunner()
	{
		// Create the default groups
		$this->sentryCreateDefaultGroups();

		// Create the user
		$this->sentryCreateUser();

		// Create dummy user
		$this->sentryCreateDummyUser();
	}

	/**
	 * Creates the default groups.
	 *
	 * @return void
	 */
	protected function sentryCreateDefaultGroups()
	{
		try
		{
			// Create the admin group
			$group = Sentry::getGroupProvider()->create(array(
				'name'        => 'Admin',
				'permissions' => array(
					'admin' => 1,
					'users' => 1
				)
			));

			// Show the success message.
			$this->comment('');
			$this->info('Admin group created successfully.');
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			$this->error('Group already exists.');
		}



		try
		{
			// Create the reporting group
			$group = Sentry::getGroupProvider()->create(array(
				'name'        => 'Reporting',
				'permissions' => array(
					'admin' => 0,
					'users' => 1
				)
			));

			// Show the success message.
			$this->comment('');
			$this->info('Reporting group created successfully.');
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			$this->error('Group already exists.');
		}


		try
		{
			// Create the general users group
			$group = Sentry::getGroupProvider()->create(array(
				'name'        => 'Users',
				'permissions' => array(
					'admin' => 0,
					'users' => 1
				)
			));

			// Show the success message.
			$this->comment('');
			$this->info('Users group created successfully.');
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			$this->error('Group already exists.');
		}
	}

	/**
	 * Create the user and associates the admin group to that user.
	 *
	 * @return void
	 */
	protected function sentryCreateUser()
	{
		// Prepare the user data array.
		$data = array_merge($this->userData, array(
			'activated'   => 1,
			'manager_id'  => NULL,
			'permissions' => array(
				'admin' => 1,
				'user'  => 1,
			),
		));

		// Create the user
		$user = Sentry::getUserProvider()->create($data);

		// Associate the Admin group to this user
		$group = Sentry::getGroupProvider()->findById(1);
		$user->addGroup($group);

		// Show the success message
		$this->comment('');
		$this->info('Your user was created successfully.');
		$this->comment('');
	}

	/**
	 * Create a dummy user.
	 *
	 * @return void
	 */
	protected function sentryCreateDummyUser()
	{
		// Prepare the user data array.
		$data = array(
			'first_name' => 'John',
			'last_name'  => 'Doe',
			'email'      => 'john.doe@example.com',
			'password'   => 'johndoe',
			'activated'  => 1,
			'manager_id'  => 1,
		);

		// Create the user
		Sentry::getUserProvider()->create($data);
	}

}
