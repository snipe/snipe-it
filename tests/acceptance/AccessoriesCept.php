<?php
$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);

$I->am('logged in user');
$I->wantTo('ensure that the accessories listing page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/accessories');
$I->waitForElement('.table', 5); // secs
$I->seeNumberOfElements('table[name="accessories"] tr', [5,30]);
$I->seeInTitle('Accessories');
$I->see('Accessories');
$I->seeInPageSource('accessories/create');
$I->dontSee('Accessories', '.page-header');
$I->see('Accessories', 'h1.pull-left');

/* Create Form */
$I->wantTo('ensure that the create accessories form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->click(['link' => 'Create New']);
$I->amOnPage('/accessories/create');
$I->dontSee('Create Accessory', '.page-header');
$I->see('Create Accessory', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
