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
                {{ Form::text('name', Input::old('name', $field->name), array('class' => 'form-control')) }}
                {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
          </div>

          <!-- Element Type -->
          <div class="form-group {{ $errors->has('element') ? ' has-error' : '' }}">
            <label for="element" class="col-md-4 control-label">
              {{ trans('admin/custom_fields/general.field_element') }}
            </label>
            <div class="col-md-6 required">

            {!! Form::customfield_elements('element', Input::old('element', $field->element), 'field_element select2 form-control') !!}
            {!! $errors->first('element', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}

            </div>
          </div>

          <!-- Element values -->
          <div class="form-group {{ $errors->has('element') ? ' has-error' : '' }}" id="field_values_text" style="display:none;">
            <label for="field_values" class="col-md-4 control-label">
              {{ trans('admin/custom_fields/general.field_values') }}
            </label>
            <div class="col-md-6 required">
              {!! Form::textarea('field_values', Input::old('name', $field->field_values), ['style' => 'width: 100%', 'rows' => 4, 'class' => 'form-control']) !!}
              {!! $errors->first('field_values', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              <p class="help-block">{{ trans('admin/custom_fields/general.field_values_help') }}</p>
            </div>
          </div>

          <!-- Format -->
          <div class="form-group {{ $errors->has('format') ? ' has-error' : '' }}">
            <label for="format" class="col-md-4 control-label">
              {{ trans('admin/custom_fields/general.field_format') }}
            </label>
            <div class="col-md-6 required">
              {{ Form::select("format",\App\Helpers\Helper::predefined_formats(), $field->format, array('class'=>'format select2 form-control')) }}
              {!! $errors->first('format', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
          </div>

          <!-- Custom Format -->
          <div class="form-group {{ $errors->has('custom_format') ? ' has-error' : '' }}" id="custom_regex" style="display:none;">
            <label for="custom_format" class="col-md-4 control-label">
              {{ trans('admin/custom_fields/general.field_custom_format') }}
            </label>
            <div class="col-md-6 required">

                {{ Form::text('custom_format', Input::old('custom_format', (($field->format!='') && (stripos($field->format,'regex')===0)) ? $field->format : ''), array('class' => 'form-control', 'id' => 'custom_format', 'placeholder'=>'regex:/^[0-9]{15}$/')) }}
                <p class="help-block">{!! trans('admin/custom_fields/general.field_custom_format_help') !!}</p>

              {!! $errors->first('custom_format', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}

            </div>
          </div>

          <!-- Help Text -->
          <div class="form-group {{ $errors->has('help_text') ? ' has-error' : '' }}">
              <label for="help_text" class="col-md-4 control-label">
                  Help Text
              </label>
              <div class="col-md-6">
                  {{ Form::text('help_text', Input::old('help_text', $field->help_text), array('class' => 'form-control')) }}
                  <p class="help-block">This is optional text that will appear below the form elements while editing an asset to provide context on the field.</p>
                  {!! $errors->first('help_text', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
              </div>
          </div>


      @if (!$field->id)

          <!-- Show in Email  -->
              <div class="form-group {{ $errors->has('show_in_email') ? ' has-error' : '' }}"  id="show_in_email">
                  <div class="col-md-8 col-md-offset-4">
                      <label for="field_encrypted">
                          <input type="checkbox" name="show_in_email"class="minimal"{{ (Input::old('show_in_email') || $field->show_in_email) ? ' checked="checked"' : '' }}>
                          {{ trans('admin/custom_fields/general.show_in_email') }}
                      </label>
                  </div>

              </div>


          <!-- Encrypted  -->
          <div class="form-group {{ $errors->has('encrypted') ? ' has-error' : '' }}">
            <div class="col-md-8 col-md-offset-4">
              <label for="field_encrypted">
                <input type="checkbox" value="1" name="field_encrypted" id="field_encrypted" class="minimal"{{ (Input::old('field_encrypted') || $field->field_encrypted) ? ' checked="checked"' : '' }}>
                {{ trans('admin/custom_fields/general.encrypt_field') }}
              </label>
            </div>

            <div class="col-md-6 col-md-offset-4" id="encrypt_warning" style="display:none;">
              <div class="callout callout-danger">
                <p><i class="fa fa-warning"></i> {{ trans('admin/custom_fields/general.encrypt_field_help') }}</p>
              </div>
            </div>
          </div>
          @endif


      </div> <!-- /.box-body-->
      <div class="box-footer text-right">
        <button type="submit" class="btn btn-success"> {{ trans('general.save') }}</button>
      </div>
    </div> <!--.box.box-default-->
      {{ Form::close() }}
  </div> <!--/.col-md-9-->
  <div class="col-md-3">
    <h4>About Custom Fields</h4>
    <p>Custom fields allow you to add arbitrary attributes to assets.</p>
  </div>
</div>
@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">
    $(document).ready(function(){

        // Initialize selected index of the format dropdown
        // If the custom_regex is ever NOT the last element in the format
        // listbox, we will need to refactor this.
        if ($('#custom_format').val()!='') {
            // console.log('value is ' + $('#custom_format').val());
            $('.format').prop('selectedIndex', $('.format')[0].options.length - 1);
        }


        // Only display the custom format field if it's a custom format validation type
        $(".format").change(function(){
            $(this).find("option:selected").each(function(){
                if (($(this).attr("value")=="") &&  $('.format').prop("selectedIndex") != 0) {
                    $("#custom_regex").show();
                } else{
                    $("#custom_regex").hide();
                }
            });
        }).change();

        // Only display the field element if the type is not text
        $(".field_element").change(function(){
            $(this).find("option:selected").each(function(){
                if($(this).attr("value")!="text"){
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
    });

    $('#field_encrypted').on('ifUnchecked', function(event){
        $("#encrypt_warning").hide();
        $("#show_in_email").show();
    });

</script>
@stop
