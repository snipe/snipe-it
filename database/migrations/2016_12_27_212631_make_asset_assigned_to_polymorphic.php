<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Asset;
use App\Models\User;

class MakeAssetAssignedToPolymorphic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('assets', function (Blueprint $table) {
             $table->string('assigned_type')->nullable();
         });

        // Prior to this migration, asset's could only be assigned to users
        switch($database = config('database.default')) {
            case 'mysql':
                // In mysql int may be empty
                Asset::whereNotNull('assigned_to')->orWhere('assigned_to', '!=', '')->update(['assigned_type' => User::class]);
                break;
            case 'pgsql':
                Asset::whereNotNull('assigned_to')->update(['assigned_type' => User::class]);
                break;
            default:
                throw new Exception('Unsupported database: '. $database);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return voidatom
     */
    public function down()
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('assigned_type');
        });
    }
}
