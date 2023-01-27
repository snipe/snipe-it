@extends('layouts/edit-form', [
    'createText' => trans('admin/custom_fields/general.create_fieldset') ,
    'updateText' => trans('admin/custom_fields/general.update_fieldset'),
    'formAction' => (isset($item->id)) ? route('fieldsets.update', ['fieldset' => $item->id]) : route('fieldsets.store'),
])

@section('inputFields')

  @include ('partials.forms.edit.name', ['translated_name' => trans('general.name')])



@stop
