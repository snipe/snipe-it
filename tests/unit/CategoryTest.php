<?php
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

//     public function testAssetCategoryAdd()
//     {
//         $category = factory(Category::class)->make(['category_type' => 'asset']);
//         $values = [
//             'name' => $category->name,
//             'category_type' => $category->category_type,
//             'require_acceptance' => true,
//             'use_default_eula' => false
//         ];

//         Category::create($values);
//         $this->tester->seeRecord('categories', $values);
//     }

//     public function testAccessoryCategoryAdd()
//     {
//         $category = factory(Category::class)->make(['category_type' => 'accessory']);
//         $values = [
//             'name' => $category->name,
//             'category_type' => $category->category_type,
//             'require_acceptance' => true,
//             'use_default_eula' => false
//         ];

//         Category::create($values);
//         $this->tester->seeRecord('categories', $values);
//     }

//     public function testFailsEmptyValidation()
//     {
//        // An Asset requires a name, a qty, and a category_id.
//         $a = Category::create();
//         $this->assertFalse($a->isValid());

//         $fields = [
//             'name' => 'name',
//             'category_type' => 'category type'
//         ];
//         $errors = $a->getErrors();
//         foreach ($fields as $field => $fieldTitle) {
//             $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
//         }
//     }

//     public function testACategoryCanHaveAssets()
//     {
//         $category = factory(Category::class)->create(['category_type' => 'asset']);
//         $models = factory(App\Models\AssetModel::class, 5)->create(['category_id' => $category->id]);
//         $this->assertEquals(5, $category->has_models());
//         $this->assertCount(5, $category->models);

//         $models->each(function($model) {
//             factory(App\Models\Asset::class, 2)->create(['model_id' => $model->id]);
//         });
//         $this->assertEquals(10, $category->itemCount());
//     }

//     public function testACategoryCanHaveAccessories()
//     {
//         $category = factory(Category::class)->create(['category_type' => 'accessory']);
//         factory(App\Models\Accessory::class, 5)->create(['category_id' => $category->id]);
//         $this->assertCount(5, $category->accessories);
//         $this->assertEquals(5, $category->itemCount());
//     }

//     public function testACategoryCanHaveConsumables()
//     {
//         $category = factory(Category::class)->create(['category_type' => 'consumable']);
//         factory(App\Models\Consumable::class, 5)->create(['category_id' => $category->id]);
//         $this->assertCount(5, $category->consumables);
//         $this->assertEquals(5, $category->itemCount());
//     }

//     public function testACategoryCanHaveComponents()
//     {
//         $category = factory(Category::class)->create(['category_type' => 'component']);
//         factory(App\Models\Component::class, 5)->create(['category_id' => $category->id]);
//         $this->assertCount(5, $category->components);
//         $this->assertEquals(5, $category->itemCount());
//     }
}
