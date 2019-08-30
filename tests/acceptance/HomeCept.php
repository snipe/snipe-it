<?php
$I = new AcceptanceTester($scenario);

$I->wantTo('sign in');
$I->amOnPage('/login');
$I->see('Please Login');
$I->seeElement('input[type=text]');
$I->seeElement('input[type=password]');
