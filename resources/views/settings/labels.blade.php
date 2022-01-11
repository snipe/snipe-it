@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/settings/general.labels_title') }}
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>


    {{ Form::open(['method' => 'POST', 'files' => false, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form' ]) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fas fa-tags"></i> {{ trans('admin/settings/general.labels') }}
                    </h4>
                </div>
                <div class="box-body">


                    <div class="col-md-11 col-md-offset-1">

                        <div class="form-group {{ $errors->has('labels_per_page') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('labels_per_page', trans('admin/settings/general.labels_per_page')) }}
                            </div>
                            <div class="col-md-9">
                                {{ Form::text('labels_per_page', old('labels_per_page', $setting->labels_per_page), ['class' => 'form-control','style' => 'width: 100px;', 'aria-label'=>'labels_per_page']) }}
                                {!! $errors->first('labels_per_page', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('labels_fontsize') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('labels_fontsize', trans('admin/settings/general.labels_fontsize')) }}
                            </div>
                            <div class="col-md-2 form-group">
                                <div class="input-group">
                                    {{ Form::text('labels_fontsize', old('labels_fontsize', $setting->labels_fontsize), ['class' => 'form-control', 'aria-label'=>'labels_fontsize']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.text_pt') }}</div>
                                </div>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                {!! $errors->first('labels_fontsize', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('labels_width') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('labels_width', trans('admin/settings/general.label_dimensions')) }}
                            </div>
                            <div class="col-md-3 form-group">
                                <div class="input-group">
                                    {{ Form::text('labels_width', old('labels_width', $setting->labels_width), ['class' => 'form-control', 'aria-label'=>'labels_width']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.width_w') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 form-group" style="margin-left: 10px">
                                <div class="input-group">
                                    {{ Form::text('labels_height', old('labels_height', $setting->labels_height), ['class' => 'form-control', 'aria-label'=>'labels_height']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.height_h') }}</div>
                                </div>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                {!! $errors->first('labels_width', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                {!! $errors->first('labels_height', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('labels_display_sgutter') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('labels_display_sgutter', trans('admin/settings/general.label_gutters')) }}
                            </div>
                            <div class="col-md-3 form-group">
                                <div class="input-group">
                                    {{ Form::text('labels_display_sgutter', old('labels_display_sgutter', $setting->labels_display_sgutter), ['class' => 'form-control', 'aria-label'=>'labels_display_sgutter']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.horizontal') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 form-group" style="margin-left: 10px">
                                <div class="input-group">
                                    {{ Form::text('labels_display_bgutter', old('labels_display_bgutter', $setting->labels_display_bgutter), ['class' => 'form-control', 'aria-label'=>'labels_display_bgutter']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.vertical') }}</div>
                                </div>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                {!! $errors->first('labels_display_sgutter', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                {!! $errors->first('labels_display_bgutter', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('labels_pmargin_top') ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('labels_pmargin_top', trans('admin/settings/general.page_padding')) }}
                            </div>
                            <div class="col-md-3 form-group">
                                <div class="input-group" style="margin-bottom: 15px;">
                                    {{ Form::text('labels_pmargin_top', old('labels_pmargin_top', $setting->labels_pmargin_top), ['class' => 'form-control', 'aria-label'=>'labels_pmargin_top']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.top') }}</div>
                                </div>
                                <div class="input-group">
                                    {{ Form::text('labels_pmargin_right', old('labels_pmargin_right', $setting->labels_pmargin_right), ['class' => 'form-control', 'aria-label'=>'labels_pmargin_right']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.right') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 form-group" style="margin-left: 10px; ">
                                <div class="input-group" style="margin-bottom: 15px;">
                                    {{ Form::text('labels_pmargin_bottom', old('labels_pmargin_bottom', $setting->labels_pmargin_bottom), ['class' => 'form-control', 'aria-label'=>'labels_pmargin_bottom']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.bottom') }}</div>
                                </div>
                                <div class="input-group">
                                    {{ Form::text('labels_pmargin_left', old('labels_pmargin_left', $setting->labels_pmargin_left), ['class' => 'form-control', 'aria-label'=>'labels_pmargin_left']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.left') }}</div>
                                </div>

                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                {!! $errors->first('labels_width', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                {!! $errors->first('labels_height', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group {{ (($errors->has('labels_pageheight')) || $errors->has('labels_pagewidth')) ? 'error' : '' }}">
                            <div class="col-md-3">
                                {{ Form::label('labels_pagewidth', trans('admin/settings/general.page_dimensions')) }}
                            </div>
                            <div class="col-md-3 form-group">
                                <div class="input-group">
                                    {{ Form::text('labels_pagewidth', old('labels_pagewidth', $setting->labels_pagewidth), ['class' => 'form-control', 'aria-label'=>'labels_pagewidth']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.width_w') }}</div>
                                </div>
                            </div>
                            <div class="col-md-3 form-group" style="margin-left: 10px">
                                <div class="input-group">
                                    {{ Form::text('labels_pageheight', old('labels_pageheight', $setting->labels_pageheight), ['class' => 'form-control', 'aria-label'=>'labels_pageheight']) }}
                                    <div class="input-group-addon">{{ trans('admin/settings/general.height_h') }}</div>
                                </div>
                            </div>
                            <div class="col-md-9 col-md-offset-3">
                                {!! $errors->first('labels_pagewidth', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                {!! $errors->first('labels_pageheight', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3">
			                {{ Form::label('labels_display', trans('admin/settings/general.label_fields')) }}
                            </div>
                            <div class="col-md-9">
                                <div class="checkbox">
                                    <label for="labels_display_name">
                                        {{ Form::checkbox('labels_display_name', '1', old('labels_display_name',   $setting->labels_display_name),['class' => 'minimal', 'aria-label'=>'labels_display_name']) }}
                                        {{ trans('admin/hardware/form.name') }}
                                    </label>
                                    <label for="labels_display_serial">
                                        {{ Form::checkbox('labels_display_serial', '1', old('labels_display_serial',   $setting->labels_display_serial),['class' => 'minimal', 'aria-label'=>'labels_display_serial']) }}
                                        {{ trans('admin/hardware/form.serial') }}
                                    </label>
                                    <label for="labels_display_tag">
                                        {{ Form::checkbox('labels_display_tag', '1', old('labels_display_tag',   $setting->labels_display_tag),['class' => 'minimal', 'aria-label'=>'labels_display_tag']) }}
                                        {{ trans('admin/hardware/form.tag') }}
                                    </label>
                                    <label for="labels_display_model">
                                        {{ Form::checkbox('labels_display_model', '1', old('labels_display_model',   $setting->labels_display_model),['class' => 'minimal', 'aria-label'=>'labels_display_model']) }}
                                        {{ trans('admin/hardware/form.model') }}
                                    </label>
                                    <label for="labels_display_company_name">
                                        {{ Form::checkbox('labels_display_company_name', '1', old('labels_display_company_name',   $setting->labels_display_company_name),['class' => 'minimal', 'aria-label'=>'labels_display_company_name']) }}
                                        {{ trans('admin/companies/table.name') }}
				    </label>

                                </div> <!--/.CHECKBOX-->
                            </div> <!--/.col-md-9-->
                        </div> <!--/.form-group-->




                    </div>

                </div> <!--/.box-body-->
                <div class="box-footer">
                    <div class="text-left col-md-6">
                        <a class="btn btn-link text-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>
                    </div>
                    <div class="text-right col-md-6">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
                    </div>

                </div>
            </div> <!-- /box -->
        </div> <!-- /.col-md-8-->
    </div> <!-- /.row-->

    {{Form::close()}}

@stop
