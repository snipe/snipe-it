<?php
$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure that assets page loads without errors');
$I->amGoingTo('go to the assets listing page');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/hardware');
$I->waitForElement('.table', 5); // secs
$I->seeNumberOfElements('table[name="assets"] tr', [5,50]);
$I->seeInTitle('Assets');
$I->see('Assets');
$I->seeInPageSource('hardware/create');
$I->dontSee('Assets', '.page-header');
$I->see('Assets', 'h1.pull-left');


/* Create Form */
$I->wantTo('ensure that the create assets form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/hardware/create');
$I->dontSee('Create Asset', '.page-header');
$I->see('Create Asset', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
