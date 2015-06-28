@extends('backend/layouts/default')

{{-- Page title --}}
@lang('admin/improvements/general.improvements') ::
@parent
@stop

{{-- Page content --}}
@section('content')
    <div class="row header">
        <div class="col-md-12">
            <a href="{{ route('create/improvements') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i> Create New</a>
            <h3>@lang('admin/improvements/general.improvements')</h3>
        </div>
    </div>

    <div class="row form-wrapper">
        {{ Datatable::table()
            ->addColumn(Lang::get('admin/improvements/table.asset_name'),
                        Lang::get('admin/improvements/table.supplier_name'),
                        Lang::get('admin/improvements/form.improvement_type'),
                        Lang::get('admin/improvements/form.title'),
                        Lang::get('admin/improvements/form.start_date'),
                        Lang::get('admin/improvements/form.completion_date'),
                        Lang::get('admin/improvements/form.improvement_time'),
                        Lang::get('admin/improvements/form.cost'),
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
                        'sAjaxSource'=>route('api.improvements.list'),
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
