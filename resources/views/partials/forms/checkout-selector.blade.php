<div class="form-group" id="assignto_selector"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>
    {{ Form::label('name', trans('admin/hardware/form.checkout_to'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-8">
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-default active">
                <input name="checkout_to_type" value="user" type="radio" selected><i class="fa fa-user"></i> {{ trans('general.user') }}
            </label>
            <label class="btn btn-default">
                <input name="checkout_to_type" value="asset" type="radio"><i class="fa fa-barcode"></i> {{ trans('general.asset') }}
            </label>
            <label class="btn btn-default">
                <input name="checkout_to_type" value="location" class="active" type="radio"><i class="fa fa-map-marker"></i> {{ trans('general.location') }}
            </label>
        </div>
    </div>
</div>
