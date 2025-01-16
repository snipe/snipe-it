<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsTermTypeToDepreciationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('depreciations', function (Blueprint $table) {
            $table->renameColumn('months', 'term_length');
            $table->string('term_type')->default('months');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depreciations', function (Blueprint $table) {
            $table->renameColumn('term_length', 'months');
            $table->dropColumn('term_type');
        });
    }
}