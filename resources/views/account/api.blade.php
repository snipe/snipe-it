@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Personal API Keys
    @parent
@stop

{{-- Page content --}}
@section('content')
     @if (!config('app.lock_passwords'))
        <passport-personal-access-tokens
            token-url="{{ url('oauth/personal-access-tokens') }}"
            scopes-url="{{ url('oauth/scopes') }}">
        </passport-personal-access-tokens>
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
