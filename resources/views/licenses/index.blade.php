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
@can('delete', \App\Models\License::class)
    <a href="#"   class="btn btn-danger pull-right" style="color:#FFFFFF;" data-toggle="modal" data-target="#checkInAllLicenses">{{ trans('admin/licenses/form.checkinall') }}</a>
@endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div class="box-body">

          <table
              data-columns="{{ \App\Presenters\LicensePresenter::dataTableLayout() }}"
              data-cookie-id-table="licensesTable"
              data-pagination="true"
              data-search="true"
              data-side-pagination="server"
              data-show-columns="true"
              data-show-export="true"
              data-show-footer="true"
              data-show-refresh="true"
              data-sort-order="asc"
              data-sort-name="name"
              id="licensesTable"
              class="table table-striped snipe-table"
              data-url="{{ route('api.licenses.index') }}"
              data-export-options='{
            "fileName": "export-licenses-{{ date('Y-m-d') }}",
            "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
            }'>
          </table>

      </div><!-- /.box-body -->

      <div class="box-footer clearfix">
      </div>
    </div><!-- /.box -->
  </div>
</div>

<!-- Check-in all licenses Modal -->
<div class="modal fade" id="checkInAllLicenses" tabindex="-1" role="dialog" aria-labelledby="checkInAllLicenses" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br>
                <h3 class="modal-title" id="checkInAllLicense">Check-in All Seats for All Licenses</h3>
            </div>
            <div class="modal-body">
                <h4>Warning: this checks in all seats for all licenses? Do you wish to continue?</h4>
                <br><br>
                <div class="form-group">
                </div>
                <div class="modal-footer">
                    <form action="{{route('/checkin-all-licenses')}}" method="POST">
                        {{csrf_field()}}
                        <button type="submit" style="width:100%;" class="btn btn-danger">{{trans('admin/licenses/form.checkinall')}}</button>
                    </form>
                    <button type="button" style="width:100%;" class="btn btn-primary" data-dismiss="modal">{{trans('button.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</div><!--end of Modal -->
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')

@stop
