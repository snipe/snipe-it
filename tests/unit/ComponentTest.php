<?php
namespace Tests\Unit;

use App\Models\Category;
use App\Models\Company;
use App\Models\Component;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;

class ComponentTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testFailsEmptyValidation()
    {
        // An Component requires a name, a qty, and a category_id.
        $a = Component::create();
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
        // An Component name has a min length of 3
        // An Component has a min qty of 1
        // An Component has a min amount of 0
        $a = Component::factory()->make([
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
        $category = $this->createValidCategory('component-hdd-category',
            ['category_type' => 'component']);
        $component = Component::factory()->ssdCrucial240()
            ->make(['category_id' => $category->id]);
        $this->createValidManufacturer('apple');

        $component->save();
        $this->assertTrue($component->isValid());
        $newId = $category->id + 1;
        $component = Component::factory()->ssdCrucial240()->make(['category_id' => $newId]);
        $component->save();

        $this->assertFalse($component->isValid());
        $this->assertStringContainsString('The selected category id is invalid.', $component->getErrors()->get('category_id')[0]);
    }

    public function testAnComponentBelongsToACompany()
    {
        $component = Component::factory()
            ->create(['company_id' => Company::factory()->create()->id]);
        $this->assertInstanceOf(Company::class, $component->company);
    }

    public function testAnComponentHasALocation()
    {
        $component = Component::factory()
            ->create(['location_id' => Location::factory()->create()->id]);
        $this->assertInstanceOf(Location::class, $component->location);
    }

    public function testAnComponentBelongsToACategory()
    {
        $component = Component::factory()->ssdCrucial240()
            ->create([
                'category_id' => Category::factory()->componentHddCategory()
                                    ->create(['category_type' => 'component'])->id,
            ]);
        $this->assertInstanceOf(Category::class, $component->category);
        $this->assertEquals('component', $component->category->category_type);
    }
}
