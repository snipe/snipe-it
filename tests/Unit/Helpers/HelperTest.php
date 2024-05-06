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

    public function testParseCurrencyMethod()
    {
        $this->settings->set(['default_currency' => 'USD']);
        $this->assertSame(12.34, Helper::ParseCurrency('USD 12.34'));

        $this->settings->set(['digit_separator' => '1.234,56']);
        $this->assertSame(12.34, Helper::ParseCurrency('12,34'));
    }
}
