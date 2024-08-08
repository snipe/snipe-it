<?php

namespace App\Models;

use App\Models\Traits\Searchable;
use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

/**
 * Model for Components.
 *
 * @version    v1.0
 */
class ComponentAsset  extends SnipeModel
{
    protected $table = 'component_assets';

    protected $fillable = [
        'user_id',
        'assigned_qty',
        'component_id',
        'asset_id',
        'note',
    ];

    use Searchable;

    // Define any relationships or additional methods as needed

    /**
     * Delete the component assets based on the component ID.
     *
     * @param int $componentId
     * @return bool
     */
    public static function deleteByComponentId($componentId)
    {
        // Start the database transaction
        \DB::beginTransaction();

        try {
            // Get the component assets to be deleted
            $componentAssets = self::table('component_assets')->where('component_id', $componentId)->get();

            // // Move the component assets to history table
            foreach ($componentAssets as $componentAsset) {
            //     ComponentAssetHistory::create([
            //         'asset_id' => $componentAsset->asset_id,
            //         // Include other columns you want to move to history table
            //         // 'column_name' => $componentAsset->column_name,
            //         // 'another_column' => $componentAsset->another_column,
            //     ]);

                $componentAsset->delete();
            }

            // Commit the transaction if all operations were successful
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            \DB::rollBack();

            // Handle the exception or log the error
            // echo $e->getMessage();
            return false;
        }
    }
}
