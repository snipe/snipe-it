@extends('layouts/default')

{{-- Page title --}}
@section('title')
   OAuth API Settings
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-default pull-right">{{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
    @if (!config('app.lock_passwords'))
        <div id="app">
            <passport-clients clients-url="{{ url('oauth/clients') }}"></passport-clients>
            <passport-authorized-clients clients-url="{{ url('oauth/clients') }}" tokens-url="{{ url('oauth/tokens') }}"></passport-authorized-clients>
        </div>
    @else
        <p class="help-block">{{ trans('general.feature_disabled') }}</p>
    @endif

@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">
    new Vue({
        el: "#app",
    });
</script>
@endsection
