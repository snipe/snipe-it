@extends('backend/layouts/default')
@section('content')
@if(Session::has("message"))
<span class="alert-msg">{{ Session::get("message") }}</span>
@endif
<h2>Fieldsets</h2>
@if(isset($models))
@foreach($models as $model)
{{link_to_route("view/model",$model->name,[$model->id])}}
<a href=''>$model->name</a> 
@endforeach
@endif
<ul>
@foreach($custom_fieldsets AS $fieldset)
{{-- FIXME - should we be using a 'Resource' instead of 'Controller' here? --}}
<li>{{link_to_route("admin.custom_fields.show",$fieldset->name,['id' => $fieldset->id])}}, 
  @if($fieldset->models->count() > 0)
    Fieldset in use in models: 
    @foreach($fieldset->models AS $model)
      {{link_to_route("view/model",$model->name,[$model->id])}} 
    @endforeach
  @else
    {{ Form::open(array('route' => array('admin.custom_fields.destroy', $fieldset->id), 'method' => 'delete')) }}
    <button type="submit" class="btn btn-danger btn-mini">Delete</button>
    {{ Form::close() }}</li>
  @endif
@endforeach
</ul>

{{link_to_route("admin.custom_fields.create","New Fieldset")}}<br>
<h2>Custom Field Definitions</h2>
<ul>
  @foreach($custom_fields AS $field) 
  <li>{{{$field->name}}}, {{{$field->format}}}, 
    @if($field->fieldset->count()>0)
    Custom field in use in these fieldsets: 
    @foreach($field->fieldset AS $fieldset)
    {{link_to_route("admin.custom_fields.show",$fieldset->name,[$fieldset->id])}}
    @endforeach
    @else
    {{ Form::open(array('route' => array('admin.custom_fields.delete-field', $field->id), 'method' => 'delete')) }}
    <button type="submit" class="btn btn-danger btn-mini">Delete</button>
    {{ Form::close() }}</li>    @endif
  </li>
  @endforeach
</ul>
{{link_to_route("admin.custom_fields.create-field","New Field")}}
@stop
