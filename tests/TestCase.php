<?php

namespace Tests;

use App\Http\Middleware\SecurityHeaders;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Support\InteractsWithSettings;
use Tests\Support\Settings;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    protected Settings $settings;

    private array $globallyDisabledMiddleware = [
        SecurityHeaders::class,
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware($this->globallyDisabledMiddleware);

        if (in_array(InteractsWithSettings::class, class_uses_recursive($this))) {
            $this->settings = Settings::initialize();
        }
    }
}
