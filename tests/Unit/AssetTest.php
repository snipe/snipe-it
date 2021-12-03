<?php
namespace Tests\Unit;

use App\Exceptions\CheckoutNotAllowed;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Location;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;
use App\Models\Component;
use App\Models\ActionLog;


class AssetTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // public function testAutoIncrementMixed()
    // {
    //     $expected = '123411';
    //     $next = Asset::nextAutoIncrement(
    //         collect([
    //             ['asset_tag' => '0012345'],
    //             ['asset_tag' => 'WTF00134'],
    //             ['asset_tag' => 'WTF-745'],
    //             ['asset_tag' => '0012346'],
    //             ['asset_tag' => '00123410'],
    //             ['asset_tag' => 'U8T7597h77'],
    //         ])
    //     );

    //     \Log::debug('Next: '.$next);
    //     $this->assertEquals($expected, $next);
    // }


    /**
     * @test
     */
    public function testWarrantyExpiresAttribute()
    {

        $asset = Asset::factory()
        ->create(
            [
                'model_id' => AssetModel::factory()
                    ->create(
                        [
                            'category_id' => Category::factory()->assetLaptopCategory()->id
                        ]
                )->id,   
                'warranty_months' => 24,
                'purchase_date' =>   Carbon::createFromDate(2017, 1, 1)->hour(0)->minute(0)->second(0)                  
            ]);

        
        $this->assertEquals(Carbon::createFromDate(2017, 1, 1)->format('Y-m-d'), $asset->purchase_date->format('Y-m-d'));
        $this->assertEquals(Carbon::createFromDate(2019, 1, 1)->format('Y-m-d'), $asset->warranty_expires->format('Y-m-d'));

    }

}
