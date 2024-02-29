<?php

namespace Tests\Unit\Helpers;

use App\Helpers\Helper;
use Tests\TestCase;

class HelperTest extends TestCase
{
    public function testDefaultChartColorsMethodHandlesHighValues()
    {
        $this->assertIsString(Helper::defaultChartColors(1000));
    }

    public function testDefaultChartColorsMethodHandlesNegativeNumbers()
    {
        $this->assertIsString(Helper::defaultChartColors(-1));
    }
}
