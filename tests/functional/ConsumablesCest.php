<?php


class ConsumablesCest
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
        $I->wantTo('ensure that the create consumables form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('consumables.create'));
        $I->dontSee('Create Consumable', '.page-header');
        $I->see('Create Consumable', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('consumables.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The category id field is required.', '.alert-msg');
        $I->see('The qty field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('consumables.create'));
        $I->fillField('name', 't2');
        $I->fillField('qty', '-15');
        $I->fillField('min_amt', '-15');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
        $I->see('The qty must be at least 0', '.alert-msg');
        $I->see('The min amt must be at least 1', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $consumable = factory(App\Models\Consumable::class)->states('cardstock')->make([
            'name' => 'Test Consumable',
            'model_number' => 23520
        ]);
        // dd($consumable);
        $values = [
            'category_id'       => $consumable->category_id,
            'company_id'        => $consumable->company_id,
            'item_no'           => $consumable->item_no,
            'manufacturer_id'   => $consumable->manufacturer_id,
            'min_amt'           => $consumable->min_amt,
            'model_number'      => $consumable->model_number,
            'name'              => $consumable->name,
            'order_number'      => $consumable->order_number,
            'purchase_cost'     => $consumable->purchase_cost,
            'purchase_date'     => '2016-01-01',
            'qty'               => $consumable->qty,
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('consumables.create'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('consumables', $values);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a consumable');
        $I->sendDelete(route('consumables.destroy', $I->getConsumableId()), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }
}
