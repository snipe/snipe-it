@extends('layouts/default')

{{-- Page title --}}
@section('title')
   API Settings (test)
    @parent
@stop

{{-- Page content --}}
@section('content')
    <div id="app">

        <passport-clients></passport-clients>
        <passport-authorized-clients></passport-authorized-clients>
        <passport-personal-access-tokens></passport-personal-access-tokens>

    </div>





@stop
