@extends('layouts/setup')
{{-- Page title --}}
@section('title')
{{ trans('general.setup_migrations') }}
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="col-lg-12" style="padding-top: 20px;">
    @if (trim($output)=='Nothing to migrate.')
    <div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            {{ trans('general.setup_no_migrations') }}
        </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            {{ trans('general.setup_successful_migrations') }}
        </div>
    </div>

    @endif

    <p>{{ trans('general.setup_migration_output') }} </p>
    <pre>{{ $output }}</pre>
</div>
@stop

@section('button')
  <form action="{{ route('setup.user') }}" method="GET">
    <button class="btn btn-primary">{{ trans('general.setup_migrations_create_user') }}</button>
  </form>
@parent
@stop
