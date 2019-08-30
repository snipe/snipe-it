@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.accessory_report') }}
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
                                data-cookie-id-table="accessoriesReport"
                                data-pagination="true"
                                data-id-table="accessoriesReport"
                                data-search="true"
                                data-side-pagination="server"
                                data-show-columns="true"
                                data-show-export="true"
                                data-show-refresh="true"
                                data-sort-order="asc"
                                id="accessoriesReport"
                                class="table table-striped snipe-table"
                                data-export-options='{
                        "fileName": "accessory-report-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>

                            <thead>
                            <tr>
                                <th class="col-sm-1">{{ trans('admin/companies/table.title') }}</th>
                                <th class="col-sm-1">{{ trans('admin/accessories/table.title') }}</th>
                                <th class="col-sm-1">{{ trans('admin/accessories/general.total') }}</th>
                                <th class="col-sm-1">{{ trans('admin/accessories/general.remaining') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($accessories as $accessory)
                                <tr>
                                    <td>{{ is_null($accessory->company) ? '' : $accessory->company->name }}</td>
                                    <td>{{ $accessory->name }}</td>
                                    <td>{{ $accessory->qty }}</td>
                                    <td>{{ $accessory->numRemaining() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        </table>
                    </div>
                </div>
            </div>
        </div>


        @stop

        @section('moar_scripts')
            @include ('partials.bootstrap-table')

        @stop


