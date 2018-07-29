<?php


use App\Models\LicenseModel;

class LicensesCest
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
        $I->see('The category id field is required.', '.alert-msg');
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
        $licenseModel = factory(App\Models\LicenseModel::class)->states('photoshop')->make([
            'name' => 'Test License',
            'company_id' => 3,
        ]);
        $values = [
            'company_id'        => $licenseModel->company_id,
            'expiration_date'   => '2018-01-01',
            'license_email'     => $licenseModel->license_email,
            'license_name'      => $licenseModel->license_name,
            'maintained'        => true,
            'manufacturer_id'   => $licenseModel->manufacturer_id,
            'category_id'       => $licenseModel->category_id,
            'name'              => $licenseModel->name,
            'notes'             => $licenseModel->notes,
            'order_number'      => $licenseModel->order_number,
            'purchase_cost'     => $licenseModel->purchase_cost,
            'purchase_date'     => '2016-01-01',
            'purchase_order'    => $licenseModel->purchase_order,
            'reassignable'      => true,
            'seats'             => $licenseModel->seats,
            'serial'            => $licenseModel->serial,
            'termination_date'  => '2020-01-01',
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
        $I->sendDelete(route('licenses.destroy', LicenseModel::doesntHave('assignedUsers')->first()->id), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }

}
