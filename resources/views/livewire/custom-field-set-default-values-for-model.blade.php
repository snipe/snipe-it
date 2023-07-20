<span> {{-- This <span> doesn't seem to fix it, neither does a div? --}}
    <div class="form-group{{ $errors->has('custom_fieldset') ? ' has-error' : '' }}">
        <label for="custom_fieldset" class="col-md-3 control-label">{{ trans('admin/models/general.fieldset') }}</label>
            <div class="col-md-5">
                {{ Form::select('fieldset_id', Helper::customFieldsetList(), old('fieldset_id', $fieldset_id), array('class'=>'select2 js-fieldset-field livewire-select2', 'style'=>'width:100%; min-width:350px', 'aria-label'=>'custom_fieldset', 'data-livewire-component' => $_instance->id)) }}
                {!! $errors->first('custom_fieldset', '<span class="alert-msg" aria-hidden="true"><br><i class="fas fa-times"></i> :message</span>') !!}
            </div>
            <div class="col-md-3">
                    <label class="form-control">
                    {{ Form::checkbox('add_default_values', 1, old('add_default_values', $add_default_values), ['data-livewire-component' => $_instance->id, 'id' => 'add_default_values', 'wire:model' => 'add_default_values']) }}
                    {{ trans('admin/models/general.add_default_values') }}
                </label>
            </div>
    </div>
    @if ($this->add_default_values ) {{-- 'if the checkbox is enabled *AND* there are more than 0 fields in the fieldsset' --}}
    <div style="padding-left: 10px; padding-bottom: 0px; margin-bottom: -15px;">
        <div class="form-group">
            @if ($fields)
                @foreach ($fields as $field)
                    <div class="form-group">
                    
                            <label class="col-md-3 control-label{{ $errors->has($field->name) ? ' has-error' : '' }}" for="default-value{{ $field->id }}">{{ $field->name }}</label>

                            <div class="col-md-7">
                                @if ($field->format == "DATE")
                                    <div class="input-group col-md-4" style="padding-left: 0px;">
                                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                                            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="default_values[{{ $field->id }}]" id="default-value{{ $field->id }}" value="{{ $field->defaultValue($model_id) }}">
                                            <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                @elseif ($field->element == "text")
                                    <input class="form-control m-b-xs" type="text" value="{{ $field->defaultValue($model_id) }}" id="default-value{{ $field->id }}" name="default_values[{{ $field->id }}]">
                                @elseif($field->element == "textarea")
                                    <textarea class="form-control" style="width: 100%;" id="default-value{{ $field->id }}" name="default_values[{{ $field->id }}]">{{ $field->defaultValue($model_id) }}</textarea><br>
                                @elseif($field->element == "listbox")

                                    <select class="form-control m-b-xs" name="default_values[{{ $field->id }}]">
                                        <option value=""></option>
                                        @foreach(explode("\r\n", $field->field_values) as $field_value)
                                            <option value="{{$field_value}}" {{ $field->defaultValue($model_id) == $field_value ? 'selected="selected"': '' }}>{{ $field_value }}</option>
                                        @endforeach
                                    </select>
                                @elseif($field->element == "radio")
                                    @foreach(explode("\r\n", $field->field_values) as $field_value)
                                        <input type='radio' name="default_values[{{ $field->id }}]" value="{{$field_value}}" {{ $field->defaultValue($model_id) == $field_value ? 'checked="checked"': '' }} />{{ $field_value }}<br />
                                    @endforeach
                                @elseif($field->element == "checkbox")
                                    @foreach(explode("\r\n", $field->field_values) as $field_value)
                                        <input type='checkbox' name="default_values[{{ $field->id }}][]" value="{{$field_value}}" {{ in_array($field_value, explode(', ',$field->defaultValue($model_id))) ? 'checked="checked"': '' }} /> {{ $field_value }}<br />
                                    @endforeach
                                @else
                                    <span class="help-block form-error">
                                        Unknown field element: {{ $field->element }}
                                    </span>
                                @endif
                            </div>
                        </div>

                @endforeach
                @endif

        </div>
    </div>
    @endif
</span>
