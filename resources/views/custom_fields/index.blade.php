@extends('layouts/default', [
    'helpText' => trans('admin/custom_fields/general.about_fieldsets_text'),
    'helpPosition' => 'right',
])


{{-- Page title --}}
@section('title')
  {{ trans('admin/custom_fields/general.manage') }} {{ trans('admin/custom_fields/general.custom_fields') }}
@parent
@stop

@section('content')

@can('view', \App\Models\CustomFieldset::class)
<div class="row">
  <div calss="col-md-12">
    <div class="box box-default">
      <div class="box-body">

        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            {{-- TODO - generalize this so it's less 'hardcoded' --}}
            <li {!! !Request::query('tab') ? 'class="active"': '' !!}><a
                      href="{{ route("fields.index",["tab" => 0]) }}">Asset Custom Fields</a></li>
            <li {!! Request::query('tab') == 1 ? 'class="active"': '' !!}><a
                      href="{{ route("fields.index",["tab" => 1]) }}">Users</a></li>
            <li {!! Request::query('tab') == 2 ? 'class="active"': '' !!}><a
                      href="{{ route("fields.index",["tab" => 2]) }}">Accessories</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- Do not show fieldsets for Users' customf ields --}}
@if(Request::query('tab') != 1)

<div class="row">
  <div class="col-md-12">
    <div class="box box-default">

      <div class="box-header with-border">
        <h2 class="box-title">{{ trans('admin/custom_fields/general.fieldsets') }}</h2>
        <div class="box-tools pull-right">
          @can('create', \App\Models\CustomFieldset::class)
            <a href="{{ route('fieldsets.create',['tab' => Request::query('tab',0)]) }}" class="btn btn-sm btn-primary"
               data-tooltip="true"
               title="{{ trans('admin/custom_fields/general.create_fieldset_title') }}">{{ trans('admin/custom_fields/general.create_fieldset') }}</a>
          @endcan
        </div>
      </div><!-- /.box-header -->

      <div class="box-body">
        <table
                data-cookie-id-table="customFieldsetsTable"
                data-id-table="customFieldsetsTable"
                data-search="true"
                data-side-pagination="client"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="customFieldsTable"
                class="table table-striped snipe-table"
                data-export-options='{
                "fileName": "export-fieldsets-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
          <thead>
            <tr>
              <th>{{ trans('general.name') }}</th>
              <th>{{ trans('admin/custom_fields/general.qty_fields') }}</th>
              <th>{{ trans('admin/custom_fields/general.used_by_models') }}{{-- FIXME --}}</th>
              <th>{{ trans('table.actions') }}</th>
            </tr>
          </thead>

          @if(isset($custom_fieldsets))
          <tbody>
            @foreach($custom_fieldsets AS $fieldset)
            <tr>
              <td>
                {{ link_to_route("fieldsets.show",$fieldset->name,['fieldset' => $fieldset->id]) }}
              </td>
              <td>
                {{ $fieldset->fields->count() }}
              </td>
              <td>
                @foreach($fieldset->customizables() as $url => $name)
                  <a href="{{ $url }}" class="label label-default">{{ $name }}</a>
                  {{-- get_class($customizable) }}: {{ $customizable->name<br /> --}}
                @endforeach
              </td>
              <td>

                <nobr>

                @can('update', $fieldset)

                  <a href="{{ route('fieldsets.show', ['fieldset' => $fieldset->id]) }}" data-tooltip="true" title="{{ trans('general.edit_fieldset') }}">
                    <button type="submit" class="btn btn-info btn-sm">
                      <i class="fa-regular fa-rectangle-list"></i>
                    </button>
                  </a>

                  <a href="{{ route('fieldsets.edit', $fieldset->id) }}" class="btn btn-warning btn-sm" data-tooltip="true" title="{{ trans('general.update') }}">
                    <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                    <span class="sr-only">{{ trans('button.edit') }}</span>
                  </a>
                @endcan

                @can('delete', $fieldset)
                {{ Form::open(['route' => array('fieldsets.destroy', $fieldset->id), 'method' => 'delete','style' => 'display:inline-block']) }}
                    @if(count($fieldset->customizables()) > 0 /* TODO - hate 'customizables' */)
                      <button type="submit" class="btn btn-danger btn-sm disabled" data-tooltip="true"
                              title="{{ trans('general.cannot_be_deleted') }}" disabled><i class="fas fa-trash"></i>
                      </button>
                  @else
                      <button type="submit" class="btn btn-danger btn-sm" data-tooltip="true"
                              title="{{ trans('general.delete') }}"><i class="fas fa-trash"></i></button>
                  @endif
                {{ Form::close() }}
                @endcan
                  </nobr>
              </td>
            </tr>
            @endforeach
          </tbody>
          @endif
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box.box-default -->

  </div> <!-- .col-md-12-->


</div> <!-- .row-->
@endif
@endcan
@can('view', \App\Models\CustomField::class)
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <h2 class="box-title">{{ trans('admin/custom_fields/general.custom_fields') }}</h2>
        <div class="box-tools pull-right">
          @can('create', \App\Models\CustomField::class)
            <a href="{{ route('fields.create', ['tab' => Request::query('tab',0)]) }}" class="btn btn-sm btn-primary"
               data-tooltip="true"
               title="{{ trans('admin/custom_fields/general.create_field_title') }}">{{ trans('admin/custom_fields/general.create_field') }}</a>
          @endcan
        </div>

      </div><!-- /.box-header -->
      <div class="box-body">

        <table
                data-cookie-id-table="customFieldsTable"
                data-id-table="customFieldsTable"
                data-search="true"
                data-side-pagination="client"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="customFieldsTable"
                class="table table-striped snipe-table"
                data-export-options='{
                "fileName": "export-fields-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
          <thead>
            <tr>
              <th data-sortable="true" data-searchable="true">{{ trans('general.name') }}</th>
              <th data-sortable="true" data-searchable="true">{{ trans('admin/custom_fields/general.help_text')}}</th>
              <th data-sortable="true" data-searchable="true">{{ trans('admin/custom_fields/general.unique') }}</th>
              <th data-sortable="true" data-visible="false">{{ trans('admin/custom_fields/general.db_field') }}</th>
              <th data-sortable="true" data-searchable="true">{{ trans('admin/custom_fields/general.field_format') }}</th>
              <th data-sortable="true"><i class="fa fa-lock" aria-hidden="true"></i>
                <span class="hidden-xs hidden-sm hidden-md hidden-lg">{{ trans('admin/custom_fields/general.encrypted') }}</span>
              </th>
              <th data-sortable="true" class="text-center"><i class="fa fa-list" aria-hidden="true"></i>
                <span class="hidden-xs hidden-sm hidden-md hidden-lg">{{ trans('admin/custom_fields/general.show_in_listview_short') }}</span>
              </th>
              <th data-visible="false" data-sortable="true" class="text-center"><i class="fa fa-eye" aria-hidden="true"><span class="sr-only">Visible to User</span></i></th>
              <th data-sortable="true" data-searchable="true" class="text-center"><i class="fa fa-envelope" aria-hidden="true"><span class="sr-only">{{ trans('admin/custom_fields/general.show_in_email_short') }}</span></i></th>
              <th data-sortable="true" data-searchable="true" class="text-center"><i class="fa fa-laptop fa-fw" aria-hidden="true"><span class="sr-only">{{ trans('admin/custom_fields/general.show_in_requestable_list_short') }}</span></i></th>
              <th data-sortable="true" data-searchable="true" class="text-center"><i class="fa-solid fa-fingerprint"><span class="sr-only">{{ trans('admin/custom_fields/general.unique') }}</span></i></th>
              <th data-sortable="true" data-searchable="true" class="text-center">{{ trans('admin/custom_fields/general.field_element_short') }}</th>
              <th data-searchable="true">{{ trans('admin/custom_fields/general.fieldsets') }}</th>
              <th>{{ trans('button.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($custom_fields as $field)
            <tr>
              <td>{{ $field->name }}</td>
              <td>{{ $field->help_text }}</td>

              <td class="text-center">{!! ($field->is_unique=='1') ? '<i class="fas fa-check text-success" aria-hidden="true"><span class="sr-only">'.trans('general.yes').'</span></i>' : '<i class="fas fa-times text-danger" aria-hidden="true"><span class="sr-only">'.trans('general.no').'</span></i>'  !!}</td>
              <td>
                 <code>{{ $field->convertUnicodeDbSlug() }}</code>
                @if ($field->convertUnicodeDbSlug()!=$field->db_column)
                  <br><i class="fas fa-exclamation-triangle text-danger"></i>
                  {!! trans('admin/custom_fields/general.db_convert_warning',['db_column' => $field->db_column, 'expected' => $field->convertUnicodeDbSlug()]) !!}
                @endif
              </td>
              <td>{{ $field->format }}</td>
              <td class="text-center">{!!  ($field->field_encrypted=='1' ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>') !!}</td>
              <td class="text-center">{!!  ($field->show_in_listview=='1' ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>') !!}</td>
              <td class="text-center">{!!  ($field->display_in_user_view=='1' ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>') !!}</td>
              <td class="text-center">{!! ($field->show_in_email=='1') ? '<i class="fas fa-check text-success" aria-hidden="true"><span class="sr-only">'.trans('general.yes').'</span></i>' : '<i class="fas fa-times text-danger" aria-hidden="true"><span class="sr-only">'.trans('general.no').'</span></i>'  !!}</td>
              <td class="text-center">{!! ($field->show_in_requestable_list=='1') ? '<i class="fas fa-check text-success" aria-hidden="true"><span class="sr-only">'.trans('general.yes').'</span></i>' : '<i class="fas fa-times text-danger" aria-hidden="true"><span class="sr-only">'.trans('general.no').'</span></i>'  !!}</td>
              <td class="text-center">{!! ($field->is_unique=='1') ? '<i class="fas fa-check text-success" aria-hidden="true"><span class="sr-only">'.trans('general.yes').'</span></i>' : '<i class="fas fa-times text-danger" aria-hidden="true"><span class="sr-only">'.trans('general.no').'</span></i>'  !!}</td>
              <td>{{ $field->element }}</td>
              <td>
                @foreach($field->fieldset as $fieldset)
                  <a href="{{ route('fieldsets.show', $fieldset->id) }}" class="label label-default">{{ $fieldset->name }}</a>
                @endforeach
              </td>
              <td>
                <nobr>
                  {{ Form::open(array('route' => array('fields.destroy', $field->id), 'method' => 'delete', 'style' => 'display:inline-block')) }}
                  @can('update', $field)
                        <a href="{{ route('fields.edit', $field->id) }}?tab={{ array_search($field->type, Helper::$itemtypes_having_custom_fields) }}"
                           class="btn btn-warning btn-sm" data-tooltip="true" title="{{ trans('general.update') }}">
                      <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                      <span class="sr-only">{{ trans('button.edit') }}</span>
                    </a>
                @endcan

                @can('delete', $field)

                        @if($field->fieldset->count()>0 && Request::query('tab') != 1 )
                    <button type="submit" class="btn btn-danger btn-sm disabled" data-tooltip="true" title="{{ trans('general.cannot_be_deleted') }}" disabled>
                      <i class="fas fa-trash" aria-hidden="true"></i>
                      <span class="sr-only">{{ trans('button.delete') }}</span></button>
                  @else
                    <button type="submit" class="btn btn-danger btn-sm" data-tooltip="true" title="{{ trans('general.delete') }}">
                      <i class="fas fa-trash" aria-hidden="true"></i>
                      <span class="sr-only">{{ trans('button.delete') }}</span>
                    </button>
                  @endif

                @endcan
                  {{ Form::close() }}
                </nobr>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div> <!-- /.col-md-9-->
</div>
@endcan

@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop
