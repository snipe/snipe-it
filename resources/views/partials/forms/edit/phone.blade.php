<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
    <label for="phone" class="col-md-3 control-label">{{ trans('admin/suppliers/table.phone') }}</label>
    <div class="col-md-7">
        <input class="form-control" aria-label="phone" maxlength="191" name="phone" type="text" id="phone" value="{{ old('phone', $item->phone) }}">
        <x-form.error name="phone" />
    </div>
</div>
