@extends('backend/layouts/default')
@section('content')

{{-- 
['url' => '/admin/custom_fields/create-field']
--}}
{{ Form::open(["route" => 'admin.custom_fields.store-field'] )}}
Name: {{ Form::text("name")}}<span class="alert-msg"><?= $errors->first('name'); ?></span><br>
type: {{ Form::select("element",["text" => "Text Box"])}}<span class="alert-msg"><?= $errors->first('element'); ?></span><br>
format: {{ Form::select("format",predefined_formats(),"ANY") }}<span class="alert-msg"><?= $errors->first('format'); ?></span>
Custom Format (if selected): {{ Form::text("custom_format") }}<br>
<input type='submit'>
{{ Form::close() }}
<br>{{ link_to_route('admin.custom_fields.index',"Back to Custom Fieldset List") }}
@stop
