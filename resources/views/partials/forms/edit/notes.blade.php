<!-- Notes -->
<div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
    <label for="notes" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="notes" aria-label="notes" name="notes" style="min-width:100%;">{{ old('notes', $item->notes) }}</textarea>
        <x-form-error name="notes" />
    </div>
</div>
