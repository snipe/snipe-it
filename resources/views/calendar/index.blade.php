@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.calendar') }}
    @parent
@stop

{{-- Page content --}}
@section('content')
    <x-container>
        <x-box name="calendar" class="no-header">
            <div id="calendar-truncation-banner" class="alert alert-warning" role="alert" style="display:none;" aria-live="polite">
                <i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i>
                <span id="calendar-truncation-banner-message"></span>
            </div>
            <div id="calendar"></div>
        </x-box>
    </x-container>
@stop

{{-- FullCalendar bundles its own layout CSS via its ES modules, so
     no separate link tag is required. Any theme-specific overrides
     Snipe-IT wants to layer on top belong in overrides.less under a
     .fc scope. --}}
@section('moar_scripts')
    <script src="{{ url(mix('js/dist/snipeit-calendar.js')) }}" nonce="{{ csrf_token() }}"></script>
    <script nonce="{{ csrf_token() }}">
        document.addEventListener('DOMContentLoaded', function () {
            var config = {
                events: '{{ route('api.calendar.events') }}',
                direction: '{{ \App\Helpers\Helper::determineLanguageDirection() }}',
                locale: '{{ str_replace('_', '-', app()->getLocale()) }}',
                phpDateFormat: '{{ $snipeSettings->date_display_format }}',
                filter: [],
                filterMulti: true,
                onFetchMeta: function (meta) {
                    var banner = document.getElementById('calendar-truncation-banner');
                    var message = document.getElementById('calendar-truncation-banner-message');
                    if (!banner || !message) {
                        return;
                    }
                    if (meta.truncated) {
                        message.textContent = '{{ trans('general.calendar_truncation_banner') }}'
                            .replace(':returned', meta.returned)
                            .replace(':total', meta.total);
                        banner.style.display = '';
                    } else {
                        banner.style.display = 'none';
                    }
                },
                {{-- Per-button permission gates. The API already
                     filters events server-side by each source's view
                     policy, so buttons for types the viewer can't
                     access would produce zero events anyway. Hiding
                     them here also avoids leaking the app's event
                     vocabulary ("License expires", "Employment end")
                     to users whose role doesn't touch those objects. --}}
                filterButtons: [
                    @can('view', \App\Models\Asset::class)
                        {
                            name: 'maintenance.start',
                            text: '{{ trans('general.calendar_event_maintenance') }}'
                        },
                        {
                            name: 'asset.audit_due',
                            text: '{{ trans('general.calendar_event_asset_audit_due') }}'
                        },
                        {
                            name: 'asset.expected_checkin',
                            text: '{{ trans('general.calendar_event_asset_expected_checkin') }}'
                        },
                        {
                            name: 'asset.checkout',
                            text: '{{ trans('general.calendar_event_asset_checkout') }}'
                        },
                        {
                            name: 'asset.eol',
                            text: '{{ trans('general.calendar_event_asset_eol') }}'
                        },
                        {
                            name: 'asset.warranty_expiration',
                            text: '{{ trans('general.calendar_event_asset_warranty_expiration') }}'
                        },
                    @endcan
                    @can('view', \App\Models\License::class)
                        {
                            name: 'license.expiration',
                            text: '{{ trans('general.calendar_event_license_expiration') }}'
                        },
                        {
                            name: 'license.termination',
                            text: '{{ trans('general.calendar_event_license_termination') }}'
                        },
                    @endcan
                    @can('view', \App\Models\User::class)
                        {
                            name: 'user.start_date',
                            text: '{{ trans('general.calendar_event_user_start_date') }}'
                        },
                        {
                            name: 'user.end_date',
                            text: '{{ trans('general.calendar_event_user_end_date') }}'
                        },
                    @endcan
                    @can('canCheckoutAtLeastOneItemType')
                        {
                            name: 'request.reservation',
                            text: '{{ trans('general.calendar_event_request_reservation') }}'
                        },
                    @endcan
                ],
            };

            window.snipeitCalendar.init('calendar', config);
        });
    </script>
@stop
