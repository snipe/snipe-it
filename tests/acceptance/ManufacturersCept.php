<?php
$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure that the manufacturers listing page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/manufacturers');
$I->seeNumberOfElements('table[name="manufacturers"] tr', [5,30]);
$I->see('Manufacturers');
$I->seeInTitle('Manufacturers');
$I->seeInPageSource('manufacturers/create');
$I->dontSee('Manufacturers', '.page-header');
$I->see('Manufacturers', 'h1.pull-left');


/* Create Form */
$I->wantTo('ensure that the create manufacturer form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->click(['link' => 'Create New']);
$I->amOnPage('/manufacturers/create');
$I->dontSee('Create Manufacturer', '.page-header');
$I->see('Create Manufacturer', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
