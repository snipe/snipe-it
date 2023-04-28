@extends('layouts/edit-form', [
    'createText' => trans('admin/statuslabels/table.create') ,
    'updateText' => trans('admin/statuslabels/table.update'),
    'helpTitle' => trans('admin/statuslabels/table.about'),
    'helpText' => trans('admin/statuslabels/table.info'),
    'formAction' => (isset($item->id)) ? route('statuslabels.update', ['statuslabel' => $item->id]) : route('statuslabels.store'),
])

{{-- Page content --}}
@section('content')
<style>
    .input-group-addon {
        width: 30px;
    }
</style>

@parent
@stop

@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('general.name')])

<!-- Label type -->
<div class="form-group{{ $errors->has('statuslabel_types') ? ' has-error' : '' }}">
    <label for="statuslabel_types" class="col-md-3 control-label">{{ trans('admin/statuslabels/table.status_type') }} </label>
    <div class="col-md-7 required">
        {{ Form::select('statuslabel_types', $statuslabel_types, $item->getStatuslabelType(), array('class'=>'select2', 'style'=>'min-width:400px', 'aria-label'=>'statuslabel_types')) }}
        {!! $errors->first('statuslabel_types', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

<!-- Chart color -->
<div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
    {{ Form::label('color', trans('admin/statuslabels/table.color'), ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-2">
        <div class="input-group color">
            {{ Form::text('color', Request::old('color', $item->color), array('class' => 'form-control', 'style' => 'width: 100px;', 'maxlength'=>'10')) }}
            <div class="input-group-addon"><i></i></div>
        </div><!-- /.input group -->
        {!! $errors->first('header_color', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.notes')

<!-- Show in Nav -->
<div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">

    <label class="col-md-offset-3" style="padding-left: 15px;">
        <input type="checkbox" value="1" name="show_in_nav" id="show_in_nav" class="minimal" {{ Request::old('show_in_nav', $item->show_in_nav) == '1' ? ' checked="checked"' : '' }}> {{ trans('admin/statuslabels/table.show_in_nav') }}
    </label>
</div>

<!-- Set as Default -->
<div class="form-group{{ $errors->has('default_label') ? ' has-error' : '' }}">

    <label class="col-md-offset-3" style="padding-left: 15px;">
        <input type="checkbox" value="1" name="default_label" id="default_label" class="minimal" {{ Request::old('default_label', $item->default_label) == '1' ? ' checked="checked"' : '' }}> {{ trans('admin/statuslabels/table.default_label') }}
    </label>
    <p class="col-md-offset-3 help-block"> {{ trans('admin/statuslabels/table.default_label_help') }}</p>
</div>

@stop

@section('moar_scripts')
    <!-- bootstrap color picker -->
    <script nonce="{{ csrf_token() }}">
        //color picker with addon
        $(".color").colorpicker();
    </script>

@stop
