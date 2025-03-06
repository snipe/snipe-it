<?php

namespace Tests\Feature\Modals\Ui;

use App\Models\User;
use Tests\TestCase;

class ShowModalsTest extends TestCase
{
    public function testUserModalRenders()
    {
        $this->actingAs(User::factory()->createUsers()->create())
            ->get('modals/user')
            ->assertOk();
    }

    public function testDepartmentModalRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/model')
            ->assertOk();
    }

    public function testStatusLabelModalRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/statuslabel')
            ->assertOk();
    }

    public function testLocationModalRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/location')
            ->assertOk();
    }

    public function testCategoryModalRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/category')
            ->assertOk();
    }

    public function testManufacturerModalRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/manufacturer')
            ->assertOk();
    }

    public function testSupplierModalRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/supplier')
            ->assertOk();
    }


}
