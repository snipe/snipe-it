<?php

namespace App\Actions\AssetModels;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MergeAssetModelsAction
{
    /**
     * Reassign every asset attached to each of $sources onto $target,
     * then soft-delete the source models. Writes an action_log entry
     * on both the source and the surviving target for each pair, so
     * the merge history is visible from either side.
     *
     * Transactional: a partial failure rolls the whole operation
     * back, so admins never end up with half-moved assets and a
     * half-deleted source list.
     *
     * @param  Collection<int, AssetModel>  $sources
     * @return int Number of assets reassigned across all sources.
     */
    public static function run(AssetModel $target, Collection $sources, ?User $admin): int
    {
        return DB::transaction(function () use ($target, $sources, $admin) {
            $moved = 0;
            foreach ($sources as $source) {
                $moved += Asset::where('model_id', $source->id)
                    ->update(['model_id' => $target->id]);
                $source->delete();
                self::logMerge($source, $target, $admin);
            }

            return $moved;
        });
    }

    private static function logMerge(AssetModel $source, AssetModel $target, ?User $admin): void
    {
        // One absolute note text, used on both logs. Avoids the
        // "this model" ambiguity that shows up when the polymorphic
        // history relation pulls both entries onto both models'
        // history tabs.
        $note = trans('general.merged_log_model', [
            'from_id' => $source->id,
            'from_name' => $source->name,
            'to_id' => $target->id,
            'to_name' => $target->name,
        ]);

        Log::debug('Asset models merged: '.$source->id.' ('.$source->name.') merged into '.$target->id.' ('.$target->name.')');

        // Record on the source model (the one being deleted).
        $sourceLog = new Actionlog;
        $sourceLog->item_id = $source->id;
        $sourceLog->item_type = AssetModel::class;
        $sourceLog->target_id = $target->id;
        $sourceLog->target_type = AssetModel::class;
        $sourceLog->action_type = ActionType::Merged->value;
        $sourceLog->note = $note;
        $sourceLog->created_by = $admin->id ?? null;
        $sourceLog->save();

        // Record on the surviving target so history is visible from
        // the model that stuck around.
        $targetLog = new Actionlog;
        $targetLog->item_id = $target->id;
        $targetLog->item_type = AssetModel::class;
        $targetLog->target_id = $source->id;
        $targetLog->target_type = AssetModel::class;
        $targetLog->action_type = ActionType::Merged->value;
        $targetLog->note = $note;
        $targetLog->created_by = $admin->id ?? null;
        $targetLog->save();
    }
}
