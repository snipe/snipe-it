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

    {{ Form::open(['id' => 'settingsForm', 'method' => 'POST', 'files' => false, 'autocomplete' => 'off', 'class' => 'form-horizontal', 'role' => 'form' ]) }}
    <!-- CSRF Token -->
    {{csrf_field()}}

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-md-10">


            <div class="panel box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <i class="fas fa-tags"></i> {{ trans('admin/settings/general.labels') }}
                    </h2>
                </div>
                <div class="box-body">


                    <div class="col-md-12">

                        <!-- New Label Engine -->
                        <div class="form-group" {{ $errors->has('label2_enable') ? 'error' : '' }}">

                            <div class="col-md-7 col-md-offset-3">

                                <label class="form-control">
                                    <input type="checkbox" value="1" name="label2_enable"{{ ((old('label2_enable') == '1') || ($setting->label2_enable) == '1') ? ' checked="checked"' : '' }} aria-label="label2_enable">
                                    {{ Form::label('label2_enable', trans('admin/settings/general.label2_enable')) }}
                                </label>

                                {!! $errors->first('label2_enable', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}

                                <p class="help-block">
                                    {!! trans('admin/settings/general.label2_enable_help') !!}
                                </p>



                            </div>
                        </div>


                        @if ($setting->label2_enable)
                            <!-- New Settings -->

                            <!-- Template -->
                            <div class="form-group{{ $errors->has('label2_template') ? ' has-error' : '' }}">
                                <div class="col-md-3">
                                    @include('partials.label2-preview')
                                </div>
                                <div class="col-md-9">
                                    <table
                                        data-click-to-select="true"
                                        data-columns="{{ \App\Presenters\LabelPresenter::dataTableLayout() }}"
                                        data-cookie="true"
                                        data-cookie-id-table="label2TemplateTable"
                                        data-id-table="label2TemplateTable"
                                        data-pagination="true"
                                        data-search="true"
                                        data-select-item-name="label2_template"
                                        data-id-field="name"
                                        data-show-columns="true"
                                        data-show-fullscreen="true"
                                        data-show-refresh="true"
                                        data-side-pagination="server"
                                        data-sort-name="name"
                                        data-sort-order="asc"
                                        data-url="{{ route('api.labels.index') }}"
                                        id="label2TemplateTable"
                                        class="table table-striped snipe-table"
                                    ></table>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', () => {
                                            $('#label2TemplateTable').on('load-success.bs.table', (e) => {
                                                let form = document.getElementById('settingsForm');
                                                form.dispatchEvent(new Event('change'));
                                            });
                                        });
                                    </script>
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="form-group{{ $errors->has('label2_title') ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('label2_title', trans('admin/settings/general.label2_title'), ['class'=>'control-label']) }}
                                </div>
                                <div class="col-md-7">
                                    {{ Form::text('label2_title', old('label2_title', $setting->label2_title), [ 'class'=>'form-control', 'placeholder'=>$setting->qr_text, 'aria-label'=>'label2_title' ]) }}
                                    {!! $errors->first('label2_title', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    <p class="help-block">{!! trans('admin/settings/general.label2_title_help') !!}</p>
                                    <p class="help-block">
                                        {!! trans('admin/settings/general.label2_title_help_phold') !!}.<br />
                                        {!! trans('admin/settings/general.help_asterisk_bold') !!}.<br />
                                        {!!
                                            trans('admin/settings/general.help_blank_to_use', [
                                                'setting_name' => trans('admin/settings/general.barcodes').' &gt; '.trans('admin/settings/general.qr_text')
                                            ])
                                        !!}
                                    </p>
                                </div>
                            </div>

                            <!-- Use Asset Logo -->
                            <div class="form-group" {{ $errors->has('label2_asset_logo') ? 'error' : '' }}">
                                <div class="col-md-7 col-md-offset-3">

                                    <label class="form-control">
                                        <input type="checkbox" value="1" name="label2_asset_logo"{{ ((old('label2_asset_logo') == '1') || ($setting->label2_asset_logo) == '1') ? ' checked="checked"' : '' }} aria-label="label2_asset_logo">
                                        {{ Form::label('label2_asset_logo', trans('admin/settings/general.label2_asset_logo')) }}
                                    </label>
                                    <p class="help-block">
                                        {!! trans('admin/settings/general.label2_asset_logo_help', ['setting_name' => trans('admin/settings/general.brand').' &gt; '.trans('admin/settings/general.label_logo')]) !!}
                                    </p>

                                </div>
                            </div>

                            <!-- 1D Barcode Type -->
                            <div class="form-group{{ $errors->has('label2_1d_type') ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('label2_1d_type', trans('admin/settings/general.label2_1d_type'), ['class'=>'control-label']) }}
                                </div>
                                <div class="col-md-7">
                                    @php
                                        $select1DValues = [
                                            'default' => trans('admin/settings/general.default').' [ '.$setting->alt_barcode.' ]',
                                            'none'    => trans('admin/settings/general.none'),
                                            'C128'    => 'C128',
                                            'C39'     => 'C39',
                                            'EAN5'    => 'EAN5',
                                            'EAN13'   => 'EAN13',
                                            'UPCA'    => 'UPCA',
                                            'UPCE'    => 'UPCE'
                                        ];
                                    @endphp
                                    {{ Form::select('label2_1d_type', $select1DValues, old('label2_1d_type', $setting->label2_1d_type), [ 'class'=>'select2 col-md-4', 'aria-label'=>'label2_1d_type' ]) }}
                                    {!! $errors->first('label2_1d_type', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                    <p class="help-block">
                                        {{ trans('admin/settings/general.label2_1d_type_help') }}.
                                        {!!
                                            trans('admin/settings/general.help_default_will_use', [
                                                'default' => trans('admin/settings/general.default'),
                                                'setting_name' => trans('admin/settings/general.barcodes').' &gt; '.trans('admin/settings/general.alt_barcode_type'),
                                            ])
                                        !!}
                                    </p>
                                </div>
                            </div>

                            <!-- 2D Barcode Type -->
                            <div class="form-group{{ $errors->has('label2_2d_type') ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('label2_2d_type', trans('admin/settings/general.label2_2d_type'), ['class'=>'control-label']) }}
                                </div>
                                <div class="col-md-7">
                                    @php
                                        $select2DValues = [
                                            'default'    => trans('admin/settings/general.default').' [ '.$setting->barcode_type.' ]',
                                            'none'       => trans('admin/settings/general.none'),
                                            'QRCODE'     => 'QRCODE',
                                            'DATAMATRIX' => 'DATAMATRIX',
                                            'PDF417'     => 'PDF417',
                                        ];
                                    @endphp
                                    {{ Form::select('label2_2d_type', $select2DValues, old('label2_2d_type', $setting->label2_2d_type), [ 'class'=>'select2 col-md-4', 'aria-label'=>'label2_2d_type' ]) }}
                                    {!! $errors->first('label2_2d_type', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                    <p class="help-block">
                                        {{ trans('admin/settings/general.label2_2d_type_help', ['current' => $setting->barcode_type]) }}.
                                        {!!
                                            trans('admin/settings/general.help_default_will_use', [
                                                'default' => trans('admin/settings/general.default'),
                                                'setting_name' => trans('admin/settings/general.barcodes').' &gt; '.trans('admin/settings/general.barcode_type'),
                                            ])
                                        !!}
                                    </p>
                                </div>
                            </div>

                            <!-- 2D Barcode Target -->
                            <div class="form-group{{ $errors->has('label2_2d_target') ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('label2_2d_target', trans('admin/settings/general.label2_2d_target'), ['class'=>'control-label']) }}
                                </div>
                                <div class="col-md-9">
                                    {{ Form::select('label2_2d_target', ['hardware_id'=>'/hardware/{id} ('.trans('admin/settings/general.default').')', 'ht_tag'=>'/ht/{asset_tag}'], old('label2_2d_target', $setting->label2_2d_target), [ 'class'=>'select2 col-md-4', 'aria-label'=>'label2_2d_target' ]) }}
                                    {!! $errors->first('label2_2d_target', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                    <p class="help-block">{{ trans('admin/settings/general.label2_2d_target_help') }}</p>
                                </div>
                            </div>

                            <!-- Fields -->
                            <div class="form-group {{ $errors->has('label2_fields') ? 'error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('label2_fields', trans('admin/settings/general.label2_fields')) }}
                                </div>
                                <div class="col-md-9">
                                    @include('partials.label2-field-definitions', [ 'name' => 'label2_fields', 'value' => old('label2_fields', $setting->label2_fields) ])
                                    {!! $errors->first('label2_fields', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                    <p class="help-block">{{ trans('admin/settings/general.label2_fields_help') }}</p>
                                </div>
                            </div>

                            @include('partials.bootstrap-table')

                        @else
                            <!-- Hidden version of new settings -->
                            {{ Form::hidden('label2_template', old('label2_template', $setting->label2_template)) }}
                            {{ Form::hidden('label2_title', old('label2_title', $setting->label2_title)) }}
                            {{ Form::hidden('label2_asset_logo', old('label2_asset_logo', $setting->label2_asset_logo)) }}
                            {{ Form::hidden('label2_1d_type', old('label2_1d_type', $setting->label2_1d_type)) }}
                            {{ Form::hidden('label2_2d_type', old('label2_2d_type', $setting->label2_2d_type)) }}
                            {{ Form::hidden('label2_2d_target', old('label2_2d_target', $setting->label2_2d_target)) }}
                            {{ Form::hidden('label2_fields', old('label2_fields', $setting->label2_fields)) }}
                        @endif

                        @if ($setting->label2_enable && ($setting->label2_template != 'DefaultLabel'))
                            <!-- Hidden version of legacy settings -->
                            {{ Form::hidden('labels_per_page', old('labels_per_page', $setting->labels_per_page)) }}
                            {{ Form::hidden('labels_fontsize', old('labels_fontsize', $setting->labels_fontsize)) }}
                            {{ Form::hidden('labels_width', old('labels_width', $setting->labels_width)) }}
                            {{ Form::hidden('labels_height', old('labels_height', $setting->labels_height)) }}
                            {{ Form::hidden('labels_display_sgutter', old('labels_display_sgutter', $setting->labels_display_sgutter)) }}
                            {{ Form::hidden('labels_display_bgutter', old('labels_display_bgutter', $setting->labels_display_bgutter)) }}
                            {{ Form::hidden('labels_pmargin_top', old('labels_pmargin_top', $setting->labels_pmargin_top)) }}
                            {{ Form::hidden('labels_pmargin_bottom', old('labels_pmargin_bottom', $setting->labels_pmargin_bottom)) }}
                            {{ Form::hidden('labels_pmargin_left', old('labels_pmargin_left', $setting->labels_pmargin_left)) }}
                            {{ Form::hidden('labels_pmargin_right', old('labels_pmargin_right', $setting->labels_pmargin_right)) }}
                            {{ Form::hidden('labels_pagewidth', old('labels_pagewidth', $setting->labels_pagewidth)) }}
                            {{ Form::hidden('labels_pageheight', old('labels_pageheight', $setting->labels_pageheight)) }}
                            {{ Form::hidden('labels_display_name', old('labels_display_name', $setting->labels_display_name)) }}
                            {{ Form::hidden('labels_display_serial', old('labels_display_serial', $setting->labels_display_serial)) }}
                            {{ Form::hidden('labels_display_tag', old('labels_display_tag', $setting->labels_display_tag)) }}
                            {{ Form::hidden('labels_display_model', old('labels_display_model', $setting->labels_display_model)) }}
                            {{ Form::hidden('labels_display_company_name', old('labels_display_company_name', $setting->labels_display_company_name)) }}
                        @else

                            <!-- Legacy settings -->
                            <div class="form-group{{ $errors->has('labels_per_page') ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('labels_per_page', trans('admin/settings/general.labels_per_page'), ['class'=>'control-label']) }}
                                </div>
                                <div class="col-md-9">
                                    {{ Form::text('labels_per_page', old('labels_per_page', $setting->labels_per_page), ['class' => 'form-control','style' => 'width: 100px;', 'aria-label'=>'labels_per_page']) }}
                                    {!! $errors->first('labels_per_page', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('labels_fontsize') ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('labels_fontsize', trans('admin/settings/general.labels_fontsize'), ['class'=>'control-label']) }}
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        {{ Form::text('labels_fontsize', old('labels_fontsize', $setting->labels_fontsize), ['class' => 'form-control', 'aria-label'=>'labels_fontsize']) }}
                                        <div class="input-group-addon">{{ trans('admin/settings/general.text_pt') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-9 col-md-offset-3">
                                    {!! $errors->first('labels_fontsize', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('labels_width') ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('labels_width', trans('admin/settings/general.label_dimensions'), ['class'=>'control-label']) }}
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        {{ Form::text('labels_width', old('labels_width', $setting->labels_width), ['class' => 'form-control', 'aria-label'=>'labels_width']) }}
                                        <div class="input-group-addon">{{ trans('admin/settings/general.width_w') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
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

                            <div class="form-group{{ $errors->has('labels_display_sgutter') ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('labels_display_sgutter', trans('admin/settings/general.label_gutters')) }}
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        {{ Form::text('labels_display_sgutter', old('labels_display_sgutter', $setting->labels_display_sgutter), ['class' => 'form-control', 'aria-label'=>'labels_display_sgutter']) }}
                                        <div class="input-group-addon">{{ trans('admin/settings/general.horizontal') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3">
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

                            <div class="form-group{{ $errors->has('labels_pmargin_top') ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('labels_pmargin_top', trans('admin/settings/general.page_padding')) }}
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="margin-bottom: 15px;">
                                        {{ Form::text('labels_pmargin_top', old('labels_pmargin_top', $setting->labels_pmargin_top), ['class' => 'form-control', 'aria-label'=>'labels_pmargin_top']) }}
                                        <div class="input-group-addon">{{ trans('admin/settings/general.top') }}</div>
                                    </div>
                                    <div class="input-group">
                                        {{ Form::text('labels_pmargin_right', old('labels_pmargin_right', $setting->labels_pmargin_right), ['class' => 'form-control', 'aria-label'=>'labels_pmargin_right']) }}
                                        <div class="input-group-addon">{{ trans('admin/settings/general.right') }}</div>
                                    </div>
                                </div>
                                <div class="col-md-3" style="margin-left: 10px; ">
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

                            <div class="form-group{{ (($errors->has('labels_pageheight')) || $errors->has('labels_pagewidth')) ? ' has-error' : '' }}">
                                <div class="col-md-3 text-right">
                                    {{ Form::label('labels_pagewidth', trans('admin/settings/general.page_dimensions'), ['class'=>'control-label']) }}
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3 text-right">
                                {{ Form::label('labels_display', trans('admin/settings/general.label_fields'), ['class' => 'control-label']) }}
                                </div>
                                <div class="col-md-9">
                                        <label class="form-control">
                                            {{ Form::checkbox('labels_display_name', '1', old('labels_display_name',   $setting->labels_display_name),['class' => 'minimal', 'aria-label'=>'labels_display_name']) }}
                                            {{ trans('admin/hardware/form.name') }}
                                        </label>
                                        <label class="form-control">
                                            {{ Form::checkbox('labels_display_serial', '1', old('labels_display_serial',   $setting->labels_display_serial),['class' => 'minimal', 'aria-label'=>'labels_display_serial']) }}
                                            {{ trans('admin/hardware/form.serial') }}
                                        </label>
                                        <label class="form-control">
                                            {{ Form::checkbox('labels_display_tag', '1', old('labels_display_tag',   $setting->labels_display_tag),['class' => 'minimal', 'aria-label'=>'labels_display_tag']) }}
                                            {{ trans('admin/hardware/form.tag') }}
                                        </label>
                                        <label class="form-control">
                                            {{ Form::checkbox('labels_display_model', '1', old('labels_display_model',   $setting->labels_display_model),['class' => 'minimal', 'aria-label'=>'labels_display_model']) }}
                                            {{ trans('admin/hardware/form.model') }}
                                        </label>
                                        <label class="form-control">
                                            {{ Form::checkbox('labels_display_company_name', '1', old('labels_display_company_name',   $setting->labels_display_company_name),['class' => 'minimal', 'aria-label'=>'labels_display_company_name']) }}
                                            {{ trans('admin/companies/table.name') }}
                                        </label>

                                </div> <!--/.col-md-9-->
                            </div> <!--/.form-group-->

                        @endif


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
