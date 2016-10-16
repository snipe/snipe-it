<!-- Manufacturer -->
<div class="form-group {{ $errors->has('manufacturer_id') ? ' has-error' : '' }}">
    <label for="manufacturer_id" class="col-md-3 control-label">{{ trans('general.manufacturer') }}</label>
    <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'manufacturer_id')) ? ' required' : '' }}">
        {{ Form::select('manufacturer_id', $manufacturer_list , Input::old('manufacturer_id', $item->manufacturer_id), array('class'=>'select2', 'style'=>'width:100%')) }}
        {!! $errors->first('manufacturer_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>