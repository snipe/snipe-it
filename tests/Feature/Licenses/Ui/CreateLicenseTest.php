<?php

namespace Tests\Feature\Licenses\Ui;

use App\Models\AssetModel;
use App\Models\Category;
use App\Models\License;
use App\Models\Depreciation;
use App\Models\User;
use Tests\TestCase;

class CreateLicenseTest extends TestCase
{
    public function testPermissionRequiredToViewLicense()
    {
        $license = License::factory()->create();
        $this->actingAs(User::factory()->create())
            ->get(route('licenses.create', $license))
            ->assertForbidden();
    }

    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('licenses.create'))
            ->assertOk();
    }

    public function testLicenseWithoutPurchaseDateFailsValidation()
    {
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->from(route('licenses.create'))
            ->post(route('licenses.store'), [
                'name' => 'Test Invalid License',
                'seats' => '10',
                'category_id' => Category::factory()->forLicenses()->create()->id,
                'depreciation_id' => Depreciation::factory()->create()->id
            ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('licenses.create'));
        $response->assertInvalid(['purchase_date']);
        $response->assertSessionHasErrors(['purchase_date']);
        $this->followRedirects($response)->assertSee(trans('general.error'));
        $this->assertFalse(AssetModel::where('name', 'Test Invalid License')->exists());

    }
}
