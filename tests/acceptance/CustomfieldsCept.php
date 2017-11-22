<?php

$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);
$I->am('logged in user');
$I->wantTo('ensure that the custom fields page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/fields');
$I->seeInTitle('Custom Fields');
$I->see('Custom Fields');
$I->seeInPageSource('/fields/create');
$I->dontSee('Custom Fields', '.page-header');
$I->dontSee('Fieldsets', '.page-header');
$I->see('Manage Custom Fields', 'h1.pull-left');
