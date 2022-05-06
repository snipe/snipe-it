@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/models/table.view') }}
{{ $model->model_tag }}
@parent
@stop

@section('header_right')
  @can('superuser')
  <div class="btn-group pull-right">
     <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
          <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
          @if ($model->deleted_at=='')
            <li><a href="{{ route('models.edit', $model->id) }}">{{ trans('admin/models/table.edit') }}</a></li>
            <li><a href="{{ route('clone/model', $model->id) }}">{{ trans('admin/models/table.clone') }}</a></li>
            <li><a href="{{ route('hardware.create', ['model_id' => $model->id]) }}">{{ trans('admin/hardware/form.create') }}</a></li>
          @else
            <li><a href="{{ route('restore/model', $model->id) }}">{{ trans('admin/models/general.restore') }}</a></li>
          @endif
      </ul>
  </div>
  @endcan
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      @if ($model->id)
        <div class="box-header with-border">
          <div class="box-heading">
            <h2 class="box-title"> {{ $model->name }}
                {{ ($model->model_number) ? '(#'.$model->model_number.')' : '' }}
            </h2>
          </div>
        </div><!-- /.box-header -->
      @endif
      <div class="box-body">

          @include('partials.asset-bulk-actions')




                  <table
                  data-columns="{{ \App\Presenters\AssetPresenter::dataTableLayout() }}"
                  data-cookie-id-table="assetListingTable"
                  data-pagination="true"
                  data-id-table="assetListingTable"
                  data-search="true"
                  data-side-pagination="server"
                  data-show-columns="true"
                  data-toolbar="#toolbar"
                  data-show-export="true"
                  data-show-refresh="true"
                  data-sort-order="asc"
                  id="assetListingTable"
                  data-url="{{ route('api.assets.index',['model_id'=> $model->id]) }}"
                  class="table table-striped snipe-table"
                  data-export-options='{
                "fileName": "export-models-{{ str_slug($model->name) }}-assets-{{ date('Y-m-d') }}",
                "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                }'>
                </table>
                  {{ Form::close() }}

      </div> <!-- /.box-body-->
    </div> <!-- /.box-default-->
  </div> <!-- /.col-md-9-->

  <!-- side address column -->
  <div class="col-md-3">
      <div class="box box-default">
              <div class="box-header with-border">
                  <div class="box-heading">
                      <h2 class="box-title"> {{ trans('general.moreinfo') }}:</h2>
                  </div>
              </div><!-- /.box-header -->
          <div class="box-body">

              @if ($model->image)
                  <img src="{{ Storage::disk('public')->url(app('models_upload_path').e($model->image)) }}" class="img-responsive"></li>
              @endif


            <ul class="list-unstyled" style="line-height: 25px;">
              @if ($model->manufacturer)
              <li>
                {{ trans('general.manufacturer') }}:
              @can('view', \App\Models\Manufacturer::class)
                  <a href="{{ route('manufacturers.show', $model->manufacturer->id) }}">
                      {{ $model->manufacturer->name }}
                  </a>
              @else
                  {{ $model->manufacturer->name }}
              @endcan
              </li>

                  @if ($model->manufacturer->url)
                      <li>
                          <i class="fas fa-globe-americas"></i> <a href="{{ $model->manufacturer->url }}">{{ $model->manufacturer->url }}</a>
                      </li>
                  @endif

                  @if ($model->manufacturer->support_url)
                      <li>
                          <i class="far fa-life-ring"></i> <a href="{{ $model->manufacturer->support_url }}">{{ $model->manufacturer->support_url }}</a>
                      </li>
                  @endif

                  @if ($model->manufacturer->support_phone)
                      <li>
                          <i class="fas fa-phone"></i>
                          <a href="tel:{{ $model->manufacturer->support_phone }}">{{ $model->manufacturer->support_phone }}</a>

                      </li>
                  @endif

                  @if ($model->manufacturer->support_email)
                      <li>
                          <i class="far fa-envelope"></i> <a href="mailto:{{ $model->manufacturer->support_email }}">{{ $model->manufacturer->support_email }}</a>
                      </li>
                  @endif
                @endif
              @if ($model->model_number)
              <li>
                {{ trans('general.model_no') }}:
                {{ $model->model_number }}
              </li>
              @endif

              @if ($model->depreciation)
              <li>
                {{ trans('general.depreciation') }}:
                {{ $model->depreciation->name }} ({{ $model->depreciation->months.' '.trans('general.months')}})
              </li>
              @endif

              @if ($model->eol)
              <li>{{ trans('general.eol') }}:
                {{ $model->eol .' '. trans('general.months') }}
              </li>
              @endif

              @if ($model->fieldset)
              <li>{{ trans('admin/models/general.fieldset') }}:
                <a href="{{ route('fieldsets.show', $model->fieldset->id) }}">{{ $model->fieldset->name }}</a>
              </li>
              @endif

              @if ($model->notes)
                  <li>
                      {{ trans('general.notes') }}:
                      {{ $model->notes }}
                  </li>
              @endif



              @if  ($model->deleted_at!='')
               <li><br /><a href="{{ route('restore/model', $model->id) }}" class="btn-flat large info ">{{ trans('admin/models/general.restore') }}</a></li>
              @endif
            </ul>

            @if ($model->note)
            Notes:
            <p>
              {!! $model->present()->note() !!}
            </p>
            @endif
          </div>
      </div>
  </div>
  </div>
</div>
@stop

@section('moar_scripts')
@include ('partials.bootstrap-table')
@stop
