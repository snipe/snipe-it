<?php

namespace App\Http\Requests;

use App\Models\AssetModel;
use Session;


use Illuminate\Contracts\Validation\Validator;

class AssetRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'            => 'max:255|nullable',
            'model_id'        => 'required|integer|exists:models,id',
            'status_id'       => 'required|integer|exists:status_labels,id',
            'company_id'      => 'integer|nullable',
            'warranty_months' => 'numeric|nullable',
            'physical'        => 'integer|nullable',
            'checkout_date'   => 'date',
            'checkin_date'    => 'date',
            'supplier_id'     => 'integer|nullable',
            'status'          => 'integer|nullable',
            'purchase_cost'   => 'numeric|nullable',
            "assigned_user"   => 'sometimes:required_without_all:assigned_asset,assigned_location',
            "assigned_asset"   => 'sometimes:required_without_all:assigned_user,assigned_location',
            "assigned_location"   => 'sometimes:required_without_all:assigned_user,assigned_asset',
        ];

        $settings = \App\Models\Setting::getSettings();

        $rules['asset_tag'] = ($settings->auto_increment_assets == '1') ? 'max:255' : 'required';

        if($this->request->get('model_id') != '') {
            $model = AssetModel::find($this->request->get('model_id'));

            if (($model) && ($model->fieldset)) {
                $rules += $model->fieldset->validation_rules();
            }
        }

        return $rules;

    }

    public function response(array $errors)
    {
        $this->session()->flash('errors', Session::get('errors', new \Illuminate\Support\ViewErrorBag)
            ->put('default', new \Illuminate\Support\MessageBag($errors)));
        \Input::flash();
        return parent::response($errors);
    }

    /**
     * Handle a failed validation attempt.
     *
     * public function json($data = [], $status = 200, array $headers = [], $options = 0)
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        return response()->json([
                'message' => 'The given data is invalid',
                'errors' => $validator->errors()
        ], 422);
    }
}
