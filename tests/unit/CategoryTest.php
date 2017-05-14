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

    protected function _before()
    {
        Artisan::call('migrate');
    }

    public function testAssetCategoryAdd()
    {
        $category = factory(Category::class)->make(['category_type' => 'asset']);
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
        $category = factory(Category::class)->make(['category_type' => 'accessory']);
        $values = [
            'name' => $category->name,
            'category_type' => $category->category_type,
            'require_acceptance' => true,
            'use_default_eula' => false
        ];

        Category::create($values);
        $this->tester->seeRecord('categories', $values);
    }

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
}
