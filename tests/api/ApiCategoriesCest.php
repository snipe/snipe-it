<?php

use App\Helpers\Helper;
use App\Http\Transformers\CategoriesTransformer;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class ApiCategoriesCest
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
    public function indexCategorys(ApiTester $I)
    {
        $I->wantTo('Get a list of categories');

        // call
        $I->sendGET('/categories?order_by=id&limit=10');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse(), true);
        // sample verify
        $category = App\Models\Category::withCount('assets as assets_count', 'accessories as accessories_count', 'consumables as consumables_count', 'components as components_count', 'licenses as licenses_count')
            ->orderByDesc('created_at')->take(10)->get()->shuffle()->first();
        $I->seeResponseContainsJson($I->removeTimestamps((new CategoriesTransformer)->transformCategory($category)));
    }

    /** @test */
    public function createCategory(ApiTester $I, $scenario)
    {
        $I->wantTo('Create a new category');

        $temp_category = \App\Models\Category::factory()->assetLaptopCategory()->make([
            'name' => 'Test Category Tag',
        ]);

        // setup
        $data = [
            'category_type' => $temp_category->category_type,
            'checkin_email' => $temp_category->checkin_email,
            'eula_text' => $temp_category->eula_text,
            'name' => $temp_category->name,
            'require_acceptance' => $temp_category->require_acceptance,
            'use_default_eula' => $temp_category->use_default_eula,
        ];

        // create
        $I->sendPOST('/categories', $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
    }

    // Put is routed to the same method in the controller
    // DO we actually need to test both?

    /** @test */
    public function updateCategoryWithPatch(ApiTester $I, $scenario)
    {
        $I->wantTo('Update an category with PATCH');

        // create
        $category = \App\Models\Category::factory()->assetLaptopCategory()
            ->create([
                'name' => 'Original Category Name',
        ]);
        $I->assertInstanceOf(\App\Models\Category::class, $category);

        $temp_category = \App\Models\Category::factory()->accessoryMouseCategory()->make([
            'name' => 'updated category name',
        ]);

        $data = [
            'category_type' => $temp_category->category_type,
            'checkin_email' => $temp_category->checkin_email,
            'eula_text' => $temp_category->eula_text,
            'name' => $temp_category->name,
            'require_acceptance' => $temp_category->require_acceptance,
            'use_default_eula' => $temp_category->use_default_eula,
        ];

        $I->assertNotEquals($category->name, $data['name']);

        // update
        $I->sendPATCH('/categories/'.$category->id, $data);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());

        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/categories/message.update.success'), $response->messages);
        $I->assertEquals($category->id, $response->payload->id); // category id does not change
        $I->assertEquals($temp_category->name, $response->payload->name); // category name updated
        // Some manual copying to compare against
        $temp_category->created_at = Carbon::parse($response->payload->created_at);
        $temp_category->updated_at = Carbon::parse($response->payload->updated_at);
        $temp_category->id = $category->id;

        // verify
        $I->sendGET('/categories/'.$category->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson((new CategoriesTransformer)->transformCategory($temp_category));
    }

    /** @test */
    public function deleteCategoryTest(ApiTester $I, $scenario)
    {
        $I->wantTo('Delete an category');

        // create
        $category = \App\Models\Category::factory()->assetLaptopCategory()->create([
            'name' => 'Soon to be deleted',
        ]);
        $I->assertInstanceOf(\App\Models\Category::class, $category);

        // delete
        $I->sendDELETE('/categories/'.$category->id);
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(200);

        $response = json_decode($I->grabResponse());
        $I->assertEquals('success', $response->status);
        $I->assertEquals(trans('admin/categories/message.delete.success'), $response->messages);

        // verify, expect a 200
        $I->sendGET('/categories/'.$category->id);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
