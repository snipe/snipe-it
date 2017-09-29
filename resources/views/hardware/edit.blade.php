
@extends('layouts/edit-form', [
    'createText' => trans('admin/hardware/form.create'),
    'updateText' => trans('admin/hardware/form.update'),
    'helpTitle' => trans('admin/hardware/general.about_assets_title'),
    'helpText' => trans('admin/hardware/general.about_assets_text'),
    'formAction' => ($item) ? route('hardware.update', ['hardware' => $item->id]) : route('hardware.store'),
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
      {{ Form::select('model_id', $model_list , $selected_model->id, array('class'=>'select2 model', 'style'=>'width:100%','id' => 'model_select_id', 'id' =>'model_select_id')) }}
      @else
      {{ Form::select('model_id', $model_list , Input::old('model_id', $item->model_id), array('class'=>'select2 model', 'id' => 'model_select_id', 'style'=>'width:100%','id' =>'model_select_id')) }}
      @endif
      <!-- onclick="return dependency('model')" -->
      {!! $errors->first('model_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
    <div class="col-md-1 col-sm-1 text-left">
        <a href='{{ route('modal.model') }}' data-toggle="modal" data-target="#createModal" data-dependency="model" data-select="model_select_id" class="btn btn-sm btn-default">New</a>
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
  <div id="assigned_user" style="display: none;" class="form-group {{ $errors->has('assigned_user') ? ' has-error' : '' }}">
    <label for="parent" class="col-md-3 control-label">
      {{ trans('admin/hardware/form.checkout_to') }}
    </label>
    <div class="col-md-7 col-sm-12">
      {{ Form::select('assigned_user', $users_list , Input::old('assigned_user', $item->assigned_type == 'App\Models\User' ? $item->assigned_to : 0), array('class'=>'select2', 'id'=>'assigned_user', 'style'=>'width:100%')) }}
      {!! $errors->first('assigned_user', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
    <div class="col-md-1 col-sm-1 text-left" style="margin-left: -20px; padding-top: 3px">
        @can('users.create')
      <a href='{{ route('modal.user') }}' data-toggle="modal"  data-target="#createModal" data-dependency="user" data-select='assigned_user' class="btn btn-sm btn-default">New</a>
        @endcan
    </div>
  </div>

  <!-- Assets -->
  <div id="assigned_asset" style="display: none;" class="form-group{{ $errors->has('assigned_asset') ? ' has-error' : '' }}">
    {{ Form::label('assigned_asset', trans('admin/hardware/form.checkout_to'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
      {{ Form::select('assigned_asset', $assets_list , Input::old('assigned_asset', $item->assigned_type == 'App\Models\Asset' ? $item->assigned_to : 0), array('class'=>'select2', 'id'=>'assigned_asset', 'style'=>'width:100%')) }}
      {!! $errors->first('assigned_asset', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>

  </div>

  <!-- Locations -->
  <div id="assigned_location" style="display: none;" class="form-group{{ $errors->has('assigned_location') ? ' has-error' : '' }}">
    {{ Form::label('assigned_location', trans('admin/hardware/form.checkout_to'), array('class' => 'col-md-3 control-label')) }}
    <div class="col-md-7">
      {{ Form::select('assigned_location', $locations_list , Input::old('assigned_location', $item->assigned_type == 'App\Models\Asset' ? $item->assigned_to : 0), array('class'=>'select2', 'id'=>'assigned_location', 'style'=>'width:100%')) }}

      {!! $errors->first('assigned_location', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
    </div>
    <div class="col-md-1 col-sm-1 text-left">
      <a href='{{ route('modal.location') }}' data-toggle="modal"  data-target="#createModal" data-dependency="location" data-select='assigned_location' class="btn btn-sm btn-default">New</a>
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
      {{ Form::select('rtd_location_id', $locations_list , Input::old('rtd_location_id', $item->rtd_location_id), array('class'=>'select2', 'style'=>'width:100%','id'=>'rtd_location_select')) }}

      {!! $errors->first('rtd_location_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
      </div>
      <div class="col-md-1 col-sm-1 text-left">
        <a href='{{ route('modal.location') }}' data-toggle="modal" data-target="#createModal" data-dependency='location' data-select='rtd_location_select' class="btn btn-sm btn-default">New</a>
      </div>
  </div>

  @include ('partials.forms.edit.requestable', ['requestable_text' => trans('admin/hardware/general.requestable')])

  <!-- Image -->
  @if ($item->image)
  <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
      <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
      <div class="col-md-5">
          <label class="control-label" for="image_delete">
          <input type="checkbox" value="1" name="image_delete" id="image_delete" class="minimal" {{ Input::old('image_delete') == '1' ? ' checked="checked"' : '' }}>
          {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
          </label>
          <div style="margin-top: 0.5em">
              <img src="{{ url('/') }}/uploads/assets/{{ $item->image }}" class="img-responsive"/>
          </div>
      </div>
  </div>
  @endif

  <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
    <div class="col-md-5">
      <input type="file" id="file-upload" accept="image/*" name="image">
      {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
    </div>
  </div>

@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">



    function fetchCustomFields() {
        var modelid = $('#model_select_id').val();
        if (modelid == '') {
            $('#custom_fields_content').html("");
        } else {

            $.ajax({
                type: 'GET',
                url: "{{url('/') }}/models/" + modelid + "/custom_fields",
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                _token: "{{ csrf_token() }}",
                dataType: 'html',
                success: function (data) {
                    data: data,
                    $('#custom_fields_content').html(data);
                }
            });
        }
    }

    function user_add(status_id) {

        if (status_id != '') {
            $(".status_spinner").css("display", "inline");
            $.ajax({
                url: "{{url('/') }}/api/v1/statuslabels/" + status_id + "/deployable",
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $(".status_spinner").css("display", "none");

                    if (data == true) {
                        $("#assigned_user").css("display", "block");
                        $("#assigned_location").css("display", "block");
                        $("#assigned_asset").css("display", "block");
                    } else {
                        $("#assigned_user").css("display", "none");
                        $("#assigned_location").css("display", "none");
                        $("#assigned_asset").css("display", "none");
                    }
                }
            });
        }
    }
    ;

    $(function () {
        //grab custom fields for this model whenever model changes.
        $('#model_select_id').on("change", fetchCustomFields);

        //initialize assigned user/loc/asset based on statuslabel's statustype
        user_add($(".status_id option:selected").val());

        //whenever statuslabel changes, update assigned user/loc/asset
        $(".status_id").on("change", function () {
            user_add($(".status_id").val());
        });

        $("form").submit(function (event) {
            event.preventDefault();
            return sendForm();
        });

        // Resize Files when chosen
        //First check to see if there is a file before doing anything else

        var imageData = "";
        var $fileInput = $('#file-upload');
        $fileInput.on('change', function (e) {
            if ($fileInput != '') {
                if (window.File && window.FileReader && window.FormData) {
                    var file = e.target.files[0];
                    if (file) {
                        if (/^image\//i.test(file.type)) {
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

            reader.onloadend = function () {
                processFile(reader.result, file.type);
            }

            reader.onerror = function () {
                alert("Unable to read file");
            }

            reader.readAsDataURL(file);
        }

        function processFile(dataURL, fileType) {
            var maxWidth = 800;
            var maxHeight = 800;

            var image = new Image();
            image.src = dataURL;

            image.onload = function () {
                var width = image.width;
                var height = image.height;
                var shouldResize = (width > maxWidth) || (height > maxHeight);

                if (!shouldResize) {
                    imageData = dataURL;
                    return;
                }

                var newWidth;
                var newHeight;

                if (width > height) {
                    newHeight = height * (maxWidth / width);
                    newWidth = maxWidth;
                } else {
                    newWidth = width * (maxHeight / height);
                    newHeight = maxHeight;
                }
                var canvas = document.createElement('canvas');

                canvas.width = newWidth;
                canvas.height = newHeight;

                var context = canvas.getContext('2d');

                context.drawImage(this, 0, 0, newWidth, newHeight);

                dataURL = canvas.toDataURL(fileType);

                imageData = dataURL;

            };

            image.onerror = function () {
                alert('Unable to process file :(');
            }
        }

        function sendForm() {
            var form = $("#create-form").get(0);
            var formData = $('#create-form').serializeArray();
            formData.push({name: 'image', value: imageData});
            $.ajax({
                type: 'POST',
                url: form.action,
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                dataType: 'json',
                success: function (data) {
                    // console.dir(data);
                    // AssetController flashes success to session, redirect to hardware page.
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                        return true;
                    }
                    window.location.reload(true);
                    return false;

                },
                error: function (data) {
                    // AssetRequest Validator will flash all errors to session, this just refreshes to see them.
                    window.location.reload(true);
                    // console.log(JSON.stringify(data));
                    // console.log('error submitting');
                }
            });

            return false;
        }

    });
</script>
@stop
