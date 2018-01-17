<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\CustomFieldsTransformer;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class CustomFieldsController extends Controller
{
    /**
     * Reorder the custom fields within a fieldset
     *
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @param  int  $id
     * @since [v3.0]
     * @return Array
     */

    public function index()
    {
        $this->authorize('index', CustomFields::class);
        $fields = CustomField::get();

        $total = count($fields);
        return (new CustomFieldsTransformer)->transformCustomFields($fields, $total);
    }

    /**
    * Shows the given field
    * @author [V. Cordes] [<volker@fdatek.de>]
    * @param int $id
    * @since [v4.1.10]
    * @return View
    */
    public function show($id)
    {
      $this->authorize('show', CustomField::class);
        if ($field = CustomField::find($id)) {
            return (new CustomFieldsTransformer)->transformCustomField($field);
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/custom_fields/message.field.invalid')), 200);
    }

     /**
     * Update the specified field
     *
     * @author [V. Cordes] [<volker@fdatek.de>]
     * @since [v4.1.10]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit', CustomField::class);
        $field = CustomField::findOrFail($id);
        $data = $request->all();

        $validator = Validator::make($data, $field->validationRules());
        if ($validator->fails()) {
            return response()->json(Helper::formatStandardApiResponse('error', null, $validator->errors()));
        }

        $field->fill($data);

        if ($field->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $field, trans('admin/custom_fields/message.field.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $field->getErrors()));
    }


    /**
     * Store a newly created field.
     *
     * @author [V. Cordes] [<volker@fdatek.de>]
     * @since [v4.1.10]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', CustomField::class);
        $field = new CustomField;

        $data = $request->all();
        $validator = Validator::make($data, $field->validationRules());
        if ($validator->fails()) {
            return response()->json(Helper::formatStandardApiResponse('error', null, $validator->errors()));
        }
        $field->fill($data);

        if ($field->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $field, trans('admin/custom_fields/message.field.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $field->getErrors()));

    }

    public function postReorder(Request $request, $id)
    {
        $fieldset = CustomFieldset::find($id);
        $fields = array();
        $order_array = array();

        $items = $request->input('item');

        foreach ($items as $order => $field_id) {
            $order_array[$field_id] = $order;
        }

        foreach ($fieldset->fields as $field) {
            $fields[$field->id] = ['required' => $field->pivot->required, 'order' => $order_array[$field->id]];
        }

        return $fieldset->fields()->sync($fields);

    }


    /**
     * Delete a custom field.
     *
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @since [v1.8]
     * @return Redirect
     */
    public function destroy($field_id)
    {
        $field = CustomField::findOrFail($field_id);

        if ($field->fieldset->count() >0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Field is in use.'));
        }

        $field->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/custom_fields/message.field.delete.success')));

    }

}
