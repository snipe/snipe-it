<?php
namespace App\Http\Controllers;

use View;
use App\Models\CustomFieldset;
use App\Models\CustomField;
use Input;
use Validator;
use Redirect;
use App\Models\AssetModel;
use Lang;
use Auth;
use Illuminate\Http\Request;
use Log;

/**
 * This controller handles all actions related to Custom Asset Fields for
 * the Snipe-IT Asset Management application.
 *
 * @todo Improve documentation here.
 * @todo Check for raw DB queries and try to convert them to query builder statements
 * @version    v2.0
 * @author [Brady Wetherington] [<uberbrady@gmail.com>]
 */

class CustomFieldsController extends Controller
{

    /**
    * Returns a view with a listing of custom fields.
    *
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @since [v1.8]
    * @return View
    */
    public function index()
    {
        //
        $fieldsets=CustomFieldset::with("fields", "models")->get();
        //$fieldsets=CustomFieldset::all();
        $fields=CustomField::with("fieldset")->get();
        //$fields=CustomField::all();
        return View::make("custom_fields.index")->with("custom_fieldsets", $fieldsets)->with("custom_fields", $fields);
    }


    /**
    * Returns a view with a form for creating a new custom fieldset.
    *
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @since [v1.8]
    * @return View
    */
    public function create()
    {
        //
        return View::make("custom_fields.create");
    }


    /**
    * Validates and stores a new custom fieldset.
    *
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @since [v1.8]
    * @return Redirect
    */
    public function store(Request $request)
    {
        //
        $cfset = new CustomFieldset(
            [
                "name" => e($request->get("name")),
                "user_id" => Auth::user()->id]
            );

        $validator=Validator::make(Input::all(), $cfset->rules);
        if ($validator->passes()) {
            $cfset->save();
            return redirect()->route("admin.custom_fields.show", [$cfset->id])->with('success', trans('admin/custom_fields/message.fieldset.create.success'));
        } else {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    /**
    * Associate the custom field with a custom fieldset.
    *
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @since [v1.8]
    * @return View
    */
    public function associate($id)
    {

        $set = CustomFieldset::find($id);

        foreach ($set->fields as $field) {
            if ($field->id == Input::get('field_id')) {
                return redirect()->route("admin.custom_fields.show", [$id])->withInput()->withErrors(['field_id' => trans('admin/custom_fields/message.field.already_added')]);
            }
        }

        $results=$set->fields()->attach(Input::get('field_id'), ["required" => (Input::get('required') == "on"),"order" => Input::get('order')]);

        return redirect()->route("admin.custom_fields.show", [$id])->with("success", trans('admin/custom_fields/message.field.create.assoc_success'));
    }


    /**
    * Returns a view with a form to create a new custom field.
    *
    * @see CustomFieldsController::storeField()
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @since [v1.8]
    * @return View
    */
    public function createField()
    {
        return View::make("custom_fields.create_field");
    }


    /**
    * Validates and stores a new custom field.
    *
    * @see CustomFieldsController::createField()
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @since [v1.8]
    * @return Redirect
    */
    public function storeField(Request $request)
    {
        $field = new CustomField([
            "name" => e($request->get("name")),
            "element" => e($request->get("element")),
            "field_values" => e($request->get("field_values")),
            "field_encrypted" => e($request->get("field_encrypted", 0)),
            "user_id" => Auth::user()->id
        ]);



        if (!in_array(Input::get('format'), array_keys(CustomField::$PredefinedFormats))) {
            $field->format = e($request->get("custom_format"));
        } else {
            $field->format = e($request->get("format"));
        }



        $validator=Validator::make(Input::all(), $field->rules);
        if ($validator->passes()) {
            $results = $field->save();
            if ($results) {
                return redirect()->route("admin.custom_fields.index")->with("success", trans('admin/custom_fields/message.field.create.success'));
            } else {
                dd($field);
                return redirect()->back()->withInput()->with('error', trans('admin/custom_fields/message.field.create.error'));
            }
        } else {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }


    /**
     * Detach a custom field from a fieldset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return Redirect
     */
    public function deleteFieldFromFieldset($field_id, $fieldset_id)
    {
        $field = CustomField::find($field_id);

        if ($field->fieldset()->detach($fieldset_id)) {
            return redirect()->route("admin.custom_fields.index")->with("success", trans('admin/custom_fields/message.field.delete.success'));
        }

        return redirect()->back()->withErrors(['message' => "Field is in-use"]);
    }

    /**
    * Delete a custom field.
    *
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @since [v1.8]
    * @return Redirect
    */
    public function deleteField($field_id)
    {
        $field = CustomField::find($field_id);

        if ($field->fieldset->count()>0) {
            return redirect()->back()->withErrors(['message' => "Field is in-use"]);
        } else {
            $field->delete();
            return redirect()->route("admin.custom_fields.index")->with("success", trans('admin/custom_fields/message.field.delete.success'));
        }
    }

    /**
    * Validates and stores a new custom field.
    *
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @param int $id
    * @since [v1.8]
    * @return View
    */
    public function show($id)
    {
        $cfset = CustomFieldset::with('fields')->where('id','=',$id)->orderBy('id','ASC')->first();
        $custom_fields_list = ["" => "Add New Field to Fieldset"] + CustomField::lists("name", "id")->toArray();

        $maxid = 0;
        foreach ($cfset->fields() as $field) {
            if ($field->pivot->order > $maxid) {
                $maxid=$field->pivot->order;
            }
            if (isset($custom_fields_list[$field->id])) {
                unset($custom_fields_list[$field->id]);
            }
        }

        return View::make("custom_fields.show")->with("custom_fieldset", $cfset)->with("maxid", $maxid+1)->with("custom_fields_list", $custom_fields_list);
    }


    /**
    * What the actual fuck, Brady?
    *
    * @todo Uhh, build this?
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @param  int  $id
    * @since [v1.8]
    * @return Fuckall
    */
    public function edit($id)
    {
        //
    }


    /**
    * GET IN THE SEA BRADY.
    *
    * @todo Uhh, build this too?
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @param  int  $id
    * @since [v1.8]
    * @return Fuckall
    */
    public function update($id)
    {
        //
    }


    /**
    * Validates a custom fieldset and then deletes if it has no models associated.
    *
    * @author [Brady Wetherington] [<uberbrady@gmail.com>]
    * @param  int  $id
    * @since [v1.8]
    * @return View
    */
    public function destroy($id)
    {
        //
        $fieldset = CustomFieldset::find($id);

        $models = AssetModel::where("fieldset_id", "=", $id);
        if ($models->count() == 0) {
            $fieldset->delete();
            return redirect()->route("admin.custom_fields.index")->with("success", trans('admin/custom_fields/message.fieldset.delete.success'));
        } else {
            return redirect()->route("admin.custom_fields.index")->with("error", trans('admin/custom_fields/message.fieldset.delete.in_use'));
        }
    }


    /**
     * Reorder the custom fields within a fieldset
     *
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @param  int  $id
     * @since [v3.0]
     * @return Array
     */
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
}
