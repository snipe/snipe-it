<?php

namespace Tests\Feature\Importing\Ui;

use App\Models\User;
use Tests\TestCase;

class ImportTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('imports.index'))
            ->assertOk();
    }
}
