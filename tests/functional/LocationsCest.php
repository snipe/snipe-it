<?php


use App\Models\Location;

class LocationsCest
{
    public function _before(FunctionalTester $I)
    {
          // logging in
         $I->amOnPage('/login');
         $I->fillField('username', 'snipeit');
         $I->fillField('password', 'snipeit');
         $I->click('Login');
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        /* Create Form */
        $I->wantTo('Test Location Creation');
        $I->lookForwardTo('Finding no Failures');
        $I->amOnPage(route('create/location'));
        $I->dontSee('Create Location', '.page-header');
        $I->see('Create Location', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('create/location'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short values");
        $I->amOnPage(route('create/location'));
        $I->fillField('name', 't2');
        $I->fillField('address', 't2da');
        $I->fillField('city', 't2');
        $I->fillField('state', 't');
        $I->fillField('zip', 't2');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 3 characters', '.alert-msg');
        $I->see('The address must be at least 5 characters', '.alert-msg');
        $I->see('The city must be at least 3 characters', '.alert-msg');
        $I->see('The zip must be at least 3 characters', '.alert-msg');
    }
    public function passesCorrectValidation(FunctionalTester $I)
    {
        $location = factory(App\Models\Location::class, 'location')->make();
        $values = [
            'name'              => $location->name,
            'parent_id'         => $I->getLocationId(),
            'currency'          => $location->currency,
            'address'           => $location->address,
            'address2'          => $location->address2,
            'city'              => $location->city,
            'state'             => $location->state,
            'country'           => $location->country,
            'zip'               => $location->zip,
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('create/location'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('locations', $values);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a location');
        $I->amOnPage(route('delete/location', Location::doesntHave('assets')->doesntHave('assignedAssets')->first()->id));
        $I->seeElement('.alert-success');
    }
}
