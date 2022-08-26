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

The browser tests use [Dusk](https://laravel.com/docs/8.x/dusk) to run them.
When troubleshooting any problems, make sure that your `.env` file is configured
correctly to run the existing application.

### Test Setup

Your application needs to be configued and up and running in order for the browser
tests to actually run. When running the tests locally, you can start the application
using the following command:

`php artisan serve`


To run the test suite use the following command from another terminal tab or window:

`php artisan dusk`

To run individual test files, you can pass the path to the test that you want to run.

`php artisan dusk tests/Browser/LoginTest.php`
