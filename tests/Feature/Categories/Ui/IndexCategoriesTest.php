<?php

namespace Tests\Feature\Categories\Ui;

use App\Models\User;
use Tests\TestCase;

final class IndexCategoriesTest extends TestCase
{
    public function testPermissionRequiredToViewCategoryList(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('categories.index'))
            ->assertForbidden();
    }

    public function testUserCanListCategories(): void
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('categories.index'))
            ->assertOk();
    }
}
