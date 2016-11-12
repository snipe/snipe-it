@extends('emails/layouts/default')

@section('content')

<<<<<<< HEAD
<p>A user has requested an asset on the <a href="{{ config('app.url') }}">{{ \App\Models\Setting::getSettings()->site_name }} website</a>. </p>

<p>User: <a href="{{ config('app.url') }}/admin/users/{{ $user_id }}/view">{{ $requested_by }}</a><br>
Asset: <a href="{{ config('app.url') }}/hardware/{{ $asset_id }}/view">{{ $asset_name }}</a> ({{ $asset_type }}) <br>
Requested: {{ $requested_date }}
</p>
=======
<p>{{ trans('mail.a_user_requested') }} <a href="{{ config('app.url') }}"> {{ \App\Models\Setting::getSettings()->site_name }}</a>. </p>

<p>{{ trans('mail.user') }} <a href="{{ config('app.url') }}/admin/users/{{ $user_id }}/view">{{ $requested_by }}</a><br>
   {{ trans('mail.item') }} <a href="{{ $item_url }}">{{ $item_name }}</a> ({{ $item_type }}) <br>
   {{ trans('mail.requested') }} {{ $requested_date }}
@if ($item_quantity > 1)
{{ trans('mail.quantity') }} {{ $item_quantity}}
@endif
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72

@stop
