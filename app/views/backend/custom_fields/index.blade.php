@extends('backend/layouts/default')
@section('content')
<h2>Fieldsets</h2>
<ul>
@foreach($custom_fieldsets AS $fieldset)
{{-- FIXME - should we be using a 'Resource' instead of 'Controller' here? --}}
<li>{{link_to_route("admin.custom_fields.show",$fieldset->name,['id' => $fieldset->id])}}</li>
@endforeach
</ul>

{{link_to_route("admin.custom_fields.create","New Fieldset")}}<br>
<h2>Custom Field Definitions</h2>
<ul>
  @foreach($custom_fields AS $field) 
  <li>{{{$field->name}}}, {{{$field->format}}}</li>
  @endforeach
</ul>
{{link_to_route("admin.custom_fields.create-field","New Field")}}
@stop
