<h2>Fieldset</h2>
{{{ $custom_fieldset->name }}}

<ul>
@foreach($custom_fieldset->fields AS $field)
<li>{{$field->pivot->order}}) {{$field->name}}, {{$field->format}}, {{$field->pivot->required ? "REQUIRED" : "OPTIONAL"}}</li>
@endforeach
</ul>
{{ Form::open(['url' => '/custom_fieldsets/'.$custom_fieldset->id.'/associate']) }}
{{ Form::checkbox("required","on") }}Required?
{{ Form::text("order",$maxid)}}
{{ Form::select("field_id",["" => "Add New Field to Fieldset"] + CustomField::lists("name","id"),"",["onchange" => "document.forms[0].submit()"]) }}
