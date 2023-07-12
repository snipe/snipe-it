<?php

namespace Tests;

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use RuntimeException;
use Tests\Support\CustomTestMacros;
use Tests\Support\InteractsWithAuthentication;
use Tests\Support\InteractsWithSettings;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use CustomTestMacros;
    use InteractsWithAuthentication;
    use LazilyRefreshDatabase;

    private array $globallyDisabledMiddleware = [
        SecurityHeaders::class,
    ];

    protected function setUp(): void
    {
        if (!file_exists(realpath(__DIR__ . '/../') . '/.env.testing')) {
            throw new RuntimeException(
                '.env.testing file does not exist. Aborting to avoid wiping your local database'
            );
        }

        parent::setUp();

        $this->withoutMiddleware($this->globallyDisabledMiddleware);

        if (collect(class_uses_recursive($this))->contains(InteractsWithSettings::class)) {
            $this->initializeSettings();
        }

        $this->registerCustomMacros();
    }
}
