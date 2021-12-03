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
