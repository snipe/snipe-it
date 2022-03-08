<?php

use App\Helpers\Helper;
use App\Http\Transformers\UsersTransformer;
use App\Models\Group;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiUsersCest
{
    protected $user;
    protected $timeFormat;

    public function _before(ApiTester $I)
    {
        $this->user = \App\Models\User::find(1);
        $I->haveHttpHeader('Accept', 'application/json');
        $I->amBearerAuthenticated($I->getToken($this->user));
    }

    /** @test */
    public function indexUsers(ApiTester $I)
    {
        $I->wantTo('Get a list of users');

        // call
        $I->sendGET('/users?limit=10&sort=created_at');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        // sample verify
        $user = App\Models\User::orderByDesc('created_at')
            ->withCount('assets as assets_count', 'licenses as licenses_count', 'accessories as accessories_count', 'consumables as consumables_count')
            ->take(10)->get()->shuffle()->first();
        $I->seeResponseContainsJson($I->removeTimestamps((new UsersTransformer)->transformUser($user)));
    }

    /** @test */
    public function createUser(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new user');

        $temp_user = \App\Models\User::factory()->make([
            'name' => 'Test User Name',
        ]);
        Group::factory()->count(2)->create();
        $groups = Group::pluck('id');
        // setup
        $data = [
            'activated' => $temp_user->activated,
            'address' => $temp_user->address,
            'city' => $temp_user->city,
            'company_id' => $temp_user->company_id,
            'country' => $temp_user->country,
            'department_id' => $temp_user->department_id,
            'email' => $temp_user->email,
            'employee_num' => $temp_user->employee_num,
            'first_name' => $temp_user->first_name,
            'jobtitle' => $temp_user->jobtitle,
            'last_name' => $temp_user->last_name,
            'locale' => $temp_user->locale,
            'location_id' => $temp_user->location_id,
            'notes' => $temp_user->notes,
            'manager_id' => $temp_user->manager_id,
            'password' => $temp_user->password,
            'password_confirmation' => $temp_user->password,
            'phone' => $temp_user->phone,
            'state' => $temp_user->state,
            'username' => $temp_user->username,
            'zip' => $temp_user->zip,
            'groups' => $groups,
        ];

        // create
        $I->sendPOST('/users', $data);
        $I->seeResponseIsJson();
        $user = User::where('username', $temp_user->username)->first();
        $I->assertEquals($groups, $user->groups()->pluck('id'));
        $I->seeResponseCodeIs(200);
    }

    // Put is routed to the same method in the controller
    // DO we actually need to test both?

    /** @test */
    public function updateUserWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update an user with PATCH');

        // create
        $user = \App\Models\User::factory()->create([
            'first_name' => 'Original User Name',
            'company_id' => 2,
            'location_id' => 3,
        ]);
        $I->assertInstanceOf(\App\Models\User::class, $user);

        $temp_user = \App\Models\User::factory()->make([
            'company_id' => 3,
            'first_name' => 'updated user name',
            'location_id' => 1,
        ]);

        Group::factory()->count(2)->create();
        $groups = Group::pluck('id');

        $data = [
            'activated' => $temp_user->activated,
            'address' => $temp_user->address,
            'city' => $temp_user->city,
            'company_id' => $temp_user->company_id,
            'country' => $temp_user->country,
            'department_id' => $temp_user->department_id,
            'email' => $temp_user->email,
            'employee_num' => $temp_user->employee_num,
            'first_name' => $temp_user->first_name,
            'groups' => $groups,
            'jobtitle' => $temp_user->jobtitle,
            'last_name' => $temp_user->last_name,
            'locale' => $temp_user->locale,
            'location_id' => $temp_user->location_id,
            'notes' => $temp_user->notes,
            'manager_id' => $temp_user->manager_id,
            'password' => $temp_user->password,
            'phone' => $temp_user->phone,
            'state' => $temp_user->state,
            'username' => $temp_user->username,
            'zip' => $temp_user->zip,
        ];

        $I->assertNotEquals($user->first_name, $data['first_name']);

        // update
        $I->sendPATCH('/users/'.$user->id, $data);
        $I->seeResponseIsJson();

        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/users/message.success.update'), $response->messages);
        $I->assertEquals($user->id, $response->payload->id); // user id does not change
        $I->assertEquals($temp_user->company_id, $response->payload->company->id); // company_id updated
        $I->assertEquals($temp_user->first_name, $response->payload->first_name); // user name updated
        $I->assertEquals($temp_user->location_id, $response->payload->location->id); // user location_id updated
        $newUser = User::where('username', $temp_user->username)->first();
        $I->assertEquals($groups, $newUser->groups()->pluck('id'));
        $temp_user->created_at = Carbon::parse($response->payload->created_at->datetime);
        $temp_user->updated_at = Carbon::parse($response->payload->updated_at->datetime);
        $temp_user->id = $user->id;
        // verify
        $I->sendGET('/users/'.$user->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson((new UsersTransformer)->transformUser($temp_user));
    }

    /** @test */
    public function deleteUserTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an user');

        // create
        $user = \App\Models\User::factory()->create([
            'first_name' => 'Soon to be deleted',
        ]);
        $I->assertInstanceOf(\App\Models\User::class, $user);

        // delete
        $I->sendDELETE('/users/'.$user->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        // dd($response);
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/users/message.success.delete'), $response->messages);

        // verify, expect a 200
        $I->sendGET('/users/'.$user->id);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    /** @test */
    public function fetchUserAssetsTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Fetch assets for a user');

        $user = User::has('assets')->first();
        $asset = $user->assets->shuffle()->first();
        $I->sendGET("/users/{$user->id}/assets");
        $response = json_decode($I->grabResponse());
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        // Just test a random one.
        $I->seeResponseContainsJson([
            'asset_tag' => $asset->asset_tag,
        ]);
    }
}
