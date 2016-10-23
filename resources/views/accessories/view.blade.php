@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $accessory->name }}
 {{ trans('general.accessory') }}
@parent
@stop

{{-- Right header --}}
@section('header_right')
    @can('accessories.manage')
        <div class="dropdown pull-right">
          <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
              <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
                @if ($accessory->assigned_to != '')
                  @can('accessories.checkin')
                  <li role="presentation"><a href="{{ route('checkin/accessory', $accessory->id) }}">{{ trans('admin/accessories/general.checkin') }}</a></li>
                  @endcan
                @else
                  @can('accessories.checkout')
                  <li role="presentation"><a href="{{ route('checkout/accessory', $accessory->id)  }}">{{ trans('admin/accessories/general.checkout') }}</a></li>
                  @endcan
                @endif
                    @can('accessories.edit')
                <li role="presentation"><a href="{{ route('update/accessory', $accessory->id) }}">{{ trans('admin/accessories/general.edit') }}</a></li>
                        @endcan

          </ul>
        </div>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-9">

    <div class="box box-default">
       <div class="box-body">
         <div class="table table-responsive">
         <table
         name="accessory_users"
         class="table table-striped"
         id="table"
         data-url="{{ route('api.accessories.view', $accessory->id) }}"
         data-cookie="true"
         data-click-to-select="true"
         data-cookie-id-table="accessoryUsersTable">

               <thead>
                   <tr>
                       <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="name">{{ trans('general.user') }}</th>
                       <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
                   </tr>
               </thead>
           </table>
         </div>
      </div>
    </div>
  </div>


<!-- side address column -->
<div class="col-md-3">

    <h4>{{ trans('admin/accessories/general.about_accessories_title') }}</h4>
    <p>{{ trans('admin/accessories/general.about_accessories_text') }} </p>
    <div class="text-center">
        @can('accessories.checkout')
        <a href="{{ route('checkout/accessory', $accessory->id) }}" style="margin-right:5px;" class="btn btn-info btn-sm" {{ (($accessory->numRemaining() > 0 ) ? '' : ' disabled') }}>{{ trans('general.checkout') }}</a>
        @endcan
    </div>

</div>
</div>

@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js?v=1') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js?v=1') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
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
        columnsHidden: ['name'],
        showExport: true,
        exportLabel: 'Export',
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
