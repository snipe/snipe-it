<?php


class CompaniesCest
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
        $I->wantTo('Test Company Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/settings/companies/create');
        $I->seeInTitle('Create Company');
        $I->see('Create Company', 'h1.pull-left');

        $I->wantTo("Test Validation Fails with blank elements");
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->wantTo("Test Validation Succeeds");
        $I->fillField('name', 'TestCompany');
        $I->click('Save');
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }
}
