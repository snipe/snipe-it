<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Illuminate\Foundation\Http\FormRequest;
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
        if (!$this->has('asset_tag')) {
            // TODO: not sure if i'll be able to use the route model binding here because of not-found return stuff, need to test
            $asset_tag = $this->asset->asset_tag;
        }
        if (!$this->has('model_id')) {
            $model_id = $this->asset->model_id;
        }
        if (!$this->has('status_id')) {
            $status_id = $this->asset->status_id;
        }

        $this->merge([
           'asset_tag' => $asset_tag,
           'model_id'  => $model_id,
           'status_id' => $status_id,
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
        );

        return $rules;
    }
}
