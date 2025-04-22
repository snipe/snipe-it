@component('mail::message')

### {{ trans_choice('mail.upcoming-audits', $assets->count(), ['count' => $assets->count(), 'threshold' => $threshold]) }}

@component('mail::table')
| |{{ trans('mail.name') }}|{{ trans('general.last_audit') }}|{{ trans('general.next_audit_date') }}|{{ trans('mail.Days') }}|{{ trans('mail.supplier') }} | {{ trans('mail.assigned_to') }}|{{ trans('general.notes') }}
|-|:------------- |:-------------|:---------|:---------|:---------|:---------|:---------|
@foreach ($assets as $asset)
@php
$next_audit_date = Helper::getFormattedDateObject($asset->next_audit_date, 'date', false);
$last_audit_date = Helper::getFormattedDateObject($asset->last_audit_date, 'date', false);
$diff = (int) Carbon::parse(Carbon::now())->diffInDays($asset->next_audit_date, true);
$icon = ($diff <= 7) ? '🚨' : (($diff <= 14) ? '⚠️' : ' ');
@endphp
|{{ $icon }}| [{{ $asset->present()->name }}]({{ route('hardware.show', $asset->id) }}) | {{ $last_audit_date }}| {{ $next_audit_date }} | {{ $diff }}  | {{ ($asset->supplier ? e($asset->supplier->name) : '') }}|{{ ($asset->assignedTo ? $asset->assignedTo->present()->name() : '') }}|{{ $asset->notes }}
@endforeach
@endcomponent


@endcomponent
