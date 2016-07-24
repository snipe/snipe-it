<?php


class GroupsCest
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
        $I->wantTo('ensure that the create groups form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/groups/create');
        $I->dontSee('Create New Group', '.page-header');
        $I->see('Create New Group', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/admin/groups/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage('/admin/groups/create');
        $I->fillField('name', 't2');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/admin/groups/create');
        $I->fillField('name', 'TestGroup');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

}
