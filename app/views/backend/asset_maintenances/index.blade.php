@extends('backend/layouts/default')

{{-- Page title --}}
@lang('admin/asset_maintenances/general.improvements') ::
@parent
@stop

{{-- Page content --}}
@section('content')
    <div class="row header">
        <div class="col-md-12">
            <a href="{{ route('create/asset_maintenances') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> Create New</a>
            <h3>@lang('admin/asset_maintenances/general.asset_maintenances')</h3>
        </div>
    </div>

    <div class="row form-wrapper">
        {{ Datatable::table()
            ->addColumn(Lang::get('admin/asset_maintenances/table.asset_name'),
                        Lang::get('admin/asset_maintenances/table.supplier_name'),
                        Lang::get('admin/asset_maintenances/form.asset_maintenance_type'),
                        Lang::get('admin/asset_maintenances/form.title'),
                        Lang::get('admin/asset_maintenances/form.start_date'),
                        Lang::get('admin/asset_maintenances/form.completion_date'),
                        Lang::get('admin/asset_maintenances/form.asset_maintenance_time'),
                        Lang::get('admin/asset_maintenances/form.cost'),
                        Lang::get('table.actions'))
            ->setOptions(
                    [
                        'language' => [
                        'search' => Lang::get('general.search'),
                        'lengthMenu' => Lang::get('general.page_menu'),
                        'loadingRecords' => Lang::get('general.loading'),
                        'zeroRecords' => Lang::get('general.no_results'),
                        'info' => Lang::get('general.pagination_info'),
                        'processing' => Lang::get('general.processing'),
                        'paginate'=> [
                            'first'=>Lang::get('general.first'),
                            'previous'=>Lang::get('general.previous'),
                            'next'=>Lang::get('general.next'),
                            'last'=>Lang::get('general.last'),
                            ],
                        ],
                        'sAjaxSource'=>route('api.asset_maintenances.list'),
                        'dom' =>'CT<"clear">lfrtip',
                        'colVis'=> ['showAll'=>'Show All','restore'=>'Restore','activate'=>'mouseover'],
                        'columnDefs'=> [
                            ['bSortable'=>false,'targets'=>[8]],
                            ['width'=>'12%','targets'=>[8]],
                            ],
                        'order'=>[[0,'asc']],
                    ]
                )
            ->render() }}
    </div>
@stop
