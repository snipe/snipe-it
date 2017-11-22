<?php

$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure that depreciations page loads without errors');
$I->amGoingTo('go to the depreciations listing page');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/depreciations');
$I->seeInTitle('Depreciations');
$I->waitForElement('.table', 5); // secs
$I->seeNumberOfElements('table[name="depreciations"] tbody tr', [1, 5]);
$I->seeInPageSource('/depreciations/create');
$I->dontSee('Depreciations', '.page-header');
$I->see('Depreciations', 'h1.pull-left');

/* Create Form */
$I->wantTo('ensure that the create depreciation form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->click(['link' => 'Create New']);
$I->amOnPage('/depreciations/create');
$I->seeInTitle('Create Depreciation');
$I->dontSee('Create Depreciation', '.page-header');
$I->see('Create Depreciation', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
