<div>
    <div class="form-group {{ $errors->has('custom_fieldset') ? ' has-error' : '' }}">
        <label for="custom_fieldset" class="col-md-3 control-label">{{ trans('admin/models/general.fieldset') }}</label>
        <div class="col-md-7">
            {{ Form::select('custom_fieldset', \App\Helpers\Helper::customFieldsetList(),old('custom_fieldset', 0000 /*$item->fieldset_id*/), array('class'=>'select2 js-fieldset-field', 'style'=>'width:350px', 'aria-label'=>'custom_fieldset', 'wire:model' => 'fieldset_id')) }}
            {!! $errors->first('custom_fieldset', '<span class="alert-msg" aria-hidden="true"><br><i class="fa fa-times"></i> :message</span>') !!}
            <label class="m-l-xs">
                {{-- {{ Form::checkbox('add_default_values', 1, Request::old('add_default_values'), ['class' => 'js-default-values-toggler']) }} --}}
                {{-- I'm not sure  that *this* checkboxy thing will render right, because of things. It's not *in* its own view, right? So that's a problem --}}
                <input wire:click="foo" wire:model="add_default_values" type='checkbox' name='add_default_values' value='1' class='js-default-values-toggler'{{ Request::old('add_default_values')? " checked='checked'" : "" }} />
                {{ trans('admin/models/general.add_default_values') }}
            </label>
        </div>
    </div>
    @if($this->add_default_values) {{-- 'if the checkbox is enabled *AND* there are more than 0 fields in the fieldsset' --}}
    <div>
        <div class="form-group">
            <fieldset>
                <legend class="col-md-3 control-label">Default Values</legend>
                <div class="col-sm-8 col-xl-7">
                @empty($fields) {{-- There was an error? --}}
                    <p>
                        There was a problem retrieving the fields for this fieldset.
                    </p>
                @else
                    {{-- NOTE: This stuff could work well also for the 'view this asset and do its custom fields' thing --}}
                    @foreach($fields as $field)
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <label class="control-label" for="default-value{{ $field->id }}">{{ $field->name }}</label>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                @if($field->element == "text")
                                    <input b-if="field.type == 'text'" class="form-control m-b-xs" type="text" :value="getValue(field)" :id="'default-value' + field.id" :name="'default_values[' + field.id + ']'">
                                @elseif($field->element == "textarea")
                                    <textarea x-if="field.type == 'textarea'" class="form-control" :value="getValue(field)" :id="'default-value' + field.id" :name="'default_values[' + field.id + ']'"></textarea><br>
                                @elseif($field->element == "listbox")

                                    <select Z-if="field.element == 'listbox'" class="form-control m-b-xs" :name="'default_values[' + field.id + ']'">
                                        <option value=""></option>
                                        @foreach($field->field_values as $field_value)
                                            <option Q-for="field_value in field.field_values_array" :value="field_value" :selected="getValue(field) == field_value">{{ $field_value }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    Unknonown field element: {{ $field->element }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
                </div>
            </fieldset>
        </div>
    </div>
    @endif
</div>
