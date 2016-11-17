<?php


class licensesCest
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
        $I->wantTo('ensure that the create licenses form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/licenses/create');
        $I->dontSee('Create License', '.page-header');
        $I->see('Create License', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/admin/licenses/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The serial field is required.', '.alert-msg');
        $I->see('The seats field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short name");
        $I->amOnPage('/admin/licenses/create');
        $I->fillField('name', 't2');
        $I->fillField('serial', '13a-');
        $I->fillField('seats', '-15');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
        $I->see('The serial must be at least 5 characters', '.alert-msg');
        $I->see('The seats must be at least 1', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $values = [
            'name'              => 'Test Software',
            'serial'            => '946346-436346-346436',
            'seats'             => '12',
            'company_id'        => 3,
            'manufacturer_id'   => 24,
            'license_name'      => 'Marco Polo',
            'license_email'     => 'g@m.com',
            'reassignable'      => true,
            'supplier_id'       => 11,
            'order_number'      => '12345',
            'purchase_cost'     => '25.00',
            'purchase_date'     => '2016-01-01',
            'expiration_date'   => '2018-01-01',
            'termination_date'  => '2020-01-01',
            'purchase_order'    => '234562',
            'maintained'        => true,
            'notes'             => 'lorem ipsum omicron delta phi'
        ];

        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/admin/licenses/create');
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('licenses', $values);
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

}
