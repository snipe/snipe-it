<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testUserCanLoadLoginPage(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Login');
        });
    }

    /**
     * A basic browser test example.
     */
    public function testUserCanLoginAndSeeDashboard(): void
    {
        $user = User::factory()->superuser()->create([
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout();

            $browser->visit('/login')
                ->type('username', $user->username)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/')
                ->assertSeeIn('.pagetitle', 'Dashboard')
                ->assertSeeIn('.alert-success', 'Success')
                ->assertNotPresent('.alert-danger');

            $browser->logout();
        });


    }

    /**
     * A basic browser test example.
     */
    public function testRegularUserCanLoginAndSeeProfile(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->logout()
                ->visit('/login')
                ->type('username', $user->username)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/account/view-assets')
                ->assertSeeIn('.pagetitle', 'Hello')
                ->assertNotPresent('.alert-danger')
                ->logout();
        });
    }
}
