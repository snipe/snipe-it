<?php

namespace Tests\Unit;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Tests\Support\InteractsWithSettings;
use Tests\TestCase;

class CompanyScopingTest extends TestCase
{
    use InteractsWithSettings;

    public function models(): array
    {
        return [
            'Accessories' => [Accessory::class],
            'Assets' => [Asset::class],
            'Components' => [Component::class],
            'Consumables' => [Consumable::class],
            'Licenses' => [License::class],
        ];
    }

    /** @dataProvider models */
    public function testCompanyScoping($model)
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $modelA = $model::factory()->for($companyA)->create();
        $modelB = $model::factory()->for($companyB)->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->make());

        $this->settings->disableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($modelA);
        $this->assertCanSee($modelB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($modelA);
        $this->assertCanSee($modelB);

        $this->actingAs($userInCompanyB);
        $this->assertCanSee($modelA);
        $this->assertCanSee($modelB);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($modelA);
        $this->assertCanSee($modelB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($modelA);
        $this->assertCannotSee($modelB);

        $this->actingAs($userInCompanyB);
        $this->assertCannotSee($modelA);
        $this->assertCanSee($modelB);
    }

    public function testAssetMaintenanceCompanyScoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $assetMaintenanceForCompanyA = AssetMaintenance::factory()->for(Asset::factory()->for($companyA))->create();
        $assetMaintenanceForCompanyB = AssetMaintenance::factory()->for(Asset::factory()->for($companyB))->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->make());

        $this->settings->disableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($assetMaintenanceForCompanyA);
        $this->assertCanSee($assetMaintenanceForCompanyB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($assetMaintenanceForCompanyA);
        $this->assertCanSee($assetMaintenanceForCompanyB);

        $this->actingAs($userInCompanyB);
        $this->assertCanSee($assetMaintenanceForCompanyA);
        $this->assertCanSee($assetMaintenanceForCompanyB);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($assetMaintenanceForCompanyA);
        $this->assertCanSee($assetMaintenanceForCompanyB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($assetMaintenanceForCompanyA);
        $this->assertCannotSee($assetMaintenanceForCompanyB);

        $this->actingAs($userInCompanyB);
        $this->assertCannotSee($assetMaintenanceForCompanyA);
        $this->assertCanSee($assetMaintenanceForCompanyB);
    }

    public function testLicenseSeatCompanyScoping()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $licenseSeatA = LicenseSeat::factory()->for(Asset::factory()->for($companyA))->create();
        $licenseSeatB = LicenseSeat::factory()->for(Asset::factory()->for($companyB))->create();

        $superUser = $companyA->users()->save(User::factory()->superuser()->make());
        $userInCompanyA = $companyA->users()->save(User::factory()->make());
        $userInCompanyB = $companyB->users()->save(User::factory()->make());

        $this->settings->disableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);

        $this->actingAs($userInCompanyB);
        $this->assertCanSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);

        $this->settings->enableMultipleFullCompanySupport();

        $this->actingAs($superUser);
        $this->assertCanSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);

        $this->actingAs($userInCompanyA);
        $this->assertCanSee($licenseSeatA);
        $this->assertCannotSee($licenseSeatB);

        $this->actingAs($userInCompanyB);
        $this->assertCannotSee($licenseSeatA);
        $this->assertCanSee($licenseSeatB);
    }

    private function assertCanSee(Model $model)
    {
        $this->assertTrue(
            get_class($model)::all()->contains($model),
            'User was not able to see expected model'
        );
    }

    private function assertCannotSee(Model $model)
    {
        $this->assertFalse(
            get_class($model)::all()->contains($model),
            'User was able to see model from a different company'
        );
    }
}
