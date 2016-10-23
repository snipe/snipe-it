@extends('layouts/basic')

{{-- Page title --}}
@section('title')
404
@parent
@stop

{{-- Page content --}}

@section('content')



<div class="row">
  <div class="col-md-12">

    <div class="error-page" style="padding-top: 200px">
      <img src="{{ config('app.url') }}/assets/img/sad-panda.png" style="width: 200px; height: 200px;" class="pull-left">
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> 404 Page not found.</h3>
              <p>
                Sad panda. We could not find the page you were looking for.
                You should maybe <a href="{{ route('home') }}">return to the dashboard</a>.
              </p>

    </div>
</div>
@stop
