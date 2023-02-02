<?php

namespace Tests\Browser;

use App\Models\Setting;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * Test login
     *
     * @return void
     */
    public function testLoginPageLoadsAndUserCanLogin()
    {
        // Create a new user
        $user = User::factory()->make();

        // We override the existing password to use a hash of one we know
        $user->password = '$2y$10$8o5W8fgAKJbN3Kz4taepeeRVgKsG8pkZ1L4eJfdEKrn2mgI/JgCJy';

        // We want a user that is a superuser
        $user->permissions = '{"superuser": 1}';

        $user->save();

        Setting::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->assertSee(trans('auth/general.login_prompt'));
        });

        $this->browse(function ($browser) use ($user) {
            $browser->visitRoute('login')
                    ->type('username', $user->username)
                    ->type('password', 'password')
                    ->press(trans('auth/general.login'))
                    ->assertPathIs('/');
            $browser->screenshot('dashboard');
        });
    }
}
