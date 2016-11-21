<?php


use App\Models\Statuslabel;

class StatusLabelsCest
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
        $I->wantTo('ensure that the create statuslabels form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('create/statuslabel'));
        $I->dontSee('Create Status Label', '.page-header');
        $I->see('Create Status Label', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('create/statuslabel'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $status = factory(App\Models\Statuslabel::class, 'pending')->make();
        $submitValues = [
            'name'                  => 'Testing Status',
            'statuslabel_types'     => 'pending',
            'color'                 => '#b46262',
            'notes'                 => $status->notes,
            'show_in_nav'           => true,
        ];

        $recordValues = [
            'name'                  => 'Testing Status',
            'pending'               => $status->pending,
            'deployable'            => $status->archived,
            'archived'              => $status->deployable,
            'color'                 => '#b46262',
            'notes'                 => $status->notes,
            'show_in_nav'           => true,
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('create/statuslabel'));
        $I->submitForm('form#create-form', $submitValues);
        $I->seeRecord('status_labels', $recordValues);
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a Status Label');
        $I->amOnPage(route('delete/statuslabel', Statuslabel::doesntHave('assets')->first()->id));
        $I->seeElement('.alert-success');
    }
}
