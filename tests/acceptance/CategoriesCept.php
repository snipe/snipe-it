<?php
$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure that the categories listing page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/categories');
$I->waitForElement('.table', 5); // secs
$I->seeNumberOfElements('table[name="categories"] tr', [5,30]);
$I->seeInTitle('Categories');
$I->see('Categories');
$I->seeInPageSource('/categories/create');
$I->dontSee('Categories', '.page-header');
$I->see('Categories', 'h1.pull-left');

/* Create Form */
$I->wantTo('ensure that the create category form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->click(['link' => 'Create New']);
$I->amOnPage('/categories/create');
$I->dontSee('Create Category', '.page-header');
$I->see('Create Category', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
