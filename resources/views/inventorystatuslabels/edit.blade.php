@extends('layouts/edit-form', [
    'createText' => "Создать статус инвентаризации" ,
    'updateText' =>"Изменить статус инвентаризации",
    'helpTitle' => trans('admin/statuslabels/table.about'),
    'helpText' => "",
    'formAction' => ($item) ? route('inventorystatuslabels.update', ['inventorystatuslabel' => $item->id]) : route('inventorystatuslabels.store'),
])

{{-- Page content --}}
@section('content')
<style>
    .input-group-addon {
        width: 30px;
    }
</style>
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.css') }}">
@parent
@stop

@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('general.name')])



<!-- Chart color -->
<div class="form-group{{ $errors->has('color') ? ' has-error' : '' }}">
    {{ Form::label('color', trans('admin/statuslabels/table.color'), ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-2">
        <div class="input-group color">
            {{ Form::text('color', Input::old('color', $item->color), array('class' => 'form-control', 'style' => 'width: 100px;', 'maxlength'=>'10')) }}
            <div class="input-group-addon"><i></i></div>
        </div><!-- /.input group -->
        {!! $errors->first('header_color', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
</div>

@include ('partials.forms.edit.notes')

<!-- Show in Nav -->
<div class="form-group{{ $errors->has('success') ? ' has-error' : '' }}">
    <label class="col-md-offset-3" style="padding-left: 15px;">
        <input type="checkbox" value="1" name="success" id="success" class="minimal" {{ Input::old('success', $item->success) == '1' ? ' checked="checked"' : '' }}> Успешный статус
    </label>
</div>

@stop

@section('moar_scripts')
    <!-- bootstrap color picker -->
    <script nonce="{{ csrf_token() }}">
        //color picker with addon
        $(".color").colorpicker();
    </script>

@stop
