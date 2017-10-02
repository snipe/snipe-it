<?php
namespace Helper;

use Illuminate\Support\Facades\Artisan;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{
    public function setupDatabase()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }
}
