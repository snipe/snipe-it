<?php


class AssetModelsCest
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
        $I->wantTo('Test Asset Model Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('models.create'));
        $I->seeInTitle('Create Asset Model');
        $I->see('Create Asset Model', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('models.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The manufacturer id field is required.', '.alert-msg');
        $I->see('The category id field is required.', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $model = factory(App\Models\AssetModel::class)->make();
        $values = [
            'name'              => $model->name,
            'manufacturer_id'   => $model->manufacturer_id,
            'category_id'       => $model->category_id,
            'model_number'      => $model->model_number,
            'eol'               => $model->eol,
            'notes'             => $model->notes,
            'requestable'       => $model->requestable,
        ];

        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('models.create'));

        $I->submitForm('form#create-form', $values);
        $I->seeRecord('models', $values);
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete an asset model');
        $model = factory(App\Models\AssetModel::class)->create();
        $I->sendDelete(route('models.destroy', $model->id), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }

}
