<?php

namespace Tests\Feature\PredefinedKits\Ui;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\License;
use App\Models\PredefinedKit;
use App\Models\User;
use Tests\TestCase;

/**
 * FMCS tenant-isolation coverage for the kit checkout route.
 *
 * The kit-checkout path historically didn't call canCheckoutTo, so a
 * multi-company non-superuser could assign a company-A asset to a
 * company-B-only user by routing through kits — bypassing the guard
 * every other checkout sink (single, bulk, API, accessory, license,
 * consumable) enforces. Each test in this file exercises the exact
 * shape of that bypass and asserts the row/pivot state is unchanged.
 */
class CheckoutKitFmcsTest extends TestCase
{
    public function test_asset_from_wrong_company_is_not_checked_out_via_kit()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $actor = User::factory()->checkoutAssets()->create();
        $actor->companies()->sync([$companyA->id, $companyB->id]);
        $actor->syncLegacyCompanyIdMirror();

        $victim = User::factory()->create();
        $victim->companies()->sync([$companyB->id]);
        $victim->syncLegacyCompanyIdMirror();

        $model = AssetModel::factory()->create();
        $asset = Asset::factory()->create([
            'model_id' => $model->id,
            'company_id' => $companyA->id,
            'assigned_to' => null,
        ]);

        $kit = PredefinedKit::factory()->create();
        $kit->models()->attach($model->id, ['quantity' => 1]);

        $this->actingAs($actor)
            ->post(route('kits.checkout.store', $kit), ['user_id' => $victim->id]);

        $this->assertNull(
            $asset->fresh()->assigned_to,
            'Kit checkout must not assign a company-A asset to a company-B-only user.',
        );
    }

    public function test_asset_from_same_company_is_checked_out_via_kit()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();

        $actor = User::factory()->checkoutAssets()->create();
        $actor->companies()->sync([$companyA->id]);
        $actor->syncLegacyCompanyIdMirror();

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id]);
        $target->syncLegacyCompanyIdMirror();

        $model = AssetModel::factory()->create();
        $asset = Asset::factory()->create([
            'model_id' => $model->id,
            'company_id' => $companyA->id,
            'assigned_to' => null,
        ]);

        $kit = PredefinedKit::factory()->create();
        $kit->models()->attach($model->id, ['quantity' => 1]);

        $this->actingAs($actor)
            ->post(route('kits.checkout.store', $kit), ['user_id' => $target->id]);

        $this->assertSame(
            $target->id,
            $asset->fresh()->assigned_to,
            'Kit checkout to a same-company target must still succeed.',
        );
    }

    public function test_license_from_wrong_company_is_not_checked_out_via_kit()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $actor = User::factory()->checkoutAssets()->create();
        $actor->companies()->sync([$companyA->id, $companyB->id]);
        $actor->syncLegacyCompanyIdMirror();

        $victim = User::factory()->create();
        $victim->companies()->sync([$companyB->id]);
        $victim->syncLegacyCompanyIdMirror();

        $license = License::factory()->create(['company_id' => $companyA->id, 'seats' => 3]);

        $kit = PredefinedKit::factory()->create();
        $kit->licenses()->attach($license->id, ['quantity' => 1]);

        $this->actingAs($actor)
            ->post(route('kits.checkout.store', $kit), ['user_id' => $victim->id]);

        $this->assertSame(
            0,
            $license->licenseseats()->where('assigned_to', $victim->id)->count(),
            'Kit checkout must not assign a company-A license seat to a company-B-only user.',
        );
    }

    public function test_consumable_from_wrong_company_is_not_checked_out_via_kit()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $actor = User::factory()->checkoutAssets()->create();
        $actor->companies()->sync([$companyA->id, $companyB->id]);
        $actor->syncLegacyCompanyIdMirror();

        $victim = User::factory()->create();
        $victim->companies()->sync([$companyB->id]);
        $victim->syncLegacyCompanyIdMirror();

        $consumable = Consumable::factory()->create(['company_id' => $companyA->id, 'qty' => 5]);

        $kit = PredefinedKit::factory()->create();
        $kit->consumables()->attach($consumable->id, ['quantity' => 1]);

        $this->actingAs($actor)
            ->post(route('kits.checkout.store', $kit), ['user_id' => $victim->id]);

        $this->assertSame(
            0,
            \DB::table('consumables_users')->where('consumable_id', $consumable->id)->where('assigned_to', $victim->id)->count(),
            'Kit checkout must not assign a company-A consumable to a company-B-only user.',
        );
    }

    public function test_accessory_from_wrong_company_is_not_checked_out_via_kit()
    {
        $this->settings->enableMultipleFullCompanySupport();

        $companyA = Company::factory()->create();
        $companyB = Company::factory()->create();

        $actor = User::factory()->checkoutAssets()->create();
        $actor->companies()->sync([$companyA->id, $companyB->id]);
        $actor->syncLegacyCompanyIdMirror();

        $victim = User::factory()->create();
        $victim->companies()->sync([$companyB->id]);
        $victim->syncLegacyCompanyIdMirror();

        $accessory = Accessory::factory()->create(['company_id' => $companyA->id, 'qty' => 5]);

        $kit = PredefinedKit::factory()->create();
        $kit->accessories()->attach($accessory->id, ['quantity' => 1]);

        $this->actingAs($actor)
            ->post(route('kits.checkout.store', $kit), ['user_id' => $victim->id]);

        $this->assertSame(
            0,
            \DB::table('accessories_checkout')->where('accessory_id', $accessory->id)->where('assigned_to', $victim->id)->count(),
            'Kit checkout must not assign a company-A accessory to a company-B-only user.',
        );
    }
}
