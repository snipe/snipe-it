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
        $I->wantTo('ensure that the create statuslabels form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/settings/statuslabels/create');
        $I->dontSee('Create Status Label', '.page-header');
        $I->see('Create Status Label', 'h1.pull-left');

        $I->wantTo("Test Validation Fails with blank elements");
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');

        $I->wantTo("Test Validation Succeeds");
        $I->fillField('name', 'TestStatus');
        $I->click('Save');
        $I->seeElement('.alert-success');
    }
}
