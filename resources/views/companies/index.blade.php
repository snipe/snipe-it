@extends('layouts/default')

{{-- Page title --}}
@section('title')
  {{ trans('general.companies') }}
  @parent
@stop

@section('header_right')
  <a href="{{ route('companies.create') }}" class="btn btn-primary pull-right">
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
                    name="companies"
                    class="table table-striped snipe-table"
                    id="table"
                    data-url="{{ route('api.companies.index') }}"
                    data-cookie="true"
                    data-click-to-select="true"
                    data-cookie-id-table="companiesTable-{{ config('version.hash_version') }}">
              <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-sortable="true" data-formatter="companiesLinkFormatter" data-field="name" data-searchable="true">{{ trans('admin/companies/table.name') }}</th>
                <th data-sortable="false" data-field="users_count" data-formatter="usersCompanyObjFilterFormatter" data-searchable="false">
                  <span class="hidden-xs"><i class="fa fa-users"></i></span>
                  <span class="hidden-md hidden-lg">{{ trans('general.users') }}</span></th>
                <th data-sortable="false" data-field="assets_count" data-searchable="false" data-formatter="assetCompanyFilterFormatter">
                  <span class="hidden-xs"><i class="fa fa-barcode"></i></span>
                  <span class="hidden-md hidden-lg">{{ trans('general.assets') }}</span></th>
                </th>
                <th data-sortable="false" data-field="licenses_count" data-searchable="false">
                  <span class="hidden-xs"><i class="fa fa-floppy-o"></i></span>
                  <span class="hidden-md hidden-lg">{{ trans('general.licenses') }}</span></th>
                </th>
                <th data-sortable="false" data-field="accessories_count" data-searchable="false">
                  <span class="hidden-xs"><i class="fa fa-keyboard-o"></i></span>
                  <span class="hidden-md hidden-lg">{{ trans('general.accessories') }}</span></th>
                </th>
                <th data-sortable="false" data-field="consumables_count" data-searchable="false">
                  <span class="hidden-xs"><i class="fa fa-tint"></i></span>
                  <span class="hidden-md hidden-lg">{{ trans('general.consumables') }}</span></th>
                </th>
                <th data-sortable="false" data-field="components_count" data-searchable="false">
                  <span class="hidden-xs"><i class="fa fa-hdd-o"></i></span>
                  <span class="hidden-md hidden-lg">{{ trans('general.users') }}</span></th>
                </th>
                <th data-switchable="false" data-formatter="companiesActionsFormatter" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- side address column -->
    <div class="col-md-3">
      <h4>About Companies</h4>
      <p>
        You can use companies as a simple informative field, or you can use them to restrict asset visibility and availability to users with a specific company by enabling Full Company Support in your Admin Settings.
      </p>
  </div>

@stop

@section('moar_scripts')
  @include ('partials.bootstrap-table', ['exportFile' => 'companies-export', 'search' => true])

@stop
