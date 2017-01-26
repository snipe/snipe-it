@extends('layouts/default')

{{-- Page title --}}
@section('title')
   OAuth API Settings
    @parent
@stop

{{-- Page content --}}
@section('content')
    @if (!config('app.lock_passwords'))
        <passport-clients></passport-clients>
        <passport-authorized-clients></passport-authorized-clients>
    @else
        <p class="help-block">{{ trans('general.feature_disabled') }}</p>
    @endif

@stop

@section('moar_scripts')
<script>
    new Vue({
        el: "#app",
    });
</script>
@endsection