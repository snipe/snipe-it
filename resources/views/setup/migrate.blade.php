@extends('layouts/setup')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="col-lg-12" style="padding-top: 20px;">
    @if (trim($output)=='Nothing to migrate.')
    <div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fa fa-warning"></i>
            There was nothing to migrate. Your database tables were already set up!
        </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="alert alert-success">
            <i class="fa fa-check"></i>
            Your database tables have been created
        </div>
    </div>

    @endif

    <p>Migration output: </p>
    <pre>{{ $output }}</pre>
</div>
@stop

@section('button')
  <form action="{{ route('setup.user') }}" method="GET">
    <button class="btn btn-primary">Next: Create User</button>
  </form>
@parent
@stop
