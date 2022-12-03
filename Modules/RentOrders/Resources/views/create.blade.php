@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Rent Orders Create') }}
@parent
@stop

@section('header_right')
@stop

{{-- Page content --}}
@section('content')

<livewire:rentorders::rent-order-form/>

@stop

