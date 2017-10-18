@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/licenses/general.software_licenses') }}
@parent
@stop


@section('header_right')
@can('create', \App\Models\License::class)
    <a href="{{ route('licenses.create') }}" class="btn btn-primary pull-right">
      {{ trans('general.create') }}
    </a>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">
        <table
        name="licenses"
        id="table"
        data-url="{{ route('api.licenses.index') }}"
        class="table table-striped snipe-table"
        data-cookie="true"
        data-click-to-select="true"
        data-cookie-id-table="licenseTable">
        </table>
      </div><!-- /.box-body -->

      <div class="box-footer clearfix">
      </div>
    </div><!-- /.box -->
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', [
    'exportFile' => 'licenses-export',
    'search' => true,
    'showFooter' => true,
    'columns' => \App\Presenters\LicensePresenter::dataTableLayout()])

@stop
