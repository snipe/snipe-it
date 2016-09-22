@extends('emails/layouts/default')

@section('content')

<p>A user has requested an item on the <a href="{{ config('app.url') }}">{{ \App\Models\Setting::getSettings()->site_name }} website</a>. </p>
{{-- lo que yo deje: --}}
{{--<p>{{ trans('mail.a_user_requested', ['web' => \App\Models\Setting::getSettings()->site_name]) }} <a href="{{ config('app.url') }}"> </a> </p>--}}

<p>User: <a href="{{ config('app.url') }}/admin/users/{{ $user_id }}/view">{{ $requested_by }}</a><br>
Item: <a href="{{ $item_url }}">{{ $item_name }}</a> ({{ $item_type }}) <br>
Requested: {{ $requested_date }}
@if ($item_quantity > 1)
Quantity: {{ $item_quantity}}
@endif
{{-- lo que yo deje: --}}
{{--<p>{{ trans('mail.user') }} <a href="{{ config('app.url') }}/admin/users/{{ $user_id }}/view">{{ $requested_by }}</a><br>--}}
{{--{{ trans('mail.asset') }} <a href="{{ config('app.url') }}/hardware/{{ $asset_id }}/view">{{ $asset_name }}</a> ({{ $asset_type }}) <br>--}}
{{--{{ trans('mail.requested') }} {{ $requested_date }}--}}
{{--</p>--}}

@stop
