@extends('backend/layouts/default')
@section('content')
<h2>Fieldset</h2>
{{{ $custom_fieldset->name }}}

<ul>
@foreach($custom_fieldset->fields AS $field)
<li>{{$field->pivot->order}}) {{$field->name}}, {{$field->format}}, {{$field->pivot->required ? "REQUIRED" : "OPTIONAL"}}</li>
@endforeach
</ul>
{{ Form::open(['route' => ["admin.custom_fields.associate",$custom_fieldset->id]]) }}
{{ Form::checkbox("required","on") }}Required?
{{ Form::text("order",$maxid)}}
{{ Form::select("field_id",["" => "Add New Field to Fieldset"] + CustomField::lists("name","id"),"",["onchange" => "document.forms[0].submit()"]) }}
<br>{{link_to_route("admin.custom_fields.index","Back to Custom Fieldset List")}}
@stop
