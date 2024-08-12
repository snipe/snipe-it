<?php
use App\Models\Asset;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            if (!Schema::hasColumn('assets', 'purchase_cost_explicit')) {
                $table->boolean('purchase_cost_explicit')->default(false)->after('purchase_cost');
            }
        });

        Schema::table('models', function (Blueprint $table) {
            $table->decimal('default_purchase_cost', 8, 2)->default(null)->nullable()->after('min_amt');
        });

        Asset::whereNotNull('purchase_cost')->with('model')->chunkById(500, function ($assetsWithPurchaseCosts) {
            foreach ($assetsWithPurchaseCosts as $asset) {
                if($asset->purchase_cost) {
                    if ($asset->purchase_cost !== $asset->model->default_purchase_cost) {
                        DB::table('assets')->where('id', $asset->id)->update(['purchase_cost_explicit' => true]);
                    }
                }
                else {
                    DB::table('assets')->where('id', $asset->id)->update(['purchase_cost_explicit' => false]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('purchase_cost_explicit');
        });

        Schema::table('models', function (Blueprint $table) {
            $table->dropColumn('default_purchase_cost');
        });
    }
};
