<?php

namespace Tests;

use App\Http\Middleware\SecurityHeaders;
use App\Models\Setting;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use LazilyRefreshDatabase;

    private array $globallyDisabledMiddleware = [
        SecurityHeaders::class,
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->beforeApplicationDestroyed(fn() => Setting::$_cache = null);

        $this->withoutMiddleware($this->globallyDisabledMiddleware);
    }
}
