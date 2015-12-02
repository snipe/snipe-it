@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
  @lang('admin/custom_fields/general.custom_fields')
@parent
@stop



@section('content')
<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('admin.custom_fields.index') }}" class="btn-flat gray pull-right">
          <i class="fa fa-arrow-left icon-white"></i>
          @lang('general.back')</a>
        <h3>
        {{{ $custom_fieldset->name }}} @lang('admin/custom_fields/general.fieldset')
        </h3>
    </div>
</div>
<div class="row form-wrapper">

  <table
  name="fieldsets"
  id="table" class="table table-responsive table-no-bordered">
      <thead>
          <tr>
            <th>@lang('admin/custom_fields/general.order')</th>
            <th>@lang('admin/custom_fields/general.field_name')</th>
            <th>@lang('admin/custom_fields/general.field_format')</th>
            <th>@lang('admin/custom_fields/general.field_element')</th>
            <th>@lang('admin/custom_fields/general.required')</th>
          </tr>
      </thead>
      <tfoot>
          <tr>
            <td colspan="4" class="text-right">
              {{ Form::open(['route' => ["admin.custom_fields.associate",$custom_fieldset->id], 'class'=>'form-horizontal']) }}
              {{ Form::checkbox("required","on") }}
              @lang('admin/custom_fields/general.required')
              {{ Form::text("order",$maxid)}}
              {{ Form::select("field_id",$custom_fields_list,"",["onchange" => "document.forms[0].submit()"]) }}
              <span class="alert-msg"><?= $errors->first('field_id'); ?></span>

            </td>
          </tr>
      </tfoot>
      <tbody>
        @foreach($custom_fieldset->fields AS $field)
        <tr>
          <td>{{$field->pivot->order}}</td>
          <td>{{$field->name}}</td>
          <td>{{$field->format}}</td>
          <td>{{$field->element}}</td>
          <td>{{$field->pivot->required ? "REQUIRED" : "OPTIONAL"}}</td>
        </tr>
        @endforeach
      </tbody>
</table>





</div>

@stop
