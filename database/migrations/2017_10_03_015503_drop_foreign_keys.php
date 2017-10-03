<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try  {
            Schema::table('accessories', function (Blueprint $table) {
                $table->dropForeign(['company_id']);
            });
        } catch (\Exception $e) {
            //echo $e;
        }

        try  {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['company_id']);
            });
        } catch (\Exception $e) {
            //echo $e;
        }

        try  {
            Schema::table('assets', function (Blueprint $table) {
                $table->dropForeign(['company_id']);
            });
        } catch (\Exception $e) {
            //echo $e;
        }

        try  {
            Schema::table('components', function (Blueprint $table) {
                $table->dropForeign(['company_id']);
            });
        } catch (\Exception $e) {
            //echo $e;
        }

        try  {
            Schema::table('consumables', function (Blueprint $table) {
                $table->dropForeign(['company_id']);
            });
        } catch (\Exception $e) {
            //echo $e;
        }

        try  {
            Schema::table('licenses', function (Blueprint $table) {
                $table->dropForeign(['company_id']);
            });
        } catch (\Exception $e) {
            //echo $e;
        }



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
