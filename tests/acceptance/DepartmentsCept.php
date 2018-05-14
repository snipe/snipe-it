<?php
$I = new AcceptanceTester($scenario);
AcceptanceTester::test_login($I);

$I->am('logged in user');
$I->wantTo('ensure that the department listing page loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->amOnPage('/departments');
$I->waitForElement('.table', 5); // secs
$I->seeNumberOfElements('table[name="departments"] tr', [5,30]);
$I->seeInTitle('Departments');
$I->see('Departments');
$I->seeInPageSource('departments/create');
$I->dontSee('Departments', '.page-header');
$I->see('Departments', 'h1.pull-left');

/* Create Form */
$I->wantTo('ensure that the create department form loads without errors');
$I->lookForwardTo('seeing it load without errors');
$I->click(['link' => 'Create New']);
$I->amOnPage('/department/create');
$I->dontSee('Create Department', '.page-header');
$I->see('Create Department', 'h1.pull-left');
$I->dontSee('&lt;span class=&quot;');
