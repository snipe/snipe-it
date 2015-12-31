<?php namespace Controllers\Admin;

use View;
use CustomFieldset;
use CustomField;
use Input;
use Validator;
use Redirect;
use Model;
use Lang;
use Sentry;

class CustomFieldsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$fieldsets=CustomFieldset::with("fields","models")->get();
		//$fieldsets=CustomFieldset::all();
		$fields=CustomField::with("fieldset")->get();
		//$fields=CustomField::all();
		return View::make("backend.custom_fields.index")->with("custom_fieldsets",$fieldsets)->with("custom_fields",$fields);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make("backend.custom_fields.create");
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$cfset=new CustomFieldset(["name" => Input::get("name"),"user_id" => Sentry::getUser()->id]);
		$validator=Validator::make(Input::all(),$cfset->rules);
		if($validator->passes()) {
			$cfset->save();
			return Redirect::route("admin.custom_fields.show",[$cfset->id])->with('success',Lang::get('admin/custom_fields/message.fieldset.create.success')); 
		} else {
			return Redirect::back()->withInput()->withErrors($validator);
		}
	}

	public function associate($id)
	{

		$set = CustomFieldset::find($id);

		foreach($set->fields AS $field) {
			if($field->id == Input::get('field_id')) {
				return Redirect::route("admin.custom_fields.show",[$id])->withInput()->withErrors(['field_id' => Lang::get('admin/custom_fields/message.field.already_added')]);
			}
		}

		$results=$set->fields()->attach(Input::get('field_id'),["required" => (Input::get('required') == "on"),"order" => Input::get('order')]);

		return Redirect::route("admin.custom_fields.show",[$id])->with("success",Lang::get('admin/custom_fields/message.field.create.assoc_success'));
	}

	public function createField()
	{
		return View::make("backend.custom_fields.create_field");
	}

	public function storeField()
	{
		$field=new CustomField(["name" => Input::get("name"),"element" => Input::get("element"),"user_id" => Sentry::getUser()->id]);
		if(!in_array(Input::get('format'),["ALPHA","NUMERIC","MAC","IP"])) {
			$field->format=Input::get("custom_format");
		} else {
			$field->format=Input::get('format');
		}

		$validator=Validator::make(Input::all(),$field->rules);
		if($validator->passes()) {
			$results=$field->save();
			//return "postCreateField: $results";
			if ($results) {
				return Redirect::route("admin.custom_fields.index")->with("success",Lang::get('admin/custom_fields/message.field.create.success'));
			} else {
				return Redirect::back()->withInput()->with('error', Lang::get('admin/custom_fields/message.field.create.error'));
			}
		} else {
			return Redirect::back()->withInput()->withErrors($validator);
		}
	}

	public function deleteField($field_id)
	{
		$field=CustomField::find($field_id);

		if($field->fieldset->count()>0) {
			return Redirect::back()->withErrors(['message' => "Field is in-use"]);
		} else {
			$field->delete();
			return Redirect::route("admin.custom_fields.index")->with("success",Lang::get('admin/custom_fields/message.field.delete.success'));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//$id=$parameters[0];
		$cfset=CustomFieldset::find($id);

		//print_r($parameters);
		//
		$custom_fields_list=["" => "Add New Field to Fieldset"] + CustomField::lists("name","id");
		// print_r($custom_fields_list);
		$maxid=0;
		foreach($cfset->fields AS $field) {
			// print "Looking for: ".$field->id;
			if($field->pivot->order > $maxid) {
				$maxid=$field->pivot->order;
			}
			if(isset($custom_fields_list[$field->id])) {
				// print "Found ".$field->id.", so removing it.<br>";
				unset($custom_fields_list[$field->id]);
			}
		}

		return View::make("backend.custom_fields.show")->with("custom_fieldset",$cfset)->with("maxid",$maxid+1)->with("custom_fields_list",$custom_fields_list);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		$fieldset=CustomFieldset::find($id);

		$models=Model::where("fieldset_id","=",$id);
		if($models->count()==0) {
			$fieldset->delete();
			return Redirect::route("admin.custom_fields.index")->with("success",Lang::get('admin/custom_fields/message.fieldset.delete.success'));
		}
		else {
			return Redirect::route("admin.custom_fields.index")->with("error",Lang::get('admin/custom_fields/message.fieldset.delete.in_use')); //->with("models",$models);
		}
	}


}
