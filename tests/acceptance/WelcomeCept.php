<?php
$I = new AcceptanceTester($scenario);

$I->am('Website Visitor');
$I->wantTo('ensure that frontpage loads without errors');
$I->amGoingTo('go to the homepage');
$I->lookForwardTo('log in');
$I->amOnPage('/');
$I->seeElement('input[type=username]');
$I->seeElement('input[type=password]');
