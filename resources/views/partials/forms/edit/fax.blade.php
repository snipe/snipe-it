<div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
    {{ Form::label('fax', trans('admin/suppliers/table.fax'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        {{Form::text('fax', old('fax', $item->fax), array('class' => 'form-control')) }}
        {!! $errors->first('fax', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>