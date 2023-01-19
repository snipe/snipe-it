<?php

$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure that the locations listing page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/locations');
$I->waitForElement('.table', 5); // secs
$I->seeNumberOfElements('tr', [5, 30]);
$I->seeInTitle('Locations');
$I->see('Locations');
$I->seeInPageSource('/locations/create');
$I->dontSee('Locations', '.page-header');
$I->see('Locations', 'h1.pull-left');

/* Create Form */
$I->wantTo('ensure that the create location form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->click(['link' => 'Create New']);
$I->amOnPage('/locations/create');
$I->dontSee('Create Location', '.page-header');
$I->see('Create Location', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
