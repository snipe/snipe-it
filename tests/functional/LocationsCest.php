<?php


class LocationsCest
{
    public function _before(FunctionalTester $I)
    {
        exec("mysql -u snipeit -psnipe snipeit < tests/_data/dump.sql");
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        // logging in       
         $I->amOnPage('/login');
         $I->fillField('username', 'snipeit');
         $I->fillField('password', 'snipeit');
         $I->click('Login');
        /* Create Form */
        $I->wantTo('Test Location Creation');
        $I->lookForwardTo('Finding no Failures');
        $I->amOnPage('/admin/settings/locations/create');
        $I->dontSee('Create Location', '.page-header');
        $I->see('Create Location', 'h1.pull-left');
        $I->dontSee('&lt;span class=&quot;');
        $I->wantTo("Test Validation Fails with blank elements");
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->wantTo("Test Validation Fails with short values");
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
        $I->see('The state must be at least 2 characters', '.alert-msg');
        $I->see('The zip must be at least 3 characters', '.alert-msg');
        $I->wantTo("Test Validation Succeeds");
        $I->fillField('name', 'TestDeprecation3');
        $I->fillField('address', 't2da33');
        $I->fillField('city', 'West Borough');
        $I->fillField('state', 'tH');
        $I->fillField('zip', 't232a');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }
}
