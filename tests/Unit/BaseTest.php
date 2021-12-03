<?php
namespace Tests\Unit;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase; 
use Auth;
use Artisan;

class BaseTest extends TestCase
{
    use DatabaseTransactions;

    protected function _before()
    {
        Artisan::call('migrate');
        Setting::factory()->create();
    }

    protected function signIn($user = null)
    {
        if (! $user) {
            $user = User::factory()->superuser()->create([
                'location_id' => $this->createValidLocation()->id,
            ]);
        }
        Auth::login($user);
        return $user;
    }

    protected function createValidAssetModel()
    {
        return \App\Models\AssetModel::factory()->create([
            'category_id' => $this->createValidCategory(),
            'manufacturer_id' => $this->createValidManufacturer(),
            'depreciation_id' => $this->createValidDepreciation(),
        ]);
    }

    protected function createValidCategory()
    {
        return \App\Models\Category::factory()->make();
    }

    protected function createValidCompany()
    {
        return \App\Models\Company::factory()->create();
    }

    protected function createValidDepartment($state = 'engineering', $overrides = [])
    {
        return \App\Models\Department::factory()->create(array_merge([
            'location_id' => $this->createValidLocation()->id,
        ], $overrides));
    }

    protected function createValidDepreciation()
    {
        return \App\Models\Depreciation::factory()->create();
    }

    protected function createValidLocation($overrides = [])
    {
        return \App\Models\Location::factory()->create($overrides);
    }

    protected function createValidManufacturer()
    {
        return \App\Models\Manufacturer::factory()->create();
    }

    protected function createValidSupplier($overrides = [])
    {
        return \App\Models\Supplier::factory()->create($overrides);
    }

    protected function createValidStatuslabel($state = 'rtd', $overrides = [])
    {
        return \App\Models\Statuslabel::factory()->state()->create($overrides);
    }

    protected function createValidUser($overrides = [])
    {
        return \App\Models\User::factory()->create(
            array_merge([
                'location_id'=>$this->createValidLocation()->id,
            ], $overrides)
        );
    }

    protected function createValidAsset($overrides = [])
    {
        $locId = $this->createValidLocation()->id;
        $this->createValidAssetModel();

        return \App\Models\Asset::factory()->laptopMbp()->create(
            array_merge([
                'rtd_location_id' => $locId,
                'location_id' => $locId,
                'supplier_id' => $this->createValidSupplier()->id,
            ], $overrides)
        );
    }
}
