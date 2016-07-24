<?php


class ManufacturerCest
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
        $I->wantTo('Test Asset Model Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/hardware/models/create');
        $I->seeInTitle('Create Asset Model');
        $I->see('Create Asset Model', 'h1.pull-left');

        $I->wantTo("Test Validation Fails with blank elements");
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The manufacturer id field is required.', '.alert-msg');
        $I->see('The category id field is required.', '.alert-msg');
        $I->wantTo("Test Validation Succeeds");
        $I->fillField('name', 'TestModel');
        $I->selectOption('form select[name=manufacturer_id]', 'Test Manufacturer');
        $I->selectOption('form select[name=category_id]', 'Test Asset');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }
}
