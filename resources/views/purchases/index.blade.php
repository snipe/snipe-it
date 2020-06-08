@extends('layouts/default')

{{-- Page title --}}
@section('title')
Закупки
@parent
@stop

@section('header_right')
    @can('create', \App\Models\Location::class)
        <a href="{{ route('purchases.create') }}" class="btn btn-primary pull-right">
            {{ trans('general.create') }}</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <table
                            data-click-to-select="true"
                            data-columns="{{ \App\Presenters\PurchasePresenter::dataTableLayout() }}"
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
                            data-url="{{ route('api.purchases.index') }}">
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')


@stop

