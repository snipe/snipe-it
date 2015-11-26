<?php

class CustomFieldsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		//
		return View::make("backend.custom_fields.index")->with("custom_fieldsets",CustomFieldset::all())->with("custom_fields",CustomField::all());
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		//
		return View::make("backend.custom_fields.create");
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postIndex()
	{
		//
		$cfset=new CustomFieldset(["name" => Input::get("name")]);
		$cfset->save();
		return Redirect::to("/custom_fieldsets/".$cfset->id); //redirect(["asdf" => "alskdjf"]);
		
	}
	
	public function postAssociate($id)
	{
		print "ID is: $id";
		$set=CustomFieldset::find($id);
		$results=$set->fields()->attach(Input::get('field_id'),["required" => (Input::get('required') == "on"),"order" => Input::get('order')]);
		//return "I assoced it. Results: $results";
		return Redirect::to("/custom_fieldsets/".$id); //redirect(["asdf" => "alskdjf"]);
	}
	
	public function getCreateField()
	{
		return View::make("backend.custom_fields.create_field");
	}
	
	public function postCreateField()
	{
		$field=new CustomField(["name" => Input::get("name"),"element" => Input::get("element")]);
		if(!in_array(Input::get('format'),["ALPHA","NUMERIC","MAC","IP"])) {
			$field->format=Input::get("custom_format");
		} else {
			$field->format=Input::get('format');
		}
		$results=$field->save();
		//return "postCreateField: $results";
		if ($results) {
			return Redirect::to("/custom_fieldsets/");
		} else {
			return Redirect::to("/custom_fieldsets/create-field");
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function missingMethod($parameters = array())
	{
		$id=$parameters[0];
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
