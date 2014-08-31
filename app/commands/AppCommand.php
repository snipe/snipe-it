<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AppCommand extends Command
{
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
    
    protected $locationData = array(
        'name' => null,
        'address' => null,
        'city' => null,
        'state' => null,
        'country' => null
    );
    
    protected $entityData = array(
        'name' => null,
        'common_name'  => null,
    );
    
    protected $countryData = array(
        'value' => null,
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
        // Generate the Application Encryption key
        $this->call('key:generate');

        // Create the migrations table
        $this->call('migrate:install');

        // Run the Sentry Migrations
        $this->call('migrate', array('--package' => 'cartalyst/sentry'));

        // Run the Migrations
        $this->call('migrate');
        
        // Seed the tables with dummy data
        $this->call('db:seed');
        
        
        $this->comment('=====================================');
        $this->comment('');
        $this->info('  Step: 1');
        $this->comment('');
        $this->info('    Please answer the following');
        $this->info('    to create an initial admin user:');
        $this->comment('');
        $this->comment('-------------------------------------');
        $this->comment('');
        
        // Let's ask the user some questions, shall we?
        $this->askUserFirstName();
        $this->askUserLastName();
        $this->askUserEmail();
        $this->askUserPassword();

        
        $this->comment('');
        $this->comment('=====================================');
        $this->comment('');
        $this->info('  Step: 2');
        $this->comment('');
        $this->info('    Please answer the following');
        $this->info('    to setup your company information:');
        $this->comment('');
        $this->comment('-------------------------------------');
        $this->comment('');
        $this->askEntityName();
        $this->comment('');
        $this->askEntityCommonName();   
        $this->comment('');
        $this->comment('-------------------------------------');
        $this->comment('');
        $this->askLocationName();
        $this->comment('');
        $this->askLocationAddress();
        $this->comment('');
        $this->askLocationCity();
        $this->comment('');
        $this->askLocationState();
        $this->comment('');
        $this->askLocationCountry();  
        $this->comment('');
        $this->comment('');
        
        
        $this->comment('=====================================');
        $this->comment('');
        $this->info('  Step: 3');
        $this->comment('');
        $this->info('    Preparing the application');
        $this->comment('');
        $this->comment('-------------------------------------');
        $this->comment('');

        // Add the initial entity information
        $this->addEntity();
        
        // Add the initial location information
        $this->addLocation();
        
        // Add default country record
        $this->addDefaultCountry();
        
        // Create the default user and default groups.
        $this->sentryRunner();

    }

    /**
     * Asks the user for the first name.
     *
     * @return void
     * @todo   Use the Laravel Validator
     */
    protected function askUserFirstName()
    {
        do {
            // Ask the user to input the first name
            $first_name = $this->ask('Please enter your first name: ');

            // Check if the first name is valid
            if ($first_name == '') {
                // Return an error message
                $this->error('First name is required. Please enter min 3 characters.');
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
        do {
            // Ask the user to input the last name
            $last_name = $this->ask('Please enter your last name: ');

            // Check if the last name is valid.
            if ($last_name == '') {
                // Return an error message
                $this->error('Last name is required. Please enter min 3 characters');
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
        do {
            // Ask the user to input the email address
            $email = $this->ask('Please enter your logon email: ');

            // Check if email is valid
            if ($email == '') {
                // Return an error message
                $this->error('Email address is required. Please enter an email address.');
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
        do {
            // Ask the user to input the user password
            $password = $this->ask('Please enter your logon password (min 6 characters): ');

            // Check if email is valid
            if ($password == '') {
                // Return an error message
                $this->error('Password is required. Please enter min 6 characters.');
            }

            // Store the password
            $this->userData['password'] = $password;
        } while( ! $password);
    }

    
    protected function askLocationName()
    {
        do {
            // Ask the user to input the initial location
            $location = $this->ask('Please enter descriptive location name (min 3 characters, eg. \'Main Office\'): ');

            // Check if email is valid
            if ($location == '') {
                // Return an error message
                $this->error('Location name is required. Please enter min 3 characters.');
            }

            // Store the password
            $this->locationData['name'] = $location;
        } while( ! $location);
    }

    protected function askLocationAddress()
    {
        do {
            // Ask the user to input the initial location
            $address = $this->ask('Please enter your location address (optional): ');

            // Check if address is valid
            if ($address == '') {
                // Return an error message
                //$this->error('The address you entered is invalid. Please try again.');
                $address = ' ';
            }

            // Store the address
            $this->locationData['address'] = $address;
        } while( ! $address);
    }

    protected function askLocationCity()
    {
        do {
            // Ask the user to input the initial location
            $city = $this->ask('Please enter your location city (optional): ');

            // Check if city is valid
            if ($city == '') {
                // Return an error message
                //$this->error('The city you entered is invalid. Please try again.');
                $city = ' ';
            }

            // Store the city
            $this->locationData['city'] = $city;
        } while( ! $city);
    }

    protected function askLocationState()
    {
        do {
            // Ask the user to input the initial location
            $state = $this->ask('Please enter your state or province (optional): ');

            // Check if state is valid
            if ($state == '') {
                // Return an error message
                //$this->error('The state you entered is invalid. Please try again.');
                $state = ' ';
            }

            // Store the state
            $this->locationData['state'] = $state;
        } while( ! $state);
    }
 
    protected function askLocationCountry()
    {
          do {
            // Ask the user to input the initial location
            $country = $this->ask('Please enter your country 2-letter ISO code (2 characters): ');

            // Check if country is entered
            if ($country == '') {
                // Return an error message
                $this->error('Country code is required. Please enter a country code.');
            }

           // $results = DB::select('select id from countries where code = ?', array($country));
            $countryid = DB::table('countries')->where('code','=',$country)->pluck('id');

            if ( ! $countryid ) {
                // Return an error message
                $country = NULL;
                $this->error('The country code entered is invalid. Please enter a valid ISO country code.');
            }
            else {
                $this->locationData['country'] = $country;
                $this->countryData['value'] = $countryid;
            }

        } while( ! $country);

    }
    
    protected function askEntityName()
    {
        do {
            // Ask the user to input the initial location
            $entity = $this->ask('Please enter full company name (min 3 characters, eg. \'Venture Enterprises Ltd.\'): ');

            // Check if email is valid
            if ($entity == '') {
                // Return an error message
                $this->error('Company name is required. Please enter min 3 characters.');
            }

            // Store the entity name
            $this->entityData['name'] = $entity;
            
        } while( ! $entity);
    }
    
    protected function askEntityCommonName()
    {
        do {
            
            // Ask the user to input the initial location
            $entitycommon = $this->ask('Please enter your company short, common name (optional): ');

            // Check if email is valid
            if ($entitycommon == '') {
                // Return an error message
                //$this->error('Entity common name is invalid. Please try again.');
                $entitycommon = $this->entityData['name'];
            }

            // Store the entity common name
            $this->entityData['common_name'] = $entitycommon;
            
        } while( ! $entitycommon);
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
     * Add the country default
     *
     * @return void
     */
    protected function addDefaultCountry()
    {

        // Prepare the location data array.
        $data = array_merge($this->countryData, array(
                'name' => 'country',
                'table_name' => 'locations',
                'column_name' => 'country',
                'source_table' => 'countries',
                'user_id' => '1',
            ));
        DB::table('defaults')->insert($data);
        
    }
    
    /**
     * Add the initial location
     *
     * @return void
     */
    protected function addLocation()
    {

        // Prepare the location data array.
        $data = array_merge($this->locationData, array(
                'entity_id' => '1',
                'user_id' => '1'
            ));
        DB::table('locations')->insert($data);
        
    }
    
    /**
     * Add the initial entity
     *
     * @return void
     */
    protected function addEntity()
    {
    
        // Prepare the location data array.
        $data = array_merge($this->entityData, array(
                'user_id' => '1',
                'notes' => 'Added by installation'
            ));
        
        DB::table('entities')->insert($data);
        
    }

    /**
     * Creates the default groups.
     *
     * @return void
     */
    protected function sentryCreateDefaultGroups()
    {
        try {
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
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            $this->error('Group already exists.');
        }



        try {
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
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            $this->error('Group already exists.');
        }


        try {
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
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
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
