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
		print "ID is: $id";
		$set=CustomFieldset::find($id);
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
		$maxid=0;
		foreach($cfset->fields AS $field) {
			if($field->pivot->order > $maxid) {
				$maxid=$field->pivot->order;
			}
		}
		return View::make("backend.custom_fields.show")->with("custom_fieldset",$cfset)->with("maxid",$maxid+1);
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
