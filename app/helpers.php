<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
if(!function_exists("ParseFloat")) {
  //this may be only necessary to run tests?
  function ParseFloat($floatString){ 
      // use comma for thousands until local info is property used
      $LocaleInfo = localeconv();
      $floatString = str_replace("," , "", $floatString); 
      $floatString = str_replace($LocaleInfo["decimal_point"] , ".", $floatString); 
      return floatval($floatString); 
  } 
}

function modelList() {
    $model_list = array('' => Lang::get('general.select_model')) + DB::table('models')
    ->select(DB::raw('IF (modelno="" OR modelno IS NULL,name,concat(name, " / ",modelno)) as name, id'))
    ->orderBy('name', 'asc')
    ->whereNull('deleted_at')
    ->lists('name', 'id');
    return $model_list;
}

function categoryList() {
    $category_list = array('' => '') + DB::table('categories')
    ->whereNull('deleted_at')
    ->orderBy('name', 'asc')
    ->lists('name', 'id');
    return $category_list;
}

function suppliersList() {
    $supplier_list = array('' => Lang::get('general.select_supplier')) + Supplier::orderBy('name', 'asc')
    ->orderBy('name', 'asc')
    ->lists('name', 'id');
    return $supplier_list;
}

function statusLabelList() {
    $statuslabel_list = Statuslabel::orderBy('name', 'asc')
    ->lists('name', 'id');
    return $statuslabel_list;
}

function locationsList() {
    $location_list = array('' => Lang::get('general.select_location')) + Location::orderBy('name', 'asc')
    ->lists('name', 'id');
    return $location_list;
}

function manufacturerList() {
    $manufacturer_list = array('' => 'Select One') + Manufacturer::orderBy('name', 'asc')
    ->lists('name', 'id');
    return $manufacturer_list;
}

function statusTypeList() {
    $statuslabel_types = array('' => Lang::get('admin/hardware/form.select_statustype')) + array('undeployable' => Lang::get('admin/hardware/general.undeployable')) + array('pending' => Lang::get('admin/hardware/general.pending')) + array('archived' => Lang::get('admin/hardware/general.archived')) + array('deployable' => Lang::get('admin/hardware/general.deployable'));
    return $statuslabel_types;
}

function managerList() {
    $manager_list = array('' => '') + DB::table('users')
    ->select(DB::raw('concat(last_name,", ",first_name," (",username,")") as full_name, id'))
    ->whereNull('deleted_at', 'and')
    ->orderBy('last_name', 'asc')
    ->orderBy('first_name', 'asc')
    ->lists('full_name', 'id');
    return $manager_list;
}

function depreciationList() {
    $depreciation_list = array('' => 'Do Not Depreciate') + Depreciation::orderBy('name', 'asc')->lists('name', 'id');
    return $depreciation_list;
}

function categoryTypeList() {
     $category_types= array('' => '','accessory' => 'Accessory', 'asset' => 'Asset', 'consumable' => 'Consumable');
     return $category_types;
}

function usersList() {
    $users_list = array('' => Lang::get('general.select_user')) + DB::table('users')->select(DB::raw('concat(last_name,", ",first_name," (",username,")") as full_name, id'))->whereNull('deleted_at')->orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->lists('full_name', 'id');
    return $users_list;
}

function customFieldsetList() {
  $customfields=CustomFieldset::lists('name','id');
  return array('' => Lang::get('general.no_custom_field')) + $customfields;
}

function predefined_formats() {
  $keys=array_keys(CustomField::$PredefinedFormats);
  $stuff=array_combine($keys,$keys);
  return $stuff+["" => "Custom Format..."];
}

function barcodeDimensions ($barcode_type = 'QRCODE') {
    if ($barcode_type == 'C128') {
        $size['height'] = '-1';
        $size['width'] = '-10';
    } elseif  ($barcode_type == 'PDF417') {
        $size['height'] = '-3';
        $size['width'] = '-10';
    } else {
        $size['height'] = '-3';
        $size['width'] = '-3';
    }
    return $size;
}
