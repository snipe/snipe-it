@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($category->id)
        {{ trans('admin/categories/general.update') }}
    @else
        {{ trans('admin/categories/general.create') }}
    @endif
@parent
@stop


@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">

    <div class="box box-default">
      <div class="box-header with-border">
        @if ($category->id)
          <div class="panel-heading">
            <h3 class="box-title"> {{ $category->name }}</h3>
          </div>
        @endif

      </div><!-- /.box-header -->
      <div class="box-body">
        <form class="form-horizontal" method="post" action="" autocomplete="off">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <!-- Name -->
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
          <div class="col-md-3">
            {{ Form::label('name', trans('admin/categories/general.category_name')) }}

          </div>
            <div class="col-md-8 required">
                <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $category->name) }}" />
                {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
        </div>

      <!-- Type -->
      <div class="form-group {{ $errors->has('category_type') ? ' has-error' : '' }}">
        <div class="col-md-3">
          {{ Form::label('category_type', trans('general.type')) }}
        </div>
          <div class="col-md-7 required">
              {{ Form::select('category_type', $category_types , Input::old('category_type', $category->category_type), array('class'=>'select2', 'style'=>'min-width:350px', $category->itemCount() > 0 ? 'disabled' : '')) }}
              {!! $errors->first('category_type', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
      </div>

      <!-- EULA text -->
      <div class="form-group {{ $errors->has('eula_text') ? 'error' : '' }}">
        <div class="col-md-3">
          {{ Form::label('eula_text', trans('admin/categories/general.eula_text')) }}
        </div>
        <div class="col-md-8">
        {{ Form::textarea('eula_text', Input::old('eula_text', $category->eula_text), array('class' => 'form-control')) }}
        <p class="help-block">{!! trans('admin/categories/general.eula_text_help') !!} </p>
        <p class="help-block">{!! trans('admin/settings/general.eula_markdown') !!} </p>

        {!! $errors->first('eula_text', '<span class="alert-msg">:message</span>') !!}
              </div>
          </div>

             <!-- Use default checkbox -->
          <div class="checkbox col-md-offset-3">
      <label>

      @if (\App\Models\Setting::getSettings()->default_eula_text!='')
        {{ Form::checkbox('use_default_eula', '1', Input::old('use_default_eula', $category->use_default_eula)) }}
        {!! trans('admin/categories/general.use_default_eula') !!}
                 @else
                  {{ Form::checkbox('use_default_eula', '0', Input::old('use_default_eula'), array('disabled' => 'disabled')) }}
                  {!! trans('admin/categories/general.use_default_eula_disabled') !!}
                 @endif

      </label>
      </div>

      <!-- Require Acceptance -->
      <div class="checkbox col-md-offset-3">
      <label>
      {{ Form::checkbox('require_acceptance', '1', Input::old('require_acceptance', $category->require_acceptance)) }}
      {{ trans('admin/categories/general.require_acceptance') }}
      </label>
      </div>

      <!-- Email on Checkin -->
      <div class="checkbox col-md-offset-3">
          <label>
              {{ Form::checkbox('checkin_email', '1', Input::old('checkin_email', $category->checkin_email)) }}
              {{ trans('admin/categories/general.checkin_email') }}
          </label>
      </div>


      </div><!-- /.box-body -->
      <div class="box-footer text-right">
        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div>

    </div><!-- /.box -->

  </div>



    <!-- side address column -->
    <div class="col-md-3">
        <h4>{{ trans('admin/categories/general.about_asset_categories') }}</h4>
        <p>{{ trans('admin/categories/general.about_categories') }} </p>

    </div>
  </div>
</div>

@if (\App\Models\Setting::getSettings()->default_eula_text!='')
<!-- Modal -->
<div class="modal fade" id="eulaModal" tabindex="-1" role="dialog" aria-labelledby="eulaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="eulaModalLabel">{{ trans('admin/settings/general.default_eula_text') }}</h4>
      </div>
      <div class="modal-body">
        {{ \App\Models\Setting::getDefaultEula() }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
      </div>
    </div>
  </div>
</div>
@endif

@stop
