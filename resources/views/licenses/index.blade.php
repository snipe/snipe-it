@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/licenses/general.software_licenses') }}
@parent
@stop


@section('header_right')
@can('licenses.create')
    <a href="{{ route('create/licenses') }}" class="btn btn-primary pull-right">
      {{ trans('general.create') }}
    </a>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box">

    <div class="box-body">
      <table
      name="licenses"
      id="table"
      data-url="{{route('api.licenses.list') }}"
      class="table table-striped snipe-table"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="licenseTable">
          <thead>
              <tr>
                  <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                  <th data-field="company" data-sortable="true" data-switchable="true">{{ trans('general.company') }}</th>
                  <th data-field="name" data-sortable="true">{{ trans('admin/licenses/table.title') }}</th>
                  <th data-field="manufacturer" data-sortable="true">{{ trans('general.manufacturer') }}</th>
                  <th data-field="serial" data-sortable="true" >{{ trans('admin/licenses/form.license_key') }}</th>
                  <th data-field="license_name" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.to_name') }}</th>
                  <th data-field="license_email" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.to_email') }}</th>
                  <th data-field="totalSeats" data-sortable="false">{{ trans('admin/licenses/form.seats') }}</th>
                  <th data-field="remaining" data-sortable="false">{{ trans('admin/licenses/form.remaining_seats') }}</th>
                  <th data-field="purchase_date" data-sortable="true">{{ trans('general.purchase_date') }}</th>
                  <th data-field="purchase_cost" data-sortable="true">{{ trans('general.purchase_cost') }}</th>
                  <th data-field="purchase_order" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.purchase_order') }}</th>
                  <th data-field="expiration_date" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.expiration') }}</th>
                  <th data-field="notes" data-sortable="true" data-visible="false">{{ trans('admin/hardware/form.notes') }}</th>
                  <th data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
          </thead>
      </table>
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">

    </div>
  </div><!-- /.box -->




  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'licenses-export', 'search' => true])
@stop
