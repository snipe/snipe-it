<?php

class AssetsCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('username', 'admin');
        $I->fillField('password', 'password');
        $I->click('Login');
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that the create assets form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('hardware.create'));
        $I->dontSee('Create Asset', '.page-header');
        $I->see('Create Asset', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo('Test Validation Fails with blank elements');
        $I->amOnPage(route('hardware.create'));
        // Settings factory can enable auto prefixes, which generate a random asset id.  Lets clear it out for the sake of this test.
        $I->fillField('#asset_tag', '');
        $I->click('Save');
        $I->see('The asset tag field is required.', '.alert-msg');
        $I->see('The model id field is required.', '.alert-msg');
        $I->see('The status id field is required.', '.alert-msg');
    }

    public function passesCreateAndCheckout(FunctionalTester $I)
    {
        $asset = \App\Models\Asset::factory()->laptopMbp()->make([
            'asset_tag'=>'test tag',
            'name'=> 'test asset',
            'company_id'=>1,
            'warranty_months'=>15,
         ]);
        $userId = $I->getUserId();
        $values = [
            'asset_tags[1]'         => $asset->asset_tag,
            'assigned_user'     => $userId,
            'company_id'        => $asset->company_id,
            'model_id'          => $asset->model_id,
            'name'              => $asset->name,
            'notes'             => $asset->notes,
            'order_number'      => $asset->order_number,
            'purchase_cost'     => $asset->purchase_cost,
            'purchase_date'     => '2016-01-01',
            'requestable'       => $asset->requestable,
            'rtd_location_id'   => $asset->rtd_location_id,
            'serials[1]'        => $asset->serial,
            'status_id'         => $asset->status_id,
            'supplier_id'       => $asset->supplier_id,
            'warranty_months'   => $asset->warranty_months,
        ];

        $seenValues = [
            'asset_tag'         => $asset->asset_tag,
            'assigned_to'       => $userId,
            'assigned_type'     => \App\Models\User::class,
            'company_id'        => $asset->company_id,
            'model_id'          => $asset->model_id,
            'name'              => $asset->name,
            'notes'             => $asset->notes,
            'order_number'      => $asset->order_number,
            'purchase_cost'     => $asset->purchase_cost,
            'purchase_date'     => '2016-01-01',
            'requestable'       => $asset->requestable,
            'rtd_location_id'   => $asset->rtd_location_id,
            'serial'            => $asset->serial,
            'status_id'         => $asset->status_id,
            'supplier_id'       => $asset->supplier_id,
            'warranty_months'   => $asset->warranty_months,
        ];

        $I->wantTo('Test Validation Succeeds');
        $I->amOnPage(route('hardware.create'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('assets', $seenValues);
        $I->seeResponseCodeIs(200);
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete an asset');
        $I->sendDelete(route('hardware.destroy', $I->getAssetId()), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }
}
