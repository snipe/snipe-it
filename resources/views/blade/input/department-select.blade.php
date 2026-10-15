@use('App\Models\Department', 'Department')
@use('Illuminate\Support\Arr', 'Arr')

@props([
    'label',
    'name',
    'selected' => null,
    'required' => false,
    'multiple' => false,
])

<div
    @class([
        'form-group',
        'has-error' => $errors->has($name),
    ])
>
    <label for="{{ $name }}_select" class="col-md-3 control-label">{{ $label }}</label>
    <div class="col-md-6">
        <select
            class="js-data-ajax"
            data-endpoint="departments"
            data-placeholder="{{ trans('general.select_department') }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            id="{{ $name }}_select"
            style="width: 100%"
            aria-label="{{ $label }}"
            @required($required)
            @if ($multiple) multiple @endif
        >
            <option value="" role="option">{{ trans('general.select_department') }}</option>
            @if ($selected)
                @foreach (Arr::wrap($selected) as $value)
                    <option value="{{ $value }}" selected="selected" role="option" aria-selected="true">
                        {{ Department::find($value)?->name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-md-8 col-md-offset-3"><x-form.error :name="$name" /></div>
</div>
