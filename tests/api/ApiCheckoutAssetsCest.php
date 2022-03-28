<?php

use App\Exceptions\CheckoutNotAllowed;
use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Setting;
use App\Models\Statuslabel;
use Illuminate\Support\Facades\Auth;

class ApiCheckoutAssetsCest
{
    protected $faker;
    protected $user;
    protected $timeFormat;

    public function _before(ApiTester $I)
    {
        $this->user = \App\Models\User::find(1);
        $I->amBearerAuthenticated($I->getToken($this->user));
    }

    /** @test */
    public function checkoutAssetToUser(ApiTester $I)
    {
        $I->wantTo('Check out an asset to a user');
        //Grab an asset from the database that isn't checked out.
        $asset = Asset::whereNull('assigned_to')->first();
        $targetUser = \App\Models\User::factory()->create();
        $data = [
            'assigned_user' => $targetUser->id,
            'note' => 'This is a test checkout note',
            'expected_checkin' => '2018-05-24',
            'name' => 'Updated Asset Name',
            'checkout_to_type' => 'user',
        ];
        $I->sendPOST("/hardware/{$asset->id}/checkout", $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/hardware/message.checkout.success'), $response->messages);

        // Confirm results.
        $I->sendGET("/hardware/{$asset->id}");
        $I->seeResponseContainsJson([
            'assigned_to' => [
                'id' => $targetUser->id,
                'type' => 'user',
            ],
            'name' => 'Updated Asset Name',
            'expected_checkin' => Helper::getFormattedDateObject('2018-05-24', 'date'),
        ]);
    }

    /** @test */
    public function checkoutAssetToAsset(ApiTester $I)
    {
        $I->wantTo('Check out an asset to an asset');
        //Grab an asset from the database that isn't checked out.
        $asset = Asset::whereNull('assigned_to')
            ->where('model_id', 8)
            ->where('status_id', Statuslabel::deployable()->first()->id)
            ->first();  // We need to make sure that this is an asset/model that doesn't require acceptance
        $targetAsset = \App\Models\Asset::factory()->desktopMacpro()->create([
            'name' => 'Test Asset For Checkout to',
        ]);
        $data = [
            'assigned_asset' => $targetAsset->id,
            'checkout_to_type' => 'asset',
        ];
        $I->sendPOST("/hardware/{$asset->id}/checkout", $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/hardware/message.checkout.success'), $response->messages);

        // Confirm results.
        $I->sendGET("/hardware/{$asset->id}");
        $I->seeResponseContainsJson([
            'assigned_to' => [
                'id' => $targetAsset->id,
                'type' => 'asset',
            ],
        ]);
    }

    /** @test */
    public function checkoutAssetToLocation(ApiTester $I)
    {
        $I->wantTo('Check out an asset to an asset');
        //Grab an asset from the database that isn't checked out.
        $asset = Asset::whereNull('assigned_to')
            ->where('model_id', 8)
            ->where('status_id', Statuslabel::deployable()->first()->id)
            ->first();  // We need to make sure that this is an asset/model that doesn't require acceptance
        $targetLocation = \App\Models\Location::factory()->create([
            'name' => 'Test Location for Checkout',
        ]);
        $data = [
            'assigned_location' => $targetLocation->id,
            'checkout_to_type' => 'location',
        ];
        $I->sendPOST("/hardware/{$asset->id}/checkout", $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/hardware/message.checkout.success'), $response->messages);

        // Confirm results.
        $I->sendGET("/hardware/{$asset->id}");
        $I->seeResponseContainsJson([
            'assigned_to' => [
                'id' => $targetLocation->id,
                'type' => 'location',
            ],
        ]);
    }

    /** @test */
    public function checkinAsset(ApiTester $I)
    {
        $I->wantTo('Checkin an asset that is currently checked out');

        $asset = Asset::whereNotNull('assigned_to')->first();

        $I->sendPOST("/hardware/{$asset->id}/checkin", [
            'note' => 'Checkin Note',
        ]);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/hardware/message.checkin.success'), $response->messages);

        // Verify
        $I->sendGET("/hardware/{$asset->id}");
        $I->seeResponseContainsJson([
            'assigned_to' => null,
        ]);
    }
}
