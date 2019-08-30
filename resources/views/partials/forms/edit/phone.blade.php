<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
    {{ Form::label('phone', trans('admin/suppliers/table.phone'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
    {{Form::text('phone', Input::old('phone', $item->phone), array('class' => 'form-control')) }}
        {!! $errors->first('phone', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
</div>