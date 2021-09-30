<div>
    <div class="form-group{{ $errors->has('custom_fieldset') ? ' has-error' : '' }}">
        <label for="custom_fieldset" class="col-md-3 control-label">{{ trans('admin/models/general.fieldset') }}</label>
        <span wire:ignore> {{-- wire:ignore is because Select 2 mangles the dom in many awful ways, and so does iCheckbox --}}
            <div class="col-md-9">
                {{ Form::select('custom_fieldset', Helper::customFieldsetList(),old('custom_fieldset', 0000 /*$item->fieldset_id*/), array('class'=>'select2 js-fieldset-field', 'style'=>'width:350px', 'aria-label'=>'custom_fieldset', 'wire:model' => 'fieldset_id','id' => 'glooobits')) }} {{-- when we have this wrapped in 'ignore', the wire:model won't work --}}
                {!! $errors->first('custom_fieldset', '<span class="alert-msg" aria-hidden="true"><br><i class="fas fa-times"></i> :message</span>') !!}
                <label class="m-l-xs">
                    {{-- {{ Form::checkbox('add_default_values', 1, Request::old('add_default_values'), ['class' => 'js-default-values-toggler']) }} --}}
                    {{-- I'm not sure  that *this* checkboxy thing will render right, because of things. It's not *in* its own view, right? So that's a problem --}}
                    {{-- DELETE this and references to it: js-default-values-toggler --}}
                    <input id="add_default_values" {{-- wire:click="foo"--}} wire:model="add_default_values" type='checkbox' name='add_default_values' value='1' class='minimal'{{ Request::old('add_default_values',$add_default_values)? " checked='checked'" : "" }} />
                    {{ trans('admin/models/general.add_default_values') }}
                </label>
                </span>
            </div>
    </div>
    @if($this->add_default_values) {{-- 'if the checkbox is enabled *AND* there are more than 0 fields in the fieldsset' --}}
    <div>
        <div class="form-group">
                <?php
                \Log::error("Fieldset ID is: ".$fieldset_id);
                ?>
                {{-- GET READY TO ADD ME SOME CRAAAAAAZY DEFAULT VALUES MOTHER FLIPPER! For, of course, fieldset: {{ $fieldset_id }} --}}
                {{-- @livewire('custom-fields-for-fieldset',['fieldset_id' => $fieldset_id]) --}}
                        
                {{-- NOTE: This stuff could work well also for the 'view this asset and do its custom fields' thing --}}
                {{-- I don't know if we break *here* or if we break per field element? --}}
                @foreach ($fields as $field)
                    <div class="form-group">
                    
                            <label class="col-md-3 control-label{{ $errors->has($field->name) ? ' has-error' : '' }}" for="default-value{{ $field->id }}">{{ $field->name }}</label>

                            <div class="col-md-7">

                                @if ($field->element == "text")
                                    <input class="form-control m-b-xs" type="text" value="{{ $field->defaultValue($model_id) }}" id="default-value{{ $field->id }}" name="default_values[{{ $field->id }}]">
                                @elseif($field->element == "textarea")
                                    <textarea x-if="field.type == 'textarea'" class="form-control" :value="getValue(field)" :id="'default-value' + field.id" :name="'default_values[' + field.id + ']'"></textarea><br>
                                @elseif($field->element == "listbox")

                                    <select Z-if="field.element == 'listbox'" class="form-control m-b-xs" :name="'default_values[' + field.id + ']'">
                                        <option value=""></option>
                                        @foreach($field->field_values as $field_value)
                                            <option Q-for="field_value in field.field_values_array" :value="field_value" :selected="getValue(field) == field_value">{{ $field_value }}</option>
                                        @endforeach
                                    </select>
                                @elseif($field->element == "checkbox")
                                    <input type='checkbox' />
                                @else
                                    <span class="help-block form-error">
                                        Unknown field element: {{ $field->element }}
                                    </span>
                                @endif
                            </div>
                        </div>

                @endforeach

        </div>
    </div>
    @endif
    <script>
    /* FIXME - see if we ccan do this and get @this.set() support?
       Though I don't like having $() sometimes, and document.addEventListener other times?
        document.addEventListener("DOMContentLoaded", () => {
 3        Livewire.hook('component.initialized', (component) => {})
 4 
    */
    </script>
    @push('js')
    <script>
    // HEADS UP - this doesn't work at all right now. So you can ignore it.
    console.log("pushed JS is ready")
    $(function () {
        console.log(" - DUMPING ALL LIVEWIRE COMPOPNENTS!")
        console.dir(Livewire.all());
        console.log("DOMReady is fired, about to add event listener")
        //console.log("Well, can we even reference the damned thing: ".$('#gloobits'))
        //var that = @this; //see if this even works?! FIXME PLS! - this is the right way to do it
        $('#glooobits').on('select2:select',function (event) { //'change' seems to be the jquery-compatible version but I think the select2 versions might be nicer.
            console.log("Select2 has changed!!!!!")
            console.dir(event)
            {{-- @this.set('fieldset_id',event.params.data.id) --}}
            Livewire.first().set('fieldset_id',event.params.data.id) // I still don't know why @this does'nt work here?
        })
        $('#add_default_values').on('ifToggled',function (event) {
            console.log("toggled!")
            console.dir(event.target)
            Livewire.first().set('add_default_values',event.target.checked)
        })
    })
    function whatever(something) {
        console.log("Whatever fired")
    }
    </script>
    @endpush
</div>
