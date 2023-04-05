@extends('layouts/setup')
{{-- Page title --}}
@section('title')
{{ trans('general.create_admin_user') }}
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="col-lg-12" style="padding-top: 20px;">
	<div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fas fa-check"></i>
            {{ trans('general.create_admin_success') }}
        </div>
    </div>
    <p>{{ trans('general.create_admin_redirect') }} <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
</div>
@stop
