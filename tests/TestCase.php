<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class TestCase extends TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost:8000';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        return $app;
    }


    public function setUp() : void
    {
        parent::setUp();
        \Artisan::call('migrate:fresh');
        $this->seed();
    }

    public function tearDown() : void 
    {
        //Artisan::call('migrate:reset');
        parent::tearDown();
    }
}