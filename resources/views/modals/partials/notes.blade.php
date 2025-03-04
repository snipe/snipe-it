<!-- partials/modals/partials/notes.blade.php -->
<div class="dynamic-form-row">
    <div class="col-md-4 col-xs-12">
        <label for="modal-notes">{{ trans('admin/hardware/form.notes') }}</label>
    </div>
    <div class="col-md-8 col-xs-12">
        <textarea
                class="form-control"
                id="modal-notes"
                aria-label="notes"
                name="notes"
                style="width: 100%; min-height: 100px;"
        >{{ old('notes', $item->notes) }}</textarea>
        {!! $errors->first('notes', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
<!-- partials/modals/partials/notes.blade.php -->