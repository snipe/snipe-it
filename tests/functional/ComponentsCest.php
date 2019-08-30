<?php


class ComponentsCest
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
        $I->wantTo('ensure that the create components form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('components.create'));
        $I->dontSee('Create Component', '.page-header');
        $I->see('Create Component', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('components.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The category id field is required.', '.alert-msg');
        $I->see('The qty field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('components.create'));
        $I->fillField('name', 't2');
        $I->fillField('qty', '-15');
        $I->fillField('min_amt', '-15');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
        $I->see('The qty must be at least 1', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $component = factory(App\Models\Component::class)->states('ram-crucial4')->make([
            'name' => 'Test Component',
            'serial' => '3523-235325-1350235'
        ]);
        $values = [
            'category_id'       => $component->category_id,
            'company_id'        => $component->company_id,
            'location_id'       => $component->location_id,
            'min_amt'           => $component->min_amt,
            'name'              => $component->name,
            'order_number'      => $component->order_number,
            'purchase_cost'     => $component->purchase_cost,
            'purchase_date'     => '2016-01-01',
            'qty'               => $component->qty,
            'serial'            => $component->serial,
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('components.create'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('components', $values);
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }
    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a component');
        $I->sendDelete(route('components.destroy', $I->getComponentId()), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }
}
