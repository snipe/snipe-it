<?php

use App\Http\Transformers\LicensesTransformer;

class ApiLicensesCest
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
    public function indexLicenses(ApiTester $I)
    {
        $I->wantTo('Get a list of licenses');

        // call
        $I->sendGET('/licenses?limit=10&sort=created_at');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        // sample verify
        $licenseModel = App\Models\LicenseModel::orderByDesc('created_at')
            ->withCount('freeLicenses')
            ->take(10)->get()->shuffle()->first();

        $I->seeResponseContainsJson($I->removeTimestamps((new LicensesTransformer)->transformLicense($licenseModel)));
    }

    /** @test */
    public function createLicense(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new license');

        $temp_license = factory(\App\Models\LicenseModel::class)->states('acrobat')->make([
            'name' => "Test License Name",
            'depreciation_id' => 3,
            'company_id' => 2
        ]);

        // setup
        $data = [
            'company_id' => $temp_license->company_id,
            'depreciation_id' => $temp_license->depreciation_id,
            'expiration_date' => $temp_license->expiration_date,
            'license_email' => $temp_license->license_email,
            'license_name' => $temp_license->license_name,
            'maintained' => $temp_license->maintained,
            'manufacturer_id' => $temp_license->manufacturer_id,
            'name' => $temp_license->name,
            'notes' => $temp_license->notes,
            'order_number' => $temp_license->order_number,
            'purchase_cost' => $temp_license->purchase_cost,
            'purchase_date' => $temp_license->purchase_date,
            'purchase_order' => $temp_license->purchase_order,
            'reassignable' => $temp_license->reassignable,
            'seats' => $temp_license->seats,
            'serial' => $temp_license->serial,
            'supplier_id' => $temp_license->supplier_id,
            'termination_date' => $temp_license->termination_date,
        ];

        // create
        $I->sendPOST('/licenses', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    // Put is routed to the same method in the controller
    // DO we actually need to test both?
    /** @test */
    public function updateLicenseWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update a licenseModel with PATCH');

        // create
        $licenseModel = factory(\App\Models\LicenseModel::class)->states('acrobat')->create([
            'name' => 'Original License Name',
            'depreciation_id' => 3,
            'company_id' => 2
        ]);
        $I->assertInstanceOf(\App\Models\LicenseModel::class, $licenseModel);

        $temp_license = factory(\App\Models\LicenseModel::class)->states('office')->make([
            'company_id' => 3,
            'depreciation_id' => 2
        ]);

        $data = [
            'company_id' => $temp_license->company_id,
            'depreciation_id' => $temp_license->depreciation_id,
            'expiration_date' => $temp_license->expiration_date,
            'license_email' => $temp_license->license_email,
            'license_name' => $temp_license->license_name,
            'maintained' => $temp_license->maintained,
            'manufacturer_id' => $temp_license->manufacturer_id,
            'name' => $temp_license->name,
            'notes' => $temp_license->notes,
            'order_number' => $temp_license->order_number,
            'purchase_cost' => $temp_license->purchase_cost,
            'purchase_date' => $temp_license->purchase_date,
            'purchase_order' => $temp_license->purchase_order,
            'reassignable' => $temp_license->reassignable,
            'seats' => $temp_license->seats,
            'serial' => $temp_license->serial,
            'supplier_id' => $temp_license->supplier_id,
            'category_id' => $temp_license->category_id,
            'termination_date' => $temp_license->termination_date,
        ];

        $I->assertNotEquals($licenseModel->name, $data['name']);

        // update
        $I->sendPATCH('/licenses/' . $licenseModel->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/licenses/message.update.success'), $response->messages);
        $I->assertEquals($licenseModel->id, $response->payload->id); // licenseModel id does not change
        $I->assertEquals($temp_license->name, $response->payload->name); // licenseModel name
        $temp_license->created_at = Carbon::parse($response->payload->created_at);
        $temp_license->updated_at = Carbon::parse($response->payload->updated_at);
        $temp_license->id = $licenseModel->id;
        // verify
        $I->sendGET('/licenses/' . $licenseModel->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson((new LicensesTransformer)->transformLicense($temp_license));
    }

    /** @test */
    public function deleteLicenseWithUsersTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Ensure a licenseModel with seats checked out cannot be deleted');

        // create
        $licenseModel = factory(\App\Models\LicenseModel::class)->states('acrobat')->create([
            'name' => "Soon to be deleted"
        ]);
        $license = $licenseModel->freeLicense();
        $license->assigned_to = $this->user->id;
        $license->save();
        $I->assertInstanceOf(\App\Models\LicenseModel::class, $licenseModel);

        // delete
        $I->sendDELETE('/licenses/' . $licenseModel->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('error', $response->status);
        $I->assertEquals(trans('admin/licenses/message.assoc_users'), $response->messages);
    }

    /** @test */
    public function deleteLicenseTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an licenseModel');

        // create
        $licenseModel = factory(\App\Models\LicenseModel::class)->states('acrobat')->create([
            'name' => "Soon to be deleted"
        ]);
        $I->assertInstanceOf(\App\Models\LicenseModel::class, $licenseModel);

        // delete
        $I->sendDELETE('/licenses/' . $licenseModel->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/licenses/message.delete.success'), $response->messages);

        // verify, expect a 200
        $I->sendGET('/licenses/' . $licenseModel->id);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
