<?php


class CategoriesCest
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
        $I->wantTo('Test Category Creation');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage(route('categories.create'));
        $I->seeInTitle('Create Category');
        $I->see('Create Category', 'h1.pull-left');
    }

    public function failsEmptyValidation(FunctionalTester $I)
    {
        $I->wantTo("Test Validation Fails with blank elements");
        $I->amOnPage(route('categories.create'));
        $I->click('Save');
        $I->seeElement('.alert-danger');
        $I->see('The name field is required.', '.alert-msg');
        $I->see('The category type field is required.', '.alert-msg');
    }

    public function passesCorrectValidation(FunctionalTester $I)
    {
        $category = factory(App\Models\Category::class)->make();
        $values = [
            'name'                  => $category->name,
            'category_type'         => $category->category_type,
            'eula_text'             => $category->eula_text,
            'require_acceptance'    => $category->require_acceptance,
            'checkin_email'         => $category->checkin_email,
        ];
        $I->wantTo("Test Validation Succeeds");
        $I->amOnPage(route('categories.create'));
        $I->submitForm('form#create-form', $values);
        $I->seeRecord('categories', $values);
        $I->dontSee('&lt;span class=&quot;');
        $I->seeElement('.alert-success');
    }
    public function allowsDelete(FunctionalTester $I)
    {
        $I->wantTo('Ensure I can delete a category');
        $category = factory(App\Models\Category::class)->create();
        $I->sendDelete(route('categories.destroy', $category->id), ['_token' => csrf_token()]);
        $I->seeResponseCodeIs(200);
    }
}
