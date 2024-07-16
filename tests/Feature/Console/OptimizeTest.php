<?php

namespace Tests\Feature\Console;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class OptimizeTest extends TestCase
{
    public function testOptimizeSucceeds()
    {
        $this->artisan('optimize')->assertSuccessful();
    }
}
