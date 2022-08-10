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
          <h2 class="box-title">{{  trans('general.customize_report') }}</h2>
        </div><!-- /.box-header -->

        <div class="box-body">
          <div class="col-md-4">


            <div class="checkbox col-md-12">
              <label>
                <input type="checkbox" class="all minimal" checked="checked">
               {{ trans('general.select_all') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('id', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.id') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('company', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.company') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
              {{ Form::checkbox('asset_tag', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.asset_tag') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('asset_name', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/form.name') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('manufacturer', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.manufacturer') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('model', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.asset_models') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('category', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.category') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('serial', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/table.serial') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('purchase_date', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/table.purchase_date') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('purchase_cost', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/form.cost') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('eol', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/table.eol') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('order', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/form.order') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('supplier', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.suppliers') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('location', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.location') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('location_address', '1', '1', ['class' => 'minimal']) }}
                - {{ trans('general.address') }}
              </label>
            </div>

            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('rtd_location', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/form.default_location') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('rtd_location_address', '1', '1', ['class' => 'minimal']) }}
                - {{ trans('general.address') }}
              </label>
            </div>

            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('status', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.status') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('warranty', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/form.warranty') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('depreciation', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.depreciation') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('checkout_date', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/table.checkout_date') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('expected_checkin', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/form.expected_checkin') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('created_at', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.created_at') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('updated_at', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.updated_at') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('deleted_at', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.deleted') }}
              </label>
            </div>

            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('last_audit_date', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.last_audit') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('next_audit_date', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.next_audit_date') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('notes', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.notes') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('url', '1', '1', ['class' => 'minimal']) }}
                - {{ trans('admin/manufacturers/table.url') }}
              </label>
            </div>

            <!-- User fields -->
            <div class="checkbox col-md-12">
              <h2>{{ trans('general.checked_out_to') }} {{ trans('general.fields') }}:</h2>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('assigned_to', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/table.assigned_to') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('username', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/users/table.username') }}
              </label>
            </div>

            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('employee_num', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.employee_number') }}
              </label>
            </div>

            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('manager', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/users/table.manager') }}
              </label>
            </div>

            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('department', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.department') }}
              </label>
            </div>

            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('title', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/users/table.title') }}
              </label>
            </div>


            @if ($customfields->count() > 0)
              <div class="checkbox col-md-12">
                <h2>{{ trans('admin/custom_fields/general.custom_fields') }}</h>:</h4>
              </div>
              @foreach ($customfields as $customfield)
                <div class="checkbox col-md-12">
                  <label>
                    {{ Form::checkbox($customfield->db_column_name(), '1', '1', ['class' => 'minimal']) }}
                    {{ $customfield->name }}
                  </label>
                </div>
              @endforeach
            @endif

          </div> <!-- /.col-md-3-->

          <div class="col-md-8">

            {!! trans('general.report_fields_info') !!}

            @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'by_company_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'by_location_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.default_location'), 'fieldname' => 'by_rtd_location_id', 'hide_new' => 'true'])
          @include ('partials.forms.edit.department-select', ['translated_name' => trans('general.department'), 'fieldname' => 'by_dept_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'by_supplier_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.model-select', ['translated_name' => trans('general.asset_model'), 'fieldname' => 'by_model_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'by_manufacturer_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'by_category_id', 'hide_new' => 'true', 'category_type' => 'asset'])

          <!-- Status -->
            <div class="form-group">
              <label for="by_status_id" class="col-md-3 control-label">{{ trans('admin/hardware/form.status') }}</label>
              <div class="col-md-7 col-sm-11">
                {{ Form::select('by_status_id', Helper::statusLabelList() , old('by_status_id'), array('class'=>'select2', 'style'=>'width:100%', 'aria-label'=>'by_status_id')) }}
              </div>
            </div>


            <!-- Order Number -->
            <div class="form-group">
              <label for="by_order_number" class="col-md-3 control-label">{{ trans('general.order_number') }}</label>
              <div class="col-md-5 col-sm-8">
                <input class="form-control" type="text" name="by_order_number" value="" aria-label="by_order_number">
              </div>
            </div>

          <!-- Purchase Date -->
            <div class="form-group purchase-range">
              <label for="purchase_start" class="col-md-3 control-label">{{ trans('general.purchase_date') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="input-sm form-control" name="purchase_start" aria-label="purchase_start">
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" name="purchase_end" aria-label="purchase_end">
              </div>
            </div>

            <!-- Created Date -->
            <div class="form-group purchase-range">
              <label for="created_start" class="col-md-3 control-label">{{ trans('general.created_at') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="input-sm form-control" name="created_start" aria-label="created_start">
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" name="created_end" aria-label="created_end">
              </div>
            </div>

            <!-- Expected Checkin Date -->
            <div class="form-group expected_checkin-range">
              <label for="expected_checkin_start" class="col-md-3 control-label">{{ trans('admin/hardware/form.expected_checkin') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="input-sm form-control" name="expected_checkin_start" aria-label="expected_checkin_start">
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" name="expected_checkin_end" aria-label="expected_checkin_end">
              </div>
            </div>

              <!-- Last Audit Date -->
              <div class="form-group last_audit-range">
                  <label for="last_audit_start" class="col-md-3 control-label">{{ trans('general.last_audit') }}</label>
                  <div class="input-daterange input-group col-md-6" id="datepicker">
                      <input type="text" class="input-sm form-control" name="last_audit_start" aria-label="last_audit_start">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="input-sm form-control" name="last_audit_end" aria-label="last_audit_end">
                  </div>
              </div>

              <!-- Next Audit Date -->
              <div class="form-group next_audit-range">
                  <label for="next_audit_start" class="col-md-3 control-label">{{ trans('general.next_audit_date') }}</label>
                  <div class="input-daterange input-group col-md-6" id="datepicker">
                      <input type="text" class="input-sm form-control" name="next_audit_start" aria-label="nex_audit_start">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="input-sm form-control" name="next_audit_end" aria-label="next_audit_end">
                  </div>
              </div>

            <div class="col-md-9 col-md-offset-3">
            <label>
              {{ Form::checkbox('exclude_archived', '1', old('exclude_archived'), ['class' => 'minimal']) }}
              {{ trans('general.exclude_archived') }}
            </label>
            </div>
            <div class="col-md-9 col-md-offset-3">
              <label>
                {{ Form::checkbox('use_bom', '1', old('use_bom'), ['class' => 'minimal']) }}
                {{ trans('general.bom_remark') }}
              </label>
            </div>

              <div class="col-md-9 col-md-offset-3">
                <br>
                  {{ Form::radio('deleted_assets', '', true, ['aria-label'=>'deleted_assets', 'class'=>'minimal', 'id'=>'deleted_assets_exclude_deleted'])}}
                  <label for="deleted_assets_exclude_deleted">{{ trans('general.exclude_deleted') }}</label>
                  <br>
                  {{ Form::radio('deleted_assets', '1', old('deleted_assets'), ['aria-label'=>'deleted_assets','class' => 'minimal', 'id'=>'deleted_assets_include_deleted']) }}
                  <label for="deleted_assets_include_deleted">{{ trans('general.include_deleted') }}</label>
                  <br>
                  {{ Form::radio('deleted_assets', '0', old('deleted_assets'), ['aria-label'=>'deleted_assets','class' => 'minimal','id'=>'deleted_assets_only_deleted']) }}
                <label for="deleted_assets_only_deleted">{{ trans('general.only_deleted') }}</label>
              </div>

          </div>


        </div> <!-- /.box-body-->
        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success"><i class="fas fa-download icon-white" aria-hidden="true"></i> {{ trans('general.generate') }}</button>
        </div>
      </div> <!--/.box.box-default-->
    {{ Form::close() }}
  </div>
</div>

@stop

@section('moar_scripts')
  <script>

      $('.purchase-range .input-daterange').datepicker({
          clearBtn: true,
          todayHighlight: true,
          endDate: '0d',
          format: 'yyyy-mm-dd'
      });

      $('.expected_checkin-range .input-daterange').datepicker({
          clearBtn: true,
          todayHighlight: true,
          format: 'yyyy-mm-dd'
      });

      $('.last_audit-range .input-daterange').datepicker({
          clearBtn: true,
          todayHighlight: true,
          endDate:'0d',
          format: 'yyyy-mm-dd'
      });

      $('.next_audit-range .input-daterange').datepicker({
          clearBtn: true,
          todayHighlight: true,
          format: 'yyyy-mm-dd'
      });

    // Check-all / Uncheck all
      $(function () {
          var checkAll = $('input.all');
          var checkboxes = $('input.minimal');


          checkAll.on('ifChecked ifUnchecked', function(event) {
              if (event.type == 'ifChecked') {
                  checkboxes.iCheck('check');
              } else {
                  checkboxes.iCheck('uncheck');
              }
          });

          checkboxes.on('ifChanged', function(event){
              if(checkboxes.filter(':checked').length == checkboxes.length) {
                  checkAll.prop('checked', 'checked');
              } else {
                  checkAll.removeProp('checked');
              }
              checkAll.iCheck('update');
          });
      });
  </script>
@stop
