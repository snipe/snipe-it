<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\AssetModel;
use Session;

class ComponentRequest extends Request
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
		\Debugbar::info('ComponentRequest::rules');
		// \Debugbar::addMessage('ComponentRequest::rules', 'mylabel');.
        $rules = [
          'name'            => 'required|min:2|max:255',
		  'component_tag'   => 'required',
          'model_id'        => 'required|integer',
          'company_id'      => 'integer',
          'warranty_months' => 'integer|min:0|max:240',
		  'qty'             => 'required|integer|min:1',
          'supplier_id'     => 'integer',
          'purchase_date'   => 'date',
          'purchase_cost'   => 'numeric',

        ];

        // $model = AssetModel::find($this->request->get('model_id'));
        // if (($model) && ($model->fieldset)) {
            // $rules += $model->fieldset->validation_rules();
        // }

		\Debugbar::info('ComponentRequest::rules 1');
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
