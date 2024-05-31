<?php

namespace Tests\Feature\Settings;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\TestResponse;
use PDOException;
use Tests\TestCase;

class ShowSetUpPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $_SERVER['REQUEST_URI'] = '/setup';
    }

    protected function getSetUpPageResponse(): TestResponse
    {
        return $this->get('/setup');
    }

    public function testView(): void
    {
        $this->getSetUpPageResponse()->assertOk()->assertViewIs('setup.index');
    }

    public function testWillShowErrorMessageWhenDatabaseConnectionCannotBeEstablished(): void
    {
        Event::listen(function (QueryExecuted $query) {
            if ($query->sql === 'select 2 + 2') {
                throw new PDOException("SQLSTATE[HY000] [1045] Access denied for user ''@'localhost' (using password: NO)");
            }
        });

        $this->getSetUpPageResponse()->assertOk();

        $this->assertSeeDatabaseConnectionErrorMessage();
    }

    protected function assertSeeDatabaseConnectionErrorMessage(bool $shouldSee = true): void
    {
        $errorMessage = "D'oh! Looks like we can't connect to your database. Please update your database settings in your  <code>.env</code> file.";
        $successMessage = sprintf('Great work! Connected to <code>%s</code>', DB::connection()->getDatabaseName());

        if ($shouldSee) {
            self::$latestResponse->assertSee($errorMessage, false)->assertDontSee($successMessage, false);
            return;
        }

        self::$latestResponse->assertSee($successMessage, false)->assertDontSee($errorMessage, false);
    }

    public function testWillNotShowErrorMessageWhenDatabaseIsConnected(): void
    {
        $this->getSetUpPageResponse()->assertOk();

        $this->assertSeeDatabaseConnectionErrorMessage(false);
    }

    public function testWillShowErrorMessageWhenDebugModeIsEnabledAndAppEnvironmentIsSetToProduction(): void
    {
        config(['app.debug' => true]);

        $this->app->bind('env', fn () => 'production');

        $this->getSetUpPageResponse()->assertOk();

        $this->assertSeeDebugModeMisconfigurationErrorMessage();
    }

    protected function assertSeeDebugModeMisconfigurationErrorMessage(bool $shouldSee = true): void
    {
        $errorMessage = 'Yikes! You should turn off debug mode unless you encounter any issues. Please update your <code>APP_DEBUG</code> settings in your  <code>.env</code> file';
        $successMessage = "Awesomesauce. Debug is either turned off, or you're running this in a non-production environment. (Don't forget to turn it off when you're ready to go live.)";

        if ($shouldSee) {
            self::$latestResponse->assertSee($errorMessage, false)->assertDontSee($successMessage, false);
            return;
        }

        self::$latestResponse->assertSee($successMessage, false)->assertDontSee($errorMessage, false);
    }

    public function testWillNotShowErrorWhenDebugModeIsEnabledAndAppEnvironmentIsSetToLocal(): void
    {
        config(['app.debug' => true]);

        $this->app->bind('env', fn () => 'local');

        $this->getSetUpPageResponse()->assertOk();

        $this->assertSeeDebugModeMisconfigurationErrorMessage(false);
    }

    public function testWillNotShowErrorWhenDebugModeIsDisabledAndAppEnvironmentIsSetToProduction(): void
    {
        config(['app.debug' => false]);

        $this->app->bind('env', fn () => 'production');

        $this->getSetUpPageResponse()->assertOk();

        $this->assertSeeDebugModeMisconfigurationErrorMessage(false);
    }

    public function testWillShowErrorWhenEnvironmentIsLocal(): void
    {
        $this->app->bind('env', fn () => 'local');

        $this->getSetUpPageResponse()->assertOk();

        $this->assertSeeEnvironmentMisconfigurationErrorMessage();
    }

    protected function assertSeeEnvironmentMisconfigurationErrorMessage(bool $shouldSee = true): void
    {
        $errorMessage = 'Your app is set <code>local</code> instead of <code>production</code> mode.';
        $successMessage = 'Your app is set to production mode. Rock on!';

        if ($shouldSee) {
            self::$latestResponse->assertSee($errorMessage, false)->assertDontSee($successMessage, false);

            return;
        }

        self::$latestResponse->assertSee($successMessage, false)->assertDontSee($errorMessage, false);
    }

    public function testWillNotShowErrorWhenEnvironmentIsProduction(): void
    {
        $this->app->bind('env', fn () => 'production');

        $this->getSetUpPageResponse()->assertOk();

        $this->assertSeeEnvironmentMisconfigurationErrorMessage(false);
    }
}
