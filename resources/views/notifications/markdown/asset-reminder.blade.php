@component('mail::message')
    # {{ trans('mail.hello') }} {{ $assigned_to}},

    {{ trans('mail.item_checked_reminder', ['link' => $link, 'count' => $count]) }}

    {{ trans('mail.best_regards') }}

    {{ $snipeSettings->site_name }}

@endcomponent
