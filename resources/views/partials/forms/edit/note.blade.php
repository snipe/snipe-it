<!-- Note -->
<div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
  <label for="note" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
  <div class="col-md-7">
    <textarea class="col-md-6 form-control" id="note" name="note">{{ Input::old('note', (isset($item)) ? $item->note : '')) }}</textarea>
    {!! $errors->first('note', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
  </div>
</div>
