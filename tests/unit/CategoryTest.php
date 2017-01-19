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
        $category = factory(Category::class, 'category')->make(['category_type' => 'asset']);
        $values = [
            'name' => $category->name,
            'category_type' => $category->category_type,
            'require_acceptance' => true,
            'use_default_eula' => false
        ];

        Category::create($values);
        $this->tester->seeRecord('categories', $values);
    }

    public function testAccessoryCategoryAdd()
    {
        $category = factory(Category::class, 'category')->make(['category_type' => 'accessory']);
        $values = [
            'name' => $category->name,
            'category_type' => $category->category_type,
            'require_acceptance' => true,
            'use_default_eula' => false
        ];

        Category::create($values);
        $this->tester->seeRecord('categories', $values);
    }
}
