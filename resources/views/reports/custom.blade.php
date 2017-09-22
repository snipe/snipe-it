@extends('layouts/default')

{{-- Page Title --}}
@section('title')
{{ trans('general.custom_report') }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-8 col-md-offset-2">

    {{ Form::open(['method' => 'post', 'class' => 'form-horizontal']) }}
    {{csrf_field()}}

    <!-- Horizontal Form -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Customize Report</h3>
        </div><!-- /.box-header -->

        <div class="box-body">
          <div class="col-md-3">

            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('company', '1') }}
                {{ trans('general.company') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
              {{ Form::checkbox('asset_tag', '1') }}
                {{ trans('general.asset_tag') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('asset_name', '1') }}
                {{ trans('admin/hardware/form.name') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('manufacturer', '1') }}
                {{ trans('general.manufacturer') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('model', '1') }}
                {{ trans('general.asset_models') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('category', '1') }}
                {{ trans('general.category') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('serial', '1') }}
                {{ trans('admin/hardware/table.serial') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('purchase_date', '1') }}
                {{ trans('admin/licenses/table.purchase_date') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('purchase_cost', '1') }}
                {{ trans('admin/hardware/form.cost') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('eol', '1') }}
                {{ trans('admin/hardware/table.eol') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('order', '1') }}
                {{ trans('admin/hardware/form.order') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('supplier', '1') }}
                {{ trans('general.suppliers') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('location', '1') }}
                {{ trans('general.location') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('assigned_to', '1') }}
                {{ trans('admin/licenses/table.assigned_to') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('username', '1') }}
                {{ trans('admin/users/table.username') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('employee_num', '1') }}
                {{ trans('admin/users/table.employee_num') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('status', '1') }}
                {{ trans('general.status') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('warranty', '1') }}
                {{ trans('admin/hardware/form.warranty') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('depreciation', '1') }}
                {{ trans('general.depreciation') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('expected_checkin', '1') }}
                {{ trans('admin/hardware/form.expected_checkin') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('notes', '1') }}
                {{ trans('general.notes') }}
              </label>
            </div>

            @foreach ($customfields as $customfield)
              <div class="checkbox col-md-12">
                <label>
                  {{ Form::checkbox($customfield->db_column_name(), '1') }}
                  {{ $customfield->name }}
                </label>
              </div>
            @endforeach
          </div> <!-- /.col-md-3-->

          <div class="col-md-7">
            <p>Select the fields you'd like to include in your custom report, and click Generate. The file (YYYY-mm-dd-his-custom-asset-report.csv) will download automatically, and you can open it in Excel.</p>
          </div>

        </div> <!-- /.box-body-->
        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success"><i class="fa fa-download icon-white"></i> {{ trans('general.generate') }}</button>
        </div>
      </div> <!--/.box.box-default-->
    {{ Form::close() }}
  </div>
</div>

@stop
