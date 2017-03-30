@extends('layouts/setup')

{{-- Page title --}}
@section('title')
{{ trans('admin/setup/general.create_database_tables') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')




      <div class="col-lg-12" style="padding-top: 20px;">

        @if (trim($output)=='Nothing to migrate.')
        <div class="col-md-12">
            <div class="alert alert-warning">
                <i class="fa fa-warning"></i>
              {{ trans('admin/setup/general.nothing_to_migrate') }}
            </div>
        </div>
        @else
        <div class="col-md-12">
            <div class="alert alert-success">
                <i class="fa fa-check"></i>
                {{ trans('admin/setup/general.database_created') }}
            </div>
        </div>

        @endif

        <p>{{ trans('admin/setup/general.migration_output') }}</p>
        <pre>{{ $output }}</pre>
        </div>

@stop

@section('button')
  <form action="{{ route('setup.user') }}" method="GET">
    <button class="btn btn-primary">{{ trans('general.next') }}: {{ trans('admin/setup/general.create_user') }}</button>
  </form>
@parent
@stop
