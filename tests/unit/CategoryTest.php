<?php
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testAssetCategoryAdd()
    {
      $category = factory(Category::class, 'asset-category')->make();
      $values = [
        'name' => $category->name,
        'category_type' => $category->category_type,
      ];

      Category::create($values);
      $this->tester->seeRecord('categories', $values);
    }

    public function testAccessoryCategoryAdd()
    {
      $category = factory(Category::class, 'accessory-category')->make();
      $values = [
        'name' => $category->name,
        'category_type' => $category->category_type,
      ];

      Category::create($values);
      $this->tester->seeRecord('categories', $values);
    }

}
