<!-- Location -->
<div id="location_id" class="form-group{{ $errors->has('location_id') ? ' has-error' : '' }}"{!!  (isset($style)) ? ' style="'.e($style).'"' : ''  !!}>

    {{ Form::label('location_id', $translated_name, array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        <select class="js-data-ajax" data-endpoint="locations" data-placeholder="{{ trans('general.select_location') }}" name="location_id" style="width: 100%" id="location_id_location_select">
            @if ($location_id = Input::old('location_id', (isset($user)) ? $user->location_id : ''))
                <option value="{{ $location_id }}" selected="selected">
                    {{ (\App\Models\Location::find($location_id)) ? \App\Models\Location::find($location_id)->name : '' }}
                </option>
            @else
                <option value="">{{ trans('general.select_location') }}</option>
            @endif
        </select>
    </div>

    {!! $errors->first('location_id', '<div class="col-md-8 col-md-offset-3"><span class="alert-msg"><i class="fa fa-times"></i> :message</span></div>') !!}

</div>



