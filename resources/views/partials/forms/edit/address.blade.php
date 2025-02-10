<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
    <label for="address" class="col-md-3 control-label">{{ trans('general.address') }}</label>
    <div class="col-md-7">
        {{Form::text('address', old('address', $item->address), array('class' => 'form-control', 'aria-label'=>'address', 'maxlength'=>'191')) }}
        {!! $errors->first('address', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
    <label class="sr-only " for="address2">{{  trans('general.address')  }}</label>
    <div class="col-md-7 col-md-offset-3">
        {{Form::text('address2', old('address2', $item->address2), array('class' => 'form-control', 'aria-label'=>'address2', 'maxlength'=>'191')) }}
        {!! $errors->first('address2', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
    <label for="city" class="col-md-3 control-label">{{ trans('general.city') }}</label>
    <div class="col-md-7">
    {{Form::text('city', old('city', $item->city), array('class' => 'form-control', 'aria-label'=>'city', 'maxlength'=>'191')) }}
        {!! $errors->first('city', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
    <label for="state" class="col-md-3 control-label">{{ trans('general.state') }}</label>
    <div class="col-md-7">
    {{Form::text('state', old('state', $item->state), array('class' => 'form-control', 'aria-label'=>'state', 'maxlength'=>'191')) }}
        {!! $errors->first('state', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}

    </div>
</div>

<div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
    <label for="country" class="col-md-3 control-label">{{ trans('general.country') }}</label>
    <div class="col-md-7">
    {!! Form::countries('country', old('country', $item->country), 'select2') !!}
        <p class="help-block">{{ trans('general.countries_manually_entered_help') }}</p>
        {!! $errors->first('country', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
    <label for="zip" class="col-md-3 control-label" maxlength="10">{{ trans('general.zip') }}</label>
    <div class="col-md-7">
    {{Form::text('zip', old('zip', $item->zip), array('class' => 'form-control')) }}
        {!! $errors->first('zip', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
