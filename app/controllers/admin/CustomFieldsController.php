<?php namespace Controllers\Admin;

use View;
use CustomFieldset;
use CustomField;
use Input;
use Validator;
use Redirect;

class CustomFieldsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return View::make("backend.custom_fields.index")->with("custom_fieldsets",CustomFieldset::all())->with("custom_fields",CustomField::all());
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
		$cfset=new CustomFieldset(["name" => Input::get("name")]);
		$validator=Validator::make(Input::all(),$cfset->rules);
		if($validator->passes()) {
			$cfset->save();
			return Redirect::route("admin.custom_fields.show",[$cfset->id]); //redirect(["asdf" => "alskdjf"]);
		} else {
			return Redirect::back()->withInput()->withErrors($validator);
		}
	}
	
	public function associate($id)
	{
		//print "ID is: $id";
		$set=CustomFieldset::find($id);
		//print_r($set->fields());
		foreach($set->fields AS $field) {
			//print_r($field);
			//print "Field ID of this particular field is:".$field->id.", and we are checking for: ".Input::get('field_id');
			if($field->id == Input::get('field_id')) {
				//print "I want to redirect back in failure";
				//exit(-2);
				return Redirect::route("admin.custom_fields.show",[$id])->withInput()->withErrors(['field_id' => "Field already added"]);
			}
		}
		exit(-1);
		$results=$set->fields()->attach(Input::get('field_id'),["required" => (Input::get('required') == "on"),"order" => Input::get('order')]);
		//return "I assoced it. Results: $results";
		return Redirect::route("admin.custom_fields.show",[$id]); //redirect(["asdf" => "alskdjf"]);
	}
	
	public function createField()
	{
		return View::make("backend.custom_fields.create_field");
	}
	
	public function storeField()
	{
		$field=new CustomField(["name" => Input::get("name"),"element" => Input::get("element")]);
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
				return Redirect::route("admin.custom_fields.index");
			} else {
				return Redirect::back()->withInput()->withErrors(['message' => "Failed to save?"]);
			}
		} else {
			return Redirect::back()->withInput()->withErrors($validator);
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
	}


}
