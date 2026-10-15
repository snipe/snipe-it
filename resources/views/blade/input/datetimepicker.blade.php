@props([
    'value' => '',
    'required' => '',
    'format' => 'YYYY-MM-DD HH:mm:ss',
    'placeholder' => trans('general.select_datetime'),
    'col_size_class' => null,
    'default_now' => true,
    'side_by_side' => false,
])
@php
    // Belt-and-suspenders: if a caller (or old() after a validation error)
    // hands us an array/object rather than a scalar, cast it to empty so
    // htmlspecialchars() doesn't blow up rendering the value attribute.
    $value = is_scalar($value) ? (string) $value : '';
@endphp

<!-- Datetimepicker (eonasdan-bootstrap-datetimepicker) -->
<div class="input-group date {{ $col_size_class }}"
     data-provide="datetimepicker"
     data-format="{{ $format }}"
     data-locale="{{ auth()->user()?->locale ?? 'en' }}"
     data-default-now="{{ $default_now ? 'true' : 'false' }}"
     data-side-by-side="{{ $side_by_side ? 'true' : 'false' }}">
    <input type="text"
           placeholder="{{ $placeholder }}"
           value="{{ $value }}"
           {{ $attributes->merge(['class' => 'form-control']) }}
           {{ $required == '1' ? 'required' : '' }}>
    <span class="input-group-addon"><x-icon type="calendar" /></span>
</div>
