@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.departments') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('departments.create') }}" class="btn btn-primary pull-right">
        {{ trans('general.create') }}</a>
@stop
{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="table-responsive">

                        <table
                                data-columns="{{ \App\Presenters\DepartmentPresenter::dataTableLayout() }}"
                                data-cookie-id-table="departmentsTable"
                                data-pagination="true"
                                data-id-table="departmentsTable"
                                data-search="true"
                                data-side-pagination="server"
                                data-show-columns="true"
                                data-show-export="true"
                                data-show-refresh="true"
                                data-sort-order="asc"
                                id="departmentsTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.departments.index') }}"
                                data-export-options='{
                              "fileName": "export-departments-{{ date('Y-m-d') }}",
                              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                              }'>
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
