@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/hardware/general.checkin') }}
    @parent
@stop

{{-- Page content --}}
@section('content')
    <style>

        .input-group {
            padding-left: 0px !important;
        }
    </style>


    <div class="row"><!-- .row -->
        <!-- left column -->
        <div class="col-md-7 col-sm-11 col-xs-12 col-md-offset-2">
            <div class="box box-default"><!-- .box-default -->
                <div class="box-header with-border"><!-- .box-header -->
                    <h2 class="box-title">
                        {{ trans('admin/hardware/form.tag') }}
                        {{ $asset->asset_tag }}
                    </h2>
                </div><!-- /.box-header -->

                <div class="box-body"><!-- .box-body -->
                    <div class="col-md-12"><!-- .col-md-12 -->

                        @if ($backto == 'user')
                            <form class="form-horizontal" method="post"
                                  action="{{ route('hardware.checkin.store', array('assetId'=> $asset->id, 'backto'=>'user')) }}"
                                  autocomplete="off">
                                @else
                                    <form class="form-horizontal" method="post"
                                          action="{{ route('hardware.checkin.store', array('assetId'=> $asset->id)) }}"
                                          autocomplete="off">
                                        @endif
                                        {{csrf_field()}}

                                        <!-- AssetModel name -->
                                        <div class="form-group">
                                            <label for="model" class="col-sm-3 control-label">
                                                {{ trans('admin/hardware/form.model') }}
                                            </label>
                                            <div class="col-md-8">

                                                <p class="form-control-static">
                                                    @if (($asset->model) && ($asset->model->name))
                                                        {{ $asset->model->name }}
                                                    @else
                                                        <span class="text-danger text-bold">
                              <x-icon type="warning" />
                              {{ trans('admin/hardware/general.model_invalid')}}
                            </span>
                                                        {{ trans('admin/hardware/general.model_invalid_fix')}}
                                                        <a href="{{ route('hardware.edit', $asset->id) }}">
                                                            <strong>{{ trans('admin/hardware/general.edit') }}</strong>
                                                        </a>
                                                    @endif
                                                </p>

                                            </div>
                                        </div>

                                        <!-- Asset Name -->
                                        <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                                            <label for="name" class="col-sm-3 control-label">
                                                {{ trans('general.name') }}
                                            </label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="name" aria-label="name"
                                                       id="name" value="{{ old('name', $asset->name) }}"/>
                                                {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="form-group {{ $errors->has('status_id') ? 'error' : '' }}">
                                            <label for="status_id" class="col-sm-3 control-label">
                                                {{ trans('admin/hardware/form.status') }}
                                            </label>
                                            <div class="col-md-8 required">
                                                {{ Form::select('status_id', $statusLabel_list, '', array('class'=>'select2', 'style'=>'width:100%','id' =>'modal-statuslabel_types', 'aria-label'=>'status_id')) }}
                                                {!! $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                            </div>
                                        </div>

                                        @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id', 'help_text' => ($asset->defaultLoc) ? trans('general.checkin_to_diff_location', ['default_location' => $asset->defaultLoc->name]) : null, 'hide_location_radio' => true])

                                        <!-- Checkout/Checkin Date -->
                                        <div class="form-group{{ $errors->has('checkin_at') ? ' has-error' : '' }}">
                                            <label for="checkin_at" class="col-sm-3 control-label">
                                                {{ trans('admin/hardware/form.checkin_date') }}
                                            </label>

                                            <div class="col-md-8">
                                                <div class="input-group col-md-5 required">
                                                    <div class="input-group date" data-provide="datepicker"
                                                         data-date-format="yyyy-mm-dd" data-autoclose="true">
                                                        <input type="text" class="form-control"
                                                               placeholder="{{ trans('general.select_date') }}"
                                                               name="checkin_at" id="checkin_at"
                                                               value="{{ old('checkin_at', date('Y-m-d')) }}">
                                                        <span class="input-group-addon"><i class="fas fa-calendar"
                                                                                           aria-hidden="true"></i></span>
                                                    </div>
                                                    {!! $errors->first('checkin_at', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Note -->
                                        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                                            <label for="note" class="col-sm-3 control-label">
                                                {{ trans('general.notes') }}
                                            </label>
                                            <div class="col-md-8">
                                                <textarea class="col-md-6 form-control" id="note"
                                                          name="note">{{ old('note', $asset->note) }}</textarea>
                                                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                            </div>
                                        </div>
                    </div> <!--/.box-body-->
                </div> <!--/.box-body-->

                <x-redirect_submit_options
                        index_route="hardware.index"
                        :button_label="trans('general.checkin')"
                        :disabled_select="!$asset->model"
                        :options="[
                                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => trans('general.assets')]),
                                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.asset')]),
                               ]"
                />
                </form>

            </div>
        </div>
    </div>

@stop