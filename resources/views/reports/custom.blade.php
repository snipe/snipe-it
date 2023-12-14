@extends('layouts/default')

{{-- Page Title --}}
@section('title')
{{ trans('general.custom_report') }}
@parent
@stop

@section('header_right')
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-8 col-md-offset-1">

    {{ Form::open([
        'method' => 'post',
        'class' => 'form-horizontal',
        'id' => 'custom-report-form',
        'url' => '/reports/custom',
    ]) }}
    {{csrf_field()}}

    <!-- Horizontal Form -->
      <div class="box box-default">
        <div class="box-header with-border">
            <h2 class="box-title">
                @if ($savedReport->exists && request()->routeIs('saved-templates.edit'))
                    Updating: {{ $savedReport->name }}
                @elseif($savedReport->exists)
                    Saved Template: {{ $savedReport->name }}
                @else
                    {{ trans('general.customize_report') }}
                @endif
            </h2>
            @if ($savedReport->exists && request()->routeIs('saved-templates.edit'))
                <div class="box-tools pull-right">
                    {{-- todo --}}
                    <form id="savetemplateform" action="{{ route("savedreports/update") }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="savetemplateform" name="options">
                        <input type="hidden" id="name" name="name" value="{{ $savedReport->name }},1git ">
                        <button class="btn btn-primary" style="width: 32%">
                            {{ "update" }}
                        </button>
                    </form>
                </div>
            @elseif ($savedReport->exists)
                <div class="box-tools pull-right">
                    <a
                        href="{{ route('saved-templates.edit', $savedReport) }}"
                        class="btn btn-sm btn-warning"
                        data-tooltip="true"
                        title="Update"
                    >
                        <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                        <span class="sr-only">Update</span>
                    </a>
                    {{-- these were pulled from hardware.index and the one below doesn't work...--}}
                    <a
                        href="#"
                        class="actions btn btn-danger btn-sm delete-asset"
                        data-tooltip="true"
                        data-toggle="modal"
                        data-content="Are you sure you wish to delete 1260505622?"
                        data-title="Delete"
                        onclick="return false;"
                    >
                            <i class="fas fa-trash" aria-hidden="true"></i><span class="sr-only">Delete</span>
                    </a>
                </div>
            @endif
        </div><!-- /.box-header -->

        <div class="box-body">

            <div class="col-md-4">

              <label class="form-control">
                <input type="checkbox" id="checkAll" checked="checked">
               {{ trans('general.select_all') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('id', '1', $savedReport->checkmarkValue('id')) }}
                {{ trans('general.id') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('company', '1', $savedReport->checkmarkValue('company')) }}
                {{ trans('general.company') }}
              </label>

              <label class="form-control">
              {{ Form::checkbox('asset_tag', '1', $savedReport->checkmarkValue('asset_tag')) }}
                {{ trans('general.asset_tag') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('asset_name', '1', $savedReport->checkmarkValue('asset_name')) }}
                {{ trans('admin/hardware/form.name') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('manufacturer', '1', $savedReport->checkmarkValue('manufacturer')) }}
                {{ trans('general.manufacturer') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('model', '1', $savedReport->checkmarkValue('model')) }}
                {{ trans('general.asset_models') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('category', '1', $savedReport->checkmarkValue('category')) }}
                {{ trans('general.category') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('serial', '1', $savedReport->checkmarkValue('serial')) }}
                {{ trans('admin/hardware/table.serial') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('purchase_date', '1', $savedReport->checkmarkValue('purchase_date')) }}
                {{ trans('admin/licenses/table.purchase_date') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('purchase_cost', '1', $savedReport->checkmarkValue('purchase_cost')) }}
                {{ trans('admin/hardware/form.cost') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('eol', '1', $savedReport->checkmarkValue('eol')) }}
                {{ trans('admin/hardware/table.eol') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('order', '1', $savedReport->checkmarkValue('order')) }}
                {{ trans('admin/hardware/form.order') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('supplier', '1', $savedReport->checkmarkValue('supplier')) }}
                {{ trans('general.suppliers') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('location', '1', $savedReport->checkmarkValue('location')) }}
                {{ trans('general.location') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('location_address', '1', $savedReport->checkmarkValue('location_address')) }}
                - {{ trans('general.address') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('rtd_location', '1', $savedReport->checkmarkValue('rtd_location')) }}
                {{ trans('admin/hardware/form.default_location') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('rtd_location_address', '1', $savedReport->checkmarkValue('rtd_location_address')) }}
                - {{ trans('general.address') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('status', '1', $savedReport->checkmarkValue('status')) }}
                {{ trans('general.status') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('warranty', '1', $savedReport->checkmarkValue('warranty')) }}
                {{ trans('admin/hardware/form.warranty') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('depreciation', '1', $savedReport->checkmarkValue('depreciation')) }}
                {{ trans('general.depreciation') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('checkout_date', '1', $savedReport->checkmarkValue('checkout_date')) }}
                {{ trans('admin/hardware/table.checkout_date') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('expected_checkin', '1', $savedReport->checkmarkValue('expected_checkin')) }}
                {{ trans('admin/hardware/form.expected_checkin') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('created_at', '1', $savedReport->checkmarkValue('created_at')) }}
                {{ trans('general.created_at') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('updated_at', '1', $savedReport->checkmarkValue('updated_at')) }}
                {{ trans('general.updated_at') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('deleted_at', '1', $savedReport->checkmarkValue('deleted_at')) }}
                {{ trans('general.deleted') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('last_audit_date', '1', $savedReport->checkmarkValue('last_audit_date')) }}
                {{ trans('general.last_audit') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('next_audit_date', '1', $savedReport->checkmarkValue('next_audit_date')) }}
                {{ trans('general.next_audit_date') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('notes', '1', $savedReport->checkmarkValue('notes')) }}
                {{ trans('general.notes') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('url', '1', $savedReport->checkmarkValue('url')) }}
                - {{ trans('admin/manufacturers/table.url') }}
              </label>


            <!-- User fields -->

              <h2>{{ trans('general.checked_out_to') }} {{ trans('general.fields') }}:</h2>

              <label class="form-control">
                {{ Form::checkbox('assigned_to', '1', $savedReport->checkmarkValue('assigned_to')) }}
                {{ trans('admin/licenses/table.assigned_to') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('username', '1', $savedReport->checkmarkValue('username')) }}
                {{ trans('admin/users/table.username') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('employee_num', '1', $savedReport->checkmarkValue('employee_num')) }}
                {{ trans('general.employee_number') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('manager', '1', $savedReport->checkmarkValue('manager')) }}
                {{ trans('admin/users/table.manager') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('department', '1', $savedReport->checkmarkValue('department')) }}
                {{ trans('general.department') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('title', '1', $savedReport->checkmarkValue('title')) }}
                {{ trans('admin/users/table.title') }}
              </label>



            @if ($customfields->count() > 0)

                <h2>{{ trans('admin/custom_fields/general.custom_fields') }}</h2>

              @foreach ($customfields as $customfield)

                  <label class="form-control">
                    {{ Form::checkbox($customfield->db_column_name(), '1', $savedReport->checkmarkValue($customfield->db_column_name())) }}
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

            @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'),'multiple' => 'true', 'fieldname' => 'by_company_id[]', 'hide_new' => 'true', 'selected' => $savedReport->selectValues('by_company_id')])
            @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'multiple' => 'true', 'fieldname' => 'by_location_id[]', 'hide_new' => 'true', 'selected' => $savedReport->selectValues('by_location_id')])
            @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.default_location'), 'multiple' => 'true', 'fieldname' => 'by_rtd_location_id[]', 'hide_new' => 'true', 'selected' => $savedReport->selectValues('by_rtd_location_id')])
            @include ('partials.forms.edit.department-select', ['translated_name' => trans('general.department'), 'fieldname' => 'by_dept_id', 'hide_new' => 'true', 'selected' => $savedReport->selectValue('by_dept_id')])
            @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'by_supplier_id[]', 'multiple' => 'true', 'hide_new' => 'true', 'selected' => $savedReport->selectValues('by_supplier_id')])
            @include ('partials.forms.edit.model-select', ['translated_name' => trans('general.asset_model'), 'fieldname' => 'by_model_id[]', 'multiple' => 'true', 'hide_new' => 'true', 'selected' => $savedReport->selectValues('by_model_id')])
            @include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'by_manufacturer_id', 'hide_new' => 'true', 'selected' => $savedReport->selectValue('by_manufacturer_id')])
            @include ('partials.forms.edit.category-select', ['translated_name' => trans('general.category'), 'fieldname' => 'by_category_id', 'hide_new' => 'true', 'category_type' => 'asset', 'selected' => $savedReport->selectValue('by_category_id')])
            @include ('partials.forms.edit.status-select', ['translated_name' => trans('admin/hardware/form.status'), 'fieldname' => 'by_status_id[]', 'multiple' => 'true', 'hide_new' => 'true', 'selected' => $savedReport->selectValues('by_status_id')])

            <!-- Order Number -->
            <div class="form-group">
              <label for="by_order_number" class="col-md-3 control-label">{{ trans('general.order_number') }}</label>
              <div class="col-md-5 col-sm-8">
                <input class="form-control" type="text" name="by_order_number" value="{{ $savedReport->textValue('by_order_number') }}" aria-label="by_order_number">
              </div>
            </div>

          <!-- Purchase Date -->
            <div class="form-group purchase-range">
              <label for="purchase_start" class="col-md-3 control-label">{{ trans('general.purchase_date') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="form-control" name="purchase_start" aria-label="purchase_start" value="{{ $savedReport->textValue('purchase_start') }}">
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="purchase_end" aria-label="purchase_end" value="{{ $savedReport->textValue('purchase_end') }}">
              </div>
            </div>

            <!-- Created Date -->
            <div class="form-group purchase-range">
              <label for="created_start" class="col-md-3 control-label">{{ trans('general.created_at') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="form-control" name="created_start" aria-label="created_start" value="{{ $savedReport->textValue('created_start') }}">
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="created_end" aria-label="created_end" value="{{ $savedReport->textValue('created_end') }}">
              </div>
            </div>

          <!-- Checkout Date -->
          <div class="form-group checkout-range">
              <label for="checkout_date" class="col-md-3 control-label">{{ trans('general.checkout') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                  <input type="text" class="form-control" name="checkout_date_start" aria-label="checkout_date_start" value="{{ $savedReport->textValue('checkout_date_start') }}">
                  <span class="input-group-addon">to</span>
                  <input type="text" class="form-control" name="checkout_date_end" aria-label="checkout_date_end" value="{{ $savedReport->textValue('checkout_date_end') }}">
              </div>
          </div>

            <!-- Expected Checkin Date -->
            <div class="form-group expected_checkin-range">
              <label for="expected_checkin_start" class="col-md-3 control-label">{{ trans('admin/hardware/form.expected_checkin') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="form-control" name="expected_checkin_start" aria-label="expected_checkin_start" value="{{ $savedReport->textValue('expected_checkin_start') }}">
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="expected_checkin_end" aria-label="expected_checkin_end" value="{{ $savedReport->textValue('expected_checkin_end') }}">
              </div>
            </div>

              <!-- Last Audit Date -->
              <div class="form-group last_audit-range">
                  <label for="last_audit_start" class="col-md-3 control-label">{{ trans('general.last_audit') }}</label>
                  <div class="input-daterange input-group col-md-6" id="datepicker">
                      <input type="text" class="form-control" name="last_audit_start" aria-label="last_audit_start" value="{{ $savedReport->textValue('last_audit_start') }}">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="form-control" name="last_audit_end" aria-label="last_audit_end" value="{{ $savedReport->textValue('last_audit_end') }}">
                  </div>
              </div>

              <!-- Next Audit Date -->
              <div class="form-group next_audit-range">
                  <label for="next_audit_start" class="col-md-3 control-label">{{ trans('general.next_audit_date') }}</label>
                  <div class="input-daterange input-group col-md-6" id="datepicker">
                      <input type="text" class="form-control" name="next_audit_start" aria-label="nex_audit_start" value="{{ $savedReport->textValue('next_audit_start') }}">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="form-control" name="next_audit_end" aria-label="next_audit_end" value="{{ $savedReport->textValue('next_audit_end') }}">
                  </div>
              </div>

            <div class="col-md-9 col-md-offset-3">
            <label class="form-control">
              {{ Form::checkbox('exclude_archived', '1', $savedReport->checkmarkValue('exclude_archived')) }}
              {{ trans('general.exclude_archived') }}
            </label>
            </div>
            <div class="col-md-9 col-md-offset-3">
              <label class="form-control">
                {{ Form::checkbox('use_bom', '1', $savedReport->checkmarkValue('use_bom')) }}
                {{ trans('general.bom_remark') }}
              </label>
            </div>

              <div class="col-md-9 col-md-offset-3">
                  <label class="form-control">
                    {{ Form::radio('deleted_assets', '', $savedReport->radioValue('deleted_assets', null, true), ['aria-label'=>'deleted_assets', 'id'=>'deleted_assets_exclude_deleted'])}}
                    {{ trans('general.exclude_deleted') }}
                  </label>
                  <label class="form-control">
                    {{ Form::radio('deleted_assets', '1', $savedReport->radioValue('deleted_assets', '1', '1'), ['aria-label'=>'deleted_assets', 'id'=>'deleted_assets_include_deleted']) }}
                    {{ trans('general.include_deleted') }}
                  </label>
                  <label class="form-control">
                  {{ Form::radio('deleted_assets', '0', $savedReport->radioValue('deleted_assets', '0', '1'), ['aria-label'=>'deleted_assets','id'=>'deleted_assets_only_deleted']) }}
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
    {{ Form::close() }}  {{--does this need to be at the bottom of all our new stuff?--}}
  </div>

    <div class="col-md-2">
        @if (! request()->routeIs('saved-templates.edit'))
            <div style=padding-bottom:5px>
                <form method="post" id="savetemplateform" action="{{ route("savedreports/store") }}">
                    @csrf
                        <input type="hidden" id="savetemplateform" name="options">
                        <input type="text" id="name" name="name" value="{{ $savedReport->name }}"> {{--this means that the name of a loaded report is in the input box. could lead to confusion with update--}}
                        <button class="btn btn-primary" style="width: 100%">
                            {{ trans('admin/reports/general.save_template') }}
                        </button>
                </form>
            </div>

            <div style=padding-bottom:5px>
    {{--            <a href="#" class="js-data-ajax" data-toggle="dropdown" tabindex="-1" data-placeholder="{{ trans('admin/reports/general.saved_reports')}}" style="width:100%">--}}
    {{--                {{ trans('admin/reports/general.select_template') }}--}}
    {{--            <strong class="caret"></strong>--}}
    {{--            </a>--}}
    {{--            {!! Form::select('brand', array('1'=>'Text','2'=>'Logo','3'=>'Logo + Text'), old('brand', $setting->brand), array('class' => 'form-control select2', 'style'=>'width: 150px ;')) !!}--}}
                <select
                    id="saved_report_select"
                    class="form-control select2"
                    data-placeholder="Load Saved Report" {{-- needs translation --}}
                    data-allow-clear="true"
                >
                    <option></option>
                    @foreach($saved_reports as $report)
                        <option value="{{ $report->id }}" @if (request()->input('report') == $report->id) selected @endif>
                            {{ $report->name }}
                        </option>
                    @endforeach
                </select>

{{--                @if($saved_reports->first()!="")--}}
{{--                    <button type="submit" class="btn btn-success" style="width: 32%">--}}
{{--                        <i class="fas fa-download icon-white" aria-hidden="true"></i>--}}
{{--                    </button>--}}
{{--                    <form method="post" id="savetemplateform" action="{{ route("savedreports/update") }}">--}}
{{--                        @csrf--}}
{{--                        <input type="hidden" id="savetemplateform" name="options">--}}
{{--                        <input type="hidden" id="name" name="name" value="{{ $savedReport->name }},1git ">--}}
{{--                        <button class="btn btn-primary" style="width: 32%">--}}
{{--                            {{ "update" }}--}}
{{--                        </button>--}}
{{--                    </form>--}}
{{--                    <button class="btn btn-warning" style="width: 32%">--}}
{{--                        {{ "delete" }}--}}
{{--                    </button>--}}
{{--                @endif--}}

                @push('js')
                    <script>
                        $('#saved_report_select')
                            .on('select2:select', function (event) {
                                window.location.href = '{{ route('reports/custom') }}?report=' + event.params.data.id;
                            })
                            .on('select2:clearing', function (event) {
                                window.location.href = '{{ route('reports/custom') }}';
                            });
                    </script>
                @endpush
            </div>
        @endif
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

      $("#savetemplateform").submit(function(e) {
          e.preventDefault(e);

          let form = $('#custom-report-form');
          {{-- handle null? --}}
          {{-- handle duplicate name? --}}
          $('<input>').attr({
              type: 'hidden',
              name: 'name',
              value: $('#name').val(),
          }).appendTo(form);

          form.attr('action', '/reports/savedtemplate').submit();
      });

  </script>
@stop
