<?php


class licensesCest
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
        $I->wantTo('ensure that the create licenses form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/licenses/create');
        $I->dontSee('Create License', '.page-header');
        $I->see('Create License', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/admin/licenses/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The serial field is required.', '.alert-msg');
        $I->see('The seats field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage('/admin/licenses/create');
        $I->fillField('name', 't2');
        $I->fillField('serial', '13a-');
        $I->fillField('seats', '-15');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
        $I->see('The serial must be at least 5 characters', '.alert-msg');
        $I->see('The seats must be at least 1', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/admin/licenses/create');
        $I->fillField('name', 'TestAccessory');
        $I->fillField('serial', '12a66b3-13aacd');
        $I->fillField('seats', '15');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

}
