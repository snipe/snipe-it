@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.activity_report') }} 
@parent
@stop

{{-- Page content --}}
@section('content')



<div class="row">
  <div class="col-md-12">

  <div class="box box-default">
    <div class="box-body">

        <table
                name="activityReport"
                data-toolbar="#toolbar"
                class="table table-striped snipe-table"
                id="table"
                data-url="{{ route('api.activity.list') }}"
                data-cookie="true"
                data-cookie-id-table="activityReportTable">
            <thead>
            <tr>
                <th class="col-sm-1" data-field="admin">{{ trans('general.admin') }}</th>
                <th class="col-sm-1" data-field="action_type">{{ trans('general.action') }}</th>
                <th class="col-sm-1" data-field="item_type">{{ trans('general.type') }}</th>
                <th class="col-sm-1" data-field="item">{{ trans('general.item') }}</th>
                <th class="col-sm-1" data-field="target">To</th>
                <th class="col-sm-1" data-field="created_at">{{ trans('general.date') }}</th>
                <th class="col-sm-1" data-field="note">{{ trans('general.notes') }}</th>
            </tr>
            </thead>

        </table>


    </div>
    </div>
  </div>
@stop


@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'activity-export', 'search' => true])
@stop
