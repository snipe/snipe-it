<?php

$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure that the suppliers listing page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/suppliers');
$I->waitForElement('.table', 5); // secs
$I->seeNumberOfElements('table[name="suppliers"] tr', [5, 25]);
$I->seeInTitle('Suppliers');
$I->see('Suppliers');
$I->seeInPageSource('suppliers/create');
$I->dontSee('Suppliers', '.page-header');
$I->see('Suppliers', 'h1.pull-left');

/* Create Form */
$I->wantTo('ensure the create supplier form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->click(['link' => 'Create New']);
$I->amOnPage('/suppliers/create');
$I->dontSee('Create Supplier', '.page-header');
$I->see('Create Supplier', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
