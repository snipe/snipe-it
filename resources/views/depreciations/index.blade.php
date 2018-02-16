@extends('layouts/default')

{{-- Page title --}}
@section('title')
Asset Depreciations
@parent
@stop

@section('header_right')
<a href="{{ route('depreciations.create') }}" class="btn btn-primary pull-right">
  {{ trans('general.create') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">

          <table
                  data-cookie-id-table="depreciationsTable"
                  data-pagination="true"
                  data-id-table="depreciationsTable"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  id="depreciationsTable"
                  class="table table-striped snipe-table"
                  data-url="{{ route('api.depreciations.index') }}"
                  data-export-options='{
                    "fileName": "export-depreciations-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>

            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-sortable="true" data-field="name">{{ trans('admin/depreciations/table.title') }}</th>
                <th data-sortable="false" data-field="months">{{ trans('admin/depreciations/table.term') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions"  data-formatter="depreciationsActionsFormatter">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div> <!-- /.col-md-9-->


  <!-- side address column -->
  <div class="col-md-3">
    <h4>{{ trans('admin/depreciations/general.about_asset_depreciations') }}</h4>
    <p>{{ trans('admin/depreciations/general.about_depreciations') }} </p>
  </div>

</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'depreciations-export', 'search' => true])
@stop
