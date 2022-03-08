<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\CustomFieldsTransformer;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use Illuminate\Http\Request;
use Validator;

class CustomFieldsController extends Controller
{
    /**
     * Reorder the custom fields within a fieldset
     *
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @param  int  $id
     * @since [v3.0]
     * @return array
     */
    public function index()
    {
        $this->authorize('index', CustomField::class);
        $fields = CustomField::get();

        return (new CustomFieldsTransformer)->transformCustomFields($fields, $fields->count());
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
        $this->authorize('view', CustomField::class);
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
        $this->authorize('update', CustomField::class);
        $field = CustomField::findOrFail($id);

        /**
         * Updated values for the field,
         * without the "field_encrypted" flag, preventing the change of encryption status
         * @var array
         */
        $data = $request->except(['field_encrypted']);

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
        $regex_format = null;

        if (str_contains($data['format'], 'regex:')) {
            $regex_format = $data['format'];
        }

        $validator = Validator::make($data, $field->validationRules($regex_format));

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

        $this->authorize('update', $fieldset);

        $fields = [];
        $order_array = [];

        $items = $request->input('item');

        foreach ($items as $order => $field_id) {
            $order_array[$field_id] = $order;
        }

        foreach ($fieldset->fields as $field) {
            $fields[$field->id] = ['required' => $field->pivot->required, 'order' => $order_array[$field->id]];
        }

        return $fieldset->fields()->sync($fields);
    }

    public function associate(Request $request, $field_id)
    {
        $this->authorize('update', CustomFieldset::class);

        $field = CustomField::findOrFail($field_id);

        $fieldset_id = $request->input('fieldset_id');
        foreach ($field->fieldset as $fieldset) {
            if ($fieldset->id == $fieldset_id) {
                return response()->json(Helper::formatStandardApiResponse('success', $fieldset, trans('admin/custom_fields/message.fieldset.update.success')));
            }
        }

        $fieldset = CustomFieldset::findOrFail($fieldset_id);
        $fieldset->fields()->attach($field->id, ['required' => ($request->input('required') == 'on'), 'order' => $request->input('order', $fieldset->fields->count())]);

        return response()->json(Helper::formatStandardApiResponse('success', $fieldset, trans('admin/custom_fields/message.fieldset.update.success')));
    }

    public function disassociate(Request $request, $field_id)
    {
        $this->authorize('update', CustomFieldset::class);

        $field = CustomField::findOrFail($field_id);

        $fieldset_id = $request->input('fieldset_id');
        foreach ($field->fieldset as $fieldset) {
            if ($fieldset->id == $fieldset_id) {
                $fieldset->fields()->detach($field->id);

                return response()->json(Helper::formatStandardApiResponse('success', $fieldset, trans('admin/custom_fields/message.fieldset.update.success')));
            }
        }
        $fieldset = CustomFieldset::findOrFail($fieldset_id);

        return response()->json(Helper::formatStandardApiResponse('success', $fieldset, trans('admin/custom_fields/message.fieldset.update.success')));
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

        $this->authorize('delete', $field);

        if ($field->fieldset->count() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Field is in use.'));
        }

        $field->delete();

        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/custom_fields/message.field.delete.success')));
    }
}
