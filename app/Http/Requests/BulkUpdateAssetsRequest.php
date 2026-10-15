<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

/**
 * Bulk update: same field rules as UpdateAssetRequest, plus an `ids` array in
 * the request body naming which assets to update. Per-row authorization
 * happens in AssetsController::bulkUpdate() because a caller who can update
 * one asset may not be able to update another (FMCS, policy).
 */
class BulkUpdateAssetsRequest extends UpdateAssetRequest
{
    public function authorize()
    {
        // Coarse gate: caller must have general update permission on the
        // Asset resource. Per-row permission is checked inside bulkUpdate()
        // so a single denied asset produces one error row, not a whole 403.
        return Gate::allows('update', Asset::class);
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ]);
    }

    /**
     * Bulk endpoint always returns the per-row envelope — for a request-level
     * validation failure (bad field values, missing ids) we fan the same
     * error messages out to every id the caller aimed at so downstream code
     * iterating `results` doesn't need a special "whole payload rejected"
     * branch.
     */
    protected function failedValidation(Validator $validator)
    {
        $errorMessages = $validator->errors()->messages();
        $ids = array_values(array_unique(array_map(
            'intval',
            array_filter((array) $this->input('ids', []), fn ($v) => is_numeric($v))
        )));

        $results = array_map(fn ($id) => [
            'id' => $id,
            'status' => 'error',
            'messages' => $errorMessages,
            'payload' => null,
        ], $ids);

        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'messages' => $ids === []
                ? $errorMessages
                : trans('admin/hardware/message.bulk_update.error'),
            'results' => $results,
        ]));
    }

    /**
     * Bulk can't `Rule::unique->ignore()` N ids simultaneously; per-row
     * uniqueness collisions are caught by Watson's ValidatingTrait at
     * save-time and surface as row-level errors in the envelope.
     */
    protected function ignoreIdForUnique(): ?int
    {
        return null;
    }
}
