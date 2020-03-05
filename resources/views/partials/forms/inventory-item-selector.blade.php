<div class="form-group" id="inventory_item_selector"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>
    {{ Form::label('name', trans('admin/hardware/form.checkout_to'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-8">
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default active">
                <input name="inventory_item_type" value="accessory" type="radio" checked="checked"><i class="fa fa-keyboard-o"></i> {{ trans('general.accessory') }}
            </label>
            <label class="btn btn-default">
                <input name="inventory_item_type" value="consumable" type="radio"><i class="fa fa-tint"></i> {{ trans('general.consumable') }}
            </label>
            <label class="btn btn-default">
                <input name="inventory_item_type" value="component" type="radio"><i class="fa fa-hdd-o"></i> {{ trans('general.component') }}
            </label>

            {!! $errors->first('inventory_item_type', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
        </div>
    </div>
</div>
@include ('partials.forms.edit.accessory-select', ['translated_name' => trans('general.accessory'), 'fieldname' => 'accessory_id', 'required' => 'true'])
@include ('partials.forms.edit.consumable-select', ['translated_name' => trans('general.consumable'), 'fieldname' => 'consumable_id', 'style' => 'display:none;', 'required'=>'true'])
@include ('partials.forms.edit.component-select', ['translated_name' => trans('general.component'), 'fieldname' => 'component_id', 'style' => 'display:none;', 'required'=>'true'])

