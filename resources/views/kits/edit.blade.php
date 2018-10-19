@extends('layouts/edit-form', [
    'createText' => 'Create kit',
    'updateText' => 'Update kit',
    'formAction' => ($item) ? route('kits.update', ['kit' => $item->id]) : route('kits.store'),
])

{{-- Page content --}}
@section('inputFields')
@include ('partials.forms.edit.name')
@stop

@section('content')
@parent
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Models</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                <table
                data-cookie-id-table="kitModelsTable"
                data-columns="{{ \App\Presenters\::modelsDataTableLayout() }}"
                data-pagination="true"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="kitModelsTable"
                class="table table-striped snipe-table"
                data-url="{{ route('api.kits.models.index') }}"
                data-export-options='{
                "fileName": "export-kit-models-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                </table>
                </div>
            </div> <!--.box-body-->
        </div> <!-- /.box.box-default-->
    </div> <!-- .col-md-12-->
</div>
<div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Licenses</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
    
                    <table
                    data-cookie-id-table="kitLicensesTable"
                    data-columns="{{ \App\Presenters\::licensesDataTableLayout() }}"
                    data-pagination="true"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-sort-name="name"
                    id="kitLicensesTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.kits.licenses.index') }}"
                    data-export-options='{
                    "fileName": "export-kit-models-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
                    </table>
                    </div>
                </div> <!--.box-body-->
            </div> <!-- /.box.box-default-->
        </div> <!-- .col-md-12-->
    </div>
@stop