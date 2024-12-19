<?php

namespace Tests\Feature\Licenses\Ui;

use App\Models\License;
use App\Models\User;
use Tests\TestCase;

class UpdateLicenseTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('licenses.update', License::factory()->create()->id))
            ->assertOk();
    }
}
