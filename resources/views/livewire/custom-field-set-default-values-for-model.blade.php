<span> {{-- This <span> doesn't seem to fix it, neither does a div? --}}
    <div class="form-group{{ $errors->has('custom_fieldset') ? ' has-error' : '' }}">
        <label for="custom_fieldset" class="col-md-3 control-label">{{ trans('admin/models/general.fieldset') }}</label>
        <span wire:ignore> {{-- wire:ignore is because Select 2 mangles the dom in many awful ways, and so does iCheckbox --}}
            <div class="col-md-9">
                {{ Form::select('custom_fieldset', Helper::customFieldsetList(), old('custom_fieldset', $fieldset_id), array('class'=>'select2 js-fieldset-field', 'style'=>'width:350px', 'aria-label'=>'custom_fieldset', 'wire:model' => 'fieldset_id', 'id' => 'glooobits')) }} {{-- when we have this wrapped in 'ignore', the wire:model won't work --}}
                {!! $errors->first('custom_fieldset', '<span class="alert-msg" aria-hidden="true"><br><i class="fas fa-times"></i> :message</span>') !!}
                <label class="m-l-xs">
                    {{ Form::checkbox('add_default_values', 1, Request::old('add_default_values', $add_default_values), ['class' => 'minimal', 'wire:model' => "add_default_values", 'id' => 'add_default_values']) }}
                    {{ trans('admin/models/general.add_default_values') }}
                </label>
                </span>
            </div>
    </div>
    @if ($this->add_default_values ) {{-- 'if the checkbox is enabled *AND* there are more than 0 fields in the fieldsset' --}}
    <div>
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
                                    <textarea class="form-control" id="default-value{{ $field->id }}" name="default_values[{{ $field->id }}]">{{ $field->defaultValue($model_id) }}</textarea><br>
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
                                    <input type='checkbox' name="default_values[{{ $field->id }}]" {{ $field->defaultValue($model_id) ? 'checked="checked"': '' }}/>
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
    <script>
    // *still* haven't figured out why this doesn't seem to work at all...
    // And even if it did, I hate having $(function () {}) as my DOM-ready checker in some places, and
    // DOMContentLoaded in another...
    /* document.addEventListener("DOMContentLoaded", function () {
         Livewire.hook('component.initialized', function (component) {
            $('#glooobits').on('select2:select',function (event) { //'change' seems to be the jquery-compatible version but I think the select2 versions might be nicer.
                console.log("Select2 has changed!!!!!")
                console.dir(event)
                @this.set('fieldset_id',event.params.data.id)
                // Livewire.first().set('fieldset_id',event.params.data.id) // I still don't know why @this does'nt work here?
            })

         })
    }) */

    </script>
    @push('js')
    <script>
    $(function () {
        $('#glooobits').on('select2:select',function (event) { //'change' seems to be the jquery-compatible version but I think the select2 versions might be nicer.
            {{-- @this.set('fieldset_id',event.params.data.id) --}}
            Livewire.first().set('fieldset_id',event.params.data.id) // I still don't know why @this does'nt work here?
        })
        $('#add_default_values').on('ifToggled',function (event) {
            Livewire.first().set('add_default_values',event.target.checked)
        })
    })
    </script>
    @endpush
</span>
