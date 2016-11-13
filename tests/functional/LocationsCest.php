<?php


class LocationsCest
{
    public function _before(FunctionalTester $I)
    {
          // logging in
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
        /* Create Form */
        $I->wantTo('Test Location Creation');
        $I->lookForwardTo('Finding no Failures');
        $I->amOnPage('/admin/settings/locations/create');
        $I->dontSee('Create Location', '.page-header');
        $I->see('Create Location', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/admin/settings/locations/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short values");
        $I->amOnPage('/admin/settings/locations/create');
        $I->fillField('name', 't2');
        $I->fillField('address', 't2da');
        $I->fillField('city', 't2');
        $I->fillField('state', 't');
        $I->fillField('zip', 't2');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
        $I->see('The address must be at least 5 characters', '.alert-msg');
        $I->see('The city must be at least 3 characters', '.alert-msg');
        $I->see('The zip must be at least 3 characters', '.alert-msg');
    }
    public function passesCorrectValidation(FunctionalTester $I)
    {
        $values = [
            'name'              => 'Test Location',
            'parent_id'         => 26,
            'currency'          => 'YEN',
            'address'           => '046t46 South Street',
            'address2'          => 'Apt 356',
            'city'              => 'Sutherland',
            'state'             => 'BV',
            'country'           => 'AF',
            'zip'               => '30266',
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/admin/settings/locations/create');
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('locations', $values);
        $I->seeElement('.alert-success');
    }
}
