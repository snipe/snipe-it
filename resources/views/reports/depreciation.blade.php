@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.depreciation_report') }} 
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">

        <div class="table-responsive">

            <table
                    data-columns="{{ \App\Presenters\DepreciationReportPresenter::dataTableLayout() }}"
                    data-cookie-id-table="depreciationReportTable"
                    data-pagination="true"
                    data-id-table="depreciationReportTable"
                    data-search="true"
                    data-side-pagination="client"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    id="depreciationReport"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.depreciationreport.index') }}"
                    data-export-options='{
                        "fileName": "depreciation-report-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>
            </table>
        </div>
      </div>
    </div>
  </div> <!-- /.col-md-9-->



@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
