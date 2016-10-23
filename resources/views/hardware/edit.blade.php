@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($asset->id)
    	{{ trans('admin/hardware/form.update') }}
    @else
    	{{ trans('admin/hardware/form.create') }}
    @endif
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>
@stop



{{-- Page content --}}

@section('content')



<div class="row">
  <div class="col-md-8 col-md-offset-2">
    @if ($asset->id)
     <form id="create-form" class="form-horizontal" method="post" action="{{ route('update/hardware',$asset->id) }}" autocomplete="off" role="form" enctype="multipart/form-data">
   @else
     <form id="create-form" class="form-horizontal" method="post" action="{{ route('savenew/hardware') }}" autocomplete="off" role="form" enctype="multipart/form-data">
   @endif



    <div class="box box-default">
      @if ($asset->id)
        <div class="box-header with-border">
          <h3 class="box-title">{{ $asset->showAssetName() }}</h3>
        </div><!-- /.box-header -->
      @endif

      <div class="box-body">

       <!-- CSRF Token -->
       <input type="hidden" name="_token" value="{{ csrf_token() }}" />

       <!-- Asset Tag -->
       <div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
           <label for="asset_tag" class="col-md-3 control-label">{{ trans('admin/hardware/form.tag') }}</label>
            </label>
               <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($asset, 'asset_tag')) ? ' required' : '' }}">
                   @if  ($asset->id)
                         <input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{ Input::old('asset_tag', $asset->asset_tag) }}" />
                   @else
                         <input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{ Input::old('asset_tag', \App\Models\Asset::autoincrement_asset()) }}">
                   @endif

                {!! $errors->first('asset_tag', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
               </div>
       </div>

       <!-- Model -->
       <div class="form-group {{ $errors->has('model_id') ? ' has-error' : '' }}">
           <label for="parent" class="col-md-3 control-label">{{ trans('admin/hardware/form.model') }}</label>
            </label>
           <div class="col-md-7 col-sm-10{{  (\App\Helpers\Helper::checkIfRequired($asset, 'model_id')) ? ' required' : '' }}">
               @if (isset($selected_model))
                   {{ Form::select('model_id', $model_list , $selected_model->id, array('class'=>'select2 model', 'style'=>'width:100%','id' =>'model_select_id')) }}

               @else
                   {{ Form::select('model_id', $model_list , Input::old('model_id', $asset->model_id), array('class'=>'select2 model', 'style'=>'width:100%','id' =>'model_select_id')) }}
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
         @if ($asset->model && $asset->model->fieldset)
           <?php $model=$asset->model; ?>
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

       <!-- Status -->
       <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
           <label for="status_id" class="col-md-3 control-label">{{ trans('admin/hardware/form.status') }}</label>
               <div class="col-md-7 col-sm-11{{  (\App\Helpers\Helper::checkIfRequired($asset, 'status_id')) ? ' required' : '' }}">
                   {{ Form::select('status_id', $statuslabel_list , Input::old('status_id', $asset->status_id), array('class'=>'select2 status_id', 'style'=>'width:100%','id'=>'status_select_id')) }}



                   {!! $errors->first('status_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
               </div>
               <div class="col-md-1 col-sm-1 text-left">
                 <a href='#' data-toggle="modal"  data-target="#createModal" data-dependency='statuslabel' data-select='status_select_id' class="btn btn-sm btn-default">New</a>
                 <span class="status_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin"></i> </span>
               </div>
                <div class="col-md-7 col-sm-11 col-md-offset-3">
                    <p class="help-block">{{ trans('admin/hardware/form.help_checkout') }}</p>
               </div>
       </div>

       @if (!$asset->id)
        <!-- Assigned To -->
       <div id="assigned_user" style="display: none;" class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
           <label for="parent" class="col-md-3 control-label">{{ trans('admin/hardware/form.checkout_to') }}
            </label>
           <div class="col-md-7 col-sm-12">
               {{ Form::select('assigned_to', $assigned_to , Input::old('assigned_to', $asset->assigned_to), array('class'=>'select2', 'id'=>'assigned_to', 'style'=>'width:100%')) }}

               {!! $errors->first('assigned_to', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
           </div>
           <div class="col-md-1 col-sm-1 text-left" style="margin-left: -20px; padding-top: 3px">
              <a href='#' data-toggle="modal"  data-target="#createModal" data-dependency="user" data-select='assigned_to' class="btn btn-sm btn-default">New</a>
          </div>
       </div>
       @endif


       <!-- Serial -->
       <div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
           <label for="serial" class="col-md-3 control-label">{{ trans('admin/hardware/form.serial') }} </label>
           <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($asset, 'serial')) ? ' required' : '' }}">
               <input class="form-control" type="text" name="serial" id="serial" value="{{ Input::old('serial', $asset->serial) }}" />
               {!! $errors->first('serial', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
           </div>
       </div>

       <!-- Asset Name -->
       <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
           <label for="name" class="col-md-3 control-label">{{ trans('admin/hardware/form.name') }}</label>
               <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($asset, 'name')) ? ' required' : '' }}">
                   <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $asset->name) }}" />
                   {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
               </div>
       </div>


       <!-- Company -->
       @if (\App\Models\Company::isCurrentUserAuthorized())
         <div class="form-group {{ $errors->has('company_id') ? ' has-error' : '' }}">
           <div class="col-md-3 control-label">{{ Form::label('company_id', trans('general.company')) }}</div>
           <div class="col-md-7 col-sm-12{{  (\App\Helpers\Helper::checkIfRequired($asset, 'company_id')) ? ' required' : '' }}">
             {{ Form::select('company_id', $company_list , Input::old('company_id', $asset->company_id),
                             ['class'=>'select2', 'style'=>'width:100%']) }}
             {!! $errors->first('company_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
           </div>
         </div>
       @endif

       <!-- Purchase Date -->
       <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
           <label for="purchase_date" class="col-md-3 control-label">{{ trans('admin/hardware/form.date') }}</label>
           <div class="input-group col-md-3">
             <div class="input-group">

                 <input type="text" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" name="purchase_date" id="purchase_date" value="{{ Input::old('purchase_date', $asset->purchase_date) }}">
                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
               </div><!-- /.input group -->


               {!! $errors->first('purchase_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
           </div>
       </div>
       <!-- Supplier -->
       <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
           <label for="supplier_id" class="col-md-3 control-label">{{ trans('admin/hardware/form.supplier') }}</label>
           <div class="col-md-7 col-sm-11">
               {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $asset->supplier_id), array('class'=>'select2', 'style'=>'width:100%','id'=>'supplier_select_id')) }}

               {!! $errors->first('supplier_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
           </div>
           <div class="col-md-1 col-sm-1 text-left">
             <a href='#' data-toggle="modal"  data-target="#createModal" data-dependency="supplier" data-select='supplier_select_id' class="btn btn-sm btn-default">New</a>
           </div>
       </div>

       <!-- Order Number -->
       <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
           <label for="order_number" class="col-md-3 control-label">{{ trans('admin/hardware/form.order') }}</label>
           <div class="col-md-7 col-sm-12">
               <input class="form-control" type="text" name="order_number" id="order_number" value="{{ Input::old('order_number', $asset->order_number) }}" />
               {!! $errors->first('order_number', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
           </div>
       </div>

       <!-- Purchase Cost -->
       <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
               <label for="purchase_cost" class="col-md-3 control-label">{{ trans('admin/hardware/form.cost') }} </label>
               <div class="col-md-2">
                       <div class="input-group">
                               <span class="input-group-addon">
                                   @if (($asset->id) && ($asset->assetloc))
                                       {{ $asset->assetloc->currency }}
                                   @else
                                       {{ \App\Models\Setting::first()->default_currency }}
                                   @endif


                               </span>
                               <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', \App\Helpers\Helper::formatCurrencyOutput($asset->purchase_cost)) }}" />
                               {!! $errors->first('purchase_cost', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                        </div>
                </div>
       </div>

       <!-- Warranty -->
       <div class="form-group {{ $errors->has('warranty_months') ? ' has-error' : '' }}">
           <label for="warranty_months" class="col-md-3 control-label">{{ trans('admin/hardware/form.warranty') }}</label>
           <div class="col-md-9">

               <div class="input-group col-md-3" style="padding-left: 0px;">
                 <input class="form-control" type="text" name="warranty_months" id="warranty_months" value="{{ Input::old('warranty_months', $asset->warranty_months) }}" />
                 <span class="input-group-addon">{{ trans('admin/hardware/form.months') }}</span>
               </div>
               <div class="col-md-9" style="padding-left: 0px;">
                 {!! $errors->first('warranty_months', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
               </div>


           </div>
       </div>



       <!-- Notes -->
       <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
           <label for="notes" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
           <div class="col-md-7 col-sm-12">
               <textarea class="col-md-6 form-control" id="notes" name="notes">{{ Input::old('notes', $asset->notes) }}</textarea>
               {!! $errors->first('notes', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
           </div>
       </div>

       <!-- Default Location -->
       <div class="form-group {{ $errors->has('rtd_location_id') ? ' has-error' : '' }}">
           <label for="rtd_location_id" class="col-md-3 control-label">{{ trans('admin/hardware/form.default_location') }}</label>
               <div class="col-md-7 col-sm-11">
                   {{ Form::select('rtd_location_id', $location_list , Input::old('rtd_location_id', $asset->rtd_location_id), array('class'=>'select2', 'style'=>'width:100%','id'=>'rtd_location_select')) }}

                   {!! $errors->first('rtd_location_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
               </div>
               <div class="col-md-1 col-sm-1 text-left">
                 <a href='#' data-toggle="modal" data-target="#createModal" data-dependency='location' data-select='rtd_location_select' class="btn btn-sm btn-default">New</a>
               </div>
       </div>

       <!-- Requestable -->
       <div class="form-group">
         <div class="col-sm-offset-3 col-sm-10">
           <label>
             <input type="checkbox" value="1" name="requestable" id="requestable" class="minimal" {{ Input::old('requestable', $asset->requestable) == '1' ? ' checked="checked"' : '' }}> {{ trans('admin/hardware/form.requestable') }}
           </label>

         </div>
         </div>



       <!-- Image -->
       @if ($asset->image)
           <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
               <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
               <div class="col-md-5">
                   {{ Form::checkbox('image_delete'),array('class' => 'minimal') }}
                   <img src="{{ config('app.url') }}/uploads/assets/{{ $asset->image }}" />
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



      </div><!-- /.box-body -->
      <div class="box-footer text-right">
        <a class="btn btn-link" href="{{ URL::previous() }}" method="post" enctype="multipart/form-data">{{ trans('button.cancel') }}</a>
        <button type="submit" class="btn btn-success" id="submit-button"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div><!-- /.box-footer -->
    </div><!-- /.box -->


    </form>
    </div>
</div>


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
      show_er('#modal-modelno');
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
@stop
