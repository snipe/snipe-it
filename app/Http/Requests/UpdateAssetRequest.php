<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends ImageUploadRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', new Asset);
    }

    public function prepareForValidation()
    {
        // the following are 'required' attributes that may or may not be present on an patch request
        // so supplying them here instead of doing funky array modification to the rules
        return $this->merge([
            //'asset_tag' => $this->asset_tag ?? $this->asset->asset_tag,
            //'model_id' => $this->model_id ?? $this->asset->model_id,
            //'status_id' => $this->status_id ?? $this->asset->status_id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'model_id' => 'integer|exists:models,id,deleted_at,NULL|not_array',
            'status_id' => 'integer|exists:status_labels,id',
            'asset_tag' => ['min:1', 'max:255', 'not_array', Rule::unique('assets', 'asset_tag')->ignore($this->asset)->withoutTrashed()],
            'name' => 'nullable|max:255',
            'company_id' => 'nullable|integer|exists:companies,id',
            'warranty_months' => 'nullable|numeric|digits_between:0,240',
            'last_checkout' => 'nullable|date_format:Y-m-d H:i:s',
            'expected_checkin' => 'nullable|date',
            'location_id' => 'nullable|exists:locations,id',
            'rtd_location_id' => 'nullable|exists:locations,id',
            'purchase_date' => 'nullable|date|date_format:Y-m-d',
            'serial' => 'nullable|unique_undeleted:assets,serial',
            'purchase_cost' => 'nullable|numeric|gte:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'asset_eol_date' => 'nullable|date',
            'eol_explicit' => 'nullable|boolean',
            'byod' => 'nullable|boolean',
            'order_number' => 'nullable|string|max:191',
            'notes' => 'nullable|string|max:65535',
            'assigned_to' => 'nullable|integer',
            'requestable' => 'nullable|boolean',
        ];

        return $rules;
    }
}
