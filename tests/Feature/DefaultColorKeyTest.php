<?php

namespace Tests\Feature;

use App\Models\Statuslabel;
use Tests\TestCase;
use App\Models\Asset;

class DefaultColorKeyTest extends TestCase
{
    public function DefaultColorKeyTest()
    {
        Statuslabel::factory()->hasAssets(1)->count(255)->create();

        $this->defaultChartColors($index);

        $this->assertArrayHasKey('index', ($index)[0]);


    }
}
