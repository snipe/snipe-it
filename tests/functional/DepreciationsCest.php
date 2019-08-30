<?php


class DepreciationCest
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
        $I->wantTo('Test Depreciation Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('depreciations.create'));
        $I->seeInTitle('Create Depreciation');
        $I->dontSee('Create Depreciation', '.page-header');
        $I->see('Create Depreciation', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('depreciations.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The months field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('depreciations.create'));
        $I->fillField('name', 't2');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $depreciation = factory(App\Models\Depreciation::class)->states('computer')->make([
            'name'=>'Test Depreciation'
        ]);
        $values = [
            'name'      => $depreciation->name,
            'months'    => $depreciation->months
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('depreciations.create'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('depreciations', $values);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a depreciation');
        $I->sendDelete(route('depreciations.destroy', $I->getDepreciationId()), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }
}
