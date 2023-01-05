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
        <a href="{{ route('users.create') }}" accesskey="n" class="btn btn-primary pull-right" style="margin-right: 5px;">  {{ trans('general.create') }}</a>
    @endcan
    <!-- Split button -->
    <div class="btn-group">
        <button type="button" class="btn btn-danger">Action</button>
        <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu">
            <li>@if (request('status')=='deleted')
                    <a class="btn btn-default" style="width:100%;" href="{{ route('users.index') }}" style="margin-right: 5px;">{{ trans('admin/users/table.show_current') }}</a>
                @else
                    <a class="btn btn-default" style="width:100%;" href="{{ route('users.index', ['status' => 'deleted']) }}" style="margin-right: 5px;">{{ trans('admin/users/table.show_deleted') }}</a>
                @endif</li>
            <li>@can('superuser')
                    <form  action="{{ route('users/bulkemailEveryone')}}" method="POST">
                        {{ csrf_field() }}
                        <a href="#" class="btn btn-default" style="width:100%;">{{ trans('admin/users/general.email_everyone_assigned') }}</a>
                    </form>
                @endcan</li>
            <li>@can('view', \App\Models\User::class)
                    <a class="btn btn-default" style="width:100%;" href="{{ route('users.export') }}" style="margin-right: 5px;">{{ trans('general.export') }}</a>
                @endcan
            </li>
        </ul>
    </div>




@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
        <div class="box-body">

            @include('partials.users-bulk-actions')

            <table
                    data-click-to-select="true"
                    data-columns="{{ \App\Presenters\UserPresenter::dataTableLayout() }}"
                    data-cookie-id-table="usersTable"
                    data-pagination="true"
                    data-id-table="usersTable"
                    data-search="true"
                    data-side-pagination="server"
                    data-show-columns="true"
                    data-show-fullscreen="true"
                    data-show-export="true"
                    data-show-refresh="true"
                    data-sort-order="asc"
                    data-toolbar="#userBulkEditToolbar"
                    data-bulk-button-id="#bulkUserEditButton"
                    data-bulk-form-id="#usersBulkForm"
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