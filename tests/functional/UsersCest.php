<?php

class UsersCest
{
    public function _before(\FunctionalTester $I)
    {
         $I->amOnPage('/login');
         $I->fillField('username', 'snipeit');
         $I->fillField('password', 'snipeit');
         $I->click('Login');
    }

    public function _after(\FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(\FunctionalTester $I)
    {
        $I->wantTo('ensure that the create users form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/users/create');
        $I->dontSee('Create User', '.page-header');
        $I->see('Create User', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/admin/users/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The first name field is required.', '.alert-msg');
        $I->see('The username field is required.', '.alert-msg');
        $I->see('The password field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage('/admin/users/create');        
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
        $submitValues = [
            'first_name'        => 'John',
            'last_name'         => 'Smdt',
            'username'          => 'jsmdt',
            'password'          => 'Sutherland',
            'password_confirm'  => 'Sutherland',
            'email'             => 'g@roar.com',
            'company_id'        => 3,
            'locale'            => 'en-GB',
            'employee_num'      => '1636 636',
            'jobtitle'          => 'Robot',
            'manager_id'        => 19,
            'location_id'       => 67,
            'phone'             => '35235 33535 x5',
            'activated'         => true,
            'notes'             => 'lorem ipsum indigo something'
        ];
        $storedValues = [
            'first_name'        => 'John',
            'last_name'         => 'Smdt',
            'username'          => 'jsmdt',
            'email'             => 'g@roar.com',
            'company_id'        => 3,
            'locale'            => 'en-GB',
            'employee_num'      => '1636 636',
            'jobtitle'          => 'Robot',
            'manager_id'        => 19,
            'location_id'       => 67,
            'phone'             => '35235 33535 x5',
            'activated'         => true,
            'notes'             => 'lorem ipsum indigo something'
        ];
        $I->amOnPage('/admin/users/create');
        $I->wantTo("Test Validation Succeeds");
        $I->submitForm('form#userForm', $submitValues);
        $I->seeRecord('users', $storedValues);
        $I->seeElement('.alert-success');
    }
}
