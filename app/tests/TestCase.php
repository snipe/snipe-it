<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Default preparation for each test
	 *
	 */
	public function setUp()
	{
		parent::setUp(); // Don't forget this!

		$this->prepareForTests();
	}


	/**
	 * Creates the application.
	 *
	 * @return Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	/**
	 * Migrates the database and set the mailer to 'pretend'.
	 * This will cause the tests to run quickly.
	 *
	 */
	private function prepareForTests()
	{
		Artisan::call('migrate');
		Mail::pretend(true);
	}

}
