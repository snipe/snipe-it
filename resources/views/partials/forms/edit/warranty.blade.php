<!-- Warranty -->
<div class="form-group {{ $errors->has('warranty_months') ? ' has-error' : '' }}">
    <label for="warranty_months" class="col-md-3 control-label">{{ trans('admin/hardware/form.warranty') }}</label>
    <div class="col-md-9">
        <div class="input-group col-md-3" style="padding-left: 0px;">
            <input class="form-control" type="text" name="warranty_months" id="warranty_months" value="{{ Input::old('warranty_months', $item->warranty_months) }}" />
            <span class="input-group-addon">{{ trans('admin/hardware/form.months') }}</span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('warranty_months', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
        </div>
    </div>
</div>