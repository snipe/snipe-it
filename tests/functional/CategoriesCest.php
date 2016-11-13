<?php


class CategoryCest
{
    public function _before(FunctionalTester $I)
    {
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
        $I->wantTo('Test Category Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/settings/categories/create');
        $I->seeInTitle('Create Category');
        $I->see('Create Category', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/admin/settings/categories/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The category type field is required.', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $values = [
            'name'                  => 'TestModel',
            'category_type'         => 'accessory',
            'eula_text'             => 'lorem ipsum blah blah',
            'require_acceptance'    => true,
            'checkin_email'         => true,
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/admin/settings/categories/create');
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('categories', $values);
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }
}
