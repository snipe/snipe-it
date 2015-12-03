@if($model->fieldset)
  @foreach($model->fieldset->fields AS $field)
    <div class="form-group {{ $errors->has($field->db_column_name()) ? ' has-error' : '' }}">
      <label for="{{ $field->db_column_name() }}" class="col-md-2 control-label">{{{ $field->name }}}
        @if ($field->pivot->required=='1')
          *
        @endif
      </label>
      <div class="col-md-7 col-sm-12">
          <input type="text" value="{{{ Input::old('fields.'.$field->db_column_name(),(isset($asset) ? $asset->{$field->db_column_name()} : "")) }}}" id="{{ $field->db_column_name() }}" class="form-control" name="fields[{{{ $field->db_column_name() }}}]">
          <?php
          $errormessage=$errors->first($field->db_column_name());
          if($errormessage) {
            $errormessage=preg_replace('/ snipeit /','',$errormessage);
            print('<br><span class="alert-msg"><i class="fa fa-times"></i> '.$errormessage.'</span>');
          }
          ?>
      </div>
    </div>
  @endforeach
@endif
