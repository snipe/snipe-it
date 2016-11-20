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
        $I->amOnPage(route('create/model'));
        $I->seeInTitle('Create Asset Model');
        $I->see('Create Asset Model', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('create/model'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The manufacturer id field is required.', '.alert-msg');
        $I->see('The category id field is required.', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $model = factory(App\Models\AssetModel::class, 'assetmodel')->make();
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
        $I->amOnPage(route('create/model'));

        $I->submitForm('form#create-form', $values);
        $I->seeRecord('models', $values);
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }

    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete an asset model');
        // 6 is the only one without an assigned asset.  This is fragile.
        $I->amOnPage(route('delete/model', $I->getEmptyModelId()));
        $I->seeElement('.alert-success');
    }

}
