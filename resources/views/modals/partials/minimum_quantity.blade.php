<!-- partials/modals/partials/minimum-quantity.blade.php -->
<div class="dynamic-form-row">
    <div class="col-md-4 col-xs-12">
        <label for="modal-min_amt">{{ trans('general.min_amt') }}</label>
    </div>
    <div class="col-md-3 col-xs-12">
        <div class="dynamic-input-group" style="display: flex; align-items: center;">
            <input
                    class="form-control"
                    maxlength="5"
                    type="text"
                    name="min_amt"
                    id="modal-min_amt"
                    aria-label="min_amt"
                    value="{{ old('min_amt', $item->min_amt) }}"
                    style="flex: 1; margin-right: 10px;"
                    {{ Helper::checkIfRequired($item, 'min_amt') ? 'required' : '' }}
            />
            <a href="#" data-tooltip="true" title="{{ trans('general.min_amt_help') }}" class="info-icon">
                <x-icon type="info-circle" />
                <span class="sr-only">{{ trans('general.min_amt_help') }}</span>
            </a>
        </div>
        {!! $errors->first('min_amt', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
<!-- partials/modals/partials/minimum-quantity.blade.php -->