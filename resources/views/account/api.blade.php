@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Personal API Keys
    @parent
@stop

{{-- Page content --}}
@section('content')
     @if (!config('app.lock_passwords'))
         <passport-personal-access-tokens></passport-personal-access-tokens>
     @else
         <p class="help-block">{{ trans('general.feature_disabled') }}</p>
    @endif

@stop
