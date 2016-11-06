@extends('layouts/default')

@section('title0')

    @if (Input::get('status'))
        @if (Input::get('status')=='Pending')
            {{ trans('general.pending') }}
        @elseif (Input::get('status')=='RTD')
            {{ trans('general.ready_to_deploy') }}
        @elseif (Input::get('status')=='Undeployable')
            {{ trans('general.undeployable') }}
        @elseif (Input::get('status')=='Deployable')
            {{ trans('general.deployed') }}
         @elseif (Input::get('status')=='Requestable')
            {{ trans('admin/hardware/general.requestable') }}
        @elseif (Input::get('status')=='Archived')
            {{ trans('general.archived') }}
         @elseif (Input::get('status')=='Deleted')
            {{ trans('general.deleted') }}
        @endif
    @else
            {{ trans('general.all') }}
    @endif

    {{ trans('general.assets') }}
@stop

{{-- Page title --}}
@section('title')
    @yield('title0')  @parent
@stop

@section('header_right')
<a href="{{ route('create/hardware') }}" class="btn btn-primary pull-right"></i> {{ trans('general.create') }}</a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
        <div class="box">
          <div class="box-body">
            {{ Form::open([
                 'method' => 'POST',
                 'route' => ['hardware/bulkedit'],
                 'class' => 'form-inline' ]) }}
            <div class="row">
              <div class="col-md-12">
                @if (Input::get('status')!='Deleted')
                <div id="toolbar">
                  <select name="bulk_actions" class="form-control select2">
                      <option value="edit">Edit</option>
                      <option value="delete">Delete</option>
                      <option value="labels">Generate Labels</option>
                  </select>
                  <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
                </div>
                  @endif


                <table
                name="assets"
                {{-- data-row-style="rowStyle" --}}
                data-toolbar="#toolbar"
                class="table table-striped snipe-table"
                id="table"
                data-url="{{route('api.hardware.list', array(''=>e(Input::get('status')),'order_number'=>e(Input::get('order_number')), 'status_id'=>e(Input::get('status_id'))))}}"
                data-cookie="true"
                data-click-to-select="true"
                data-cookie-id-table="{{ e(Input::get('status')) }}assetTable-{{ config('version.hash_version') }}">
                    <thead>
                        <tr>
                            @if (Input::get('status')!='Deleted')
                            <th data-class="hidden-xs" data-switchable="false" data-searchable="false" data-sortable="false" data-field="checkbox"><div class="text-center"><input type="checkbox" id="checkAll" style="padding-left: 0px;"></div></th>
                            @endif
                            <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                            <th data-field="companyName" data-searchable="true" data-sortable="true" data-switchable="true" data-visible="false">{{ trans('general.company') }}</th>
                            <th data-sortable="true" data-field="image" data-visible="false">{{ trans('admin/hardware/table.image') }}</th>
                            <th data-sortable="true" data-field="name" data-visible="false">{{ trans('admin/hardware/form.name') }}</th>
                            <th data-sortable="true" data-field="asset_tag">{{ trans('admin/hardware/table.asset_tag') }}</th>
                            <th data-sortable="true" data-field="serial">{{ trans('admin/hardware/table.serial') }}</th>
                            <th data-sortable="true" data-field="model">{{ trans('admin/hardware/form.model') }}</th>
                            <th data-sortable="true" data-field="model_number" data-visible="false">{{ trans('admin/models/table.modelnumber') }}</th>
                            <th data-sortable="true" data-field="status_label">{{ trans('admin/hardware/table.status') }}</th>
                            <th data-sortable="true" data-field="assigned_to">{{ trans('admin/hardware/form.checkedout_to') }}</th>
                            <th data-sortable="true" data-field="location" data-searchable="true">{{ trans('admin/hardware/table.location') }}</th>
                            <th data-sortable="true" data-field="category" data-searchable="true">{{ trans('general.category') }}</th>
                            <th data-sortable="true" data-field="manufacturer" data-searchable="true" data-visible="false">{{ trans('general.manufacturer') }}</th>
                            <th data-sortable="true" data-field="purchase_cost" data-searchable="true" data-visible="false">{{ trans('admin/hardware/form.cost') }}</th>
                            <th data-sortable="true" data-field="purchase_date" data-searchable="true" data-visible="false">{{ trans('admin/hardware/form.date') }}</th>
                            <th data-sortable="false" data-field="eol" data-searchable="true">{{ trans('general.eol') }}</th>
                            <th data-sortable="true" data-searchable="true" data-field="notes">{{ trans('general.notes') }}</th>
                            <th data-sortable="true" data-searchable="true"  data-field="order_number">{{ trans('admin/hardware/form.order') }}</th>
                            <th data-sortable="true" data-searchable="true" data-field="last_checkout">{{ trans('admin/hardware/table.checkout_date') }}</th>
                            <th data-sortable="true" data-field="expected_checkin" data-searchable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>
                            @foreach(\App\Models\CustomField::all() AS $field)


                                    <th data-sortable="{{ ($field->field_encrypted=='1' ? 'false' : 'true') }}" data-visible="false" data-field="{{$field->db_column_name()}}">
                                        @if ($field->field_encrypted=='1')
                                            <i class="fa fa-lock"></i>
                                        @endif

                                        {{$field->name}}
                                    </th>

                            @endforeach
                            <th data-sortable="true" data-field="created_at" data-searchable="true" data-visible="false">{{ trans('general.created_at') }}</th>
                            <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="change">{{ trans('admin/hardware/table.change') }}</th>

                            <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" >{{ trans('table.actions') }}</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <td colspan="12">
                                <select name="bulk_actions" class="form-control">
                                    <option value="edit">Edit</option>
                                    <option value="delete">Delete</option>
                                    <option value="labels">Generate Labels</option>
                                </select>
                                <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
                            </td>
                        </tr>
                    </tfoot> --}}
                </table>
             {{ Form::close() }}
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- ./box-body -->
        </div><!-- /.box -->
    </div>


</div>


@section('moar_scripts')
@include ('partials.bootstrap-table', [
    'exportFile' => 'assets-export',
    'search' => true,
    'multiSort' => true
])

<script>
    $(function() {
        function checkForChecked() {
            var check_checked = $('input.one_required:checked').length;
            if (check_checked > 0) {
                $('#bulkEdit').removeAttr('disabled');
            }
            else {
                $('#bulkEdit').attr('disabled', 'disabled');
            }
        }
        $('#table').on('change','input.one_required',checkForChecked);
        $("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
            checkForChecked();
        });
    });
</script>
@stop

@stop
