<?php
use Illuminate\Database\Seeder;
use App\Models\CustomField;


class CustomFieldSeeder extends Seeder
{
  public function run()
  {
      CustomField::truncate();

  }
}
