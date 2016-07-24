<?php


class AssetModelCest
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
        $I->wantTo('Test Manufacturer Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/settings/manufacturers/create');
        $I->seeInTitle('Create Manufacturer');
        $I->see('Create Manufacturer', 'h1.pull-left');

        $I->wantTo("Test Validation Fails with blank elements");
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->wantTo("Test Validation Fails with short name");
        $I->fillField('name', 't');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 2 characters', '.alert-msg');
        $I->wantTo("Test Validation Succeeds");
        $I->fillField('name', 'TestManufacturer');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }
}
