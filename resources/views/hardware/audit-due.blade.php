@extends('layouts/default')

@section('title0')

    @if ((Request::get('company_id')) && ($company))
        {{ $company->name }}
    @endif

    {{ trans('general.audit_due') }}

@stop

{{-- Page title --}}
@section('title')
    @yield('title0')  @parent
@stop


{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">

                    @include('partials.asset-bulk-actions')

                    <div class="row">
                        <div class="col-md-12">

                            <table
                                    data-click-to-select="true"
                                    data-columns="{{ \App\Presenters\AssetAuditPresenter::dataTableLayout() }}"
                                    data-cookie-id-table="assetsAuditListingTable"
                                    data-pagination="true"
                                    data-id-table="assetsAuditListingTable"
                                    data-search="true"
                                    data-side-pagination="server"
                                    data-show-columns="true"
                                    data-show-export="true"
                                    data-show-footer="true"
                                    data-show-refresh="true"
                                    data-sort-order="asc"
                                    data-sort-name="name"
                                    data-toolbar="#toolbar"
                                    id="assetsAuditListingTable"
                                    class="table table-striped snipe-table"
                                    data-url="{{ route('api.asset.to-audit', ['audit' => 'due']) }}"
                                    data-export-options='{
                "fileName": "export-assets-due-audit-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                            </table>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    {{ Form::close() }}
                </div><!-- ./box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@stop

@section('moar_scripts')
    @include('partials.bootstrap-table')

@stop
