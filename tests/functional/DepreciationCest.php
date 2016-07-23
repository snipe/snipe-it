<?php


class DepreciationCest
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

        $I->wantTo('Test Depreciation Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/settings/depreciations/create');
        $I->seeInTitle('Create Depreciation');
        $I->dontSee('Create Depreciation', '.page-header');
        $I->see('Create Depreciation', 'h1.pull-left');
        $I->dontSee('&lt;span class=&quot;');
        $I->wantTo("Test Validation Fails with blank elements");
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The months field is required.', '.alert-msg');
        $I->wantTo("Test Validation Fails with short name");
        $I->fillField('name', 't2');
        $I->fillField('months', '12');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
        $I->wantTo("Test Validation Succeeds");
        $I->fillField('name', 'TestDeprecation3');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->dontSeeElement('.alert-danger');
    }
}
