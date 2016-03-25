@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $consumable->name }}
 {{ trans('general.consumable') }}
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">

        @if ($consumable->id)
          <div class="box-header with-border">
            <div class="box-heading">
              <h3 class="box-title"> {{ $consumable->name }}</h3>
            </div>
          </div><!-- /.box-header -->
        @endif

      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table table-responsive">

            <table
            name="consumable_users"
            class="table table-striped"
            id="table"
            data-url="{{route('api.consumables.view', $consumable->id)}}"
            data-cookie="true"
            data-click-to-select="true"
            data-cookie-id-table="consumableDetailTable-{{ config('version.hash_version') }}">
              <thead>
                  <tr>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="name">{{Lang::get('general.user')}}</th>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="created_at">{{Lang::get('general.date')}}</th>
                    <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="admin">{{Lang::get('general.admin')}}</th>
                  </tr>
              </thead>
            </table>
          </div>

          </div>
        </div>
      </div>
  </div>
  <div class="col-md-3">
    @if ($consumable->purchase_date)
        <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/consumables/general.date') }}: </strong>
        {{ $consumable->purchase_date }} </div>
    @endif

    @if ($consumable->purchase_cost)
        <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/consumables/general.cost') }}:</strong>
        {{ \App\Models\Setting::first()->default_currency }}

        {{ number_format($consumable->purchase_cost,2) }} </div>
    @endif

    @if ($consumable->order_number)
        <div class="col-md-12" style="padding-bottom: 5px;"><strong>{{ trans('admin/consumables/general.order') }}:</strong>
        {{ $consumable->order_number }} </div>
    @endif
  </div>
</div>




<!-- side address column -->
<div class="col-md-3">
    <h4>{{ trans('admin/consumables/general.about_consumables_title') }}</h4>
    <p>{{ trans('admin/consumables/general.about_consumables_text') }} </p>

</div>

@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: false,
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
