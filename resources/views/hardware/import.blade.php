@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.import') }}
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="app">
    <importer>
</div>
@stop
