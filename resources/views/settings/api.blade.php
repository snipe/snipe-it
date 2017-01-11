@extends('layouts/default')

{{-- Page title --}}
@section('title')
   OAuth API Settings
    @parent
@stop

{{-- Page content --}}
@section('content')

        <passport-clients></passport-clients>
        <passport-authorized-clients></passport-authorized-clients>
@stop
