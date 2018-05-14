<?php


class AccessoriesCest
{
    public function _before(FunctionalTester $I)
    {
         $I->amOnPage('/login');
         $I->fillField('username', 'admin');
         $I->fillField('password', 'password');
         $I->click('Login');
         $I->seeAuthentication();
    }

    // tests
    public function loadsFormWithoutErrors(FunctionalTester $I)
    {
        $I->wantTo('ensure that the create accessories form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/accessories/create');
        $I->seeResponseCodeIs(200);
        $I->dontSee('Create Accessory', '.page-header');
        $I->see('Create Accessory', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/accessories/create');
        $I->seeResponseCodeIs(200);
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The category id field is required.', '.alert-msg');
        $I->see('The qty field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage('/accessories/create');
        $I->seeResponseCodeIs(200);
        $I->fillField('name', 't2');
        $I->fillField('qty', '-15');
        $I->fillField('min_amt', '-15');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
        $I->see('The category id field is required', '.alert-msg');
        $I->see('The qty must be at least 1', '.alert-msg');
        $I->see('The min amt must be at least 0', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $accessory = factory(App\Models\Accessory::class)->states('apple-bt-keyboard')->make();
        $values = [
            'category_id'   => $accessory->category_id,
            'location_id'      => $accessory->location_id,
            'manufacturer_id'  => $accessory->manufacturer_id,
            'min_amt'       => $accessory->min_amt,
            'name'          => 'Test Accessory',
            'order_number'  => $accessory->order_number,
            'purchase_date' => '2016-01-01',
            'qty'           => $accessory->qty,
        ];

        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/accessories/create');
        $I->seeResponseCodeIs(200);

        $I->submitForm('form#create-form', $values);
        $I->seeRecord('accessories', $values);

        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete an accessory');
        $I->sendDelete( route('accessories.destroy', $I->getAccessoryId() ), ['_token' => csrf_token()] );
        $I->seeResponseCodeIs(200);
    }
}
