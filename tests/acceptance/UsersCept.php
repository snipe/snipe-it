<?php
$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure that the users listing page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/users');
//$I->waitForJS("return $.active == 0;", 60);
$I->waitForElement('.table', 5); // secs
//$I->seeNumberOfElements('tr', [1,10]);
$I->seeInTitle('Users');
$I->see('Users');
$I->seeInPageSource('users/create');
$I->dontSee('Users', '.page-header');
$I->see('Users', 'h1.pull-left');
$I->seeLink('Create New'); // matches <a href="/logout">Logout</a>


/* Create form */
$I->am('logged in admin');
$I->wantTo('ensure that you get errors when you submit an incomplete form');
$I->lookForwardTo('seeing errors display');
$I->click(['link' => 'Create New']);
$I->amOnPage('users/create');
$I->dontSee('Create User', '.page-header');
$I->see('Create User', 'h1.pull-left');

/* Submit form and expect errors */
$I->click(['name' => 'email']);
$I->submitForm('#userForm', [
    'email' => 'me@example.com',
]);
$I->seeElement('.alert-danger');
$I->dontSeeInSource('&lt;br&gt;&lt;');


/* Submit form and expect errors */
$I->click(['name' => 'email']);
$I->click(['name' => 'username']);
$I->submitForm('#userForm', [
    'email' => \App\Helpers\Helper::generateRandomString(15).'@example.com',
    'first_name' => 'Joe',
    'last_name' => 'Smith',
    'username' => \App\Helpers\Helper::generateRandomString(15),
]);

$I->seeElement('.alert-danger');
$I->dontSeeInSource('&lt;br&gt;&lt;');



/* Submit form and expect success */
$I->wantTo('submit the form successfully');
$I->click(['name' => 'email']);
$I->fillField(['name' => 'email'], \App\Helpers\Helper::generateRandomString(15).'@example.com');
$I->fillField(['name' => 'first_name'], 'Joe');
$I->fillField(['name' => 'last_name'], 'Smith');
$I->click(['name' => 'username']);
$I->fillField(['name' => 'username'], \App\Helpers\Helper::generateRandomString(15));
$I->click(['name' => 'password']);
$I->fillField(['name' => 'password'], 'password');
$I->click(['name' => 'password_confirmation']);
$I->fillField(['name' => 'password_confirmation'], 'password');
$I->click('Save');
$I->seeElement('.alert-success');
$I->dontSeeInSource('&lt;br&gt;&lt;');
