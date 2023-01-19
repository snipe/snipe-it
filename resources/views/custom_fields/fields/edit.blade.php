@php
    use App\Models\CustomField;
@endphp

@extends('layouts/default')

{{-- Page title --}}
@section('title')
  {{ trans('admin/custom_fields/general.custom_fields') }}
@parent
@stop

@section('content')

@section('header_right')
<a href="{{ route('fields.index') }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <!-- Horizontal Form -->
        @if ($field->id)
          {{ Form::open(['route' => ['fields.update', $field->id], 'class'=>'form-horizontal']) }}
          {{ method_field('PUT') }}
        @else
          {{ Form::open(['route' => 'fields.store', 'class'=>'form-horizontal']) }}
        @endif

    <div class="box box-default">
      <div class="box-body">
          <!-- Name -->
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">
              {{ trans('admin/custom_fields/general.field_name') }}
            </label>
            <div class="col-md-6 required">
                {{ Form::text('name', old('name', $field->name), array('class' => 'form-control', 'aria-label'=>'name')) }}
                {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

          <!-- Element Type -->
          <div class="form-group {{ $errors->has('element') ? ' has-error' : '' }}">
            <label for="element" class="col-md-4 control-label">
              {{ trans('admin/custom_fields/general.field_element') }}
            </label>
            <div class="col-md-6 required">

            {!! Form::customfield_elements('element', old('element', $field->element), 'field_element select2 form-control') !!}
            {!! $errors->first('element', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}

            </div>
          </div>

          <!-- Element values -->
          <div class="form-group {{ $errors->has('field_values') ? ' has-error' : '' }}" id="field_values_text" style="display:none;">
            <label for="field_values" class="col-md-4 control-label">
              {{ trans('admin/custom_fields/general.field_values') }}
            </label>
            <div class="col-md-6 required">
              {!! Form::textarea('field_values', old('name', $field->field_values), ['style' => 'width: 100%', 'rows' => 4, 'class' => 'form-control', 'aria-label'=>'field_values']) !!}
              {!! $errors->first('field_values', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              <p class="help-block">{{ trans('admin/custom_fields/general.field_values_help') }}</p>
            </div>
          </div>

          <!-- Format -->
          <div class="form-group {{ $errors->has('format') ? ' has-error' : '' }}" id="format_values">
            <label for="format" class="col-md-4 control-label">
              {{ trans('admin/custom_fields/general.field_format') }}
            </label>
              @php
              $field_format = '';
              if (stripos($field->format, 'regex') === 0){
                $field_format = 'CUSTOM REGEX';
              }
              @endphp
            <div class="col-md-6 required">
              {{ Form::select("format",Helper::predefined_formats(), ($field_format == '') ? $field->format : $field_format, array('class'=>'format select2 form-control', 'aria-label'=>'format')) }}
              {!! $errors->first('format', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
          <!-- Custom Format -->
          <div class="form-group {{ $errors->has('custom_format') ? ' has-error' : '' }}" id="custom_regex" style="display:none;">
            <label for="custom_format" class="col-md-4 control-label">
              {{ trans('admin/custom_fields/general.field_custom_format') }}
            </label>
            <div class="col-md-6 required">
                {{ Form::text('custom_format', old('custom_format', (($field->format!='') && (stripos($field->format,'regex')===0)) ? $field->format : ''), array('class' => 'form-control', 'id' => 'custom_format','aria-label'=>'custom_format', 'placeholder'=>'regex:/^[0-9]{15}$/')) }}
                <p class="help-block">{!! trans('admin/custom_fields/general.field_custom_format_help') !!}</p>

              {!! $errors->first('custom_format', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}

            </div>
          </div>

          <!-- Help Text -->
          <div class="form-group {{ $errors->has('help_text') ? ' has-error' : '' }}">
              <label for="help_text" class="col-md-4 control-label">
                  {{ trans('admin/custom_fields/general.help_text') }}
              </label>
              <div class="col-md-6">
                  {{ Form::text('help_text', old('help_text', $field->help_text), array('class' => 'form-control', 'aria-label'=>'help_text')) }}
                  <p class="help-block">{{ trans('admin/custom_fields/general.help_text_description') }}</p>
                  {!! $errors->first('help_text', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
          </div>

          <!-- Show in Email  -->
          <div class="form-group {{ $errors->has('show_in_email') ? ' has-error' : '' }}"  id="show_in_email">
              <div class="col-md-8 col-md-offset-4">
                  <label for="show_in_email">
                      <input type="checkbox" name="show_in_email" aria-label="show_in_email" value="1" class="minimal"{{ (old('show_in_email') || $field->show_in_email) ? ' checked="checked"' : '' }}>
                      {{ trans('admin/custom_fields/general.show_in_email') }}
                  </label>
              </div>

          </div>

          <!-- Show in View All Assets profile view  -->
          <div class="form-group {{ $errors->has('display_in_user_view') ? ' has-error' : '' }}"  id="display_in_user_view">
              <div class="col-md-8 col-md-offset-4">
                  <label for="display_in_user_view">
                      <input type="checkbox" name="display_in_user_view" aria-label="display_in_user_view" value="1" class="minimal"{{ (old('display_in_user_view') || $field->display_in_user_view) ? ' checked="checked"' : '' }}>
                      {{ trans('admin/custom_fields/general.display_in_user_view') }}
                  </label>
              </div>

          </div>

          <!-- Value Must be Unique -->
          <div class="form-group {{ $errors->has('is_unique') ? ' has-error' : '' }}"  id="is_unique">
            <div class="col-md-8 col-md-offset-4">
                <label for="is_unique">
                    <input type="checkbox" name="is_unique" aria-label="is_unique" value="1" class="minimal"{{ (old('is_unique') || $field->is_unique) ? ' checked="checked"' : '' }}>
                    {{ trans('admin/custom_fields/general.is_unique') }}
                </label>
            </div>

        </div>


      @if (!$field->id)
        <!-- Encrypted  -->
        <div class="form-group {{ $errors->has('encrypted') ? ' has-error' : '' }}">
          <div class="col-md-8 col-md-offset-4">
            <label for="field_encrypted">
              <input type="checkbox" value="1" name="field_encrypted" id="field_encrypted" class="minimal"{{ (Request::old('field_encrypted') || $field->field_encrypted) ? ' checked="checked"' : '' }}>
              {{ trans('admin/custom_fields/general.encrypt_field') }}
            </label>
          </div>
          <div class="col-md-6 col-md-offset-4" id="encrypt_warning" style="display:none;">

              <div class="callout callout-danger">
                <p><i class="fas fa-exclamation-triangle" aria-hidden="true"></i> {{ trans('admin/custom_fields/general.encrypt_field_help') }}</p>
            </div>
          </div>
        </div>
      @endif

      </div> <!-- /.box-body-->

      <div class="box-footer text-right">
        <button type="submit" class="btn btn-primary"> {{ trans('general.save') }}</button>
      </div>

    </div> <!--.box.box-default-->

      {{ Form::close() }}
  </div> <!--/.col-md-9-->

  <div class="col-md-3">
    <h2>{{ trans('admin/custom_fields/general.about_custom_fields_title') }}</h2>
    <p>{{ trans('admin/custom_fields/general.about_custom_fields_text') }}</p>
  </div>
  
</div>
@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">
    $(document).ready(function(){
        // Only display the custom format field if it's a custom format validation type
        $(".format").change(function(){
            $(this).find("option:selected").each(function(){
                if ($('.format').prop("selectedIndex") == 1) {
                    $("#custom_regex").show();
                } else{
                    $("#custom_regex").hide();
                }
            });
        }).change();

        // If the element is a radiobutton/checkbox, doesn't show the format input box
        $(".field_element").change(function(){
            $(this).find("option:selected").each(function(){
                if (($(this).attr("value") != "radio") && ($(this).attr("value") != "checkbox")){
                    $("#format_values").show();
                } else{
                    $("#format_values").hide();
                }
            });
        }).change();

        // Only display the field element if the type is not text
        $(".field_element").change(function(){
            $(this).find("option:selected").each(function(){
                if (($(this).attr("value")!="text") && ($(this).attr("value")!="textarea")){
                    $("#field_values_text").show();
                } else{
                    $("#field_values_text").hide();
                }
            });
        }).change();
    });

    // Checkbox handling
    $('#field_encrypted').on('ifChecked', function(event){
        $("#encrypt_warning").show();
        $("#show_in_email").hide();
        $("#display_in_user_view").hide();
    });

    $('#field_encrypted').on('ifUnchecked', function(event){
        $("#encrypt_warning").hide();
        $("#show_in_email").show();
        $("#display_in_user_view").show();
    });

</script>
@stop
