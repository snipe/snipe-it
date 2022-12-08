@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('Orden de alquiler') }}
@parent
@stop

@section('header_right')
@section('header_right')
<a href="{{ route('rentorders.create') }}" class="btn btn-primary pull-right">
    {{ trans('Crear') }}</a>
@stop
@stop

{{-- Page content --}}
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-body">
                <div class="table-responsive">

                    <table
                            data-columns="{{ \Modules\RentOrders\Presenters\RentOrdersPresenter::dataTableLayout() }}"
                            data-cookie-id-table="rentOrderTable"
                            data-pagination="true"
                            data-id-table="rentOrderTable"
                            data-search="true"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-fullscreen="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="asc"
                            id="rentOrderTable"
                            class="table table-striped snipe-table"
                            data-url="{{ route('api.rentorders.index') }}"
                            data-export-options='{
                            "fileName": "export-rentorders-{{ date('Y-m-d') }}",
                            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
                    </table>
                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'rentorder-export', 'search' => true,'showFooter' => true, 'columns' => \Modules\RentOrders\Presenters\RentOrdersPresenter::dataTableLayout()])
@stop
@push('js')
<script >
    function statusFormatter(value, row) {
        return row.status.name
    }
    function createdByFormatter(value, row) {
        return row.created_by.last_name+', ' + row.created_by.first_name + ' (' + row.created_by.username + ') - #' + row.created_by.id
    }
    function assignedToFormatter(value, row) {
        return row.assigned_to.last_name+', ' + row.assigned_to.first_name + ' (' + row.assigned_to.username + ') - #' + row.assigned_to.id
    }

    function createdAtFormatter(value, row) {
        return row.created_at.datetime
    }

    function updatedAtFormatter(value, row) {
        return row.updated_at.datetime
    }

    function rentOrderActionsFormatter(value, row) {
        var actions = ""
        // if ((row.available_actions) && (row.available_actions.update === true)) {
        //     actions += '<a href="{{ url('/') }}/rentorders/' + row.id + '/edit" class="btn btn-sm btn-warning" data-tooltip="true" title="{{ trans('general.update') }}"><i class="fas fa-pencil-alt" aria-hidden="true"></i><span class="sr-only">{{ trans('general.update') }}</span></a>&nbsp;';
        // }
        if ((row.available_actions) && (row.available_actions.delete === true)) {
            actions += '<a href="{{ url('/') }}/rentorders/' + row.id + '/delete"'
                + ' class="btn btn-danger btn-sm delete-asset"  data-toggle="tooltip"  '
                + ' data-toggle="modal" '
                + ' data-content="{{ trans('general.sure_to_delete') }} ' + row.id + '?" '
            + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
            + '<i class="fas fa-trash" aria-hidden="true"></i><span class="sr-only">Delete</span></a>&nbsp;';
        } else {
            actions += '<a class="btn btn-danger btn-sm delete-asset disabled" onClick="return false;"><i class="fas fa-trash"></i></a>&nbsp;';
        }
        return actions;
    }

</script>
@endpush

