<?php

namespace Tests\Unit\BladeComponents;

use App\Models\User;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

class UserFullNameTest extends TestCase
{
    public function testComponent()
    {
        $this->actingAs(User::factory()->viewUsers()->create());

        $user = User::factory()->create(['first_name' => 'Jim', 'last_name' => 'Bagg']);

        $renderedTemplateString = View::make('blade.full-user-name', ['user' => $user])->render();

        $this->assertStringContainsString('<a', $renderedTemplateString);
        $this->assertStringContainsString('Jim Bagg', $renderedTemplateString);
    }
}
