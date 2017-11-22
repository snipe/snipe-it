<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BaseTest extends \Codeception\TestCase\Test
{
    use DatabaseTransactions;
    protected function _before()
    {
        Artisan::call('migrate');
        factory(App\Models\Setting::class)->create();
    }

    protected function signIn($user = null)
    {
        if (! $user) {
            $user = factory(User::class)->states('superuser')->create();
        }
        Auth::login($user);

        return $user;
    }
}
