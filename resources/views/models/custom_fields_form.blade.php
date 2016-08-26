@if($model->fieldset)
  @foreach($model->fieldset->fields AS $field)
    <div class="form-group{{ $errors->has($field->db_column_name()) ? ' has-error' : '' }}">
      <label for="{{ $field->db_column_name() }}" class="col-md-3 control-label">{{ $field->name }} </label>
      <div class="col-md-7 col-sm-12{{ ($field->pivot->required=='1') ? ' required' : '' }}">

          @if ($field->element!='text')

              @if ($field->element=='listbox')
                  {{ Form::select($field->db_column_name(), $field->formatFieldValuesAsArray(), Input::old($field->db_column_name(), $asset->{$field->db_column_name()}), ['class'=>'format select2 form-control']) }}
              @elseif ($field->element=='checkbox')

                  @foreach ($field->formatFieldValuesAsArray() as $key => $value)

                      <div>
                          <label>
                              <input type="checkbox" value="1" name="{{ $key }}[]" class="minimal" {{ Input::old($field->db_column_name()) == '1' ? ' checked="checked"' : '' }}> {{ $value }}
                          </label>
                      </div>
                  @endforeach

              @endif


          @else
            <input type="text" value="{{ Input::old($field->db_column_name(),(isset($asset) ? $asset->{$field->db_column_name()} : "")) }}" id="{{ $field->db_column_name() }}" class="form-control" name="{{ $field->db_column_name() }}">

          @endif

          <?php
          $errormessage=$errors->first($field->db_column_name());
          if ($errormessage) {
              $errormessage=preg_replace('/ snipeit /', '', $errormessage);
              print('<span class="alert-msg"><i class="fa fa-times"></i> '.$errormessage.'</span>');
            }
            ?>
      </div>
    </div>
  @endforeach
@endif
