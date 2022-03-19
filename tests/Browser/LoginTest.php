<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
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
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('login')
                ->assertSee(trans('auth/general.login_prompt'));
        });

        $this->browse(function ($browser) {
            $browser->visitRoute('login')
                    ->type('username', 'snipe')
                    ->type('password', 'password')
                    ->press(trans('auth/general.login'))
                    ->assertPathIs('/');
            $browser->screenshot('dashboard'); 
        });
    }


    /**
     * Test dashboard loads
     * 
     * @todo Flesh this out further to make sure the individual tables actually load with
     * content inside them.
     *
     * @return void
     */
    public function testDashboardLoadsWithSuperAdmin()
    {
        $this->browse(function ($browser) {
            $browser->assertSee(trans('general.dashboard'));
            $browser->assertSee(trans('general.loading'));
            $browser->screenshot('dashboard-2'); 
        });
        
    }
}
