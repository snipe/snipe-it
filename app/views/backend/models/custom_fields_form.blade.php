@if($model->fieldset)
<h1>Custom Fields</h1>
@foreach($model->fieldset->fields AS $field)
  <div class="form-group">
    <label for="idunno" class="col-md-2 control-label">{{{ $field->name }}}</label>
    <div class="col-md-7 col-sm-12">
        <input type="text" value="{{{ Input::old('fields[{{$field->db_column_name()}}]',(isset($asset) ? $asset->{$field->db_column_name()} : "")) }}}" name="fields[{{{ $field->db_column_name() }}}]">
    </div>
  </div>
@endforeach
@else
No Custom Fields Defined
@endif
