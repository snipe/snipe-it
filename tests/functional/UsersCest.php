<?php

use App\Models\User;

class UsersCest
{
    public function _before(\FunctionalTester $I)
    {
         $I->amOnPage('/login');
         $I->fillField('username', 'admin');
         $I->fillField('password', 'password');
         $I->click('Login');
    }
    // tests
    public function tryToTest(\FunctionalTester $I)
    {
        $I->wantTo('ensure that the create users form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('users.create'));
        $I->dontSee('Create User', '.page-header');
        $I->see('Create User', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('users.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The first name field is required.', '.alert-msg');
        $I->see('The username field is required unless ldap import is in 1.', '.alert-msg');
        $I->see('The password field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('users.create'));
        $I->fillField('first_name', 't2');
        $I->fillField('last_name', 't2');
        $I->fillField('username', 'a');
        $I->fillField('password', '12345');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The password must be at least 10 characters', '.alert-msg');

    }
    public function passesCorrectValidation(FunctionalTester $I)
    {
        $user = factory(App\Models\User::class)->make();
        $submitValues = [
            'first_name'        => $user->first_name,
            'last_name'         => $user->last_name,
            'username'          => $user->username,
            'password'          => $user->password,
            'password_confirmation'  => $user->password,
            'email'             => $user->email,
            'company_id'        => $user->company_id,
            'locale'            => $user->locale,
            'employee_num'      => $user->employee_num,
            'jobtitle'          => $user->jobtitle,
            'manager_id'        => $user->manager_id,
            'location_id'       => $user->location_id,
            'phone'             => $user->phone,
            'activated'         => true,
            'notes'             => $user->notes
        ];
        $storedValues = [
            'first_name'        => $user->first_name,
            'last_name'         => $user->last_name,
            'username'          => $user->username,
            'email'             => $user->email,
            'company_id'        => $user->company_id,
            'locale'            => $user->locale,
            'employee_num'      => $user->employee_num,
            'jobtitle'          => $user->jobtitle,
            'manager_id'        => $user->manager_id,
            'location_id'       => $user->location_id,
            'phone'             => $user->phone,
            'activated'         => true,
            'notes'             => $user->notes
        ];
        $I->amOnPage(route('users.create'));
        $I->wantTo("Test Validation Succeeds");
        $I->submitForm('form#userForm', $submitValues);
        $I->seeRecord('users', $storedValues);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $user = factory(App\Models\User::class)->create();
        $I->wantTo('Ensure I can delete a user');
        $I->sendDelete(route('users.destroy', $user->id), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }
}
