<?php

use App\Http\Transformers\LicenseSeatsTransformer;
use App\Models\Asset;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;

class ApiLicenseSeatsCest
{
    protected $license;
    protected $timeFormat;

    public function _before(ApiTester $I)
    {
        $this->user = \App\Models\User::find(1);
        $I->haveHttpHeader('Accept', 'application/json');
        $I->amBearerAuthenticated($I->getToken($this->user));
    }

    /** @test */
    public function indexLicenseSeats(ApiTester $I)
    {
        $I->wantTo('Get a list of license seats for a specific license');

        // call
        $I->sendGET('/licenses/1/seats?limit=10&order=desc');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        // sample verify
        $licenseSeats = App\Models\LicenseSeat::where('license_id', 1)
            ->orderBy('id', 'desc')->take(10)->get();
        // pick a random seat
        $licenseSeat = $licenseSeats->random();
        // need the index in the original list so that the "name" field is determined correctly
        $licenseSeatNumber = 0;
        foreach ($licenseSeats as $index=>$seat) {
            if ($licenseSeat === $seat) {
                $licenseSeatNumber = $index + 1;
            }
        }
        $I->seeResponseContainsJson($I->removeTimestamps((new LicenseSeatsTransformer)->transformLicenseSeat($licenseSeat, $licenseSeatNumber)));
    }

    /** @test */
    public function showLicenseSeat(ApiTester $I)
    {
        $I->wantTo('Get a license seat');

        // call
        $I->sendGET('/licenses/1/seats/10');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        // sample verify
        $licenseSeat = App\Models\LicenseSeat::findOrFail(10);
        $I->seeResponseContainsJson($I->removeTimestamps((new LicenseSeatsTransformer)->transformLicenseSeat($licenseSeat)));
    }

    /** @test */
    public function checkoutLicenseSeatToUser(ApiTester $I)
    {
        $I->wantTo('Checkout a license seat to a user');

        $user = App\Models\User::all()->random();
        $licenseSeat = App\Models\LicenseSeat::all()->random();
        $endpoint = '/licenses/'.$licenseSeat->license_id.'/seats/'.$licenseSeat->id;

        $data = [
            'assigned_to' => $user->id,
            'note' => 'Test Checkout to User via API',
        ];

        // update
        $I->sendPATCH($endpoint, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/licenses/message.update.success'), $response->messages);
        $I->assertEquals($licenseSeat->license_id, $response->payload->license_id); // license id does not change
        $I->assertEquals($licenseSeat->id, $response->payload->id); // license seat id does not change

        // verify
        $licenseSeat = $licenseSeat->fresh();
        $I->sendGET($endpoint);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($I->removeTimestamps((new LicenseSeatsTransformer)->transformLicenseSeat($licenseSeat)));

        // verify that the last logged action is a checkout
        $I->sendGET('/reports/activity?item_type=license&limit=1&item_id='.$licenseSeat->license_id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'action_type' => 'checkout',
        ]);
    }

    /** @test */
    public function checkoutLicenseSeatToAsset(ApiTester $I)
    {
        $I->wantTo('Checkout a license seat to an asset');

        $asset = App\Models\Asset::all()->random();
        $licenseSeat = App\Models\LicenseSeat::all()->random();
        $endpoint = '/licenses/'.$licenseSeat->license_id.'/seats/'.$licenseSeat->id;

        $data = [
            'asset_id' => $asset->id,
            'note' => 'Test Checkout to Asset via API',
        ];

        // update
        $I->sendPATCH($endpoint, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/licenses/message.update.success'), $response->messages);
        $I->assertEquals($licenseSeat->license_id, $response->payload->license_id); // license id does not change
        $I->assertEquals($licenseSeat->id, $response->payload->id); // license seat id does not change

        // verify
        $licenseSeat = $licenseSeat->fresh();
        $I->sendGET($endpoint);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($I->removeTimestamps((new LicenseSeatsTransformer)->transformLicenseSeat($licenseSeat)));

        // verify that the last logged action is a checkout
        $I->sendGET('/reports/activity?item_type=license&limit=1&item_id='.$licenseSeat->license_id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'action_type' => 'checkout',
        ]);
    }

    /** @test */
    public function checkoutLicenseSeatToUserAndAsset(ApiTester $I)
    {
        $I->wantTo('Checkout a license seat to a user AND an asset');

        $asset = App\Models\Asset::all()->random();
        $user = App\Models\User::all()->random();
        $licenseSeat = App\Models\LicenseSeat::all()->random();
        $endpoint = '/licenses/'.$licenseSeat->license_id.'/seats/'.$licenseSeat->id;

        $data = [
            'asset_id' => $asset->id,
            'assigned_to' => $user->id,
            'note' => 'Test Checkout to User and Asset via API',
        ];

        // update
        $I->sendPATCH($endpoint, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/licenses/message.update.success'), $response->messages);
        $I->assertEquals($licenseSeat->license_id, $response->payload->license_id); // license id does not change
        $I->assertEquals($licenseSeat->id, $response->payload->id); // license seat id does not change

        // verify
        $licenseSeat = $licenseSeat->fresh();
        $I->sendGET($endpoint);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($I->removeTimestamps((new LicenseSeatsTransformer)->transformLicenseSeat($licenseSeat)));

        // verify that the last logged action is a checkout
        $I->sendGET('/reports/activity?item_type=license&limit=1&item_id='.$licenseSeat->license_id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'action_type' => 'checkout',
        ]);
    }
}
