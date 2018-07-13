<?php


use App\Models\Group;

class GroupsCest
{
    public function _before(FunctionalTester $I)
    {
         $I->amOnPage('/login');
         $I->fillField('username', 'admin');
         $I->fillField('password', 'password');
         $I->click('Login');
    }

    // tests
    public function loadsFormWithoutErrors(FunctionalTester $I)
    {
        $I->wantTo('ensure that the create groups form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('groups.create'));
        $I->seeResponseCodeIs(200);
        $I->dontSee('Create New Group', '.page-header');
        $I->see('Create New Group', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('groups.create'));
        $I->seeResponseCodeIs(200);
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('groups.create'));
        $I->seeResponseCodeIs(200);
        $I->fillField('name', 't2');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('groups.create'));
        $I->seeResponseCodeIs(200);
        $I->fillField('name', 'TestGroup');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I, $scenario)
    {
        $scenario->incomplete('Fix this test to generate a group for deletes');
        $I->wantTo('Ensure I can delete a group');

        // create a group
        $I->amOnPage(route('groups.create'));
        $I->seeResponseCodeIs(200);
        $I->fillField('name', 'TestGroup');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');

        // delete it
        $I->amOnPage(route('groups.delete', Group::doesntHave('users')->first()->id));
        $I->seeResponseCodeIs(200);
        $I->seeElement('.alert-success');
        // $I->seeResponseCodeIs(200);
    }

    public function allowsEditing(FunctionalTester $I, $scenario)
    {
        $scenario->incomplete('Fix this test to generate a group for editing');
        $I->wantTo('Ensure i can edit a group');
    }
}
