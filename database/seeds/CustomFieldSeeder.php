<?php
use Illuminate\Database\Seeder;
use App\Models\CustomField;
use App\Models\CustomFieldset;
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
      CustomFieldset::truncate();
      DB::table('custom_field_custom_fieldset')->truncate();

      factory(CustomFieldset::class, 1)->states('mobile')->create();
      factory(CustomFieldset::class, 1)->states('computer')->create();
      factory(CustomField::class, 1)->states('imei')->create();
      factory(CustomField::class, 1)->states('phone')->create();
      factory(CustomField::class, 1)->states('ram')->create();
      factory(CustomField::class, 1)->states('cpu')->create();
      factory(CustomField::class, 1)->states('mac-address')->create();

      DB::table('custom_field_custom_fieldset')->insert([
            [
                'custom_field_id' => '1',
                'custom_fieldset_id' => '1'
            ],
            [
                'custom_field_id' => '2',
                'custom_fieldset_id' => '1'
            ],
            [
              'custom_field_id' => '3',
              'custom_fieldset_id' => '2'
            ],
            [
              'custom_field_id' => '4',
              'custom_fieldset_id' => '2'
            ],
            [
              'custom_field_id' => '5',
              'custom_fieldset_id' => '2'
            ],

      ]);




  }
}
