<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateImprovementsTable extends Migration
    {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {

            Schema::create( 'improvements', function ( Blueprint $table ) {

                $table->increments( 'id' );
                $table->enum( 'improvement_type', [ 'Maintenance', 'Repair', 'Upgrade' ] );
                $table->string( 'title', 100 );
                $table->boolean( 'is_warranty' );
                $table->dateTime( 'start_date' );
                $table->dateTime( 'completion_date' );
                $table->decimal( 'improvement_time', 8, 2 );
                $table->longText( 'notes' );
                $table->decimal( 'cost', 10, 2 );
                $table->timestamps();
            } );
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {

            Schema::dropIfExists( 'improvements' );

        }

}
