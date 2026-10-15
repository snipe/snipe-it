@props([
    'value' => '',
    'required' => '',
    'end_date' => null,
    'col_size_class' => null,
    'placeholder' => trans('general.select_date'),
])
@php
    // Belt-and-suspenders: if a caller (or old() after a validation error)
    // hands us an array/object rather than a scalar, cast it to empty so
    // htmlspecialchars() doesn't blow up rendering the value attribute.
    $value = is_scalar($value) ? (string) $value : '';
@endphp

<div class="input-group date {{ $col_size_class }}"
     data-provide="datetimepicker"
     data-format="YYYY-MM-DD"
     data-locale="{{ auth()->user()?->locale ?? 'en' }}"
     data-default-now="false"
     @if ($end_date) data-max-date="{{ $end_date === '0d' ? 'today' : $end_date }}" @endif>
    <input type="text"
           placeholder="{{ $placeholder }}"
           value="{{ $value }}"
           maxlength="10"
        {{ $attributes->merge(['class' => 'form-control']) }}
        {{ $required == '1' ? 'required' : '' }}>
    <span class="input-group-addon"><x-icon type="calendar" /></span>
</div>