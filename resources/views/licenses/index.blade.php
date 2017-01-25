@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/licenses/general.software_licenses') }}
@parent
@stop


@section('header_right')
@can('create', \App\Models\License::class)
    <a href="{{ route('licenses.create') }}" class="btn btn-primary pull-right">
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
        data-url="{{ route('api.licenses.index') }}"
        class="table table-striped snipe-table"
        data-cookie="true"
        data-click-to-select="true"
        data-cookie-id-table="licenseTable">
            <thead>
                <tr>
                    <th data-checkbox="true" data-field="checkbox"></th>
                    <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                    <th data-field="companyName" data-searchable="true" data-sortable="true" data-switchable="true" data-visible="false" data-formatter="companyFormatter">{{ trans('general.company') }}</th>
                    <th data-sortable="true" data-field="name" data-visible="false" data-formatter="licenseFormatter">{{ trans('admin/licenses/table.title') }}</th>
                    <th data-field="manufacturer" data-sortable="true" data-formatter="manufacturerFormatter">{{ trans('general.manufacturer') }}</th>
                    <th data-field="serial" data-sortable="true" >{{ trans('admin/licenses/form.license_key') }}</th>
                    <th data-field="license_name" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.to_name') }}</th>
                    <th data-field="license_email" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.to_email') }}</th>
                    <th data-field="totalSeats" data-sortable="false">{{ trans('admin/licenses/form.seats') }}</th>
                    <th data-field="remaining" data-sortable="false">{{ trans('admin/licenses/form.remaining_seats') }}</th>
                    <th data-field="purchase_date" data-sortable="true">{{ trans('general.purchase_date') }}</th>
                    <th data-field="purchase_cost" data-sortable="true">{{ trans('general.purchase_cost') }}</th>
                    <th data-field="purchase_order" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.purchase_order') }}</th>
                    <th data-field="expiration_date" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.expiration') }}</th>
                    <th data-sortable="true" data-field="created_at" data-formatter="createdAtFormatter" data-searchable="true" data-visible="false">{{ trans('general.created_at') }}</th>
                    <th data-field="notes" data-sortable="true" data-visible="false">{{ trans('admin/hardware/form.notes') }}</th>

                    <th data-switchable="false" data-searchable="false" data-formatter="actionsFormatter" data-sortable="false" data-field="actions" >{{ trans('table.actions') }}</th>
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

<script>

    function actionsFormatter(value, row) {
        return '<nobr><a href="{{ url('/') }}/licenses/' + row.id + '/edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a> '
            + '<a data-html="false" class="btn delete-asset btn-danger btn-sm" ' +
            + 'data-toggle="modal" href="" data-content="Are you sure you wish to delete this?" '
            + 'data-title="{{  trans('general.delete') }}?" onClick="return false;">'
            + '<i class="fa fa-trash"></i></a></nobr>';

    }

</script>
@stop
