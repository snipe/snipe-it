@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.depreciation_report') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="page-header">
    <div class="pull-right">
        <a href="{{ route('reports/export') }}" class="btn btn-flat gray pull-right"><i class="fa fa-download icon-white"></i>
        {{ trans('admin/hardware/table.dl_csv') }}</a>
        </div>
    <h3>{{ trans('general.depreciation_report') }}</h3>
</div>

<div class="row">
    <div class="table-responsive">
        <table id="example">
            <thead>
                <tr role="row">
                    <th class="col-sm-1">{{ trans('admin/hardware/table.asset_tag') }}</th>
                    <th class="col-sm-1">{{ trans('admin/hardware/table.title') }}</th>
                    @if ($snipeSettings->display_asset_name)
                    <th class="col-sm-1">{{ trans('general.name') }}</th>
                    @endif
                    <th class="col-sm-1">{{ trans('admin/hardware/table.serial') }}</th>
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
                    <td>{{ $asset->asset_tag }}</td>
                    <td>{{ $asset->model->name }}</td>
                    @if ($snipeSettings->display_asset_name)
                    <td>{{ $asset->name }}</td>
                    @endif
                    <td>{{ $asset->serial }}</td>
                    <td>
                        @if ($asset->assigned_to != '')
                            {!!  $asset->assignedTo->present->nameUrl()  !!}
                        @endif
                    </td>
                    <td>
                        @if (($asset->checkedOutToUser()) && ($asset->assignedTo->assetLoc))
                            {{ $asset->assignedTo->assetLoc->city }}, {{ $asset->assignedTo->assetLoc->state}}
                        @endif
                    </td>
                    <td>{{ $asset->purchase_date }}</td>

                    <td>
                        @if ($asset->model->eol) {{ $asset->present()->eol_date() }}
                        @endif
                    </td>

                    @if ($asset->purchase_cost > 0)
                    <td class="align-right">
                        {{ $snipeSettings->default_currency }}
                        {{ \App\Helpers\Helper::formatCurrencyOutput($asset->purchase_cost) }}
                    </td>
                    <td class="align-right">
                        {{ $snipeSettings->default_currency }}
                        {{ number_format($asset->depreciate()) }}
                    </td>
                    <td class="align-right">
                        {{ $snipeSettings->default_currency }}
                        -{{ number_format(($asset->purchase_cost - $asset->depreciate())) }}
                    </td>
                    @else {{-- purchase_cost > 0 --}}
                    <td></td>
                    <td></td>
                    <td></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
