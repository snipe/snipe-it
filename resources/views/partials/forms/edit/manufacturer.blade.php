<!-- Manufacturer -->
<div class="form-group {{ $errors->has('manufacturer_id') ? ' has-error' : '' }}">
    <label for="manufacturer_id" class="col-md-3 control-label">{{ trans('general.manufacturer') }}</label>
    <div class="col-md-7{{  (Helper::checkIfRequired($item, 'manufacturer_id')) ? ' required' : '' }}">
        {{ Form::select('manufacturer_id', $manufacturer_list , old('manufacturer_id', $item->manufacturer_id), array('class'=>'select2', 'style'=>'width:100%')) }}
        {!! $errors->first('manufacturer_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
