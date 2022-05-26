@extends('layouts/default')

{{-- Page Title --}}
@section('title')
{{ trans('general.custom_license_report') }}
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
                {{ trans('admin/companies/table.title') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('name', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/table.title') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('product_key', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/form.license_key') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('expiration_date', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/form.expiration') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('license_email', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/form.to_email') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('license_name', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/form.to_name') }}
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
                {{ Form::checkbox('supplier', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.supplier') }}
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
                {{ Form::checkbox('seats', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/accessories/general.total') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('free_seats_count', '1', '1', ['class' => 'minimal']) }}
                - {{ trans('admin/accessories/general.remaining') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('purchase_date', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.purchase_date') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('termination_date', '1', '1', ['class' => 'minimal']) }}
                - {{ trans('admin/licenses/form.termination_date') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('depreciation', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/hardware/form.depreciation') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('maintained', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/form.maintained') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('reassignable', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/form.reassignable') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('purchase_cost', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.purchase_cost') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('purchase_order', '1', '1', ['class' => 'minimal']) }}
                {{ trans('admin/licenses/form.purchase_order') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('order_number', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.order_number') }}
              </label>
            </div>
            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('notes', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.notes') }}
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
          </div> <!-- /.col-md-3-->

          <div class="col-md-8">

            {!! trans('general.report_fields_info') !!}

            @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'by_company_id', 'hide_new' => 'true'])
          @include ('partials.forms.edit.department-select', ['translated_name' => trans('general.department'), 'fieldname' => 'by_dept_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'by_supplier_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'by_manufacturer_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'by_category_id', 'hide_new' => 'true', 'category_type' => 'asset'])

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

            <div class="col-md-9 col-md-offset-3">
              <label>
                {{ Form::checkbox('use_bom', '1') }}
                {{ trans('general.bom_remark') }}
              </label>

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
