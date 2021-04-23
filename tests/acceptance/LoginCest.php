<?php

class LoginCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToLogin(AcceptanceTester $I)
    {
        $I->wantTo('sign in');
        $I->amOnPage('/login');
        $I->see(trans('auth/general.login_prompt'));
        $I->seeElement('input[type=text]');
        $I->seeElement('input[type=password]');
    }
}
