{{-- max_date: 'today' caps both pickers at today, or pass a moment-parseable
     string. Null (default) leaves both pickers uncapped. --}}
@props([
    'name_start',
    'name_end',
    'value_start' => '',
    'value_end' => '',
    'placeholder' => trans('general.select_date'),
    'max_date' => null,
    'format' => 'YYYY-MM-DD',
    'id' => null,
])

{{-- Two eonasdan datetimepickers linked so picking a start date sets the
     end picker's minDate, and picking an end date sets the start picker's
     maxDate. Replaces the bootstrap-datepicker .input-daterange pattern.
     Linking is handled in snipeit.js by pairing .js-date-range-start with
     the .js-date-range-end sibling under the same .js-date-range parent. --}}
<div {{ $attributes->merge(['class' => 'row js-date-range']) }} @if ($id) id="{{ $id }}" @endif>
    <div class="col-xs-5" style="padding-right: 3px;">
        <div
            class="input-group date js-date-range-start"
            data-provide="datetimepicker"
            data-format="{{ $format }}"
            data-default-now="false"
            @if ($max_date) data-max-date="{{ $max_date }}" @endif
        >
            <input type="text" name="{{ $name_start }}" value="{{ $value_start }}" placeholder="{{ $placeholder }}" aria-label="{{ $name_start }}" class="form-control">
            <span class="input-group-addon"><x-icon type="calendar" /></span>
        </div>
    </div>
    <div class="col-xs-1 text-center js-date-range-separator" style="padding-top: 7px;" aria-hidden="true">
        -
    </div>
    <div class="col-xs-5" style="padding-left: 3px;">
        <div
            class="input-group date js-date-range-end"
            data-provide="datetimepicker"
            data-format="{{ $format }}"
            data-default-now="false"
            @if ($max_date) data-max-date="{{ $max_date }}" @endif
        >
            <input type="text" name="{{ $name_end }}" value="{{ $value_end }}" placeholder="{{ $placeholder }}" aria-label="{{ $name_end }}" class="form-control">
            <span class="input-group-addon"><x-icon type="calendar" /></span>
        </div>
    </div>
</div>
