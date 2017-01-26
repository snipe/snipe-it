@extends('layouts/default')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lib/jquery.fileupload.css') }}">
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

@section('moar_scripts')
<script>
    new Vue({
        el: '#app'
    });
</script>
@endsection