<!-- partials/modals/partials/eol_months.blade.php -->
<div class="dynamic-form-row">
    <div class="col-md-4 col-xs-12">
        <label for="eol">{{ trans('general.eol') }}</label>
    </div>
    <div class="col-md-5 col-xs-12">
        <div class="input-group" style="width: 100%;">
            <input
                    class="form-control"
                    type="text"
                    name="eol"
                    id="eol"
                    value="{{ old('eol', isset($item->eol) ? $item->eol : '') }}"
            />
            <span class="input-group-addon">
                {{ trans('general.months') }}
            </span>
        </div>
        {!! $errors->first('eol', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"></i> :message</span>') !!}
    </div>
</div>
<!-- partials/modals/partials/eol_months.blade.php -->