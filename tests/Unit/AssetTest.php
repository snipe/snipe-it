<?php
namespace Tests\Unit;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Setting;

class AssetTest extends TestCase
{
    public function testAutoIncrement()
    {
        $this->settings->enableAutoIncrement();

        $a = Asset::factory()->create(['asset_tag' => Asset::autoincrement_asset() ]);
        $b = Asset::factory()->create(['asset_tag' => Asset::autoincrement_asset() ]);

        $this->assertModelExists($a);
        $this->assertModelExists($b);

    }

    public function testAutoIncrementCollision()
    {
        $this->settings->enableAutoIncrement();

        // we have to do this by hand to 'simulate' two web pages being open at the same time
        $a = Asset::factory()->make(['asset_tag' => Asset::autoincrement_asset() ]);
        $b = Asset::factory()->make(['asset_tag' => Asset::autoincrement_asset() ]);

        $this->assertTrue($a->save());
        $this->assertFalse($b->save());
    }

    public function testAutoIncrementDouble()
    {
        // make one asset with the autoincrement *ONE* higher than the next auto-increment
        // make sure you can then still make another
        $this->settings->enableAutoIncrement();

        $gap_number = Asset::autoincrement_asset(1);
        $final_number = Asset::autoincrement_asset(2);
        $a = Asset::factory()->make(['asset_tag' => $gap_number]); //make an asset with an ID that is one *over* the next increment
        $b = Asset::factory()->make(['asset_tag' => Asset::autoincrement_asset()]); //but also make one with one that is *at* the next increment
        $this->assertTrue($a->save());
        $this->assertTrue($b->save());

        //and ensure a final asset ends up at *two* over what would've been the next increment at the start
        $c = Asset::factory()->make(['asset_tag' => Asset::autoincrement_asset()]);
        $this->assertTrue($c->save());
        $this->assertEquals($c->asset_tag, $final_number);
    }

    public function testAutoIncrementGapAndBackfill()
    {
        // make one asset 3 higher than the next auto-increment
        // manually make one that's 1 lower than that
        // make sure the next one is one higher than the 3 higher one.
        $this->settings->enableAutoIncrement();

        $big_gap = Asset::autoincrement_asset(3);
        $final_result = Asset::autoincrement_asset(4);
        $backfill_one = Asset::autoincrement_asset(0);
        $backfill_two = Asset::autoincrement_asset(1);
        $backfill_three = Asset::autoincrement_asset(2);
        $a = Asset::factory()->create(['asset_tag' => $big_gap]);
        $this->assertModelExists($a);

        $b = Asset::factory()->create(['asset_tag' => $backfill_one]);
        $this->assertModelExists($b);

        $c = Asset::factory()->create(['asset_tag' => $backfill_two]);
        $this->assertModelExists($c);

        $d = Asset::factory()->create(['asset_tag' => $backfill_three]);
        $this->assertModelExists($d);

        $final = Asset::factory()->create(['asset_tag' => Asset::autoincrement_asset()]);
        $this->assertModelExists($final);
        $this->assertEquals($final->asset_tag, $final_result);
    }

    public function testPrefixlessAutoincrementBackfill()
    {
        // TODO: COPYPASTA FROM above, is there a way to still run this test but not have it be so duplicative?
        $this->settings->enableAutoIncrement()->set(['auto_increment_prefix' => '']);

        $big_gap = Asset::autoincrement_asset(3);
        $final_result = Asset::autoincrement_asset(4);
        $backfill_one = Asset::autoincrement_asset(0);
        $backfill_two = Asset::autoincrement_asset(1);
        $backfill_three = Asset::autoincrement_asset(2);
        $a = Asset::factory()->create(['asset_tag' => $big_gap]);
        $this->assertModelExists($a);

        $b = Asset::factory()->create(['asset_tag' => $backfill_one]);
        $this->assertModelExists($b);

        $c = Asset::factory()->create(['asset_tag' => $backfill_two]);
        $this->assertModelExists($c);

        $d = Asset::factory()->create(['asset_tag' => $backfill_three]);
        $this->assertModelExists($d);

        $final = Asset::factory()->create(['asset_tag' => Asset::autoincrement_asset()]);
        $this->assertModelExists($final);
        $this->assertEquals($final->asset_tag, $final_result);
    }

