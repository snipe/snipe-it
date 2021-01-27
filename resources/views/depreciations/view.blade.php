@extends('layouts/default')

{{-- Page title --}}
@section('title')

    {{ trans('general.depreciation') }}: {{ $depreciation->name }}

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
        <div class="col-md-9">


            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#assets" data-toggle="tab">{{ trans('general.assets') }}</a></li>
                    <li><a href="#licenses" data-toggle="tab">{{ trans('general.licenses') }}</a></li>
                    </ul>

                <div class="tab-content">

                    <div class="tab-pane active" id="assets">


                               sldkgjlksgj
                    </div> <!-- end tab-pane -->

                    <!-- tab-pane -->
                    <div class="tab-pane" id="licenses">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="table-responsive">

                                    <table
                                            data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayoutSeats() }}"
                                            data-cookie-id-table="seatsTable"
                                            data-id-table="seatsTable"
                                            id="seatsTable"
                                            data-pagination="true"
                                            data-search="false"
                                            data-side-pagination="server"
                                            data-show-columns="true"
                                            data-show-export="true"
                                            data-show-refresh="true"
                                            data-sort-order="asc"
                                            data-sort-name="name"
                                            class="table table-striped snipe-table"
                                            data-url="{{ route('api.assets.index',['depreciation'=> $depreciation->id]) }}"
                                            data-export-options='{
                        "fileName": "export-depreciations-{{ date('Y-m-d') }}",
                        "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                        }'>
                                    </table>

                                </div>

                            </div>

                        </div> <!--/.row-->
                    </div> <!-- /.tab-pane -->

                </div> <!-- /.tab-content -->
            </div> <!-- nav-tabs-custom -->


        </div>
        <div class="col-md-3">
            <h2>Depreciation info:</h2>
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
