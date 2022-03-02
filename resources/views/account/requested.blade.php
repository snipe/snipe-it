@extends('layouts/default')

{{-- Page title --}}
@section('title')
   {{ trans('general.requested_assets')}}
@stop

{{-- Account page content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="box box-default">
                <div class="box-body">

                    <table
                            data-cookie-id-table="userRequests"
                            data-pagination="true"
                            data-id-table="userRequests"
                            data-side-pagination="server"
                            data-show-columns="true"
                            data-show-export="true"
                            data-show-refresh="true"
                            data-sort-order="desc"
                            id="userRequests"
                            class="table table-striped snipe-table"
                            data-url="{{ route('api.assets.requested') }}"
                            data-export-options='{
                  "fileName": "my-requested-assets-{{ date('Y-m-d') }}",
                  "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                        <thead>
                        <tr>
                            <th class="col-md-1" data-field="image" data-formatter="imageFormatter">{{ trans('general.image') }}</th>
                            <th class="col-md-2" data-field="name">{{ trans('general.item_name') }}</th>
                            <th class="col-md-2" data-field="type">{{ trans('general.type') }}</th>
                            <th class="col-md-2" data-field="qty">{{ trans('general.qty') }}</th>
                            <th class="col-md-2" data-field="location">{{ trans('admin/hardware/table.location') }}</th>
                            <th class="col-md-2" data-field="expected_checkin" data-formatter="dateDisplayFormatter"> {{ trans('admin/hardware/form.expected_checkin') }}</th>
                            <th class="col-md-2" data-field="request_date" data-formatter="dateDisplayFormatter"> {{ trans('general.requested_date') }}</th>
                        </tr>
                        </thead>
                    </table>

                </div> <!-- .box-body -->
            </div> <!-- .box-default -->
        </div> <!-- .col-md-9 -->
    </div> <!-- .row-->

@stop
@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop
