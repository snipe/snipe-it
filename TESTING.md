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
