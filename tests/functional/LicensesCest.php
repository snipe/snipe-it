<?php


use App\Models\License;

class LicensesCest
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
        $I->wantTo('ensure that the create licenses form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('licenses.create'));
        $I->dontSee('Create License', '.page-header');
        $I->see('Create License', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('licenses.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The seats field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('licenses.create'));
        $I->fillField('name', 't2');
        $I->fillField('seats', '-15');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
        $I->see('The seats must be at least 1', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $license = factory(App\Models\License::class)->make();
        $values = [
            'name'              => $license->name,
            'serial'            => $license->serial,
            'seats'             => $license->seats,
            'company_id'        => $license->company_id,
            'manufacturer_id'   => $license->manufacturer_id,
            'license_name'      => $license->license_name,
            'license_email'     => $license->license_email,
            'reassignable'      => true,
            'supplier_id'       => $license->supplier_id,
            'order_number'      => $license->order_number,
            'purchase_cost'     => $license->purchase_cost,
            'purchase_date'     => '2016-01-01',
            'expiration_date'   => '2018-01-01',
            'termination_date'  => '2020-01-01',
            'purchase_order'    => $license->purchase_order,
            'maintained'        => true,
            'notes'             => $license->notes
        ];

        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('licenses.create'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('licenses', $values);
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a license');
        $I->sendDelete(route('licenses.destroy', License::doesntHave('assignedUsers')->first()->id), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }

}
