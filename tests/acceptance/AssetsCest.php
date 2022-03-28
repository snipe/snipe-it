<?php

class AssetsCest
{
    public function _before(AcceptanceTester $I)
    {
        AcceptanceTester::test_login($I);
    }

    public function listAssets(AcceptanceTester $I)
    {
        $I->am('logged in user');
        $I->wantTo('ensure that assets page loads without errors');
        $I->amGoingTo('go to the assets listing page');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/hardware');
        $I->waitForElement('.table', 20); // secs
        $I->seeNumberOfElements('table[name="assets"] tr', [5, 50]);
        $I->seeInTitle(trans('general.assets'));
        $I->see(trans('general.assets'));
        $I->seeInPageSource('hardware/create');
        $I->see(trans('general.assets'), 'h1.pull-left');
    }

    public function createAsset(AcceptanceTester $I)
    {
        $I->wantTo('ensure that the create assets form loads without errors');
        $I->lookForwardTo('seeing it load without errors');
        $I->amOnPage('/hardware/create');
        $I->dontSee('Create Asset', '.page-header');
        $I->see('Create Asset', 'h1.pull-left');
    }
}
