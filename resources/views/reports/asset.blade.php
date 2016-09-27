@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.asset_report') }}
@parent
@stop

@section('header_right')
<a href="{{ route('reports/export/assets') }}" class="btn btn-default"><i class="fa fa-download icon-white"></i>
{{ trans('admin/hardware/table.dl_csv') }}</a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">

  <div class="box box-default">
    <div class="box-body">

      <div class="table-responsive">

      <table
      name="assetReport"
      id="table"
      class="table table-striped"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="assetReportTable">

        <thead>
            <tr role="row">
            <th class="col-sm-1">{{ trans('admin/companies/table.title') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/table.asset_tag') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/form.manufacturer') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/form.model') }}</th>
            <th class="col-sm-1">{{ trans('general.model_no') }}</th>
            @if ($settings->display_asset_name)
                <th class="col-sm-1">{{ trans('general.name') }}</th>
            @endif
            <th class="col-sm-1">{{ trans('admin/hardware/table.serial') }}</th>
             <th class="col-sm-1">{{ trans('admin/hardware/table.status') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/table.purchase_date') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/table.purchase_cost') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/form.order') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/form.supplier') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/table.checkoutto') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/table.checkout_date') }}</th>
            <th class="col-sm-1">{{ trans('admin/hardware/table.location') }}</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($assets as $asset)
        <tr>
            <td>{{ is_null($asset->company) ? '' : $asset->company->name }}</td>
            <td>{{ $asset->asset_tag }}</td>
            <td>
            @if ($asset->model->manufacturer)
                {{ $asset->model->manufacturer->name }}
            @endif
            </td>
            <td>{{ $asset->model->name }}</td>
            <td>{{ $asset->model->modelno }}</td>
            @if ($settings->display_asset_name)
                <td>{{ $asset->name }}</td>
            @endif
            <td>{{ $asset->serial }}</td>
            <td>
                {{ ($asset->assigneduser) ? 'Deployed' : ((e($asset->assetstatus)) ? e($asset->assetstatus->name) : '')  }}
            </td>
            <td>{{ $asset->purchase_date }}</td>
            <td class="align-right">{{ $settings->default_currency }}
                {{ \App\Helpers\Helper::formatCurrencyOutput($asset->purchase_cost) }}
            </td>
            <td>
                @if ($asset->order_number)
                    {{ $asset->order_number }}
                @endif
            </td>
            <td>
                @if ($asset->supplier_id)
                    <a href="{{ route('view/supplier', $asset->supplier_id) }}">
                    {{ $asset->supplier->name }}
                    </a>
                @endif
            </td>
            <td>
             @if ($asset->assigneduser)
            	 @if ($asset->assigneduser->deleted_at!='')
            	 	<del>{{ $asset->assigneduser->fullName() }}</del>
            	 @else
            	 	<a href="{{ route('view/user', $asset->assigned_to) }}">
					{{ $asset->assigneduser->fullName() }}
					</a>
            	 @endif

            @endif
            </td>

            <td>
                @if (($asset->assigneduser) && ($asset->last_checkout!=''))
                    {{ $asset->last_checkout }}
                @endif
            </td>

            <td>
            @if (($asset->assigneduser) && ($asset->assigneduser->userLoc))
              {{ $asset->assigneduser->userLoc->name }}
            @elseif ($asset->defaultLoc)
              {{ $asset->defaultLoc->name }}
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
</div>
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
        pageSize: {{ $settings->per_page }},
        pagination: true,
        sidePagination: 'client',
        sortable: true,
        cookie: true,
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'txt','json', 'xml'],
        maintainSelected: true,
        paginationFirstText: "{{ trans('general.first') }}",
        paginationLastText: "{{ trans('general.last') }}",
        paginationPreText: "{{ trans('general.previous') }}",
        paginationNextText: "{{ trans('general.next') }}",
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
</script>
@stop

@stop
