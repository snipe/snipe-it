<?php
use Illuminate\Database\Seeder;
use App\Models\Location;


class LocationSeeder extends Seeder
{
  public function run()
  {
      Location::truncate();
      factory(Location::class, 'location', 5)->create();

  }
}
