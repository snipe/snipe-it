<?php

use App\Helpers\Helper;
use App\Models\Company;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ApiCompaniesCest
{
    protected $user;
    protected $timeFormat;

    public function _before(ApiTester $I)
    {
        $this->user = \App\Models\User::find(1);
        $this->timeFormat = Setting::getSettings()->date_display_format .' '. Setting::getSettings()->time_display_format;
        $this->dateFormat = Setting::getSettings()->date_display_format;
        $I->haveHttpHeader('Accept', 'application/json');
        $I->amBearerAuthenticated($I->getToken($this->user));
    }

    /** @test */
    public function indexCompanys(ApiTester $I)
    {

        $I->wantTo('Get a list of companies');

        // call
        $I->sendGET('/companies?limit=10');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        // dd($response);
        // sample verify
        $company = App\Models\Company::withCount('assets','licenses','accessories','consumables','components','users')
            ->orderByDesc('created_at')->take(10)->get()->shuffle()->first();
        $I->seeResponseContainsJson($this->generateJsonResponse($company, $company));
    }

    /** @test */
    public function createCompany(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new company');

        $temp_company = factory(\App\Models\Company::class)->make([
            'name' => "Test Company Tag",
        ]);

        // setup
        $data = [
            'name' => $temp_company->name,
        ];

        // create
        $I->sendPOST('/companies', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    // Put is routed to the same method in the controller
    // DO we actually need to test both?
    /** @test */
    public function updateCompanyWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update an company with PATCH');

        // create
        $company = factory(\App\Models\Company::class)->create([
            'name' => 'Original Company Name',
        ]);
        $I->assertInstanceOf(\App\Models\Company::class, $company);

        $temp_company = factory(\App\Models\Company::class)->make([
            'name' => "updated company name",
        ]);

        $data = [
            'name' => $temp_company->name,
        ];

        $I->assertNotEquals($company->name, $data['name']);

        // update
        $I->sendPATCH('/companies/' . $company->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());

        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/companies/message.update.success'), $response->messages);
        $I->assertEquals($company->id, $response->payload->id); // company id does not change
        $I->assertEquals($temp_company->name, $response->payload->name); // company name updated

        // verify
        $I->sendGET('/companies/' . $company->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson($this->generateJsonResponse($temp_company, $company));
    }

    /** @test */
    public function deleteCompanyTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an company');

        // create
        $company = factory(\App\Models\Company::class)->create([
            'name' => "Soon to be deleted"
        ]);
        $I->assertInstanceOf(\App\Models\Company::class, $company);

        // delete
        $I->sendDELETE('/companies/' . $company->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/companies/message.delete.success'), $response->messages);

        // verify, expect a 200
        $I->sendGET('/companies/' . $company->id);
        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
    }

    protected function generateJsonResponse($company, $orig_company)
    {
        return [
            'id' => (int) $orig_company->id,
            'name' => e($company->name),
            'image' => ($company->image) ? url('/').'/uploads/companies/'.e($company->image) : null,
            'created_at' => Helper::getFormattedDateObject($orig_company->created_at, 'datetime'),
            'updated_at' => Helper::getFormattedDateObject($orig_company->updated_at, 'datetime'),
            'assets_count' => (int) $company->assets_count,
            'licenses_count' => (int) $company->licenses_count,
            'accessories_count' => (int) $company->accessories_count,
            'consumables_count' => (int) $company->consumables_count,
            'components_count' => (int) $company->components_count,
            'users_count' => (int) $company->users_count,
            // 'available_actions' => [
            //     'update' => (bool) Gate::allows('update', Company::class),
            //     'delete' => (bool) Gate::allows('delete', Company::class),
            // ],
        ];
    }
}
