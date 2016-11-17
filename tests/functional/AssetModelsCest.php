<?php


class AssetModelsCest
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
        $I->wantTo('Test Asset Model Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/hardware/models/create');
        $I->seeInTitle('Create Asset Model');
        $I->see('Create Asset Model', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/hardware/models/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The manufacturer id field is required.', '.alert-msg');
        $I->see('The category id field is required.', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $values = [
            'name'              => 'TestModel',
            'manufacturer_id'  => '24',
            'category_id'       => '40',
            'model_number'      => '350335',
            'eol'               => '12',
            'notes'             => 'lorem ipsum blah blah',
            'requestable'       => true,
        ];

        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/hardware/models/create');

        $I->submitForm('form#create-form', $values);
        $I->seeRecord('models', $values);
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

}
