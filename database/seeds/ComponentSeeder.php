<?php
use Illuminate\Database\Seeder;
use App\Models\Component;

class ComponentSeeder extends Seeder
{
  public function run()
  {
    Component::truncate();
    DB::table('components_assets')->truncate();
    factory(Component::class, 'component',10)->create();
  }
}
