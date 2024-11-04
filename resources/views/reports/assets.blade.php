@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.assets_report') }}
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
                            data-cookie-id-table="hardwareReport"
                            data-pagination="true"
                            data-id-table="hardwareReport"
                            data-search="true"
                            data-side-pagination="client"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"                            
                            data-sort-order="asc"                            
                            id="hardwareReport"
                            class="table table-striped snipe-table"
                            data-export-options='{
                        "fileName": "hardware-report-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>

                            <thead>
                            <tr>
                                <th class="col-sm-1" >{{ trans('admin/companies/table.title') }}</th>
                                <th class="col-sm-1" data-field="asset_category" data-sortable="true" >{{ trans('admin/assets/general.asset_category') }}</th>
                                <th class="col-sm-1" data-sortable="true" >{{ trans('general.model_no') }}</th>
                                <th class="col-sm-1" data-sortable="true" >{{ trans('admin/assets/general.total') }}</th>
                                <th class="col-sm-1"  data-sortable="true" >{{ trans('admin/assets/general.deployed') }} <i class="fa fa-info-circle text-blue" data-tooltip="true" title="" data-original-title="items that are assigned/issued."></i></th>
                                <th class="col-sm-1"  data-sortable="true" >{{ trans('admin/assets/general.ready_to_deploy') }} <i class="fa fa-info-circle text-blue" data-tooltip="true" title="" data-original-title="items that can be issued."></i></th>
                                <th class="col-sm-1"  data-sortable="true" >{{ trans('admin/assets/general.pending') }} <i class="fa fa-info-circle text-blue" data-tooltip="true" title="" data-original-title="items that are out for repair, but are expected to return to circulation."></i></th>
                                <th class="col-sm-1"  data-sortable="true" >{{ trans('admin/assets/general.undeployable') }} <i class="fa fa-info-circle text-blue" data-tooltip="true" title="" data-original-title="items that are irrepairable and cannot be issued."></i></th>
                            </tr>
                            </thead>
                            <tbody>
                               @php 
                               use App\Http\Controllers\ReportsController;
                               $rc = new ReportsController();
                               @endphp
                            @foreach ($data as $asset)
                            <tr>
                                <td>{{ $asset->company->name }}</td>
                                <td>{{ link_to_route('categories.show', $asset->model->category->name, $asset->model->category->id, ['target' => '_blank']) }}</td>                                
                                <td>{{ link_to_route('models.show', $asset->model->name, $asset->model->id, ['target' => '_blank']) }}</td>
                                <td>{{ $asset->total }}</td>                                
                                <td class="">{{ $rc->getCountByStatusType("Deployed", "model_id", $asset->model->id); }}</td>
                                <td class="">{{ $rc->getCountByStatusType("RTD", "model_id", $asset->model->id) }}</td>
                                <td class="">{{ $rc->getCountByStatusType("Pending", "model_id", $asset->model->id) }}</td>
                                <td class="">{{ $rc->getCountByStatusType("Undeployable", "model_id", $asset->model->id) }}</td>
                            </tr>
                            @endforeach
                        </tbody>                    
                        </table>

                    </div>
                </div>
            </div>
        </div>


        @stop

        @section('moar_scripts')
            @include ('partials.bootstrap-table')

        @stop


