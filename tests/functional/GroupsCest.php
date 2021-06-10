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
        $I->wantTo('Test Validation Fails with blank elements');
        $I->amOnPage(route('groups.create'));
        $I->seeResponseCodeIs(200);
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo('Test Validation Fails with short name');
        $I->amOnPage(route('groups.create'));
        $I->seeResponseCodeIs(200);
        $I->fillField('name', 't');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 2 characters', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $I->wantTo('Test Validation Succeeds');
        $I->amOnPage(route('groups.create'));
        $I->seeResponseCodeIs(200);
        $I->fillField('name', 'TestGroup');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I, $scenario)
    {
        $I->wantTo('Ensure I can delete a group');
        // create a group
        $I->amOnPage(route('groups.create'));
        $I->seeResponseCodeIs(200);
        $I->fillField('name', 'TestGroup');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');

        $I->sendDelete(route('groups.destroy', Group::whereName('TestGroup')->doesntHave('users')->first()->id));
        $I->seeResponseCodeIs(200);
        $I->seeElement('.alert-success');
        $I->seeResponseCodeIs(200);
    }
}
