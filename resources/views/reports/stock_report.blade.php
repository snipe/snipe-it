@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.stock_report') }}
    @parent
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="table-responsive">

                        <table data-cookie-id-table="stockReport" data-pagination="true" data-id-table="stockReport"
                            data-search="true" data-side-pagination="client" data-show-columns="true" data-show-export="true"
                            data-sort-order="asc" data-show-refresh="true" data-sort-order="asc" id="stockReport"
                            class="table table-striped snipe-table"
                            data-export-options='{
                        "fileName": "stock-report-{{ date('Y-m-d') }}"
                        }'>
                            <thead>
                                <tr role="row">
                                    <th data-sortable="true" class="col-sm-1">QTY</th>
                                    <th data-sortable="true" class="col-sm-1">Model Name</th>
                                    <th data-sortable="true" class="col-sm-1">Part Number</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($stock as $key => $value)
                                    <tr>
                                        <td>{{ $value['qty'] }}</td>
                                        <td>{{ $key }}</td>
                                        <td>{{ $value['part_number'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- /.table-responsive-->
                </div>
            </div>
        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
