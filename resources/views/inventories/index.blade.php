@extends('layouts/default')

{{-- Page title --}}
@section('title')
Инвентаризация
@parent
@stop

{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <table
                            data-click-to-select="true"
                            data-columns="{{ \App\Presenters\InventoryPresenter::dataTableLayout() }}"
                            data-cookie-id-table="usersTable"
                            data-pagination="true"
                            data-id-table="usersTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            data-toolbar="#toolbar"
                            id="usersTable"
                            class="table table-striped snipe-table"
                            data-url="{{ route('api.inventories.index') }}">
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')


@stop

