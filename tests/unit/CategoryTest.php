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

     public function testFailsEmptyValidation()
     {
        // An Asset requires a name, a qty, and a category_id.
         $a = Category::create();
         $this->assertFalse($a->isValid());

         $fields = [
             'name' => 'name',
             'category_type' => 'category type'
         ];
         $errors = $a->getErrors();
         foreach ($fields as $field => $fieldTitle) {
             $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
         }
     }

     public function testACategoryCanHaveAssets()
     {
         $this->createValidAssetModel(); //This will seed various things to make the following work better.
         $category = $this->createValidCategory('asset-desktop-category');
         $models = factory(App\Models\AssetModel::class, 5)->states('mbp-13-model')->create(['category_id' => $category->id]);

         $this->assertEquals(5, $category->has_models());
         $this->assertCount(5, $category->models);

         $models->each(function($model) {
             factory(App\Models\Asset::class, 2)->create(['model_id' => $model->id]);
         });
         $this->assertEquals(10, $category->itemCount());
     }

     public function testACategoryCanHaveAccessories()
     {
         $category = $this->createValidCategory('accessory-keyboard-category');
         factory(App\Models\Accessory::class, 5)->states('apple-bt-keyboard')->create(['category_id' => $category->id]);

         $this->assertCount(5, $category->accessories);
         $this->assertEquals(5, $category->itemCount());
     }

     public function testACategoryCanHaveConsumables()
     {
         $category = $this->createValidCategory('consumable-paper-category');
         factory(App\Models\Consumable::class, 5)->states('cardstock')->create(['category_id' => $category->id]);
         $this->assertCount(5, $category->consumables);
         $this->assertEquals(5, $category->itemCount());
     }

     public function testACategoryCanHaveComponents()
     {
         $category = $this->createValidCategory('component-ram-category');
         factory(App\Models\Component::class, 5)->states('ram-crucial4')->create(['category_id' => $category->id]);
         $this->assertCount(5, $category->components);
         $this->assertEquals(5, $category->itemCount());
     }
}
