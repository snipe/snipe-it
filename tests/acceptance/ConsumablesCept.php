<?php

$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure that the consumables listing page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/consumables');
$I->waitForElement('.table', 5); // secs
$I->seeNumberOfElements('table[name="consumables"] tr', [5, 30]);
$I->seeInTitle('Consumables');
$I->see('Consumables');
$I->seeInPageSource('/consumables/create');
$I->dontSee('Consumables', '.page-header');
$I->see('Consumables', 'h1.pull-left');

/* Create Form */
$I->wantTo('ensure that the create consumables form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->click(['link' => 'Create New']);
$I->amOnPage('/consumables/create');
$I->dontSee('Create Consumable', '.page-header');
$I->see('Create Consumable', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
