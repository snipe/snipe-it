<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

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
          'company_id'      => 'integer',
          'warranty_months' => 'integer|min:0|max:240',
          'physical'         => 'integer',
          'checkout_date'   => 'date|max:10|min:10',
          'checkin_date'    => 'date|max:10|min:10',
          'supplier_id'     => 'integer',
          'asset_tag'       => 'required|min:2|max:255|unique:assets,asset_tag,NULL,deleted_at',
          'status'          => 'integer',
        ];

        $model = \App\Models\AssetModel::find($this->request->get('model_id'));

        if ($model->fieldset)
        {
            $rules += $model->fieldset->validation_rules();
        }



        return $rules;

    }

    public function response(array $errors)
    {
        return $this->redirector->back()->withInput()->withErrors($errors, $this->errorBag);
    }
}
