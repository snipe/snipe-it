@extends('layouts/default')

{{-- Web site Title --}}
@section('title')
{{ trans('admin/groups/titles.group_management') }}
@parent
@stop

@section('header_right')
<a href="{{ route('groups.create') }}" class="btn btn-primary pull-right" style="margin-left: 10px;"> {{ trans('general.create') }}</a>
<a href="{{ route('settings.index') }}" class="btn btn-default pull-right">{{ trans('general.back') }}</a>
@stop


{{-- Content --}}
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">
          <table
          name="groups"
          class="table table-striped snipe-table"
          id="table"
          data-toggle="table"
          data-url="{{ route('api.groups.index') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="userGroupDisplay-{{ config('version.hash_version') }}">
            <thead>
              <tr>
               <th data-switchable="true" data-sortable="false" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
               <th data-switchable="true" data-sortable="true" data-field="name" data-formatter="groupsAdminLinkFormatter" data-visible="true">{{ trans('admin/groups/table.name') }}</th>
               <th data-switchable="true" data-sortable="false" data-field="users_count" data-visible="true">{{ trans('admin/groups/table.users') }}</th>
               <th data-switchable="true" data-sortable="true" data-field="created_at" data-visible="true" data-formatter="dateDisplayFormatter">{{ trans('general.created_at') }}</th>
               <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions"   data-formatter="groupsActionsFormatter">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div>
      </div> <!--.box-body-->
    </div> <!-- /.box.box-default-->
  </div> <!-- .col-md-12-->
</div>
@stop
@section('moar_scripts')
@include ('partials.bootstrap-table', ['exportFile' => 'groups-export', 'search' => true])
@stop
