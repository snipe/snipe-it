@extends('emails/layouts/default')

@section('content')

<p>A user has canceled an item request on the <a href="{{ config('app.url') }}">{{ \App\Models\Setting::getSettings()->site_name }} website</a>. </p>

<p>User: <a href="{{ config('app.url') }}/admin/users/{{ $user_id }}/view">{{ $requested_by }}</a><br>
Item: <a href="{{ $item_url }}">{{ $item_name }}</a> ({{ $item_type }}) <br>
Canceled: {{ $requested_date }}
</p>

@stop
