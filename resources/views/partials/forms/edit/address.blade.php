<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
    {{ Form::label('address', trans('general.address'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('address', old('address', $item->address), array('class' => 'form-control', 'aria-label'=>'address', 'maxlength'=>'191')) }}
        <x-form-error name="address" />
    </div>
</div>

<div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
    <label class="sr-only " for="address2">{{  trans('general.address')  }}</label>
    <div class="col-md-7 col-md-offset-3">
        {{Form::text('address2', old('address2', $item->address2), array('class' => 'form-control', 'aria-label'=>'address2', 'maxlength'=>'191')) }}
        <x-form-error name="address2" />
    </div>
</div>

<div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
    {{ Form::label('city', trans('general.city'), array('class' => 'col-md-3 control-label', 'maxlength'=>'191')) }}
    <div class="col-md-7">
    {{Form::text('city', old('city', $item->city), array('class' => 'form-control', 'aria-label'=>'city')) }}
        <x-form-error name="city" />
    </div>
</div>

<div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
    {{ Form::label('state', trans('general.state'), array('class' => 'col-md-3 control-label', 'maxlength'=>'191')) }}
    <div class="col-md-7">
    {{Form::text('state', old('state', $item->state), array('class' => 'form-control', 'aria-label'=>'state')) }}
        <x-form-error name="state" />

    </div>
</div>

<div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
    {{ Form::label('country', trans('general.country'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
    {!! Form::countries('country', old('country', $item->country), 'select2') !!}
        <p class="help-block">{{ trans('general.countries_manually_entered_help') }}</p>
        <x-form-error name="country" />
    </div>
</div>

<div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
    {{ Form::label('zip', trans('general.zip'), array('class' => 'col-md-3 control-label', 'maxlength'=>'10')) }}
    <div class="col-md-7">
    {{Form::text('zip', old('zip', $item->zip), array('class' => 'form-control')) }}
        <x-form-error name="zip" />
    </div>
</div>
