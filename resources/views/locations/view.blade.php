@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $location->name }}
 {{ trans('general.location') }}
@parent
@stop

@section('header_right')
<a href="{{ route('update/location', $location->id) }}" class="btn btn-sm btn-primary pull-right">{{ trans('admin/locations/table.update') }} </a>
@stop

{{-- Page content --}}
@section('content')

  <div class="row">
    <div class="col-md-12">
      <div class="box box-default">

        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table table-responsive">
                <table
                name="location_users"
                id="table-users"
                class="table table-striped"
                data-url="{{route('api.locations.viewusers', $location->id)}}"
                data-cookie="true"
                data-click-to-select="true"
                data-cookie-id-table="location_usersDetailTable">
                    <thead>
                        <tr>
                            <th data-searchable="false" data-sortable="false" data-field="name">{{ trans('general.user') }}</th>
                        </tr>
                    </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-default">

        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="table table-responsive">
                <table
                name="location_assets"
                id="table-assets"
                data-url="{{route('api.locations.viewassets', $location->id)}}"
                class="table table-striped"
                data-cookie="true"
                data-click-to-select="true"
                data-cookie-id-table="location_assetsDetailTable">
                    <thead>
                        <tr>
                            <th data-searchable="false" data-sortable="false" data-field="name">{{ trans('general.name') }}</th>
                            <th data-searchable="false" data-sortable="false" data-field="model">{{ trans('admin/hardware/form.model') }}</th>
                            <th data-searchable="false" data-sortable="false" data-field="asset_tag">{{ trans('admin/hardware/form.tag') }}</th>
                            <th data-searchable="false" data-sortable="false" data-field="serial">{{ trans('admin/hardware/form.serial') }}</th>
                        </tr>
                    </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
>





@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
    $('#table-users').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{ \App\Models\Setting::getSettings()->per_page }},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        mobileResponsive: true,
        showExport: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'txt','json', 'xml'],
        maintainSelected: true,
        paginationFirstText: "{{ trans('general.first') }}",
        paginationLastText: "{{ trans('general.last') }}",
        paginationPreText: "{{ trans('general.previous') }}",
        paginationNextText: "{{ trans('general.next') }}",
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
</script>

<script type="text/javascript">
    $('#table-assets').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{ \App\Models\Setting::getSettings()->per_page }},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        mobileResponsive: true,
        showExport: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'txt','json', 'xml'],
        maintainSelected: true,
        paginationFirstText: "{{ trans('general.first') }}",
        paginationLastText: "{{ trans('general.last') }}",
        paginationPreText: "{{ trans('general.previous') }}",
        paginationNextText: "{{ trans('general.next') }}",
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
</script>


@stop

@stop
