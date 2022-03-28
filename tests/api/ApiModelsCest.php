<?php

use App\Helpers\Helper;
use App\Http\Transformers\AssetModelsTransformer;
use App\Models\AssetModel;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ApiModelsCest
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
    public function indexAssetModels(ApiTester $I)
    {
        $I->wantTo('Get a list of assetmodels');

        // call
        $I->sendGET('/models?limit=10');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        $assetmodel = App\Models\AssetModel::orderByDesc('created_at')
            ->withCount('assets as assets_count')->take(10)->get()->shuffle()->first();
        $I->seeResponseContainsJson($I->removeTimestamps((new AssetModelsTransformer)->transformAssetModel($assetmodel)));
    }

    /** @test */
    public function createAssetModel(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new assetmodel');

        $temp_assetmodel = \App\Models\AssetModel::factory()->mbp13Model()->make([
            'name' => 'Test AssetModel Tag',
        ]);

        // setup
        $data = [
            'category_id' => $temp_assetmodel->category_id,
            'depreciation_id' => $temp_assetmodel->depreciation_id,
            'eol' => $temp_assetmodel->eol,
            'image' => $temp_assetmodel->image,
            'manufacturer_id' => $temp_assetmodel->manufacturer_id,
            'model_number' => $temp_assetmodel->model_number,
            'name' => $temp_assetmodel->name,
            'notes' => $temp_assetmodel->notes,
        ];

        // create
        $I->sendPOST('/models', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    // Put is routed to the same method in the controller
    // DO we actually need to test both?

    /** @test */
    public function updateAssetModelWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update an assetmodel with PATCH');

        // create
        $assetmodel = \App\Models\AssetModel::factory()->mbp13Model()->create([
            'name' => 'Original AssetModel Name',
        ]);
        $I->assertInstanceOf(\App\Models\AssetModel::class, $assetmodel);

        $temp_assetmodel = \App\Models\AssetModel::factory()->polycomcxModel()->make([
            'name' => 'updated AssetModel name',
            'fieldset_id' => 2,
        ]);

        $data = [
            'category_id' => $temp_assetmodel->category_id,
            'depreciation_id' => $temp_assetmodel->depreciation_id,
            'eol' => $temp_assetmodel->eol,
            'image' => $temp_assetmodel->image,
            'manufacturer_id' => $temp_assetmodel->manufacturer_id,
            'model_number' => $temp_assetmodel->model_number,
            'name' => $temp_assetmodel->name,
            'notes' => $temp_assetmodel->notes,
            'fieldset' => $temp_assetmodel->fieldset->id,
        ];

        $I->assertNotEquals($assetmodel->name, $data['name']);

        // update
        $I->sendPATCH('/models/'.$assetmodel->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());

        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/models/message.update.success'), $response->messages);
        $I->assertEquals($assetmodel->id, $response->payload->id); // assetmodel id does not change
        $I->assertEquals($temp_assetmodel->name, $response->payload->name); // assetmodel name updated

        // Some necessary manual copying
        $temp_assetmodel->created_at = Carbon::parse($response->payload->created_at);
        $temp_assetmodel->updated_at = Carbon::parse($response->payload->updated_at);
        $temp_assetmodel->id = $assetmodel->id;
        // verify
        $I->sendGET('/models/'.$assetmodel->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson((new AssetModelsTransformer)->transformAssetModel($temp_assetmodel));
    }

    /** @test */
    public function deleteAssetModelTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an assetmodel');

        // create
        $assetmodel = \App\Models\AssetModel::factory()->mbp13Model()->create([
            'name' => 'Soon to be deleted',
        ]);
        $I->assertInstanceOf(\App\Models\AssetModel::class, $assetmodel);

        // delete
        $I->sendDELETE('/models/'.$assetmodel->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/models/message.delete.success'), $response->messages);

        // verify, expect a 200
        $I->sendGET('/models/'.$assetmodel->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
