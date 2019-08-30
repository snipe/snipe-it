<?php

namespace App\Http\Requests;

use App\Models\AssetModel;
use Session;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'warranty_months' => 'numeric|nullable|digits_between:0,240',
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

        if ($this->request->get('model_id') != '') {
            $model = AssetModel::find($this->request->get('model_id'));

            if (($model) && ($model->fieldset)) {
                $rules += $model->fieldset->validation_rules();
            }
        }

        return $rules;

    }


    /**
     * Handle a failed validation attempt.
     *
     * public function json($data = [], $status = 200, array $headers = [], $options = 0)
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $this->session()->flash('errors', Session::get('errors', new \Illuminate\Support\ViewErrorBag)
            ->put('default', new \Illuminate\Support\MessageBag($validator->errors()->toArray())));
        \Input::flash();
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'messages' => $validator->errors(),
            'payload' => null
        ], 422));
    }
}
