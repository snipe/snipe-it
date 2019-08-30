<?php
$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure the status labels listing page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/statuslabels');
$I->waitForElement('.table', 5); // secs
$I->seeNumberOfElements('tr', [1,30]);
$I->seeInTitle('Status Labels');
$I->see('Status Labels');
$I->seeInPageSource('statuslabels/create');
$I->dontSee('Status Labels', '.page-header');
$I->see('Status Labels', 'h1.pull-left');

/* Create Form */
$I->wantTo('ensure the create status labels form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->click(['link' => 'Create New']);
$I->amOnPage('/statuslabels/create');
$I->dontSee('Create Status Label', '.page-header');
$I->see('Create Status Label', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
