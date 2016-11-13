<?php


class ManufacturersCest
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
        $I->wantTo('Test Manufacturer Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/settings/manufacturers/create');
        $I->seeInTitle('Create Manufacturer');
        $I->see('Create Manufacturer', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/admin/settings/manufacturers/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage('/admin/settings/manufacturers/create');
        $I->fillField('name', 't');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 2 characters', '.alert-msg');
    }
    public function passesCorrectValidation(FunctionalTester $I)
    {
        $values = [
            'name' => 'Testufacturer'
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/admin/settings/manufacturers/create');
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('manufacturers', $values);
        $I->seeElement('.alert-success');
    }
}
