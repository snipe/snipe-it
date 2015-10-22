@extends('backend/layouts/default')

@section('title0')

    @if (Input::get('status'))
        @if (Input::get('status')=='Pending')
            @lang('general.pending')
        @elseif (Input::get('status')=='RTD')
            @lang('general.ready_to_deploy')
        @elseif (Input::get('status')=='Undeployable')
            @lang('general.undeployable')
        @elseif (Input::get('status')=='Deployable')
            @lang('general.deployed')
         @elseif (Input::get('status')=='Requestable')
            @lang('admin/hardware/general.requestable')
        @elseif (Input::get('status')=='Archived')
            @lang('general.archived')
         @elseif (Input::get('status')=='Deleted')
            @lang('general.deleted')
        @endif
    @else
            @lang('general.all')
    @endif

    @lang('general.assets')
@stop

{{-- Page title --}}
@section('title')
    @yield('title0') :: @parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/hardware') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> @lang('general.create')</a>
        <h3>@yield('title0')</h3>
    </div>
</div>

<div class="row">

 {{ Form::open([
      'method' => 'POST',
      'route' => ['hardware/bulkedit'],
	  'class' => 'form-horizontal' ]) }}

    <table
    name="assets"
    id="table"
    data-url="{{route('api.hardware.list', array(''=>Input::get('status'),'order_number'=>Input::get('order_number')))}}"
    data-cookie="true"
    data-click-to-select="true"
    data-cookie-id-table="assetsTable">
        <thead>
            <tr>
                <th data-class="hidden-xs" data-switchable="false" data-searchable="false" data-sortable="false" data-field="checkbox"><div class="text-center"><input type="checkbox" id="checkAll" style="padding-left: 0px;"></div></th>
                <th data-sortable="true" data-field="id" data-visible="false">@lang('general.id')</th>
                <th data-sortable="true" data-field="name"  data-visible="false">{{Lang::get('admin/hardware/form.name')}}</th>
                <th data-sortable="true" data-field="asset_tag">{{Lang::get('admin/hardware/table.asset_tag')}}</th>
                <th data-sortable="true" data-field="serial">{{Lang::get('admin/hardware/table.serial')}}</th>
                <th data-sortable="true" data-field="model">{{Lang::get('admin/hardware/form.model')}}</th>
                <th data-sortable="true" data-field="status">{{Lang::get('admin/hardware/table.status')}}</th>
                <th data-sortable="true" data-field="location">{{Lang::get('admin/hardware/table.location')}}</th>
                <th data-sortable="true" data-field="category">{{Lang::get('general.category')}}</th>
                <th data-sortable="true" data-field="eol">{{Lang::get('general.eol')}}</th>
                <th data-sortable="true" data-field="notes">{{Lang::get('general.notes')}}</th>
                <th data-sortable="true" data-field="order">{{Lang::get('admin/hardware/form.order')}}</th>
                <th data-sortable="true" data-field="checkout_date">{{Lang::get('admin/hardware/table.checkout_date')}}</th>
                @foreach(CustomField::all() AS $field)
                  <th data-sortable="true" data-field="{{$field->db_column_name()}}">{{{$field->name}}}</th>
                @endforeach
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="change">{{Lang::get('admin/hardware/table.change')}}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions" >{{Lang::get('table.actions')}}</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="12">
                    <select name="bulk_actions">
                        <option value="edit">Edit</option>
                        <option value="labels">Generate Labels</option>
                    </select>
                    <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
                </td>
            </tr>
        </tfoot>
    </table>
 {{ Form::close() }}
</div>


@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{{ Setting::getSettings()->per_page }}},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'txt','json', 'xml'],
        maintainSelected: true,
        paginationFirstText: "@lang('general.first')",
        paginationLastText: "@lang('general.last')",
        paginationPreText: "@lang('general.previous')",
        paginationNextText: "@lang('general.next')",
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
</script>


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
