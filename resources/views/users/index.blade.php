@extends('layouts/default')
{{-- Page title --}}
@section('title')

    @if (request('status')=='deleted')
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
            <a href="{{ route('ldap/user') }}" class="btn btn-default pull-right"><span class="fas fa-sitemap"></span>{{trans('general.ldap_sync')}}</a>
        @endif
        <a href="{{ route('users.create') }}" class="btn btn-primary pull-right" style="margin-right: 5px;">  {{ trans('general.create') }}</a>
    @endcan

    @if (request('status')=='deleted')
        <a class="btn btn-default pull-right" href="{{ route('users.index') }}" style="margin-right: 5px;">{{ trans('admin/users/table.show_current') }}</a>
    @else
        <a class="btn btn-default pull-right" href="{{ route('users.index', ['status' => 'deleted']) }}" style="margin-right: 5px;">{{ trans('admin/users/table.show_deleted') }}</a>
    @endif
    @can('view', \App\Models\User::class)
        <a class="btn btn-default pull-right" href="{{ route('users.export') }}" style="margin-right: 5px;">{{ trans('general.export') }}</a>
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
                'id' => 'bulkForm']) }}

            @if (request('status')!='deleted')
              @can('delete', \App\Models\User::class)
                <div id="toolbar">
                    <label for="bulk_actions" class="sr-only">{{ trans('general.bulk_actions') }}</label>
                  <select name="bulk_actions" class="form-control select2" style="width: 200px;" aria-label="bulk_actions">
                    <option value="delete">{!! trans('general.bulk_checkin_delete') !!}</option>
                    <option value="edit">{{ trans('general.bulk_edit') }}</option>
                    <option value="bulkpasswordreset">{{ trans('button.send_password_link') }}</option>
                  </select>
                  <button class="btn btn-default" id="bulkEdit" disabled>{{ trans('button.go') }}</button>
                </div>
              @endcan
            @endif


            <table
                    data-click-to-select="true"
                    data-columns="{{ \App\Presenters\UserPresenter::dataTableLayout() }}"
                    data-cookie-id-table="usersTable"
                    data-pagination="true"
                    data-id-table="usersTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-toolbar="#toolbar"
                    id="usersTable"
                    class="table table-striped snipe-table"
                    data-url="{{ route('api.users.index',
              array('deleted'=> (request('status')=='deleted') ? 'true' : 'false','company_id' => e(request('company_id')))) }}"
                    data-export-options='{
                "fileName": "export-users-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                    </table>


                    {{ Form::close() }}
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

@stop

@section('moar_scripts')


@include ('partials.bootstrap-table')


@stop