<?php

class CompaniesCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('username', 'admin');
        $I->fillField('password', 'password');
        $I->click('Login');
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->wantTo('Test Company Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('companies.create'));
        $I->seeInTitle('Create Company');
        $I->see('Create Company', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo('Test Validation Fails with blank elements');
        $I->amOnPage(route('companies.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $company = \App\Models\Company::factory()->make();
        $values = [
            'name' => $company->name,
        ];
        $I->wantTo('Test Validation Succeeds');
        $I->amOnPage(route('companies.create'));
        $I->fillField('name', 'TestCompany');
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('companies', $values);
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }
}
