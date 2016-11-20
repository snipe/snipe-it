<?php


use App\Models\Supplier;

class SuppliersCest
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
        $I->wantTo('ensure that the create settings/suppliers form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('create/supplier'));
        $I->dontSee('Create Supplier', '.page-header');
        $I->see('Create Supplier', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('create/supplier'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage(route('create/supplier'));
        $I->fillField('name', 't2');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
    }
    public function passesCorrectValidation(FunctionalTester $I)
    {
        $supplier = factory(App\Models\Supplier::class, 'supplier')->make();
        $values = [
            'name'              => $supplier->name,
            'address'           => $supplier->address,
            'address2'          => $supplier->address2,
            'city'              => $supplier->city,
            'state'             => $supplier->state,
            'country'           => $supplier->country,
            'zip'               => $supplier->zip,
            'contact'           => $supplier->contact,
            'phone'             => $supplier->phone,
            'fax'               => $supplier->fax,
            'email'             => $supplier->email,
            'url'               => $supplier->url,
            'notes'             => $supplier->notes
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('create/supplier'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('suppliers', $values);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a supplier');
        $I->amOnPage(route('delete/supplier', Supplier::doesntHave('assets')->doesntHave('licenses')->first()->id));
        $I->seeElement('.alert-success');
    }
}
