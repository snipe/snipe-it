@extends('layouts/basic')

{{-- Page title --}}
@section('title')
System Unavailable
@parent
@stop

{{-- Page content --}}

@section('content')



<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <div style="padding-top: 200px">
      <img src="{{ url('/') }}/img/sad-panda.png" style="width: 200px; height: 200px;" class="pull-left">
            <div class="error-content">
              <h2><i class="fa fa-warning text-yellow"></i> System Unavailable</h2>
              <p>
                {!! json_decode(file_get_contents(storage_path('framework/down')), true)['message'] !!}
              </p>

    </div>
</div>
@stop
