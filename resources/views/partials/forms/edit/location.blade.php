<!--  Location -->
<div class="form-group {{ $errors->has('location_id') ? ' has-error' : '' }}">
    <label for="location_id" class="col-md-3 control-label">{{ trans('general.location') }}</label>
    <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($item, 'location_id')) ? ' required' : '' }}">
        {{ Form::select('location_id', $location_list , Input::old('location_id', $item->location_id), array('class'=>'select2', 'style'=>'width:350px')) }}
        {!! $errors->first('location_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>