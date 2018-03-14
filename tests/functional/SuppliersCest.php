<?php

class SuppliersCest
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
        $I->wantTo('ensure that the create settings/suppliers form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('suppliers.create'));
        $I->dontSee('Create Supplier', '.page-header');
        $I->see('Create Supplier', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('suppliers.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $supplier = factory(App\Models\Supplier::class)->make();

        $values = [
            'name'              => $supplier->name,
            'address'           => $supplier->address,
            'address2'          => $supplier->address2,
            'city'              => $supplier->city,
            'state'             => $supplier->state,
            'zip'               => $supplier->zip,
            'country'           => $supplier->country,
            'contact'           => $supplier->contact,
            'phone'             => $supplier->phone,
            'fax'               => $supplier->fax,
            'email'             => $supplier->email,
            'url'               => $supplier->url,
            'notes'             => $supplier->notes
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('suppliers.create'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('suppliers', $values);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a supplier');
        $supplier = factory(App\Models\Supplier::class)->create();
        $I->sendDelete(route('suppliers.destroy', $supplier->id), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }
}
