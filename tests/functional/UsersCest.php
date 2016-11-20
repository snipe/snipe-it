<?php

use App\Models\User;

class UsersCest
{
    public function _before(\FunctionalTester $I)
    {
         $I->amOnPage('/login');
         $I->fillField('username', 'snipeit');
         $I->fillField('password', 'snipeit');
         $I->click('Login');
    }
    // tests
    public function tryToTest(\FunctionalTester $I)
    {
        $I->wantTo('ensure that the create users form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('create/user'));
        $I->dontSee('Create User', '.page-header');
        $I->see('Create User', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('create/user'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The first name field is required.', '.alert-msg');
        $I->see('The username field is required.', '.alert-msg');
        $I->see('The password field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('create/user'));
        $I->fillField('first_name', 't2');
        $I->fillField('last_name', 't2');
        $I->fillField('username', 'a'); // Must be 2 chars
        $I->fillField('password', '12345'); // Must be 6 chars
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The username must be at least 2 characters', '.alert-msg');
        $I->see('The password must be at least 6 characters', '.alert-msg');
        $I->see('The password confirm field is required when password is present', '.alert-msg');

    }
    public function passesCorrectValidation(FunctionalTester $I)
    {
        $user = factory(App\Models\User::class, 'valid-user')->make();
        $submitValues = [
            'first_name'        => $user->first_name,
            'last_name'         => $user->last_name,
            'username'          => $user->username,
            'password'          => $user->password,
            'password_confirm'  => $user->password,
            'email'             => $user->email,
            'company_id'        => $user->company_id,
            'locale'            => $user->locale,
            'employee_num'      => $user->employee_num,
            'jobtitle'          => $user->jobtitle,
            'manager_id'        => 19,
            'location_id'       => 67,
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
            'manager_id'        => 19,
            'location_id'       => 67,
            'phone'             => $user->phone,
            'activated'         => true,
            'notes'             => $user->notes
        ];
        $I->amOnPage(route('create/user'));
        $I->wantTo("Test Validation Succeeds");
        $I->submitForm('form#userForm', $submitValues);
        $I->seeRecord('users', $storedValues);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a user');
        $I->amOnPage(route('delete/user', User::doesntHave('assets')
                                        ->doesntHave('accessories')
                                        ->doesntHave('consumables')
                                        ->doesntHave('licenses')
                                        ->where('username', '!=', 'snipeit')
                                        ->first()->id
        ));
        $I->seeElement('.alert-success');
    }
}
