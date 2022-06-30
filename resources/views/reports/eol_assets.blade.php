@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.eol_assets_report') }}
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
                                data-cookie-id-table="eolAssetsReport"
                                data-pagination="true"
                                data-id-table="eolAssetsReport"
                                data-search="true"
                                data-side-pagination="server"
                                data-show-columns="true"
                                data-show-export="true"
                                data-show-refresh="true"
                                data-sort-order="asc"
                                id="eolAssetsReport"
                                class="table table-striped snipe-table"
                                data-columns="{{ \App\Presenters\EolAssetPresenter::dataTableLayout() }}"
                                data-export-options='{
                                "fileName": "eol-assets-report-{{ date('Y-m-d') }}",
                                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                                }'>

                            <thead>
                                <tr>
                                    <th class="col-sm-1">{{ trans('admin/hardware/form.name') }})</th>
                                    <th class="col-sm-1">{{ trans('admin/hardware/table.asset_tag') }}</th>
                                    <th class="col-sm-1">{{ trans('admin/hardware/table.asset_model') }}</th>
                                    <th class="col-sm-1">{{ trans('admin/hardware/table.serial') }}</th>
                                    <th class="col-sm-1">{{ trans('general.purchase_date') }}</th>
                                    <th class="col-sm-1">{{ trans('admin/hardware/form.notes') }}</th>
                                    <th class="col-sm-1">{{ trans('admin/hardware/table.eol_date') }}</th>
                                    <th class="col-sm-1">{{ trans('admin/hardware/table.eol_status') }}</th>
                                    <th class="col-sm-1">{{ trans('admin/hardware/table.eol_duration') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($eol_assets->count())
                                    @foreach ($eol_assets as $asset)
                                        @if($asset->present()->get_expiry_days())
                                        <tr>
                                            <td>{{ $asset->name}}</td>
                                            <td>{{ $asset->present()->asset_tag}}</td>
                                            <td>{{ $asset->model->name}}</td>
                                            <td>{{ $asset->model->model_number}}</td>
                                            <td>{{ date_format($asset->purchase_date, 'Y-m-d')}}</td>
                                            <td>{{ $asset->present()->notes}}</td>
                                            <td>{{ ($asset->purchase_date != '') ? $asset->present()->eol_date() : ''}}</td>
                                            <td>{{ ($asset->present()->get_expiry_status(date_diff(now(),$asset->present()->get_expiry_days())) != 1) ? 'Active' : 'End of Life'}}</td>
                                            <td>{{ $asset->present()->days_until_eol_date()}}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                       
                    </div>
                </div>
            </div>
        </div>
    </div>    
   


@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')

@stop


