<!--  Location -->
<div class="form-group {{ $errors->has('location_id') ? ' has-error' : '' }}">
    <label for="location_id" class="col-md-3 control-label">{{ trans('general.location') }}</label>
    <div class="col-md-7 col-sm-12{{  (Helper::checkIfRequired($item, 'location_id')) ? ' required' : '' }}">
        {{ Form::select('location_id', $location_list , old('location_id', $item->location_id), array('class'=>'select2', 'style'=>'width:350px')) }}
        <x-form-error name="location_id" />
    </div>
</div>
