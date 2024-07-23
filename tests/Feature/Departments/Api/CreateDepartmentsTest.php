<?php

namespace Tests\Feature\Departments\Api;

use App\Models\AssetModel;
use App\Models\Department;
use App\Models\Category;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CreateDepartmentsTest extends TestCase
{


    public function testRequiresPermissionToCreateDepartment()
    {
        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.departments.store'))
            ->assertForbidden();
    }

}
