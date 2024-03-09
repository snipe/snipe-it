<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Illuminate\Support\Facades\Gate;

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
            'asset_tag' => $this->asset_tag ?? $this->asset->asset_tag,
            'model_id' => $this->model_id ?? $this->asset->model_id,
            'status_id' => $this->status_id ?? $this->asset->status_id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = array_merge(
            (new Asset())->getRules(),
            parent::rules(),
        //['model_id' => 'required|integer|exists:models,id,deleted_at,NULL|not_array']
        );

        return $rules;
    }
}
