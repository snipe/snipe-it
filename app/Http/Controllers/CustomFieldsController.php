<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\CustomFieldRequest;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use \Illuminate\Contracts\View\View;


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
     */
    public function index(Request $request): View
    {
        $this->authorize('view', CustomField::class);
        if ($request->input('tab') == 1) {
            // Users section, make sure to auto-create the first fieldset if so
            CustomFieldset::firstOrCreate(['type' => Helper::$itemtypes_having_custom_fields[1]], ['name' => 'default']);
        }

        $fieldsets = CustomFieldset::with('fields')->where("type", Helper::$itemtypes_having_custom_fields[$request->get('tab', 0)])->get(); //cannot eager-load 'customizable' because it's not a relation
        $fields = CustomField::with('fieldset')->where("type", Helper::$itemtypes_having_custom_fields[$request->get('tab', 0)])->get();

        return view('custom_fields.index')->with('custom_fieldsets', $fieldsets)->with('custom_fields', $fields);
    }

    /**
     * Just redirect the user back if they try to view the details of a field.
     * We already show those details on the listing page.
     *
     * @see CustomFieldsController::storeField()
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.1.5]
     */
    public function show() : RedirectResponse
    {
        return redirect()->route('fields.index');
    }


    /**
     * Returns a view with a form to create a new custom field.
     *
     * @see CustomFieldsController::storeField()
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @since [v1.8]
     */
    public function create(Request $request) : View
    {
        $this->authorize('create', CustomField::class);
        $fieldsets = CustomFieldset::where('type', Helper::$itemtypes_having_custom_fields[$request->get('tab')])->get();

        return view('custom_fields.fields.edit', [
            'predefinedFormats' => Helper::predefined_formats(),
            'customFormat' => '',
            'fieldsets' => $fieldsets,
            'field' => new CustomField(),
        ]);
    }

    /**
     * Validates and stores a new custom field.
     *
     * @see CustomFieldsController::createField()
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @since [v1.8]
     */
    public function store(CustomFieldRequest $request) : RedirectResponse
    {
        $this->authorize('create', CustomField::class);

        $show_in_email = $request->get("show_in_email", 0);
        $display_in_user_view = $request->get("display_in_user_view", 0);

        // Override the display settings if the field is encrypted
        if ($request->get("field_encrypted") == '1') {
            $show_in_email = '0';
            $display_in_user_view = '0';
        }

        $field = new CustomField([
            "name" => trim($request->get("name")),
            "element" => $request->get("element"),
            "help_text" => $request->get("help_text"),
            "field_values" => $request->get("field_values"),
            "field_encrypted" => $request->get("field_encrypted", 0),
            "show_in_email" => $show_in_email,
            "is_unique" => $request->get("is_unique", 0),
            "display_in_user_view" => $display_in_user_view,
            "auto_add_to_fieldsets" => $request->get("auto_add_to_fieldsets", 0),
            "show_in_listview" => $request->get("show_in_listview", 0),
            "show_in_requestable_list" => $request->get("show_in_requestable_list", 0),
            "created_by" => auth()->id()
        ]);
        // not mass-assignable; must be manual
        $field->type = Helper::$itemtypes_having_custom_fields[$request->get('tab')];


        if ($request->filled('custom_format')) {
            $field->format = $request->get('custom_format');
        } else {
            $field->format = $request->get('format');
        }

        if ($field->save()) {

            // Sync fields with fieldsets
            $fieldset_array = $request->input('associate_fieldsets');
            if ($request->get('tab') == 1) {
                $fieldset_array = [CustomFieldset::firstOrCreate(['type' => User::class], ['name' => 'default'])->id => true];
            }
            if (($request->has('associate_fieldsets') || $request->get('tab') == 1) && (is_array($fieldset_array))) {
                $field->fieldset()->sync(array_keys($fieldset_array));
            } else {
                $field->fieldset()->sync([]);
            }


            return redirect()->route('fields.index', ['tab' => $request->get('tab', 0)])->with('success', trans('admin/custom_fields/message.field.create.success'));
        }

        return redirect()->back()->with('selected_fieldsets', $request->input('associate_fieldsets'))->withInput()
            ->with('error', trans('admin/custom_fields/message.field.create.error'));
    }


    /**
     * Detach a custom field from a fieldset.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     */
    public function deleteFieldFromFieldset($field_id, $fieldset_id) : RedirectResponse
    {
        $field = CustomField::find($field_id);

        $this->authorize('update', $field);

        // Check that the field exists - this is mostly related to the demo, where we 
        // rewrite the data every x minutes, so it's possible someone might be disassociating 
        // a field from a fieldset just as we're wiping the database
        if (($field) && ($fieldset_id)) {

        if ($field->fieldset()->detach($fieldset_id)) {
            return redirect()->route('fieldsets.show', ['fieldset' => $fieldset_id])
                ->with('success', trans('admin/custom_fields/message.field.delete.success'));
            } else {
                return redirect()->back()->withErrors(['message' => "Field is in use and cannot be deleted."]);
            }
        }

        return redirect()->back()->withErrors(['message' => "Error deleting field from fieldset"]);

       
    }

    /**
     * Delete a custom field.
     *
     * @author [Brady Wetherington] [<uberbrady@gmail.com>]
     * @since [v1.8]
     */
    public function destroy($field_id) : RedirectResponse
    {
        if ($field = CustomField::find($field_id)) {
            $this->authorize('delete', $field);

            if ($field->type == User::class) {
                $field->fieldset()->detach(); // remove from 'default' group (and others, if they exist in the future!)
            }
            if (($field->fieldset) && ($field->fieldset->count() > 0)) {
                return redirect()->back()->withErrors(['message' => 'Field is in-use']);
            }
            $type = $field->type;
            $field->delete();
            return redirect()->route('fields.index', ['tab' => array_search($type, Helper::$itemtypes_having_custom_fields)])
                ->with('success', trans('admin/custom_fields/message.field.delete.success'));
        }

        return redirect()->back()->withErrors(['message' => 'Field does not exist']);
    }


    /**
     * Return a view to edit a custom field
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $id
     * @since [v4.0]
     */
    public function edit(Request $request, $id) : View | RedirectResponse
    {
        if ($field = CustomField::find($id)) {

        $this->authorize('update', $field);
        $fieldsets = CustomFieldset::get();
        $customFormat = '';
        if ((stripos($field->format, 'regex') === 0) && ($field->format !== CustomField::PREDEFINED_FORMATS['MAC'])) {
            $customFormat = $field->format;
        }

        return view('custom_fields.fields.edit', [
            'field'             => $field,
            'customFormat'      => $customFormat,
            'fieldsets'         => $fieldsets,
            'predefinedFormats' => Helper::predefined_formats(),
        ]);
        } 

        return redirect()->route("fields.index")
            ->with("error", trans('admin/custom_fields/message.field.invalid'));
        
    }


    /**
     * Store the updated field
     *
     * @todo Allow encrypting/decrypting if encryption status changes
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $id
     * @since [v4.0]
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CustomFieldRequest $request, $id) : RedirectResponse
    {
        $field = CustomField::find($id);

        $this->authorize('update', $field);


        $show_in_email = $request->get("show_in_email", 0);
        $display_in_user_view = $request->get("display_in_user_view", 0);

        // Override the display settings if the field is encrypted
        if ($request->get("field_encrypted") == '1') {
            $show_in_email = '0';
            $display_in_user_view = '0';
        }
        
        $field->name          = trim(e($request->get("name")));
        $field->element       = e($request->get("element"));
        $field->field_values  = $request->get("field_values");
        $field->created_by       = auth()->id();
        $field->help_text     = $request->get("help_text");
        $field->show_in_email = $show_in_email;
        $field->is_unique     = $request->get("is_unique", 0);
        $field->display_in_user_view = $display_in_user_view;
        $field->auto_add_to_fieldsets = $request->get("auto_add_to_fieldsets", 0);
        $field->show_in_listview = $request->get("show_in_listview", 0);
        $field->show_in_requestable_list = $request->get("show_in_requestable_list", 0);

        if ($request->get('format') == 'CUSTOM REGEX') {
            $field->format = e($request->get('custom_format'));
        } else {
            $field->format = e($request->get('format'));
        }

        if ($field->element == 'checkbox' || $field->element == 'radio'){
            $field->format = 'ANY';
        }

        if ($field->save()) {


            // Sync fields with fieldsets
            $fieldset_array = $request->input('associate_fieldsets');
            if ($request->has('associate_fieldsets') && (is_array($fieldset_array))) {
                $field->fieldset()->sync(array_keys($fieldset_array));
            } else {
                $field->fieldset()->sync([]);
            }

            return redirect()->route('fields.index', ['tab' => $request->get('tab', 0)])->with('success', trans('admin/custom_fields/message.field.update.success'));
        }

        return redirect()->back()->withInput()->with('error', trans('admin/custom_fields/message.field.update.error'));
    }
}
