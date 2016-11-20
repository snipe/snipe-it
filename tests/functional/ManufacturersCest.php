<?php


use App\Models\Manufacturer;

class ManufacturersCest
{
    public function _before(FunctionalTester $I)
    {
         $I->amOnPage('/login');
         $I->fillField('username', 'snipeit');
         $I->fillField('password', 'snipeit');
         $I->click('Login');
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $I->wantTo('Test Manufacturer Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('create/manufacturer'));
        $I->seeInTitle('Create Manufacturer');
        $I->see('Create Manufacturer', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('create/manufacturer'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('create/manufacturer'));
        $I->fillField('name', 't');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 2 characters', '.alert-msg');
    }
    public function passesCorrectValidation(FunctionalTester $I)
    {
        $manufacturer = factory(App\Models\Manufacturer::class, 'manufacturer')->make();
        $values = [
            'name' => $manufacturer->name
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('create/manufacturer'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('manufacturers', $values);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a manufacturer');
        $I->amOnPage(route('delete/manufacturer', Manufacturer::doesntHave('models')
                                                ->doesntHave('accessories')
                                                ->doesntHave('consumables')
                                                ->doesntHave('licenses')->first()->id
        ));
        $I->seeElement('.alert-success');
    }
}
