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
        'url' => request()->routeIs('report-templates.edit') ? route('report-templates.update', $reportTemplate) : '/reports/custom',
    ]) }}
    {{csrf_field()}}

    <!-- Horizontal Form -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h2 class="box-title">
            @if (request()->routeIs('report-templates.edit'))
              Updating: {{ $reportTemplate->name }}
            @elseif(request()->routeIs('report-templates.show'))
              Saved Template: {{ $reportTemplate->name }}
            @else
              {{ trans('general.customize_report') }}
            @endif
          </h2>
          @if (request()->routeIs('report-templates.show'))
            <div class="box-tools pull-right">
              <a
                href="{{ route('report-templates.edit', $reportTemplate) }}"
                class="btn btn-sm btn-warning"
                data-tooltip="true"
                title="Update"
              >
                <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                <span class="sr-only">{{ trans('general.update') }}</span>
              </a>
              <button
                class="btn btn-sm btn-danger delete-asset"
                data-toggle="modal"
                data-title="{{ trans('general.delete') }}"
                data-content="{{ trans('general.delete_confirm', ['item' => $reportTemplate->name]) }}"
                data-target="#dataConfirmModal"
                type="button"
              >
                <i class="fas fa-trash" aria-hidden="true"></i><span class="sr-only">{{ trans('general.delete') }}</span>
              </button>
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
                {{ Form::checkbox('id', '1', $reportTemplate->checkmarkValue('id')) }}
                {{ trans('general.id') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('company', '1', $reportTemplate->checkmarkValue('company')) }}
                {{ trans('general.company') }}
              </label>

              <label class="form-control">
              {{ Form::checkbox('asset_tag', '1', $reportTemplate->checkmarkValue('asset_tag')) }}
                {{ trans('general.asset_tag') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('asset_name', '1', $reportTemplate->checkmarkValue('asset_name')) }}
                {{ trans('admin/hardware/form.name') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('manufacturer', '1', $reportTemplate->checkmarkValue('manufacturer')) }}
                {{ trans('general.manufacturer') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('model', '1', $reportTemplate->checkmarkValue('model')) }}
                {{ trans('general.asset_models') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('category', '1', $reportTemplate->checkmarkValue('category')) }}
                {{ trans('general.category') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('serial', '1', $reportTemplate->checkmarkValue('serial')) }}
                {{ trans('admin/hardware/table.serial') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('purchase_date', '1', $reportTemplate->checkmarkValue('purchase_date')) }}
                {{ trans('admin/licenses/table.purchase_date') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('purchase_cost', '1', $reportTemplate->checkmarkValue('purchase_cost')) }}
                {{ trans('admin/hardware/form.cost') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('eol', '1', $reportTemplate->checkmarkValue('eol')) }}
                {{ trans('admin/hardware/table.eol') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('order', '1', $reportTemplate->checkmarkValue('order')) }}
                {{ trans('admin/hardware/form.order') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('supplier', '1', $reportTemplate->checkmarkValue('supplier')) }}
                {{ trans('general.suppliers') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('location', '1', $reportTemplate->checkmarkValue('location')) }}
                {{ trans('general.location') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('location_address', '1', $reportTemplate->checkmarkValue('location_address')) }}
                - {{ trans('general.address') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('rtd_location', '1', $reportTemplate->checkmarkValue('rtd_location')) }}
                {{ trans('admin/hardware/form.default_location') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('rtd_location_address', '1', $reportTemplate->checkmarkValue('rtd_location_address')) }}
                - {{ trans('general.address') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('status', '1', $reportTemplate->checkmarkValue('status')) }}
                {{ trans('general.status') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('warranty', '1', $reportTemplate->checkmarkValue('warranty')) }}
                {{ trans('admin/hardware/form.warranty') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('depreciation', '1', $reportTemplate->checkmarkValue('depreciation')) }}
                {{ trans('general.depreciation') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('checkout_date', '1', $reportTemplate->checkmarkValue('checkout_date')) }}
                {{ trans('admin/hardware/table.checkout_date') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('expected_checkin', '1', $reportTemplate->checkmarkValue('expected_checkin')) }}
                {{ trans('admin/hardware/form.expected_checkin') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('created_at', '1', $reportTemplate->checkmarkValue('created_at')) }}
                {{ trans('general.created_at') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('updated_at', '1', $reportTemplate->checkmarkValue('updated_at')) }}
                {{ trans('general.updated_at') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('deleted_at', '1', $reportTemplate->checkmarkValue('deleted_at')) }}
                {{ trans('general.deleted') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('last_audit_date', '1', $reportTemplate->checkmarkValue('last_audit_date')) }}
                {{ trans('general.last_audit') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('next_audit_date', '1', $reportTemplate->checkmarkValue('next_audit_date')) }}
                {{ trans('general.next_audit_date') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('notes', '1', $reportTemplate->checkmarkValue('notes')) }}
                {{ trans('general.notes') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('url', '1', $reportTemplate->checkmarkValue('url')) }}
                - {{ trans('admin/manufacturers/table.url') }}
              </label>


            <!-- User fields -->

              <h2>{{ trans('general.checked_out_to') }} {{ trans('general.fields') }}:</h2>

              <label class="form-control">
                {{ Form::checkbox('assigned_to', '1', $reportTemplate->checkmarkValue('assigned_to')) }}
                {{ trans('admin/licenses/table.assigned_to') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('username', '1', $reportTemplate->checkmarkValue('username')) }}
                {{ trans('admin/users/table.username') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('employee_num', '1', $reportTemplate->checkmarkValue('employee_num')) }}
                {{ trans('general.employee_number') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('manager', '1', $reportTemplate->checkmarkValue('manager')) }}
                {{ trans('admin/users/table.manager') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('department', '1', $reportTemplate->checkmarkValue('department')) }}
                {{ trans('general.department') }}
              </label>

              <label class="form-control">
                {{ Form::checkbox('title', '1', $reportTemplate->checkmarkValue('title')) }}
                {{ trans('admin/users/table.title') }}
              </label>



            @if ($customfields->count() > 0)

                <h2>{{ trans('admin/custom_fields/general.custom_fields') }}</h2>

              @foreach ($customfields as $customfield)

                  <label class="form-control">
                    {{ Form::checkbox($customfield->db_column_name(), '1', $reportTemplate->checkmarkValue($customfield->db_column_name())) }}
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

            @include ('partials.forms.edit.company-select', [
                'translated_name' => trans('general.company'),
                'multiple' => 'true',
                'fieldname' => 'by_company_id[]',
                'hide_new' => 'true',
                'selected' => $reportTemplate->selectValues('by_company_id', \App\Models\Company::class)
            ])
            @include ('partials.forms.edit.location-select', [
                'translated_name' => trans('general.location'),
                'multiple' => 'true',
                'fieldname' => 'by_location_id[]',
                'hide_new' => 'true',
                'selected' => $reportTemplate->selectValues('by_location_id', \App\Models\Location::class)
            ])
            @include ('partials.forms.edit.location-select', [
                'translated_name' => trans('admin/hardware/form.default_location'),
                'multiple' => 'true',
                'fieldname' => 'by_rtd_location_id[]',
                'hide_new' => 'true',
                'selected' => $reportTemplate->selectValues('by_rtd_location_id', \App\Models\Location::class)
             ])
            @include ('partials.forms.edit.department-select', [
                'translated_name' => trans('general.department'),
                'fieldname' => 'by_dept_id',
                'hide_new' => 'true',
                'selected' => $reportTemplate->selectValue('by_dept_id', \App\Models\Department::class)
            ])
            @include ('partials.forms.edit.supplier-select', [
                'translated_name' => trans('general.supplier'),
                'fieldname' => 'by_supplier_id[]',
                'multiple' => 'true',
                'hide_new' => 'true',
                'selected' => $reportTemplate->selectValues('by_supplier_id', \App\Models\Supplier::class)
            ])
            @include ('partials.forms.edit.model-select', [
                'translated_name' => trans('general.asset_model'),
                'fieldname' => 'by_model_id[]',
                'multiple' => 'true',
                'hide_new' => 'true',
                'selected' => $reportTemplate->selectValues('by_model_id', \App\Models\AssetModel::class)
            ])
            @include ('partials.forms.edit.manufacturer-select', [
                'translated_name' => trans('general.manufacturer'),
                'fieldname' => 'by_manufacturer_id',
                'hide_new' => 'true',
                'selected' => $reportTemplate->selectValue('by_manufacturer_id', \App\Models\Manufacturer::class)
             ])
            @include ('partials.forms.edit.category-select', [
                'translated_name' => trans('general.category'),
                'fieldname' => 'by_category_id',
                'hide_new' => 'true',
                'category_type' => 'asset',
                'selected' => $reportTemplate->selectValue('by_category_id', \App\Models\Category::class)
            ])
            @include ('partials.forms.edit.status-select', [
                'translated_name' => trans('admin/hardware/form.status'),
                'fieldname' => 'by_status_id[]',
                'multiple' => 'true',
                'hide_new' => 'true',
                'selected' => $reportTemplate->selectValues('by_status_id', \App\Models\Statuslabel::class)
            ])

            <!-- Order Number -->
            <div class="form-group">
              <label for="by_order_number" class="col-md-3 control-label">{{ trans('general.order_number') }}</label>
              <div class="col-md-5 col-sm-8">
                <input class="form-control" type="text" name="by_order_number" value="{{ $reportTemplate->textValue('by_order_number') }}" aria-label="by_order_number">
              </div>
            </div>

          <!-- Purchase Date -->
            <div class="form-group purchase-range">
              <label for="purchase_start" class="col-md-3 control-label">{{ trans('general.purchase_date') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="form-control" name="purchase_start" aria-label="purchase_start" value="{{ $reportTemplate->textValue('purchase_start') }}">
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="purchase_end" aria-label="purchase_end" value="{{ $reportTemplate->textValue('purchase_end') }}">
              </div>
            </div>

            <!-- Created Date -->
            <div class="form-group purchase-range">
              <label for="created_start" class="col-md-3 control-label">{{ trans('general.created_at') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="form-control" name="created_start" aria-label="created_start" value="{{ $reportTemplate->textValue('created_start') }}">
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="created_end" aria-label="created_end" value="{{ $reportTemplate->textValue('created_end') }}">
              </div>
            </div>

          <!-- Checkout Date -->
          <div class="form-group checkout-range">
              <label for="checkout_date" class="col-md-3 control-label">{{ trans('general.checkout') }} {{  trans('general.range') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                  <input type="text" class="form-control" name="checkout_date_start" aria-label="checkout_date_start" value="{{ $reportTemplate->textValue('checkout_date_start') }}">
                  <span class="input-group-addon">to</span>
                  <input type="text" class="form-control" name="checkout_date_end" aria-label="checkout_date_end" value="{{ $reportTemplate->textValue('checkout_date_end') }}">
              </div>
          </div>

            <!-- Expected Checkin Date -->
            <div class="form-group expected_checkin-range">
              <label for="expected_checkin_start" class="col-md-3 control-label">{{ trans('admin/hardware/form.expected_checkin') }}</label>
              <div class="input-daterange input-group col-md-6" id="datepicker">
                <input type="text" class="form-control" name="expected_checkin_start" aria-label="expected_checkin_start" value="{{ $reportTemplate->textValue('expected_checkin_start') }}">
                <span class="input-group-addon">to</span>
                <input type="text" class="form-control" name="expected_checkin_end" aria-label="expected_checkin_end" value="{{ $reportTemplate->textValue('expected_checkin_end') }}">
              </div>
            </div>

              <!-- Last Audit Date -->
              <div class="form-group last_audit-range">
                  <label for="last_audit_start" class="col-md-3 control-label">{{ trans('general.last_audit') }}</label>
                  <div class="input-daterange input-group col-md-6" id="datepicker">
                      <input type="text" class="form-control" name="last_audit_start" aria-label="last_audit_start" value="{{ $reportTemplate->textValue('last_audit_start') }}">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="form-control" name="last_audit_end" aria-label="last_audit_end" value="{{ $reportTemplate->textValue('last_audit_end') }}">
                  </div>
              </div>

              <!-- Next Audit Date -->
              <div class="form-group next_audit-range">
                  <label for="next_audit_start" class="col-md-3 control-label">{{ trans('general.next_audit_date') }}</label>
                  <div class="input-daterange input-group col-md-6" id="datepicker">
                      <input type="text" class="form-control" name="next_audit_start" aria-label="nex_audit_start" value="{{ $reportTemplate->textValue('next_audit_start') }}">
                      <span class="input-group-addon">to</span>
                      <input type="text" class="form-control" name="next_audit_end" aria-label="next_audit_end" value="{{ $reportTemplate->textValue('next_audit_end') }}">
                  </div>
              </div>

            <div class="col-md-9 col-md-offset-3">
            <label class="form-control">
              {{ Form::checkbox('exclude_archived', '1', $reportTemplate->checkmarkValue('exclude_archived')) }}
              {{ trans('general.exclude_archived') }}
            </label>
            </div>
            <div class="col-md-9 col-md-offset-3">
              <label class="form-control">
                {{ Form::checkbox('use_bom', '1', $reportTemplate->checkmarkValue('use_bom')) }}
                {{ trans('general.bom_remark') }}
              </label>
            </div>

              <div class="col-md-9 col-md-offset-3">
                  <label class="form-control">
                    {{ Form::radio('deleted_assets', '', $reportTemplate->radioValue('deleted_assets', '', true), ['aria-label'=>'deleted_assets', 'id'=>'deleted_assets_exclude_deleted'])}}
                    {{ trans('general.exclude_deleted') }}
                  </label>
                  <label class="form-control">
                    {{ Form::radio('deleted_assets', '1', $reportTemplate->radioValue('deleted_assets', '1'), ['aria-label'=>'deleted_assets', 'id'=>'deleted_assets_include_deleted']) }}
                    {{ trans('general.include_deleted') }}
                  </label>
                  <label class="form-control">
                  {{ Form::radio('deleted_assets', '0', $reportTemplate->radioValue('deleted_assets', '0'), ['aria-label'=>'deleted_assets','id'=>'deleted_assets_only_deleted']) }}
                    {{ trans('general.only_deleted') }}
                  </label>
              </div>
          </div>

        </div> <!-- /.box-body-->
        <div class="box-footer text-right">
          @if (request()->routeIs('report-templates.edit'))
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-check icon-white" aria-hidden="true"></i>
              {{ trans('general.save') }}
            </button>
          @else
            <button type="submit" class="btn btn-success">
              <i class="fas fa-download icon-white" aria-hidden="true"></i>
              {{ trans('general.generate') }}
            </button>
          @endif
        </div>
      </div> <!--/.box.box-default-->
    {{ Form::close() }}
  </div>

    <div class="col-md-2">
        @if (! request()->routeIs('report-templates.edit'))
            <div class="form-group">
                <select
                    id="saved_report_select"
                    class="form-control select2"
                    data-placeholder="{{ trans('admin/reports/general.saved_reports') }}"
                    data-allow-clear="true"
                >
                    <option></option>
                    @foreach($report_templates as $template)
                        <option value="{{ $template->id }}" @if (request()->route()->parameter('reportId') == $template->id) selected @endif>
                            {{ $template->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        @if (request()->routeIs('reports/custom'))
            <div class="form-group">
                <form method="post" id="savetemplateform" action="{{ route("report-templates.store") }}">
                    @csrf
                    <input type="hidden" id="savetemplateform" name="options">
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        {{--this means that the name of a loaded report is in the input box. could lead to confusion with update--}}
                        <label for="name">{{ trans('admin/reports/general.report_name') }}</label>
                        <input class="form-control" placeholder="" name="name" type="text" id="name" value="{{ $reportTemplate->name }}">
                        {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                    </div>
                    <button class="btn btn-primary" style="width: 100%">
                        {{ trans('admin/reports/general.save_template') }}
                    </button>
                </form>
            </div>
        @endif
        <br>
        <h4>{{ trans('admin/reports/message.about_reports') }}</h4>
        <div class="box box-success">
            <div class="box-body">
                <p>{!!  trans('admin/reports/message.saving_reports_description')  !!}</p>
            </div>
        </div>
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
          $('<input>').attr({
              type: 'hidden',
              name: 'name',
              value: $('#name').val(),
          }).appendTo(form);

          form.attr('action', '{{ route('report-templates.store') }}').submit();
      });

      $('#saved_report_select')
        .on('select2:select', function (event) {
            window.location.href = '/reports/templates/' + event.params.data.id;
        })
        .on('select2:clearing', function (event) {
            window.location.href = '{{ route('reports/custom') }}';
        });

      $('#dataConfirmModal').on('show.bs.modal', function (event) {
          var content = $(event.relatedTarget).data('content');
          var title = $(event.relatedTarget).data('title');
          $(this).find(".modal-body").text(content);
          $(this).find(".modal-header").text(title);
      });
  </script>
@stop
