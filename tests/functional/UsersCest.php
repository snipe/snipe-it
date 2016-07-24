<?php


class AccessoriesCest
{
    public function _before(FunctionalTester $I)
    {
        exec("mysql -u snipeit -psnipe snipeit < tests/_data/dump.sql");
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
        $I->wantTo('ensure that the create users form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/users/create');
        $I->dontSee('Create User', '.page-header');
        $I->see('Create User', 'h1.pull-left');

        $I->wantTo("Test Validation Fails with blank elements");
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The first name field is required.', '.alert-msg');
        $I->see('The last name field is required.', '.alert-msg');
        $I->see('The username field is required.', '.alert-msg');
        $I->see('The password field is required.', '.alert-msg');
        $I->wantTo("Test Validation Fails with short name");
        $I->fillField('first_name', 't2');
        $I->fillField('last_name', 't2');
        $I->fillField('username', 'a'); // Must be 2 chars
        $I->fillField('password', '12345'); // Must be 6 chars
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The username must be at least 2 characters', '.alert-msg');
        $I->see('The password must be at least 6 characters', '.alert-msg');
        $I->see('The password confirm field is required when password is present', '.alert-msg');
        $I->wantTo("Test Validation Succeeds");
        $I->fillField('first_name', 't2');
        $I->fillField('last_name', 't2');
        $I->fillField('username', 'auserads'); // Must be 2 chars
        $I->fillField('password', '123456'); // Must be 6 chars
        $I->fillField('password_confirm', '123456'); // Must be 6 chars
        $I->click('Save');
        $I->seeElement('.alert-success');
    }
}
