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
          <div class="col-md-4">


            <div class="checkbox col-md-12">
              <label>
                <input type="checkbox" class="all minimal" checked="checked">
               Select All
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

            <!-- User fields -->
            <div class="checkbox col-md-12">
              <h4>Checked Out To Fields:</h4>
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
                {{ trans('admin/users/table.employee_num') }}
              </label>
            </div>

            <div class="checkbox col-md-12">
              <label>
                {{ Form::checkbox('department', '1', '1', ['class' => 'minimal']) }}
                {{ trans('general.department') }}
              </label>
            </div>




            @if ($customfields->count() > 0)
              <div class="checkbox col-md-12">
                <h4>Custom Fields:</h4>
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

            <p>Select the fields you'd like to include in your custom report, and click Generate. The file (custom-asset-report-YYYY-mm-dd.csv) will download automatically, and you can open it in Excel.</p>
            <p>If you'd like to export only certain assets, use the options below to fine-tune your results.</p>

            @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'by_company_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'by_location_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'by_supplier_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.model-select', ['translated_name' => trans('general.asset_model'), 'fieldname' => 'by_model_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'by_manufacturer_id', 'hide_new' => 'true'])
            @include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'by_category_id', 'hide_new' => 'true', 'category_type' => 'asset'])

          <!-- Status -->
            <div class="form-group">
              <label for="status_id" class="col-md-3 control-label">{{ trans('admin/hardware/form.status') }}</label>
              <div class="col-md-7 col-sm-11">
                {{ Form::select('by_status_id', \App\Helpers\Helper::statusLabelList() , Input::old('by_status_id'), array('class'=>'select2', 'style'=>'width:100%')) }}
              </div>
            </div>


            <!-- Order Number -->
            <div class="form-group">
              <label for="order_number" class="col-md-3 control-label">{{ trans('general.order_number') }}</label>
              <div class="col-md-5 col-sm-8">
                <input class="form-control" type="text" name="by_order_number" value="">
              </div>
            </div>

          <!-- Purchase Date -->
            <div class="form-group purchase-range">
              <label for="purchase_date" class="col-md-3 control-label">{{ trans('general.purchase_date') }} Range</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="input-sm form-control" name="purchase_start" />
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" name="purchase_end" />
              </div>
            </div>

            <!-- Created Date -->
            <div class="form-group purchase-range">
              <label for="purchase_date" class="col-md-3 control-label">{{ trans('general.created_at') }} Range</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="input-sm form-control" name="created_start" />
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" name="created_end" />
              </div>
            </div>

            

            <div class="col-md-9 col-md-offset-3">
              <label>
                {{ Form::checkbox('use_bom', '1') }}
                Add a BOM (byte-order mark) to this CSV
              </label>

            </div>

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

@section('moar_scripts')
  <script>

      $('.purchase-range .input-daterange').datepicker({
          clearBtn: true,
          todayHighlight: true,
          endDate: '0d',
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
