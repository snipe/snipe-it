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

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that the create assets form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/hardware/create');
        $I->dontSee('Create Asset', '.page-header');
        $I->see('Create Asset', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/hardware/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The asset tag field is required.', '.alert-msg');
        $I->see('The model id field is required.', '.alert-msg');
        $I->see('The status id field is required.', '.alert-msg');
    }

    public function passesCreateAndCheckout(FunctionalTester $I)
    {
        $values = [
            'company_id'        => 3,
            'asset_tag'         => '230-name-21 2',
            'model_id'          => 10,
            'status_id'         => 2,
            'assigned_to'       => 10,
            'serial'            => '350335',
            'name'              => 'TestModel',
            'purchase_date'     => '2016-01-01',
            'supplier_id'       => 12,
            'order_number'      => '12345',
            'purchase_cost'     => '25.00',
            'warranty_months'   => '15',
            'notes'             => 'lorem ipsum blah blah',
            'rtd_location_id'   => 38,
            'requestable'       => true,
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/hardware/create');
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('assets', $values);
        $I->dontSeeElement('.alert-danger'); // We should check for success, but we can't because of the stupid ajaxy way I did things.  FIXME when the asset form is rewritten.
    }
}
 