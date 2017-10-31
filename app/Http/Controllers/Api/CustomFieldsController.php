<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Transformers\CustomFieldsTransformer;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use Illuminate\Http\Request;

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
