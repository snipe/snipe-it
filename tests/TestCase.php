<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://snipe-it5.dev:8888';

    function __construct()
    {
        parent::createApplication();
        parent::setUp();
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        putenv('DB_DEFAULT=sqlite');
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }

    public function setUp()
    {
        Artisan::call('migrate');
        parent::setUp();
        //Artisan::call('migrate');
    }

    public function tearDown()
    {
        //Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
