<?php

namespace Tests\Unit\Mail;

use App\Mail\CheckoutAssetMail;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\User;
use Tests\TestCase;

class CheckoutAssetMailTest extends TestCase
{
    public function testSubjectLine()
    {
        $user = User::factory()->create();
        $actor = User::factory()->create();

        $assetRequiringAcceptance = Asset::factory()->requiresAcceptance()->create();
        $assetNotRequiringAcceptance = Asset::factory()->doesNotRequireAcceptance()->create();

        $acceptance = CheckoutAcceptance::factory()->for($assetRequiringAcceptance, 'checkoutable')->create();

        (new CheckoutAssetMail(
            $assetRequiringAcceptance,
            $user,
            $actor,
            $acceptance,
            'A note goes here',
            true,
        ))->assertHasSubject('Asset checked out');

        (new CheckoutAssetMail(
            $assetNotRequiringAcceptance,
            $user,
            $actor,
            null,
            'A note goes here',
            true,
        ))->assertHasSubject('Asset checked out');

        (new CheckoutAssetMail(
            $assetRequiringAcceptance,
            $user,
            $actor,
            $acceptance,
            'A note goes here',
            false,
        ))->assertHasSubject('Reminder: You have Unaccepted Assets.');
    }

    public function testContent()
    {
        $user = User::factory()->create();
        $actor = User::factory()->create();

        $assetRequiringAcceptance = Asset::factory()->requiresAcceptance()->create();
        $assetNotRequiringAcceptance = Asset::factory()->doesNotRequireAcceptance()->create();

        $acceptance = CheckoutAcceptance::factory()->for($assetRequiringAcceptance, 'checkoutable')->create();

        (new CheckoutAssetMail(
            $assetRequiringAcceptance,
            $user,
            $actor,
            $acceptance,
            'A note goes here',
            true,
        ))->assertSeeInText('A new item has been checked out under your name that requires acceptance, details are below.');

        (new CheckoutAssetMail(
            $assetNotRequiringAcceptance,
            $user,
            $actor,
            null,
            'A note goes here',
            true,
        ))->assertSeeInText('A new item has been checked out under your name, details are below.');

        (new CheckoutAssetMail(
            $assetRequiringAcceptance,
            $user,
            $actor,
            $acceptance,
            'A note goes here',
            false,
        ))->assertSeeInText('An item was recently checked out under your name that requires acceptance, details are below.');
    }
}
