<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\AssetModel;
use Session;

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
          'name'            => 'min:2|max:255',
          'model_id'        => 'required|integer',
          'status_id'       => 'required|integer',
          'company_id'      => 'integer|nullable',
          'warranty_months' => 'numeric|nullable',
          'physical'        => 'integer|nullable',
          'checkout_date'   => 'date',
          'checkin_date'    => 'date',
          'supplier_id'     => 'integer|nullable',
          'status'          => 'integer|nullable',
          'asset_tag'       => 'required',
          'purchase_cost'   => 'numeric|nullable',

        ];

        $model = AssetModel::find($this->request->get('model_id'));

        if (($model) && ($model->fieldset)) {
            $rules += $model->fieldset->validation_rules();
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
}
