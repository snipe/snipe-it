<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
    {{ Form::label('email', trans('admin/suppliers/table.email'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
    {{Form::text('email', Input::old('email', $item->email), array('class' => 'form-control')) }}
        {!! $errors->first('email', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>