@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Personal API Keys
    @parent
@stop

{{-- Page content --}}
@section('content')

        <passport-personal-access-tokens></passport-personal-access-tokens>

@stop
