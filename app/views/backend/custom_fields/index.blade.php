<?
?>

<h2>Fieldsets</h2>
<ul>
@foreach($custom_fieldsets AS $fieldset)
<li><a href='/custom_fieldsets/{{$fieldset->id}}'>{{{$fieldset->name}}}</li>
@endforeach
</ul>

<a href='/custom_fieldsets/create'>New Fieldset</a><br>
<h2>Custom Field Definitions</h2>
<ul>
  @foreach($custom_fields AS $field) 
  <li>{{{$field->name}}}, {{{$field->format}}}</li>
  @endforeach
</ul>
<a href='/custom_fieldsets/create-field'>New Field</a>
