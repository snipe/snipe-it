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


          @if (($depreciations) && ($depreciations->count() > 0))
        <div class="table-responsive">

            <table
                    data-cookie-id-table="depreciationReport"
                    data-pagination="true"
                    data-id-table="depreciationReport"
                    data-search="true"
                    data-side-pagination="client"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    id="depreciationReport"
                    class="table table-striped snipe-table"
                    data-export-options='{
                        "fileName": "depreciation-report-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>

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
                    @if (($asset->checkedOutToUser()) && ($asset->assigned))
                       {{ $asset->assigned->getFullNameAttribute() }}
                    @else

                        @if ($asset->assigned)
                            {{ $asset->assigned->name }}
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
                    @if ($asset->location && $asset->location->currency)
                    {{ $asset->location->currency }}
                    @else
                    {{ $snipeSettings->default_currency }}
                    @endif
                    {{ \App\Helpers\Helper::formatCurrencyOutput($asset->purchase_cost) }}
                  </td>
                  <td class="align-right">
                    @if ($asset->location && $asset->location->currency)
                    {{ $asset->location->currency }}
                    @else
                    {{ $snipeSettings->default_currency }}
                    @endif

                    {{ \App\Helpers\Helper::formatCurrencyOutput($asset->getDepreciatedValue()) }}
                  </td>
                  <td class="align-right">
                    @if ($asset->location && $asset->location->currency)
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
              @else
              <div class="col-md-12">
                  <div class="alert alert-warning fade in">
                      <i class="fa fa-warning faa-pulse animated"></i>
                      <strong>Warning: </strong>
                      You do not currently have any depreciations set up.
                      Please set up at least one depreciation to view the depreciation report.
                  </div>
              </div>
          @endif
      </div> <!-- /.box-body-->
    </div> <!--/box.box-default-->
  </div> <!-- /.col-md-12-->
</div> <!--/.row-->

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
