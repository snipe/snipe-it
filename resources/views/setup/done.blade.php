@extends('layouts/setup')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="col-lg-12" style="padding-top: 20px;">
	<div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fa fa-check"></i>
            Success! Your admin user has been added!
        </div>
    </div>
    <p>Click here to go to your app login! <a href="{{ url('/') }}">{{ url('/') }}</a></p>
</div>
@stop
