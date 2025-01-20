<div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
    {{ Form::label('fax', trans('admin/suppliers/table.fax'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
        <input class="form-control" type="text" name="fax" aria-label="fax" id="fax" value="{{ old('fax', $item->fax) }}"  maxlength="34"  />
        {!! $errors->first('fax', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>