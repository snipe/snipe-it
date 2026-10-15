<?php

namespace Tests\Feature\Modals\Ui;

use App\Models\User;
use Tests\TestCase;

class ShowModalsTest extends TestCase
{
    public function test_user_modal_renders()
    {
        // Force distinctive attribute values here rather than accepting the
        // Faker defaults. assertDontSee does a substring check on the entire
        // response body, so a Faker-generated first name of "Gene" collides
        // with legitimate modal text like "Generate Password" and produces a
        // false-positive failure. The strings below cannot appear inside any
        // translated label, class name, or DOM attribute in the modal.
        $admin = User::factory()->createUsers()->create([
            'first_name' => 'ZzModalTestFirst',
            'last_name' => 'ZzModalTestLast',
            'email' => 'zz-modal-test@example.invalid',
        ]);

        $response = $this->actingAs($admin)
            ->get('modals/user')
            ->assertOk();

        $response->assertStatus(200);
        $response->assertDontSee($admin->first_name);
        $response->assertDontSee($admin->last_name);
        $response->assertDontSee($admin->email);
    }

    public function test_department_modal_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/model')
            ->assertOk();
    }

    public function test_status_label_modal_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/statuslabel')
            ->assertOk();
    }

    public function test_location_modal_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/location')
            ->assertOk();
    }

    public function test_kit_model_modal_renders()
    {
        $kit = \App\Models\PredefinedKit::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('modal.show', ['type' => 'kit-model', 'itemId' => $kit->id]))
            ->assertOk()
            ->assertSee(route('api.kits.models.store', $kit->id));
    }

    public function test_kit_license_modal_renders()
    {
        $kit = \App\Models\PredefinedKit::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('modal.show', ['type' => 'kit-license', 'itemId' => $kit->id]))
            ->assertOk()
            ->assertSee(route('api.kits.licenses.store', $kit->id));
    }

    public function test_kit_accessory_modal_renders()
    {
        $kit = \App\Models\PredefinedKit::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('modal.show', ['type' => 'kit-accessory', 'itemId' => $kit->id]))
            ->assertOk()
            ->assertSee(route('api.kits.accessories.store', $kit->id));
    }

    public function test_kit_consumable_modal_renders()
    {
        $kit = \App\Models\PredefinedKit::factory()->create();

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('modal.show', ['type' => 'kit-consumable', 'itemId' => $kit->id]))
            ->assertOk()
            ->assertSee(route('api.kits.consumables.store', $kit->id));
    }

    public function test_category_modal_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/category')
            ->assertOk();
    }

    public function test_company_modal_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/company')
            ->assertOk()
            ->assertSee(route('api.companies.store'))
            ->assertSee(trans('admin/companies/table.create'));
    }

    public function test_manufacturer_modal_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/manufacturer')
            ->assertOk();
    }

    public function test_supplier_modal_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get('modals/supplier')
            ->assertOk();
    }
}
