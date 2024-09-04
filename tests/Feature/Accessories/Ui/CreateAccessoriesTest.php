<?php

namespace Tests\Feature\Accessories\Ui;

use App\Models\Category;
use App\Models\Company;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

class CreateAccessoriesTest extends TestCase
{
    public function testRequiresPermissionToViewCreateAccessoryPage()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('accessories.create'))
            ->assertForbidden();
    }

    public function testCreateAccessoryPageRenders()
    {
        $this->actingAs(User::factory()->createAccessories()->create())
            ->get(route('accessories.create'))
            ->assertOk()
            ->assertViewIs('accessories.edit');
    }

    public function testValidDataRequiredToCreateAccessory()
    {
        $this->markTestIncomplete();
    }

    public function testCanCreateAccessory()
    {
        $category = Category::factory()->create();
        $company = Company::factory()->create();
        $location = Location::factory()->create();
        $manufacturer = Manufacturer::factory()->create();
        $supplier = Supplier::factory()->create();

        $data = [
            'company_id' => $company->id,
            'name' => 'My Accessory Name',
            'category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'manufacturer_id' => $manufacturer->id,
            'location_id' => $location->id,
            'model_number' => '12345',
            'order_number' => '9876',
            'purchase_date' => '2024-09-04',
            'purchase_cost' => '99.98',
            'qty' => '3',
            'min_amt' => '1',
            'notes' => 'Some notes here',
        ];

        $this->actingAs(User::factory()->createAccessories()->create())
            ->post(route('accessories.store'), array_merge($data, ['redirect_option' => 'index']))
            ->assertRedirect(route('accessories.index'));

        $this->assertDatabaseHas('accessories', $data);
    }
}
