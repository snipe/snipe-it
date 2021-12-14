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



    public function testAComponentBelongsToACompany()
    {
        $component = Component::factory()
            ->create(
                    [
                        'company_id' => Company::factory()->create()->id
                    ]
                );
        $this->assertInstanceOf(Company::class, $component->company);
    }

    public function testAComponentHasALocation()
    {
        $component = Component::factory()
            ->create(['location_id' => Location::factory()->create()->id]);
        $this->assertInstanceOf(Location::class, $component->location);
    }

    public function testAComponentBelongsToACategory()
    {
        $component = Component::factory()->ramCrucial4()
            ->create(
                [
                    'category_id' => 
                        Category::factory()->create(
                            [
                                'category_type' => 'component'
                            ]
                )->id]);
        $this->assertInstanceOf(Category::class, $component->category);
        $this->assertEquals('component', $component->category->category_type);
    }
}
