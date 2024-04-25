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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = array_merge(
            parent::rules(),
            (new Asset)->getRules(),
            // this is to overwrite rulesets that include required, and rewrite unique_undeleted
            [
                'model_id'  => ['integer', 'exists:models,id,deleted_at,NULL', 'not_array'],
                'status_id' => ['integer', 'exists:status_labels,id'],
                'asset_tag' => [
                    'min:1', 'max:255', 'not_array',
                    Rule::unique('assets', 'asset_tag')->ignore($this->asset)->withoutTrashed()
                ],
            ],
        );

        // OR

        $rules2 = array_merge(
            parent::rules(),
            // collects rules, 'rejects' required rules not a fan of this approach, feels inflexible
            // what if we decide something _is_ required, etc, it could get complicated and harder to read than the above
            collect((new Asset)->getRules())->map(function ($rules) {
                return collect($rules)->reject(function ($rule) {
                    return $rule === 'required';
                })->reject(function ($rule) {
                    return $rule === 'unique_undeleted:assets,asset_tag';
                })->values()->all();
            })->all(),
        );

        return $rules2;
    }
}
