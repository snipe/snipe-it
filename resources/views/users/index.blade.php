@extends('layouts/default')

{{-- Page title --}}
@section('title')

@if (Input::get('status')=='deleted')
    {{ trans('general.deleted') }}
@else
    {{ trans('general.current') }}
@endif
 {{ trans('general.users') }}

@parent
@stop

@section('header_right')
    @can('create', \App\Models\User::class)
      @if ($snipeSettings->ldap_enabled == 1)
      <a href="{{ route('ldap/user') }}" class="btn btn-default pull-right"><span class="fa fa-upload"></span> LDAP</a>
      @endif
      <a href="{{ route('import/user') }}" class="btn btn-default pull-right" style="margin-right: 5px;"><span class="fa fa-upload"></span> {{ trans('general.import') }}</a>
      <a href="{{ route('users.create') }}" class="btn btn-primary pull-right" style="margin-right: 5px;">  {{ trans('general.create') }}</a>
    @endcan

    @if (Input::get('status')=='deleted')
      <a class="btn btn-default pull-right" href="{{ route('users.index') }}" style="margin-right: 5px;">{{ trans('admin/users/table.show_current') }}</a>
    @else
      <a class="btn btn-default pull-right" href="{{ route('users.index', ['status' => 'deleted']) }}" style="margin-right: 5px;">{{ trans('admin/users/table.show_deleted') }}</a>
    @endif
    @can('view', \App\Models\User::class)
        <a class="btn btn-default pull-right" href="{{ route('users.export') }}" style="margin-right: 5px;">Export</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
        <div class="box-body">
          {{ Form::open([
               'method' => 'POST',
               'route' => ['users/bulkedit'],
               'class' => 'form-inline',
                'id' => 'bulkEditForm']) }}

            @if (Input::get('status')!='deleted')
              @can('delete', \App\Models\User::class)
                <div id="toolbar">
                  <select name="bulk_actions" class="form-control select2" style="width: 200px;">
                    <option value="delete">Bulk Checkin &amp; Delete</option>
                  </select>
                  <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
                </div>
              @endcan
            @endif

             <table
              name="users"
              data-toolbar="#toolbar"
              class="table table-striped snipe-table"
              id="table"
              data-maintain-selected="true"
              data-toggle="table"
              data-url="{{ route('api.users.index', array(''=>e(Input::get('status')))) }}"
              data-cookie="true"
              data-click-to-select="true"
              data-cookie-id-table="userTableDisplay-{{ config('version.hash_version') }}">
               <thead>
                 <tr>
                     @if (Input::get('status')!='deleted')
                        <th data-checkbox="true" data-field="checkbox"></th>
                     @endif
                   <th data-switchable="true" data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                   <th data-switchable="true" data-sortable="false" data-field="companyName" data-visible="false">{{ trans('admin/companies/table.title') }}</th>
                   <th data-switchable="true" data-sortable="true" data-field="employee_num" data-visible="false">{{ trans('admin/users/table.employee_num') }}</th>
                   <th data-sortable="true" data-field="name" data-formatter="userFormatter">{{ trans('admin/users/table.name') }}</th>
                   <th data-switchable="true" data-sortable="true" data-field="jobtitle" data-visible="false">{{ trans('admin/users/table.title') }}</th>
                   <th data-sortable="true" data-field="email" data-formatter="emailFormatter">
                       <span class="hidden-md hidden-lg">{{ trans('admin/users/table.email') }}</span>
                       <span class="hidden-xs"><i class="fa fa-envelope fa-lg"></i></span>
                   </th>
                   <th data-sortable="true" data-field="username">{{ trans('admin/users/table.username') }}</th>
                   <th data-searchable="true" data-sortable="true" data-field="manager">{{ trans('admin/users/table.manager') }}</th>
                   <th data-sortable="true" data-field="location" data-formatter="locationFormatter">{{ trans('admin/users/table.location') }}</th>
                   <th data-sortable="false" data-field="assets">
                       <span class="hidden-md hidden-lg">Assets</span>
                       <span class="hidden-xs"><i class="fa fa-barcode fa-lg"></i></span>
                   </th>
                   <th data-sortable="false" data-field="licenses">
                       <span class="hidden-md hidden-lg">Licenses</span>
                       <span class="hidden-xs"><i class="fa fa-floppy-o fa-lg"></i></span>
                   </th>
                   <th data-sortable="false" data-field="accessories">
                       <span class="hidden-md hidden-lg">Accessories</span>
                       <span class="hidden-xs"><i class="fa fa-keyboard-o fa-lg"></i></span>
                   </th>
                   <th data-sortable="false" data-field="consumables">
                       <span class="hidden-md hidden-lg">Consumables</span>
                       <span class="hidden-xs"><i class="fa fa-tint fa-lg"></i></span>
                   </th>
                   <th data-sortable="false" data-field="groups">{{ trans('general.groups') }}</th>
                   <th data-sortable="true" data-field="notes">{{ trans('general.notes') }}</th>
                   <th data-sortable="true" data-field="two_factor_enrolled" data-visible="false" data-formatter="trueFalseFormatter" >{{ trans('admin/users/general.two_factor_enrolled') }}</th>
                   <th data-sortable="true" data-field="two_factor_optin" data-formatter="trueFalseFormatter" data-visible="false">{{ trans('admin/users/general.two_factor_active') }}</th>

                   <th data-sortable="true" data-field="activated" data-formatter="trueFalseFormatter">{{ trans('general.activated') }}</th>
                   <th data-sortable="true" data-field="created_at" data-searchable="true" data-visible="false" data-formatter="createdAtFormatter">{{ trans('general.created_at') }}</th>
                   <th data-switchable="false" data-searchable="false" data-sortable="false" data-formatter="actionsFormatter" data-field="actions" >{{ trans('table.actions') }}</th>
                 </tr>
               </thead>
             </table>

          {{ Form::close() }}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
  </div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'users-export', 'search' => true])

