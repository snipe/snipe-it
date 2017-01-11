@extends('layouts/default')

{{-- Page title --}}
@section('title')
    API Settings (test)
    @parent
@stop

{{-- Page content --}}
@section('content')
    <div id="app">
        <passport-personal-access-tokens></passport-personal-access-tokens>
    </div>





@stop
