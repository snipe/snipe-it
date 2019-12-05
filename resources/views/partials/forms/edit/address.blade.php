<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
    {{ Form::label('address', trans('general.address'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('address', Request::old('address', $item->address), array('class' => 'form-control')) }}
        {!! $errors->first('address', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
    {{ Form::label('address2', ' ', array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('address2', Request::old('address2', $item->address2), array('class' => 'form-control')) }}
        {!! $errors->first('address2', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
    {{ Form::label('city', trans('general.city'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
    {{Form::text('city', Request::old('city', $item->city), array('class' => 'form-control')) }}
        {!! $errors->first('city', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
    {{ Form::label('state', trans('general.state'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
    {{Form::text('state', Request::old('state', $item->state), array('class' => 'form-control')) }}
        {!! $errors->first('state', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
    {{ Form::label('country', trans('general.country'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-5">
    {!! Form::countries('country', Request::old('country', $item->country), 'select2') !!}
        {!! $errors->first('country', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
    {{ Form::label('zip', trans('general.zip'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
    {{Form::text('zip', Request::old('zip', $item->zip), array('class' => 'form-control')) }}
        {!! $errors->first('zip', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>
