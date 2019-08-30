<?php


use App\Models\Location;

class LocationsCest
{
    public function _before(FunctionalTester $I)
    {
          // logging in
         $I->amOnPage('/login');
         $I->fillField('username', 'admin');
         $I->fillField('password', 'password');
         $I->click('Login');
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        /* Create Form */
        $I->wantTo('Test Location Creation');
        $I->lookForwardTo('Finding no Failures');
        $I->amOnPage(route('locations.create'));
        $I->dontSee('Create Location', '.page-header');
        $I->see('Create Location', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('locations.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function failsShortValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with short values");
        $I->amOnPage(route('locations.create'));
        $I->fillField('name', 't');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name must be at least 2 characters', '.alert-msg');
    }
    public function passesCorrectValidation(FunctionalTester $I)
    {
        $location = factory(App\Models\Location::class)->make();
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
        $I->amOnPage(route('locations.create'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('locations', $values);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a location');
        $location = factory(App\Models\Location::class)->create();
        $I->sendDelete(route('locations.destroy', $location->id), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }
}
