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
{{ Form::select("field_id",$custom_fields_list,"",["onchange" => "document.forms[0].submit()"]) }}
<span class="alert-msg"><?= $errors->first('field_id'); ?></span>
<br>{{link_to_route("admin.custom_fields.index","Back to Custom Fieldset List")}}
@stop
