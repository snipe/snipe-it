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

<style>
    /**
    This is kind of weird, but it is necessary to prevent the column-selector code from barfing, since
    any HTML used in the UserPresenter "title" attribute breaks the column selector HTML.

    Instead, we use CSS to add the icon into the table header, which leaves the column selector
    "title" text as-is.

    See https://github.com/snipe/snipe-it/issues/7989

     */
    th.css-barcode > .th-inner,
    th.css-license > .th-inner,
    th.css-consumable > .th-inner,
    th.css-accessory > .th-inner
    {
        font-size: 0px;
        line-height: 4!important;
        text-align: left;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }


    th.css-barcode > .th-inner::before,
    th.css-license > .th-inner::before,
    th.css-consumable > .th-inner::before,
    th.css-accessory > .th-inner::before

    {
        display: inline-block;
        font: normal normal normal 14px/1 FontAwesome;
        font-size: 20px;
    }


    th.css-barcode > .th-inner::before
    {
        content: "\f02a";
    }

    th.css-license > .th-inner::before
    {
        content: "\f0c7";
    }

    th.css-consumable > .th-inner::before
    {
        content: "\f043";
    }

    th.css-accessory > .th-inner::before
    {
        content: "\f11c";
    }


</style>

    @can('create', \App\Models\User::class)
      @if ($snipeSettings->ldap_enabled == 1)
      <a href="{{ route('ldap/user') }}" class="btn btn-default pull-right"><span class="fa fa-sitemap"></span> LDAP Sync</a>
      @endif
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
                    <label for="bulk_actions" class="sr-only">Bulk Actions</label>
                  <select name="bulk_actions" class="form-control select2" style="width: 200px;" aria-label="bulk_actions">
                    <option value="delete">Bulk Checkin &amp; Delete</option>
                    <option value="edit">Bulk Edit</option>
                  </select>
                  <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
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
              array('deleted'=> (Input::get('status')=='deleted') ? 'true' : 'false','company_id'=>e(Input::get('company_id')))) }}"
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
