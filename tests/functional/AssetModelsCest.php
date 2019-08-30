<?php


class AssetModelsCest
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
        $model = factory(App\Models\AssetModel::class)->states('mbp-13-model')->make(['name'=>'Test Model']);
        $values = [
            'category_id'       => $model->category_id,
            'depreciation_id'   => $model->depreciation_id,
            'eol'               => $model->eol,
            'manufacturer_id'   => $model->manufacturer_id,
            'model_number'      => $model->model_number,
            'name'              => $model->name,
            'notes'             => $model->notes,
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
        $model = factory(App\Models\AssetModel::class)->states('mbp-13-model')->create(['name' => "Test Model"]);
        $I->sendDelete(route('models.destroy', $model->id), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }

}
