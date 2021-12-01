<?php
namespace Tests\Unit;

use App\Models\Accessory;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;

class AccessoryTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testFailsEmptyValidation()
    {
        // An Accessory requires a name, a qty, and a category_id.
        $a = Accessory::create();
        $this->assertFalse($a->isValid());
        $fields = [
            'name' => 'name',
            'qty' => 'qty',
            'category_id' => 'category id',
        ];
        $errors = $a->getErrors();
        foreach ($fields as $field => $fieldTitle) {
            $this->assertEquals($errors->get($field)[0], "The ${fieldTitle} field is required.");
        }
    }

    public function testFailsMinValidation()
    {
        // An Accessory name has a min length of 3
        // An Accessory has a min qty of 1
        // An Accessory has a min amount of 0
        $a = Accessory::factory()->make([
            'name' => 'a',
            'qty' => 0,
            'min_amt' => -1,
        ]);
        $fields = [
            'name' => 'name',
            'qty' => 'qty',
            'min_amt' => 'min amt',
        ];
        $this->assertFalse($a->isValid());
        $errors = $a->getErrors();
        foreach ($fields as $field => $fieldTitle) {
            $this->assertStringContainsString("The ${fieldTitle} must be at least", $errors->get($field)[0]);
        }
    }

    public function testCategoryIdMustExist()
    {
        $category = $this->createValidCategory('accessory-keyboard-category', ['category_type' => 'accessory']);
        $accessory = Accessory::factory()->appleBtKeyboard()->make(['category_id' => $category->id]);
        $this->createValidManufacturer('apple');

        $accessory->save();
        $this->assertTrue($accessory->isValid());
        $newId = $category->id + 1;
        $accessory = Accessory::factory()->appleBtKeyboard()->make(['category_id' => $newId]);
        $accessory->save();

        $this->assertFalse($accessory->isValid());
        $this->assertStringContainsString('The selected category id is invalid.', $accessory->getErrors()->get('category_id')[0]);
    }

    public function testAnAccessoryBelongsToACompany()
    {
        $accessory = Accessory::factory()
            ->create(['company_id' => \App\Models\Company::factory()->create()->id]);
        $this->assertInstanceOf(App\Models\Company::class, $accessory->company);
    }

    public function testAnAccessoryHasALocation()
    {
        $accessory = Accessory::factory()
            ->create(['location_id' => \App\Models\Location::factory()->create()->id]);
        $this->assertInstanceOf(App\Models\Location::class, $accessory->location);
    }

    public function testAnAccessoryBelongsToACategory()
    {
        $accessory = Accessory::factory()->appleBtKeyboard()
            ->create(['category_id' => Category::factory()->accessoryKeyboardCategory()->create(['category_type' => 'accessory'])->id]);
        $this->assertInstanceOf(App\Models\Category::class, $accessory->category);
        $this->assertEquals('accessory', $accessory->category->category_type);
    }

    public function testAnAccessoryHasAManufacturer()
    {
        $this->createValidManufacturer('apple');
        $this->createValidCategory('accessory-keyboard-category');
        $accessory = Accessory::factory()->appleBtKeyboard()->create(['category_id' => 1]);
        $this->assertInstanceOf(App\Models\Manufacturer::class, $accessory->manufacturer);
    }
}
