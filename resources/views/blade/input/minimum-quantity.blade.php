@use('App\Helpers\Helper')

@props([
    'item' => null,
])

<div
    @class([
        'form-group',
        'has-error' => $errors->has('min_amt'),
    ])
>
    <label for="min_amt" class="col-md-3 control-label">{{ trans('general.min_amt') }}</label>
    <div class="col-md-9">
        <div class="col-md-3" style="padding-left: 0">
            <input
                class="form-control"
                type="number"
                name="min_amt"
                id="min_amt"
                aria-label="{{ trans('general.min_amt') }}"
                value="{{ old('min_amt', $item->min_amt ?? '') }}"
                min="0"
                maxlength="5"
                @required($item && Helper::checkIfRequired($item, 'min_amt'))
            />
        </div>
        <div class="col-md-7" style="margin-left: -15px">
            <x-form.tooltip>{{ trans('general.min_amt_help') }}</x-form.tooltip>
        </div>
        <div class="col-md-12">
            <x-form.error name="min_amt" />
        </div>
    </div>
</div>
