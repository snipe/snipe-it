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
                $table->integer( 'asset_id' )
                      ->unsigned();
                $table->integer( 'supplier_id' )
                      ->unsigned();
                $table->enum( 'improvement_type', [ 'Maintenance', 'Repair', 'Upgrade' ] );
                $table->string( 'title', 100 );
                $table->boolean( 'is_warranty' );
                $table->date( 'start_date' );
                $table->date( 'completion_date' );
                $table->decimal( 'improvement_time', 8, 2 );
                $table->longText( 'notes' );
                $table->decimal( 'cost', 10, 2 );
                $table->dateTime( 'deleted_at' );
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
