
@extends('layouts/edit-form', [
    'createText' => trans('admin/hardware/form.create'),
    'updateText' => trans('admin/hardware/form.update'),
    'helpTitle' => trans('admin/hardware/general.about_assets_title'),
    'helpText' => trans('admin/hardware/general.about_assets_text')
])


{{-- Page content --}}

@section('inputFields')

@include ('partials.forms.edit.company')
<!-- Asset Tag -->
<div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
    <label for="asset_tag" class="col-md-3 control-label">{{ trans('admin/hardware/form.tag') }}</label>
<div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($item, 'asset_tag')) ? ' required' : '' }}">
    @if  ($item->id)
    <input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{ Input::old('asset_tag', $item->asset_tag) }}" />
    @else
    <input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{ Input::old('asset_tag', \App\Models\Asset::autoincrement_asset()) }}">
    @endif

    {!! $errors->first('asset_tag', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
</div>
</div>

<!-- Model -->
<div class="form-group {{ $errors->has('model_id') ? ' has-error' : '' }}">
    <label for="parent" class="col-md-3 control-label">{{ trans('admin/hardware/form.model') }}</label>
<div class="col-md-7 col-sm-10{{  (\App\Helpers\Helper::checkIfRequired($item, 'model_id')) ? ' required' : '' }}">
    @if (isset($selected_model))
    {{ Form::select('model_id', $model_list , $selected_model->id, array('class'=>'select2 model', 'style'=>'width:100%','id' =>'model_select_id')) }}

    @else
    {{ Form::select('model_id', $model_list , Input::old('model_id', $item->model_id), array('class'=>'select2 model', 'style'=>'width:100%','id' =>'model_select_id')) }}
    @endif

    <!-- onclick="return dependency('model')" -->
    {!! $errors->first('model_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}

</div>
<div class="col-md-1 col-sm-1 text-left">
    <a href='#' data-toggle="modal" data-target="#createModal" data-dependency="model" data-select="model_select_id" class="btn btn-sm btn-default">New</a>
    <span class="mac_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin"></i> </span>
</div>
</div>


<div id='custom_fields_content'>
    <!-- Custom Fields -->
    @if ($item->model && $item->model->fieldset)
    <?php $model=$item->model; ?>
    @endif
    @if (Input::old('model_id'))
    <?php $model=\App\Models\AssetModel::find(Input::old('model_id')); ?>
    @elseif (isset($selected_model))
    <?php $model=$selected_model; ?>
    @endif
    @if (isset($model) && $model)
    @include("models/custom_fields_form",["model" => $model])
    @endif
</div>

@include ('partials.forms.edit.status')

@if (!$item->id)
<!-- Assigned To -->
<div id="assigned_user" style="display: none;" class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
    <label for="parent" class="col-md-3 control-label">{{ trans('admin/hardware/form.checkout_to') }}
    </label>
    <div class="col-md-7 col-sm-12">
        {{ Form::select('assigned_to', $assigned_to , Input::old('assigned_to', $item->assigned_to), array('class'=>'select2', 'id'=>'assigned_to', 'style'=>'width:100%')) }}

        {!! $errors->first('assigned_to', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
    <div class="col-md-1 col-sm-1 text-left" style="margin-left: -20px; padding-top: 3px">
        <a href='#' data-toggle="modal"  data-target="#createModal" data-dependency="user" data-select='assigned_to' class="btn btn-sm btn-default">New</a>
    </div>
</div>
@endif

@include ('partials.forms.edit.serial', ['translated_serial' => trans('admin/hardware/form.serial')])
@include ('partials.forms.edit.name', ['translated_name' => trans('admin/hardware/form.name')])
@include ('partials.forms.edit.purchase_date')
@include ('partials.forms.edit.supplier')
@include ('partials.forms.edit.order_number')
<?php
$currency_type=null;
if ($item->id && $item->assetloc) {
    $currency_type = $item->assetloc->currency;
}
?>
@include ('partials.forms.edit.purchase_cost', ['currency_type' => $currency_type])
@include ('partials.forms.edit.warranty')
@include ('partials.forms.edit.notes')

<!-- Default Location -->
<div class="form-group {{ $errors->has('rtd_location_id') ? ' has-error' : '' }}">
    <label for="rtd_location_id" class="col-md-3 control-label">{{ trans('admin/hardware/form.default_location') }}</label>
    <div class="col-md-7 col-sm-11">
        {{ Form::select('rtd_location_id', $location_list , Input::old('rtd_location_id', $item->rtd_location_id), array('class'=>'select2', 'style'=>'width:100%','id'=>'rtd_location_select')) }}

        {!! $errors->first('rtd_location_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
    <div class="col-md-1 col-sm-1 text-left">
        <a href='#' data-toggle="modal" data-target="#createModal" data-dependency='location' data-select='rtd_location_select' class="btn btn-sm btn-default">New</a>
    </div>
</div>

@include ('partials.forms.edit.requestable', ['requestable_text' => trans('admin/hardware/general.requestable')])

<!-- Image -->
@if ($item->image)
<div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
    <div class="col-md-5">
        {{ Form::checkbox('image_delete'),array('class' => 'minimal') }}
        <img src="{{ config('app.url') }}/uploads/assets/{{ $item->image }}" />
        {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>
@endif

<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
    <div class="col-md-5">
        <!-- {{ Form::file('image') }} -->
        <input type="file" id="file-upload" accept="image/*" name="image">
        {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>

@stop

@section('moar_scripts')
@include('partials/modals')
<script>

    function fetchCustomFields() {
      var modelid=$('#model_select_id').val();
      if(modelid=='') {
        $('#custom_fields_content').html("");
      } else {
        $.get("{{config('app.url') }}/hardware/models/"+modelid+"/custom_fields",{_token: "{{ csrf_token() }}"},function (data) {
          $('#custom_fields_content').html(data);
        });
      }
    }

    $(function() {
      $('#model_select_id').on("change",fetchCustomFields);
    });

    $(function() {
        user_add($(".status_id option:selected").val());
    });

	var $statusSelect = $(".status_id");
	$statusSelect.on("change", function () {
        user_add($statusSelect.val());
    });

	function user_add(status_id) {

        if(status_id!=''){
            $(".status_spinner").css("display", "inline");
    	    $.ajax({
    	        url: "{{config('app.url') }}/api/statuslabels/"+status_id+"/deployable",
    	        success: function(data) {
                    $(".status_spinner").css("display", "none");

    	            if(data == true){
    	                 $("#assigned_user").css("display", "block");
    	            } else {
    	                 $("#assigned_user").css("display", "none");
    	            }
                }
    	    });
        }
	};

$(function () {
  var model,select;

  $('#createModal').on("show.bs.modal",function (event) {
    var link = $(event.relatedTarget);
    model=link.data("dependency");
    select=link.data("select");

    var modal = $(this);
    modal.find('.modal-title').text('Add a new ' + model);

    $('.dynamic-form-row').hide();
    function show_er(selector) {
      //$(selector).show().parent().show();
      $(selector).parent().parent().show();
    }
    show_er('#modal-name');
    switch(model) {
      case 'model':
      show_er('#modal-manufacturer_id');
      show_er('#modal-category_id');
      show_er('#modal-model_number');
      show_er('#modal-fieldset_id');
      break;

      case 'user':
      $('.dynamic-form-row').hide(); //we don't want a generic "name"
      show_er("#modal-first_name");
      show_er("#modal-last_name");
      show_er("#modal-username");
      show_er("#modal-password");
      show_er("#modal-password_confirm");
      break;

      case 'location':
      show_er('#modal-city');
      show_er('#modal-country');
      break;

      case 'statuslabel':
      show_er("#modal-statuslabel_types");
      break;

      case 'supplier':

      //do nothing, they just need 'name'
    }

    //console.warn("The Model is: "+model+" and the select is: "+select);
  });

   $("form").submit( function(event) {
    event.preventDefault();
    return sendForm();
  });

  // Resize Files when chosen



    //First check to see if there is a file before doing anything else

    var imageData = "";
    var $fileInput = $('#file-upload'); 
    $fileInput.on('change', function(e) {
      if( $fileInput != '' ) {
        if(window.File && window.FileReader && window.FormData) {
          var file = e.target.files[0];
          if(file) {
            if(/^image\//i.test(file.type)) {
              readFile(file);
            } else {
              alert('Invalid Image File :(');
            }
          }
        }
        else {
          console.log("File API not supported, not resizing");
        } 
      }
    });


  function readFile(file) {
    var reader = new FileReader();

    reader.onloadend = function() {
      processFile(reader.result, file.type);
    }

    reader.onerror = function() { 
      alert("Unable to read file");
    }

    reader.readAsDataURL(file);
  }

  function processFile(dataURL, fileType) {
    var maxWidth = 800;
    var maxHeight = 800;

    var image = new Image();
    image.src = dataURL;

    image.onload = function() {
      var width = image.width;
      var height = image.height;
      var shouldResize = (width > maxWidth) || (height > maxHeight);

      if(!shouldResize) {
        imageData = dataURL;
        return;
      }

      var newWidth;
      var newHeight;

      if( width > height) {
        newHeight = height * (maxWidth/width);
        newWidth = maxWidth;
      } else {
        newWidth = width * (maxHeight/height);
        newHeight = maxHeight;
      }
      var canvas = document.createElement('canvas');

      canvas.width = newWidth;
      canvas.height = newHeight;

      var context = canvas.getContext('2d');

      context.drawImage(this, 0, 0, newWidth, newHeight);

      dataURL = canvas.toDataURL( fileType );

      imageData = dataURL;

    };

    image.onerror = function () {
      alert('Unable to process file :(');
    }
  }

  function sendForm() {
    var form = $("#create-form").get(0);
    var formData = $('#create-form').serializeArray();
    formData.push({name:'image', value:imageData});
    $.ajax({
      type: 'POST',
      url: form.action,
      headers:{"X-Requested-With": 'XMLHttpRequest'},
      data: formData,
      dataType: 'json',
      success: function(data) {
        // AssetController flashes success to session, redirect to hardware page.
         window.location.href = data.redirect_url;
         // console.dir(data);
         // console.log('submit was successful');
      },
      error: function(data) {
        // AssetRequest Validator will flash all errors to session, this just refreshes to see them.
        window.location.reload(true);
        // console.log(JSON.stringify(data));
         // console.log('error submitting');
      }
    });

    return false;
  }


  $('#modal-save').on('click',function () {
    var data={};
    //console.warn("We are about to SAVE!!! for model: "+model+" and select ID: "+select);
    $('.modal-body input:visible').each(function (index,elem) {
      //console.warn("["+index+"]: "+elem.id+" = "+$(elem).val());
      var bits=elem.id.split("-");
      if(bits[0]==="modal") {
        data[bits[1]]=$(elem).val();
      }
    });
    $('.modal-body select:visible').each(function (index,elem) {
      var bits=elem.id.split("-");
      data[bits[1]]=$(elem).val();
    });

    data._token =  '{{ csrf_token() }}',
    //console.dir(data);

    $.post("{{config('app.url') }}/api/"+model+"s",data,function (result) {
      var id=result.id;
      var name=result.name || (result.first_name+" "+result.last_name);
      $('.modal-body input:visible').val("");
      $('#createModal').modal('hide');

      //console.warn("The select ID thing we're going for is: "+select);
      var selector=document.getElementById(select);
      selector.options[selector.length]=new Option(name,id);
      selector.selectedIndex=selector.length-1;
      $(selector).trigger("change");
      fetchCustomFields();

    }).fail(function (result) {
      //console.dir(result.responseJSON);
      msg=result.responseJSON.error.message || result.responseJSON.error;
      window.alert("Unable to add new "+model+" - error: "+msg);
    });

  });
});
</script>

    <script src="{{ asset('assets/js/pGenerator.jquery.js') }}"></script>

    <script>


        $(document).ready(function(){

            $('#genPassword').pGenerator({
                'bind': 'click',
                'passwordElement': '#modal-password',
                'displayElement': '#generated-password',
                'passwordLength': 16,
                'uppercase': true,
                'lowercase': true,
                'numbers':   true,
                'specialChars': true,
                'onPasswordGenerated': function(generatedPassword) {
                    $('#modal-password_confirm').val($('#modal-password').val());
                }
            });
        });
    </script>
@stop
