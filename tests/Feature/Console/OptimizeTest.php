<?php

namespace Tests\Feature\Console;

use Tests\TestCase;

final class OptimizeTest extends TestCase
{
    public function testOptimizeSucceeds(): void
    {
        $this->beforeApplicationDestroyed(function () {
            $this->artisan('config:clear');
            $this->artisan('route:clear');
        });

        $this->artisan('optimize')->assertSuccessful();
    }
}
