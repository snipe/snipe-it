@extends('layouts/default')
{{-- Page title --}}
@section('title')
  {{ trans('admin/custom_fields/general.create_field') }}
@parent
@stop

@section('content')

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
<div class="col-md-9">
  <!-- Horizontal Form -->
    <div class="box box-default">
      <div class="box-body">


        {{ Form::open(['route' => 'admin.custom_fields.store-field', 'class'=>'form-horizontal']) }}


          <!-- Name -->
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name" class="col-md-4 control-label">{{ trans('admin/custom_fields/general.field_name') }} </label>
               </label>
                  <div class="col-md-6 required">
                    <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name') }}" />
                    {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <!-- Element Type -->
          <div class="form-group {{ $errors->has('element') ? ' has-error' : '' }}">
              <label for="element" class="col-md-4 control-label">{{ trans('admin/custom_fields/general.field_element') }}</label>
               </label>
                  <div class="col-md-6 required">

                  {!! Form::customfield_elements('element', Input::old('element'), 'field_element select2 form-control') !!}
                  {!! $errors->first('element', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}

                  </div>
          </div>

            <!-- Element values -->
            <div class="form-group {{ $errors->has('element') ? ' has-error' : '' }}" id="field_values_text" style="display:none;">
                <label for="field_values" class="col-md-4 control-label">{{ trans('admin/custom_fields/general.field_values') }}</label>
                </label>
                <div class="col-md-6 required">

                    {!! Form::textarea('field_values', Input::old('field_values'), ['style' => 'width: 100%', 'rows' => 4, 'class' => 'form-control']) !!}
                    {!! $errors->first('field_values', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}

                    <p class="help-block">{{ trans('admin/custom_fields/general.field_values_help') }}</p>
                </div>


            </div>

          <!-- Format -->
          <div class="form-group {{ $errors->has('format') ? ' has-error' : '' }}">
              <label for="format" class="col-md-4 control-label">{{ trans('admin/custom_fields/general.field_format') }}</label>
               </label>
                  <div class="col-md-6 required">
                    {{ Form::select("format",\App\Helpers\Helper::predefined_formats(),"ANY", array('class'=>'format select2 form-control')) }}
                    {!! $errors->first('format', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <!-- Custom Format -->
          <div class="form-group {{ $errors->has('custom_format') ? ' has-error' : '' }}" id="custom_regex" style="display:none;">
              <label for="custom_format" class="col-md-4 control-label">{{ trans('admin/custom_fields/general.field_custom_format') }}
              </label>
                  <div class="col-md-6 required">
                    <input class="form-control" type="text" name="custom_format" id="custom_format" value="{{ Input::old('custom_format') }}" />
                    {!! $errors->first('custom_format', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

            <!-- Encrypted  -->
            <div class="form-group {{ $errors->has('custom_format') ? ' has-error' : '' }}">
                <div class="col-md-8 col-md-offset-4">
                    <label for="field_encrypted">
                        <input type="checkbox" value="1" name="field_encrypted" id="field_encrypted" class="minimal"{{ Input::old('field_encrypted') ? ' checked="checked"' : '' }}> {{ trans('admin/custom_fields/general.encrypt_field') }}
                    </label>
                </div>

                <div class="col-md-6 col-md-offset-4" id="encrypt_warning" style="display:none;">
                    <div class="callout callout-danger">
                        <p><i class="fa fa-warning"></i> {{ trans('admin/custom_fields/general.encrypt_field_help') }}</p>
                    </div>

                </div>
            </div>


         </div>
        <div class="box-footer text-right">
            <button type="submit" class="btn btn-success"> {{ trans('general.save') }}</button>
        </div>
  </div>
</div>
    {{ Form::close() }}
<div class="col-md-3">
<h4>About Custom Fields</h4>
<p>Custom fields allow you to add arbitrary attributes to assets.</p>
</div>

@section('moar_scripts')
        <script>


            $(document).ready(function(){

                // Only display the custom format field if it's a custom format validation type
                $(".format").change(function(){
                    $(this).find("option:selected").each(function(){
                        //console.warn($(this).attr("value"));
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
                        //console.warn($(this).attr("value"));
                        if($(this).attr("value")!="text"){
                            $("#field_values_text").show();
                        } else{
                            $("#field_values_text").hide();
                        }
                    });
                }).change();
            });

            // Checkbox handling
            $('div.icheckbox_minimal-blue').on('ifChecked', function(event){
                $("#encrypt_warning").show();
            });

            $('div.icheckbox_minimal-blue').on('ifUnchecked', function(event){
                $("#encrypt_warning").hide();
            });

        </script>
@stop


@stop
