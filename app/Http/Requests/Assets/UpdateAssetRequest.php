<?php

namespace App\Http\Requests\Assets;

use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\Traits\MayContainCustomFields;
use App\Models\Asset;
use App\Models\Setting;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends ImageUploadRequest
{
    use MayContainCustomFields;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', $this->asset);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $modelRules = (new Asset)->getRules();
        if ((Setting::getSettings()->digit_separator === '1.234,56' || '1,234.56') && is_string($this->input('purchase_cost'))) {
            // If purchase_cost was submitted as a string with a comma separator
            // then we need to ignore the normal numeric rules.
            // Since the original rules still live on the model they will be run
            // right before saving (and after purchase_cost has been
            // converted to a float via setPurchaseCostAttribute).
            $modelRules = $this->removeNumericRulesFromPurchaseCost($modelRules);
        }
        $rules = array_merge(
            parent::rules(),
            $modelRules,
            // this is to overwrite rulesets that include required, and rewrite unique_undeleted
            [
                'image_delete' => ['bool'],
                'model_id'  => ['integer', 'exists:models,id,deleted_at,NULL', 'not_array'],
                'status_id' => ['integer', 'exists:status_labels,id'],
                'asset_tag' => [
                    'min:1', 'max:255', 'not_array',
                    Rule::unique('assets', 'asset_tag')->ignore($this->asset)->withoutTrashed()
                ],
            ],
        );

        // if the purchase cost is passed in as a string **and** the digit_separator is ',' (as is common in the EU)
        // then we tweak the purchase_cost rule to make it a string
        if (Setting::getSettings()->digit_separator === '1.234,56' && is_string($this->input('purchase_cost'))) {
            $rules['purchase_cost'] = ['nullable', 'string'];
        }
        return $rules;
    }

    private function removeNumericRulesFromPurchaseCost(array $rules): array
    {
        $purchaseCost = $rules['purchase_cost'];

        // If rule is in "|" format then turn it into an array
        if (is_string($purchaseCost)) {
            $purchaseCost = explode('|', $purchaseCost);
        }

        $rules['purchase_cost'] = array_filter($purchaseCost, function ($rule) {
            return $rule !== 'numeric' && $rule !== 'gte:0';
        });

        return $rules;
    }
}