<script>

    var checkedRows = 0;

    $('.snipe-table').on('check.bs.table', function (e, row) {
        $(this).val(row.id);
        checkedRows++;
        $('#bulkEdit').removeAttr('disabled');
        atLeastOneChecked(checkedRows);
    });

    $('.snipe-table').on('uncheck.bs.table', function (e, row) {
        checkedRows--;
        atLeastOneChecked(checkedRows);

    });

    function atLeastOneChecked(checkedRows) {
        if (checkedRows > 0) {
            $('#bulkEdit').removeAttr('disabled');
        }
        else {
            $('#bulkEdit').attr('disabled', 'disabled');
        }
    }



    function locationFormatter(value, row) {
        if ((value) && (value[0].name)) {
            return '<a href="{{ url('/') }}/locations/' + value[0].id + '"> ' + value[0].name + '</a>';
        }
    }

    function emailFormatter(value, row) {
        if (value) {
            return '<a href="mailto:' + value + '"> ' + value + '</a>';
        }
    }

    function userFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/users/' + row.id + '"> ' + value + '</a>';
        }
    }

    function companyFormatter(value, row) {
        if ((value) && (value[0].name)) {
            return '<a href="{{ url('/') }}/companies/' + value[0].id + '"> ' + value[0].name + '</a>';
        }
    }

    function createdAtFormatter(value, row) {
        if ((value) && (value.date)) {
            return value.date;
        }
    }

    function trueFalseFormatter(value, row) {
        if ((value) && ((value == 'true') || (value == '1'))) {
            return '<i class="fa fa-check"></i>';
        } else {
            return '<i class="fa fa-times"></i>';
        }
    }

    function actionsFormatter(value, row) {
        return '<nobr><a href="{{ url('/') }}/users/' + row.id + '/edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a> '
            + '<a data-html="false" class="btn delete-asset btn-danger btn-sm" ' +
            + 'data-toggle="modal" href="" data-content="Are you sure you wish to delete this?" '
            + 'data-title="{{  trans('general.delete') }}?" onClick="return false;">'
            + '<i class="fa fa-trash"></i></a></nobr>';

    }

    $(function () {
        $('#bulkEdit').click(function () {
            var selectedIds = $('.snipe-table').bootstrapTable('getSelections');

            $.each(selectedIds, function(key,value) {
                $( "#bulkEditForm" ).append($('<input type="hidden" name="edit_user[' + value.id + ']" value="' + value.id + '">' ));
                //alert(value.id);
            });

            //event.preventDefault();
            //return false;
        });
    });



</script>
@stop
