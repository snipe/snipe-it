<?php

use App\Helpers\Helper;
use App\Http\Transformers\StatuslabelsTransformer;
use App\Models\Statuslabel;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ApiStatuslabelsCest
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
    public function indexStatuslabels(ApiTester $I)
    {

        $I->wantTo('Get a list of statuslabels');

        // call
        $I->sendGET('/statuslabels?limit=10');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        // sample verify
        $statuslabel = App\Models\Statuslabel::orderByDesc('created_at')
            ->withCount('assets')
            ->take(10)->get()->shuffle()->first();
        $I->seeResponseContainsJson((new StatuslabelsTransformer)->transformStatuslabel($statuslabel));
    }

    /** @test */
    public function createStatuslabel(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new statuslabel');

        $temp_statuslabel = factory(\App\Models\Statuslabel::class)->make([
            'name' => "Test Statuslabel Tag",
        ]);

        // setup
        $data = [
            'name' => $temp_statuslabel->name,
            'archived' => $temp_statuslabel->archived,
            'deployable' => $temp_statuslabel->deployable,
            'notes' => $temp_statuslabel->notes,
            'pending' => $temp_statuslabel->pending,
            'type' => 'deployable'
        ];

        // create
        $I->sendPOST('/statuslabels', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    // Put is routed to the same method in the controller
    // DO we actually need to test both?
    /** @test */
    public function updateStatuslabelWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update an statuslabel with PATCH');

        // create
        $statuslabel = factory(\App\Models\Statuslabel::class)->states('rtd')->create([
            'name' => 'Original Statuslabel Name',
        ]);
        $I->assertInstanceOf(\App\Models\Statuslabel::class, $statuslabel);

        $temp_statuslabel = factory(\App\Models\Statuslabel::class)->states('pending')->make([
            'name' => "updated statuslabel name",
            'type' => 'pending'
        ]);

        $data = [
            'name' => $temp_statuslabel->name,
            'archived' => $temp_statuslabel->archived,
            'deployable' => $temp_statuslabel->deployable,
            'notes' => $temp_statuslabel->notes,
            'pending' => $temp_statuslabel->pending,
            'type' => $temp_statuslabel->type
        ];

        $I->assertNotEquals($statuslabel->name, $data['name']);

        // update
        $I->sendPATCH('/statuslabels/' . $statuslabel->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
// dd($response);
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/statuslabels/message.update.success'), $response->messages);
        $I->assertEquals($statuslabel->id, $response->payload->id); // statuslabel id does not change
        $I->assertEquals($temp_statuslabel->name, $response->payload->name); // statuslabel name updated
        // Some manual copying to compare against
        $temp_statuslabel->created_at = Carbon::parse($response->payload->created_at);
        $temp_statuslabel->updated_at = Carbon::parse($response->payload->updated_at);
        $temp_statuslabel->id = $statuslabel->id;

        // verify
        $I->sendGET('/statuslabels/' . $statuslabel->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson((new StatuslabelsTransformer)->transformStatuslabel($temp_statuslabel));

    }

    /** @test */
    public function deleteStatuslabelTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an statuslabel');

        // create
        $statuslabel = factory(\App\Models\Statuslabel::class)->create([
            'name' => "Soon to be deleted"
        ]);
        $I->assertInstanceOf(\App\Models\Statuslabel::class, $statuslabel);

        // delete
        $I->sendDELETE('/statuslabels/' . $statuslabel->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/statuslabels/message.delete.success'), $response->messages);

        // verify, expect a 200
        $I->sendGET('/statuslabels/' . $statuslabel->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
