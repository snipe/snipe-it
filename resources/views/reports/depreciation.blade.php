@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.depreciation_report') }} 
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">
          <table
          class="table table-striped table-bordered table-compact"
          name="depreciationReport"
          id="table"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="depreciationReportTable">
            <thead>
              <tr role="row">
                <th class="col-sm-1" data-visible="false">{{ trans('admin/companies/table.title') }}</th>
                <th class="col-sm-1" data-visible="false">{{ trans('admin/categories/general.category_name') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.asset_tag') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.title') }}</th>
                @if ($snipeSettings->display_asset_name)
                <th class="col-sm-1">{{ trans('general.name') }}</th>
                @endif
                <th class="col-sm-1">{{ trans('admin/hardware/table.serial') }}</th>
                <th class="col-sm-1">{{ trans('admin/depreciations/general.depreciation_name') }}</th>
                <th class="col-sm-1">{{ trans('admin/depreciations/general.number_of_months') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.checkoutto') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.location') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.purchase_date') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.eol') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.purchase_cost') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.book_value') }}</th>
                <th class="col-sm-1">{{ trans('admin/hardware/table.diff') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($assets as $asset)
              <tr>
                <td>{{ is_null($asset->company) ? '' : $asset->company->name }}</td>
                <td>
                  @if ($asset->model)
                  {{ $asset->model->category->name }}
                  @endif
                </td>
                <td>
                  @if ($asset->deleted_at!='')
                  <del>{{ $asset->asset_tag }}</del>
                  @else
                  {{ $asset->asset_tag }}
                  @endif
                </td>
                <td>{{ $asset->model->name }}</td>
                @if ($snipeSettings->display_asset_name)
                <td>{{ $asset->name }}</td>
                @endif
                <td>{{ $asset->serial }}</td>
                <td>
                  @if ($asset->model->depreciation)
                  {{ $asset->model->depreciation->name }}
                  @endif
                </td>
                <td>
                  @if ($asset->model->depreciation)
                  {{ $asset->model->depreciation->months }}
                  @endif
                </td>
                <td>
                  @if ($asset->assignedTo)
                    @if ($asset->assignedTo->deleted_at!='')
                    <del>{{ $asset->assignedTo->present()->name() }}</del>
                    @else
                      {!!  $asset->assignedTo->present()->nameUrl()  !!}
                    @endif
                  @endif
                </td>
                <td>
                  @if ($asset->location)
                  {{ $asset->location->name }}
                  @elseif ($asset->defaultloc)
                  {{ $asset->defaultloc->name }}
                  @endif
                </td>
                <td>{{ $asset->purchase_date }}</td>

                <td>
                  @if ($asset->model->eol) {{ $asset->present()->eol_date() }}
                  @endif
                </td>

                @if ($asset->purchase_cost > 0)
                  <td class="align-right">
                    @if ($asset->location )
                    {{ $asset->location->currency }}
                    @else
                    {{ $snipeSettings->default_currency }}
                    @endif
                    {{ \App\Helpers\Helper::formatCurrencyOutput($asset->purchase_cost) }}
                  </td>
                  <td class="align-right">
                    @if ($asset->location )
                    {{ $asset->location->currency }}
                    @else
                    {{ $snipeSettings->default_currency }}
                    @endif

                    {{ \App\Helpers\Helper::formatCurrencyOutput($asset->getDepreciatedValue()) }}
                  </td>
                  <td class="align-right">
                    @if ($asset->location)
                    {{ $asset->location->currency }}
                    @else
                    {{ $snipeSettings->default_currency }}
                    @endif

                    -{{ \App\Helpers\Helper::formatCurrencyOutput(($asset->purchase_cost - $asset->getDepreciatedValue())) }}
                  </td>
                @else
                  <td></td>
                  <td></td>
                  <td></td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
        </div> <!-- /.table-responsive-->
      </div> <!-- /.box-body-->
    </div> <!--/box.box-default-->
  </div> <!-- /.col-md-12-->
</div> <!--/.row-->

@stop

@section('moar_scripts')
<script src="{{ asset('js/bootstrap-table.js') }}"></script>
<script src="{{ asset('js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-responsive table-striped table-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{ $snipeSettings->per_page }},
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


