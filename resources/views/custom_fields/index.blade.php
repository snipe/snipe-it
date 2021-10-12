@extends('layouts/default', [
    'helpText' => trans('admin/custom_fields/general.about_fieldsets_text'),
    'helpPosition' => 'right',
])


{{-- Page title --}}
@section('title')
  Manage {{ trans('admin/custom_fields/general.custom_fields') }}
@parent
@stop

@section('content')

@can('view', \App\Models\CustomFieldset::class)
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">

      <div class="box-header with-border">
        <h2 class="box-title">{{ trans('admin/custom_fields/general.fieldsets') }}</h2>
        <div class="box-tools pull-right">
          @can('create', \App\Models\CustomFieldset::class)
          <a href="{{ route('fieldsets.create') }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Create a new fieldset">{{ trans('admin/custom_fields/general.create_fieldset') }}</a>
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
              <th>{{ trans('admin/custom_fields/general.used_by_models') }}</th>
              <th>Actions</th>
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
                @foreach($fieldset->models as $model)
                  <a href="{{ route('models.show', $model->id) }}" class="label label-default">{{ $model->name }}{{ ($model->model_number) ? ' ('.$model->model_number.')' : '' }}</a>

                @endforeach
              </td>
              <td>
                @can('delete', $fieldset)
                {{ Form::open(['route' => array('fieldsets.destroy', $fieldset->id), 'method' => 'delete']) }}
                  @if($fieldset->models->count() > 0)
                  <button type="submit" class="btn btn-danger btn-sm disabled" disabled><i class="fa fa-trash"></i></button>
                  @else
                  <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                  @endif
                {{ Form::close() }}
                @endcan
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
@endcan
@can('view', \App\Models\CustomField::class)
<div class="row">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="box-header with-border">
        <h2 class="box-title">{{ trans('admin/custom_fields/general.custom_fields') }}</h2>
        <div class="box-tools pull-right">
          @can('create', \App\Models\CustomField::class)
          <a href="{{ route('fields.create') }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Create a new custom field">{{ trans('admin/custom_fields/general.create_field') }}</a>
          @endcan
        </div>

      </div><!-- /.box-header -->
      <div class="box-body">

        <div class="table-responsive">
        <table
                data-cookie-id-table="customFieldsTable"
                data-id-table="customFieldsTable"
                data-search="true"
                data-side-pagination="server"
                data-show-columns="true"
                data-show-export="true"
                data-show-refresh="true"
                data-sort-order="asc"
                data-sort-name="name"
                id="customFieldsTable"
                class="table table-striped snipe-table"
                data-url="{{ route('api.customfields.index') }}"
                data-export-options='{
                "fileName": "export-fields-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
          <thead>
            <tr>
              <th data-visible="false"  data-field="id" data-sortable="true" data-searchable="true">{{ trans('general.id') }}</th>
              <th data-searchable="true" data-field="name">{{ trans('general.name') }}</th>
              <th data-searchable="true" data-field="help_text">Help Text</th>
              <th data-searchable="false" data-field="show_in_email" data-formatter="trueFalseFormatter">Email</th>
              <th data-visible="false" data-sortable="true" data-field="db_column_name">DB Field</th>
              <th data-sortable="false"  data-field="field_encrypted" data-formatter="trueFalseFormatter">Encrypted</th>
              <th data-searchable="false" data-field="format">{{ trans('admin/custom_fields/general.field_format') }}</th>
              <th data-searchable="false" data-field="element">{{ trans('admin/custom_fields/general.field_element_short') }}</th>
              <th data-searchable="false" data-field="fieldsets">{{ trans('admin/custom_fields/general.fieldsets') }}</th>
              <th data-sortable="false" data-formatter="fieldsActionsFormatter" data-field="actions" data-searchable="false">{{ trans('table.actions') }}</th>
            </tr>
          </thead>
        </table>
        </div>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div> <!-- /.col-md-9-->
</div>
@endcan

@stop
@section('moar_scripts')
  @include ('partials.bootstrap-table')
@stop
