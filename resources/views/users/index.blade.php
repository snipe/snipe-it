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
      <a href="{{ route('ldap/user') }}" class="btn btn-default pull-right"><span class="fa fa-sitemap"></span> LDAP Sync</a>
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
                'id' => 'bulkForm']) }}

            @if (Input::get('status')!='deleted')
              @can('delete', \App\Models\User::class)
                <div id="toolbar">
                  <select name="bulk_actions" class="form-control select2" style="width: 200px;">
                    <option value="delete">Bulk Checkin &amp; Delete</option>
                    <option value="edit">Bulk Edit</option>
                  </select>
                  <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
                </div>
              @endcan
            @endif

             <table
              name="users"
              data-toolbar="#toolbar"
              data-toggle="table"
              class="table table-striped snipe-table"
              id="table"
              data-url="{{ route('api.users.index',
              array('deleted'=> (Input::get('status')=='deleted') ? 'true' : 'false','company_id'=>e(Input::get('company_id')))) }}"
              data-cookie="true"
              data-click-to-select="true"
              data-cookie-id-table="userTableDisplay-{{ config('version.hash_version') }}">

             </table>

          {{ Form::close() }}
        </div><!-- /.box-body -->
      </div><!-- /.box -->
  </div>
</div>

@stop

@section('moar_scripts')
@include ('partials.bootstrap-table',
    ['exportFile' => 'users-export',
    'search' => true,
    'columns' => \App\Presenters\UserPresenter::dataTableLayout()
])


@stop
