<?php
namespace Tests\Unit;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;

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
             'category_type' => 'category type',
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
        $models = \App\Models\AssetModel::factory()->count(5)->mbp13Model()->create(['category_id' => $category->id]);

        $this->assertEquals(5, $category->models->count());
        $this->assertCount(5, $category->models);

        $models->each(function ($model) {
            // This is intentionally run twice to generate the ten imagined assets, done this way to keep it in sync with createValidAsset rather than using the factory directly.
            $this->createValidAsset(['model_id' => $model->id]);
            $this->createValidAsset(['model_id' => $model->id]);
        });
        $this->assertEquals(10, $category->itemCount());
    }

    public function testACategoryCanHaveAccessories()
    {
        $category = $this->createValidCategory('accessory-keyboard-category');
        \App\Models\Accessory::factory()->count(5)->appleBtKeyboard()->create(['category_id' => $category->id]);

        $this->assertCount(5, $category->accessories);
        $this->assertEquals(5, $category->itemCount());
    }

    public function testACategoryCanHaveConsumables()
    {
        $category = $this->createValidCategory('consumable-paper-category');
        \App\Models\Consumable::factory()->count(5)->cardstock()->create(['category_id' => $category->id]);
        $this->assertCount(5, $category->consumables);
        $this->assertEquals(5, $category->itemCount());
    }

    public function testACategoryCanHaveComponents()
    {
        $category = $this->createValidCategory('component-ram-category');
        \App\Models\Component::factory()->count(5)->ramCrucial4()->create(['category_id' => $category->id]);
        $this->assertCount(5, $category->components);
        $this->assertEquals(5, $category->itemCount());
    }
}
