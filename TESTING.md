# Using the Test Suite

This document is targeted at developers looking to make modifications to
this application's code base and want to run the existing test suite.


## Setup

Follow the instructions for installing the application locally,
making sure to have also run the [database migrations](link to db migrations).


## Unit Tests 

The application will use values in the `.env.testing` file located
in the root directory to override the
default settings and/or other values that exist in your `.env` files.

Make sure to modify the section in `.env.testing` that has the
database settings. In the example below, it is connecting to the
[MariaDB](link-to-maria-db) server that is used if you install the
application using [Docker](https://docker.com).

```dotenv
# --------------------------------------------
# REQUIRED: DATABASE SETTINGS
# --------------------------------------------
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=snipeit
DB_USERNAME=root
DB_PASSWORD=changeme1234
```

To run the entire unit test suite, use the following command from your terminal:

`php artisan test --env=testing`

To run individual test files, you can pass the path to the test that
you want to run.

`php artisan test --env=testing tests/Unit/AccessoryTest.php`

## Browser Tests 

Browser tests are run via [Laravel Dusk](https://laravel.com/docs/8.x/dusk) and require Google Chrome to be installed.

Before attempting to run Dusk tests copy the example environment file for Dusk and update the values to match your environment:

`cp .env.dusk.example .env.dusk.local`
> `local` refers to the value of `APP_ENV` in your `.env` so if you have it set to `dev` then the file should be named `.env.dusk.dev`.

**Important**: Dusk tests cannot be run using an in-memory SQLite database. Additionally, the Dusk test suite uses the `DatabaseMigrations` trait which will leave the database in a fresh state after running. Therefore, it is recommended that you create a test database and point `DB_DATABASE` in `.env.dusk.local` to it.  

### Test Setup

Your application needs to be configured and up and running in order for the browser
tests to actually run. When running the tests locally, you can start the application
using the following command:

`php artisan serve`

Now you are ready to run the test suite. Use the following command from another terminal tab or window:

`php artisan dusk`

To run individual test files, you can pass the path to the test that you want to run:

`php artisan dusk tests/Browser/LoginTest.php`

If you get an error when attempting to run Dusk tests that says `Couldn't connect to server` run:

`php artisan dusk:chrome-driver --detect`

This command will install the specific ChromeDriver Dusk needs for your operating system and Chrome version.
