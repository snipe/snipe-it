<?php


class SuppliersCest
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
        $I->wantTo('ensure that the create settings/suppliers form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/settings/suppliers/create');
        $I->dontSee('Create Supplier', '.page-header');
        $I->see('Create Supplier', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/admin/settings/suppliers/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage('/admin/settings/suppliers/create');
        $I->fillField('name', 't2');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
    }
    public function passesCorrectValidation(FunctionalTester $I)
    {
        $values = [
            'name'              => 'Test Supplier',
            'address'           => '046t46 South Street',
            'address2'          => 'Apt 356',
            'city'              => 'Sutherland',
            'state'             => 'BV',
            'country'           => 'AF',
            'zip'               => '30266',
            'contact'           => 'Mr. Smith',
            'phone'             => '032626236 x35',
            'fax'               => '342 33 6647 3555',
            'email'             => 'p@roar.com',
            'url'               => 'http://snipeitapp.com',
            'notes'             => 'lorem ipsum indigo something'
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/admin/settings/suppliers/create');
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('suppliers', $values);
        $I->seeElement('.alert-success');
    }
}
