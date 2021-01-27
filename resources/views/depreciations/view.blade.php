@extends('layouts/default')

{{-- Page title --}}
@section('title')

    {{ trans('general.depreciation') }}
    : {{ $depreciation->name }}

    @parent
@stop

@section('header_right')
    <div class="btn-group pull-right">
        <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="{{ route('depreciations.edit', ['depreciation' => $depreciation->id]) }}">{{ trans('general.update') }}</a></li>
            <li><a href="{{ route('depreciations.create') }}">{{ trans('general.create') }}</a></li>
        </ul>
    </div>
@stop

{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table table-responsive">
                                <table
                                        name="location_users"
                                        id="table-users"
                                        class="table table-striped snipe-table"
                                        data-url="{{ route('api.assets.index',['depreciation'=> $depreciation->id]) }}"
                                        data-cookie="true"
                                        data-click-to-select="true"
                                        data-cookie-id-table="department_usersDetailTable">
                                    <thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table', [
        'exportFile' => 'assets-export',
        'search' => true,
        'columns' => \App\Presenters\AssetPresenter::dataTableLayout()
    ])

@stop
