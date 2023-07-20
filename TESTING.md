# Running the Test Suite

This document is targeted at developers looking to make modifications to this application's code base and want to run the existing test suite.

Before starting, follow the [instructions](README.md#installation) for installing the application locally and ensure you can load it in a browser properly.

## Unit and Feature Tests

Before attempting to run the test suite copy the example environment file for tests and update the values to match your environment:

`cp .env.testing.example .env.testing`
> Since the data in the database is flushed after each test it is recommended you create a separate mysql database for specifically for tests

Now you are ready to run the entire test suite from your terminal:

`php artisan test`

To run individual test files, you can pass the path to the test that you want to run:

`php artisan test tests/Unit/AccessoryTest.php`

## Browser Tests 

Browser tests are run via [Laravel Dusk](https://laravel.com/docs/8.x/dusk) and require Google Chrome to be installed.

Before attempting to run Dusk tests copy the example environment file for Dusk and update the values to match your environment:

`cp .env.dusk.example .env.dusk.local`
> `local` refers to the value of `APP_ENV` in your `.env` so if you have it set to `dev` then the file should be named `.env.dusk.dev`.

**Important**: Dusk tests cannot be run using an in-memory SQLite database. Additionally, the Dusk test suite uses the `DatabaseMigrations` trait which will leave the database in a fresh state after running. Therefore, it is recommended that you create a test database and point `DB_DATABASE` in `.env.dusk.local` to it.  

### Running Browser Tests

Your application needs to be configured and up and running in order for the browser tests to actually run. When running the tests locally, you can start the application using the following command:

`php artisan serve`

Now you are ready to run the test suite. Use the following command from another terminal tab or window:

`php artisan dusk`

To run individual test files, you can pass the path to the test that you want to run:

`php artisan dusk tests/Browser/LoginTest.php`

If you get an error when attempting to run Dusk tests that says `Couldn't connect to server` run:

`php artisan dusk:chrome-driver --detect`

This command will install the specific ChromeDriver Dusk needs for your operating system and Chrome version.
