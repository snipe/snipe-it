@extends('layouts/setup')
{{-- Page title --}}
@section('title')
{{ trans('gerneral.setup_migrations') }}
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="col-lg-12" style="padding-top: 20px;">
    @if (trim($output)=='Nothing to migrate.')
    <div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            {{ trans('gerneral.setup_no_migrations') }}
        </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            {{ trans('gerneral.setup_successful_migrations') }}
        </div>
    </div>

    @endif

    <p>{{ trans('gerneral.setup_migration_output') }} </p>
    <pre>{{ $output }}</pre>
</div>
@stop

@section('button')
  <form action="{{ route('setup.user') }}" method="GET">
    <button class="btn btn-primary">{{ trans('gerneral.setup_migrations_create_user') }}</button>
  </form>
@parent
@stop
