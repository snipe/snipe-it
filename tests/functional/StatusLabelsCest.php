<?php


class StatusLabelsCest
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
        $I->wantTo('ensure that the create statuslabels form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/admin/settings/statuslabels/create');
        $I->dontSee('Create Status Label', '.page-header');
        $I->see('Create Status Label', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage('/admin/settings/statuslabels/create');
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $submitValues = [
            'name'                  => 'Test Status',
            'statuslabel_types'     => 'pending',
            'color'                 => '#b46262',
            'notes'                 => 'lorem ipsum something else',
            'show_in_nav'           => true,
        ];

        $recordValues = [
            'name'                  => 'Test Status',
            'pending'               => 1,
            'deployable'            => 0,
            'archived'              => 0,
            'color'                 => '#b46262',
            'notes'                 => 'lorem ipsum something else',
            'show_in_nav'           => true,
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage('/admin/settings/statuslabels/create');
        $I->submitForm('form#create-form', $submitValues);
        $I->seeRecord('status_labels', $recordValues);
        $I->seeElement('.alert-success');
    }
}
