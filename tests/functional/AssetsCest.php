<?php


class AssetsCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('username', 'snipeit');
        $I->fillField('password', 'snipeit');
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
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('hardware.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The asset tag field is required.', '.alert-msg');
        $I->see('The model id field is required.', '.alert-msg');
        $I->see('The status id field is required.', '.alert-msg');
    }

    public function passesCreateAndCheckout(FunctionalTester $I)
    {
        $asset = factory(App\Models\Asset::class)->make();
        $userId = $I->getUserId();
        $values = [
            'company_id'        => $asset->company_id,
            'asset_tag'         => $asset->asset_tag,
            'model_id'          => $asset->model_id,
            'status_id'         => $asset->status_id,
            'assigned_user'     => $userId,
            'serial'            => $asset->serial,
            'name'              => $asset->name,
            'purchase_date'     => '2016-01-01',
            'supplier_id'       => $asset->supplier_id,
            'order_number'      => $asset->order_number,
            'purchase_cost'     => $asset->purchase_cost,
            'warranty_months'   => $asset->warranty_months,
            'notes'             => $asset->notes,
            'rtd_location_id'   => $asset->rtd_location_id,
            'requestable'       => $asset->requestable,
        ];

        $seenValues = [
            'company_id'        => $asset->company_id,
            'asset_tag'         => $asset->asset_tag,
            'model_id'          => $asset->model_id,
            'status_id'         => $asset->status_id,
            'assigned_to'       => $userId,
            'assigned_type'     => 'App\\Models\\User',
            'serial'            => $asset->serial,
            'name'              => $asset->name,
            'purchase_date'     => '2016-01-01',
            'supplier_id'       => $asset->supplier_id,
            'order_number'      => $asset->order_number,
            'purchase_cost'     => $asset->purchase_cost,
            'warranty_months'   => $asset->warranty_months,
            'notes'             => $asset->notes,
            'rtd_location_id'   => $asset->rtd_location_id,
            'requestable'       => $asset->requestable,
        ];

        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('hardware.create'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('assets', $seenValues);
        $I->dontSeeElement('.alert-danger'); // We should check for success, but we can't because of the stupid ajaxy way I did things.  FIXME when the asset form is rewritten.
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete an asset');
        $I->sendDelete(route('hardware.destroy', $I->getAssetId()), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }
}
