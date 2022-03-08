@extends('layouts/default')
{{-- Page title --}}
@section('title')
    {{ $statuslabel->name }} {{ trans('general.assets') }}
    @parent
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
                            @if (Request::get('status')!='Deleted')
                                <div id="toolbar">
                                    <select name="bulk_actions" class="form-control select2">
                                        <option value="edit">{{ trans('button.edit') }}</option>
                                        <option value="delete">{{ trans('button.delete') }}</option>
                                        <option value="labels">{{ trans_choice('button.generate_labels', 1) }}</option>
                                    </select>
                                    <button class="btn btn-default" id="bulkEdit" disabled>{{ trans('button.go') }}</button>
                                </div>
                            @endif

                                <table
                                        data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                                        data-cookie-id-table="assetsListingTable"
                                        data-pagination="true"
                                        data-id-table="assetsListingTable"
                                        data-search="true"
                                        data-side-pagination="server"
                                        data-show-columns="true"
                                        data-show-export="true"
                                        data-show-refresh="true"
                                        data-sort-order="asc"
                                        id="assetsListingTable"
                                        class="table table-striped snipe-table"
                                        data-url="{{route('api.assets.index', ['status_id' => $statuslabel->id]) }}"
                                        data-export-options='{
                              "fileName": "export-assets-{{ str_slug($statuslabel->name) }}-assets-{{ date('Y-m-d') }}",
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
    @include ('partials.bootstrap-table', [
        'exportFile' => 'assets-export',
        'search' => true,
        'columns' => \App\Presenters\AssetPresenter::dataTableLayout()
    ])

@stop
