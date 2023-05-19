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

              <label class="form-control">
                <input type="checkbox" id="checkAll" checked="checked">
               {{ trans('general.select_all') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('id', '1', '1') }}
                {{ trans('general.id') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('company', '1', '1') }}
                {{ trans('general.company') }}
              </label>

              <label class="form-control">
              {{ Form::checkbox('asset_tag', '1', '1') }}
                {{ trans('general.asset_tag') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('asset_name', '1', '1') }}
                {{ trans('admin/hardware/form.name') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('manufacturer', '1', '1') }}
                {{ trans('general.manufacturer') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('model', '1', '1') }}
                {{ trans('general.asset_models') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('category', '1', '1') }}
                {{ trans('general.category') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('serial', '1', '1') }}
                {{ trans('admin/hardware/table.serial') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('purchase_date', '1', '1') }}
                {{ trans('admin/licenses/table.purchase_date') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('purchase_cost', '1', '1') }}
                {{ trans('admin/hardware/form.cost') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('eol', '1', '1') }}
                {{ trans('admin/hardware/table.eol') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('order', '1', '1') }}
                {{ trans('admin/hardware/form.order') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('supplier', '1', '1') }}
                {{ trans('general.suppliers') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('location', '1', '1') }}
                {{ trans('general.location') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('location_address', '1', '1') }}
                - {{ trans('general.address') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('rtd_location', '1', '1') }}
                {{ trans('admin/hardware/form.default_location') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('rtd_location_address', '1', '1') }}
                - {{ trans('general.address') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('status', '1', '1') }}
                {{ trans('general.status') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('warranty', '1', '1') }}
                {{ trans('admin/hardware/form.warranty') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('depreciation', '1', '1') }}
                {{ trans('general.depreciation') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('checkout_date', '1', '1') }}
                {{ trans('admin/hardware/table.checkout_date') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('expected_checkin', '1', '1') }}
                {{ trans('admin/hardware/form.expected_checkin') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('created_at', '1', '1') }}
                {{ trans('general.created_at') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('updated_at', '1', '1') }}
                {{ trans('general.updated_at') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('deleted_at', '1', '1') }}
                {{ trans('general.deleted') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('last_audit_date', '1', '1') }}
                {{ trans('general.last_audit') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('next_audit_date', '1', '1') }}
                {{ trans('general.next_audit_date') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('notes', '1', '1') }}
                {{ trans('general.notes') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('url', '1', '1') }}
                - {{ trans('admin/manufacturers/table.url') }}
              </label>


            <!-- User fields -->

              <h2>{{ trans('general.checked_out_to') }} {{ trans('general.fields') }}:</h2>

              <label class="form-control">
                {{ Form::checkbox('assigned_to', '1', '1') }}
                {{ trans('admin/licenses/table.assigned_to') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('username', '1', '1') }}
                {{ trans('admin/users/table.username') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('employee_num', '1', '1') }}
                {{ trans('general.employee_number') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('manager', '1', '1') }}
                {{ trans('admin/users/table.manager') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('department', '1', '1') }}
                {{ trans('general.department') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('title', '1', '1') }}
                {{ trans('admin/users/table.title') }}
              </label>



            @if ($customfields->count() > 0)

                <h2>{{ trans('admin/custom_fields/general.custom_fields') }}</h2>

              @foreach ($customfields as $customfield)

                  <label class="form-control">
                    {{ Form::checkbox($customfield->db_column_name(), '1', '1') }}
                    {{ $customfield->name }}
                  </label>

              @endforeach
            @endif
          </div> <!-- /.col-md-4-->

          <div class="col-md-8">

            <p>
                {!! trans('general.report_fields_info') !!}
            </p>

              <br>

            @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'),'multiple' => 'true', 'fieldname' => 'by_company_id[]', 'hide_new' => 'true'])
            @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'multiple' => 'true', 'fieldname' => 'by_location_id[]', 'hide_new' => 'true'])
            @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.default_location'), 'multiple' => 'true', 'fieldname' => 'by_rtd_location_id[]', 'hide_new' => 'true'])
            @include ('partials.forms.edit.department-select', ['translated_name' => trans('general.department'), 'fieldname' => 'by_dept_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'by_supplier_id[]', 'multiple' => 'true', 'hide_new' => 'true'])
            @include ('partials.forms.edit.model-select', ['translated_name' => trans('general.asset_model'), 'fieldname' => 'by_model_id[]', 'multiple' => 'true', 'hide_new' => 'true'])
            @include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'by_manufacturer_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'by_category_id', 'hide_new' => 'true', 'category_type' => 'asset'])
              @include ('partials.forms.edit.status-select', ['translated_name' => trans('admin/hardware/form.status'), 'fieldname' => 'by_status_id[]', 'multiple' => 'true', 'hide_new' => 'true'])

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
                <input type="text" class="form-control" name="purchase_start" aria-label="purchase_start">
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="purchase_end" aria-label="purchase_end">
              </div>
            </div>

            <!-- Created Date -->
            <div class="form-group purchase-range">
              <label for="created_start" class="col-md-3 control-label">{{ trans('general.created_at') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="form-control" name="created_start" aria-label="created_start">
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="created_end" aria-label="created_end">
              </div>
            </div>

          <!-- Checkout Date -->
          <div class="form-group checkout-range">
              <label for="checkout_date" class="col-md-3 control-label">{{ trans('general.checkout') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                  <input type="text" class="form-control" name="checkout_date_start" aria-label="checkout_date_start">
                  <span class="input-group-addon">to</span>
                  <input type="text" class="form-control" name="checkout_date_end" aria-label="checkout_date_end">
              </div>
          </div>

            <!-- Expected Checkin Date -->
            <div class="form-group expected_checkin-range">
              <label for="expected_checkin_start" class="col-md-3 control-label">{{ trans('admin/hardware/form.expected_checkin') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="form-control" name="expected_checkin_start" aria-label="expected_checkin_start">
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="expected_checkin_end" aria-label="expected_checkin_end">
              </div>
            </div>

              <!-- Last Audit Date -->
              <div class="form-group last_audit-range">
                  <label for="last_audit_start" class="col-md-3 control-label">{{ trans('general.last_audit') }}</label>
                  <div class="input-daterange input-group col-md-6" id="datepicker">
                      <input type="text" class="form-control" name="last_audit_start" aria-label="last_audit_start">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="form-control" name="last_audit_end" aria-label="last_audit_end">
                  </div>
              </div>

              <!-- Next Audit Date -->
              <div class="form-group next_audit-range">
                  <label for="next_audit_start" class="col-md-3 control-label">{{ trans('general.next_audit_date') }}</label>
                  <div class="input-daterange input-group col-md-6" id="datepicker">
                      <input type="text" class="form-control" name="next_audit_start" aria-label="nex_audit_start">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="form-control" name="next_audit_end" aria-label="next_audit_end">
                  </div>
              </div>

            <div class="col-md-9 col-md-offset-3">
            <label class="form-control">
              {{ Form::checkbox('exclude_archived', '1', old('exclude_archived')) }}
              {{ trans('general.exclude_archived') }}
            </label>
            </div>
            <div class="col-md-9 col-md-offset-3">
              <label class="form-control">
                {{ Form::checkbox('use_bom', '1', old('use_bom')) }}
                {{ trans('general.bom_remark') }}
              </label>
            </div>

              <div class="col-md-9 col-md-offset-3">

                  <label class="form-control">
                    {{ Form::radio('deleted_assets', '', true, ['aria-label'=>'deleted_assets', 'id'=>'deleted_assets_exclude_deleted'])}}
                    {{ trans('general.exclude_deleted') }}
                  </label>
                  <label class="form-control">
                    {{ Form::radio('deleted_assets', '1', old('deleted_assets'), ['aria-label'=>'deleted_assets', 'id'=>'deleted_assets_include_deleted']) }}
                    {{ trans('general.include_deleted') }}
                  </label>
                  <label class="form-control">
                  {{ Form::radio('deleted_assets', '0', old('deleted_assets'), ['aria-label'=>'deleted_assets','id'=>'deleted_assets_only_deleted']) }}
                    {{ trans('general.only_deleted') }}
                  </label>
              </div>
          </div>



        </div> <!-- /.box-body-->
        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-download icon-white" aria-hidden="true"></i>
            {{ trans('general.generate') }}
          </button>
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
      $('.checkout-range .input-daterange').datepicker({
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

      $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
      });

  </script>
@stop
