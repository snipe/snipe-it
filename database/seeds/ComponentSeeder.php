<?php
use Illuminate\Database\Seeder;
use App\Models\Component;

class ComponentSeeder extends Seeder
{
    public function run()
    {
        Component::truncate();
        DB::table('components_assets')->truncate();
        factory(Component::class, 1)->states('ram-crucial4')->create(); // 1
        factory(Component::class, 1)->states('ram-crucial8')->create(); // 1
        factory(Component::class, 1)->states('ssd-crucial120')->create(); // 1
        factory(Component::class, 1)->states('ssd-crucial240')->create(); // 1
    }
}
