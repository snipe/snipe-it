@extends('layouts/default')

@section('title0')

    @if ((Input::get('company_id')) && ($company))
        {{ $company->name }}
    @endif

    {{ trans('general.audit_overdue') }}

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
                    {{ Form::open([
                      'method' => 'POST',
                      'route' => ['hardware/bulkedit'],
                      'class' => 'form-inline',
                       'id' => 'bulkForm']) }}
                    <div class="row">
                        <div class="col-md-12">

                            <table
                                    data-click-to-select="true"
                                    data-columns="{{ \App\Presenters\AssetAuditPresenter::dataTableLayout() }}"
                                    data-cookie-id-table="assetsOverdueAuditListingTable"
                                    data-pagination="true"
                                    data-id-table="assetsOverdueAuditListingTable"
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
                                    data-url="{{ route('api.asset.to-audit', ['audit' => 'overdue']) }}"
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