    public function testUnzerofilledPrefixlessAutoincrementBackfill()
    {
        // TODO: COPYPASTA FROM above (AGAIN), is there a way to still run this test but not have it be so duplicative?
        $this->settings->enableAutoIncrement()->set(['auto_increment_prefix' => '','zerofill_count' => 0]);

        $big_gap = Asset::autoincrement_asset(3);
        $final_result = Asset::autoincrement_asset(4);
        $backfill_one = Asset::autoincrement_asset(0);
        $backfill_two = Asset::autoincrement_asset(1);
        $backfill_three = Asset::autoincrement_asset(2);
        $a = Asset::factory()->create(['asset_tag' => $big_gap]);
        $this->assertModelExists($a);

        $b = Asset::factory()->create(['asset_tag' => $backfill_one]);
        $this->assertModelExists($b);

        $c = Asset::factory()->create(['asset_tag' => $backfill_two]);
        $this->assertModelExists($c);

        $d = Asset::factory()->create(['asset_tag' => $backfill_three]);
        $this->assertModelExists($d);

        $final = Asset::factory()->create(['asset_tag' => Asset::autoincrement_asset()]);
        $this->assertModelExists($final);
        $this->assertEquals($final->asset_tag, $final_result);
    }

    public function testAutoIncrementBIG()
    {
        $this->settings->enableAutoIncrement();

        // we have to do this by hand to 'simulate' two web pages being open at the same time
        $a = Asset::factory()->make(['asset_tag' => Asset::autoincrement_asset()]);
        $b = Asset::factory()->make(['asset_tag' => 'ABCD' . (PHP_INT_MAX - 1)]);

        $this->assertTrue($a->save());
        $this->assertTrue($b->save());
        $matches = [];
        preg_match('/\d+/', $a->asset_tag, $matches);
        $this->assertEquals(Setting::getSettings()->next_auto_tag_base, $matches[0] + 1, "Next auto increment number should be the last normally-saved one plus one, but isn't");
    }

    public function testAutoIncrementAlmostBIG()
    {
        // TODO: this looks pretty close to the one above, could we maybe squish them together?
        $this->settings->enableAutoIncrement();

        // we have to do this by hand to 'simulate' two web pages being open at the same time
        $a = Asset::factory()->make(['asset_tag' => Asset::autoincrement_asset()]);
        $b = Asset::factory()->make(['asset_tag' => 'ABCD' . (PHP_INT_MAX - 2)]);

        $this->assertTrue($a->save());
        $this->assertTrue($b->save());
        $matches = [];
        preg_match('/\d+/', $b->asset_tag, $matches); //this is *b*, not *a* - slight difference from above test
        $this->assertEquals(Setting::getSettings()->next_auto_tag_base, $matches[0] + 1, "Next auto increment number should be the last normally-saved one plus one, but isn't");
    }


    public function testWarrantyExpiresAttribute()
    {

        $asset = Asset::factory()
        ->create(
            [
                'model_id' => AssetModel::factory()
                    ->create(
                        [
                            'category_id' => Category::factory()->assetLaptopCategory()->create()->id
                        ]
                )->id,   
                'warranty_months' => 24,
                'purchase_date' =>   Carbon::createFromDate(2017, 1, 1)->hour(0)->minute(0)->second(0)                  
            ]);

        
        $this->assertEquals(Carbon::createFromDate(2017, 1, 1)->format('Y-m-d'), $asset->purchase_date->format('Y-m-d'));
        $this->assertEquals(Carbon::createFromDate(2019, 1, 1)->format('Y-m-d'), $asset->warranty_expires->format('Y-m-d'));

    }
}
