<?php


use App\Models\Group;

class GroupsCest
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
        $I->wantTo('ensure that the create groups form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('create/group'));
        $I->dontSee('Create New Group', '.page-header');
        $I->see('Create New Group', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('create/group'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('create/group'));
        $I->fillField('name', 't2');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('create/group'));
        $I->fillField('name', 'TestGroup');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a group');
        $I->amOnPage(route('delete/group', Group::doesntHave('users')->first()->id));
        $I->seeElement('.alert-success');
    }

}
