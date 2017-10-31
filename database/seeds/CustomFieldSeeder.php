<?php
use Illuminate\Database\Seeder;
use App\Models\CustomField;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


class CustomFieldSeeder extends Seeder
{
  public function run()
  {
      $columns = DB::getSchemaBuilder()->getColumnListing('assets');


          foreach ($columns as $column) {
              if(strpos($column, '_snipeit_') !== FALSE) {

                  Schema::table('assets', function (Blueprint $table) use ($column) {
                      $table->dropColumn($column);
                  });
              }
          }
      CustomField::truncate();
      factory(CustomField::class, 4)->create();

  }
}
