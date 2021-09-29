<div>
    <div class="form-group{{ $errors->has('custom_fieldset') ? ' has-error' : '' }}">
        <label for="custom_fieldset" class="col-md-3 control-label">{{ trans('admin/models/general.fieldset') }}</label>
        <div class="col-md-9">
            {{ Form::select('custom_fieldset', Helper::customFieldsetList(),old('custom_fieldset', 0000 /*$item->fieldset_id*/), array('class'=>'select2 js-fieldset-field', 'style'=>'width:350px', 'aria-label'=>'custom_fieldset', 'wire:model' => 'fieldset_id')) }}
            {!! $errors->first('custom_fieldset', '<span class="alert-msg" aria-hidden="true"><br><i class="fas fa-times"></i> :message</span>') !!}
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
                @livewire('custom-fields-for-fieldset',['fieldset_id' => $fieldset_id])
        </div>
    </div>
    @endif
</div>
