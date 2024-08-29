<span>

    <div class="form-group{{ $errors->has('custom_fieldset') ? ' has-error' : '' }}">
        <label for="custom_fieldset" class="col-md-3 control-label">
            {{ trans('admin/models/general.fieldset') }}
        </label>
        <div class="col-md-5">
            {{ Form::select('fieldset_id', Helper::customFieldsetList(), old('fieldset_id', $fieldset_id), array('class'=>'select2 js-fieldset-field livewire-select2', 'style'=>'width:100%; min-width:350px', 'aria-label'=>'custom_fieldset', 'data-livewire-component' => $this->getId())) }}
            {!! $errors->first('custom_fieldset', '<span class="alert-msg" aria-hidden="true"><br><i class="fas fa-times"></i> :message</span>') !!}
        </div>
        <div class="col-md-3">
                <label class="form-control">
                {{ Form::checkbox('add_default_values', 1, old('add_default_values', $add_default_values), ['data-livewire-component' => $this->getId(), 'id' => 'add_default_values', 'wire:model.live' => 'add_default_values']) }}
                {{ trans('admin/models/general.add_default_values') }}
            </label>
        </div>
    </div>

    @if ($this->add_default_values ) {{-- 'if the checkbox is enabled *AND* there are more than 0 fields in the fieldsset' --}}
            @if ($fields)

                @foreach ($fields as $field)
                    <div class="form-group">

                        <label class="col-md-3 control-label{{ $errors->has($field->name) ? ' has-error' : '' }}">{{ $field->name }}</label>

                        <div class="col-md-7">

                                @if ($field->format == "DATE")

                                    <div class="input-group col-md-4" style="padding-left: 0px;">
                                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                                            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="default_values[{{ $field->id }}]" id="default-value{{ $field->id }}" value="{{ $field->defaultValue($model_id) }}">
                                            <span class="input-group-addon"><x-icon type="calendar" /></span>
                                        </div>
                                    </div>

                                @elseif ($field->element == "text")


                                        <input class="form-control" type="text" value="{{ $field->defaultValue($model_id) }}" id="default-value{{ $field->id }}" name="default_values[{{ $field->id }}]">


                                @elseif($field->element == "textarea")


                                        <textarea class="form-control" style="width: 100%;" id="default-value{{ $field->id }}" name="default_values[{{ $field->id }}]">{{ $field->defaultValue($model_id) }}</textarea>


                                @elseif($field->element == "listbox")


                                        <select class="form-control" name="default_values[{{ $field->id }}]">
                                            <option value=""></option>
                                            @foreach(explode("\r\n", $field->field_values) as $field_value)
                                                <option value="{{$field_value}}" {{ $field->defaultValue($model_id) == $field_value ? 'selected="selected"': '' }}>{{ $field_value }}</option>
                                            @endforeach
                                        </select>


                                @elseif($field->element == "radio")

                                    @foreach(explode("\r\n", $field->field_values) as $field_value)
                                    <label class="col-md-3 form-control" for="{{ str_slug($field_value) }}">
                                        <input id="{{ str_slug($field_value) }}" aria-label="{{ str_slug($field->name) }}"  type='radio' name="default_values[{{ $field->id }}]" value="{{$field_value}}" {{ $field->defaultValue($model_id) == $field_value ? 'checked="checked"': '' }} />{{ $field_value }}
                                    </label>
                                    @endforeach

                                @elseif($field->element == "checkbox")

                                     @foreach(explode("\r\n", $field->field_values) as $field_value)
                                        <label class="col-md-3 form-control" for="{{ str_slug($field_value) }}">
                                            <input id="{{ str_slug($field_value) }}" type="checkbox" aria-label="{{ str_slug($field->name) }}" name="default_values[{{ $field->id }}][]" value="{{ $field_value }}"{{ in_array($field_value, explode(', ',$field->defaultValue($model_id))) ? ' checked="checked"': '' }}> {{ $field_value }}
                                        </label>
                                    @endforeach


                                @else
                                    <span class="help-block form-error">
                                        Unknown field element: {{ $field->element }}
                                    </span>
                                @endif
                            </div>
                        </div>

                @endforeach
                </div>
                @endif

    @endif
</span>
