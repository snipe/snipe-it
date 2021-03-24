<!-- Purchase Cost -->
<div class="form-group {{ $errors->has('lifetime') ? ' has-error' : '' }}">
    <label for="purchase_cost" class="col-md-3 control-label">Срок службы</label>
    <div class="col-md-9">
        <div class="input-group col-md-4" style="padding-left: 0px;">
            <input class="form-control" type="text" name="lifetime" aria-label="lifetime" id="lifetime" value="{{ Input::old('lifetime',$item->lifetime )}}" />
            <span class="input-group-addon">Месяцев</span>
        </div>
        <div class="col-md-9" style="padding-left: 0px;">
            {!! $errors->first('lifetime', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
        </div>
    </div>
</div>
