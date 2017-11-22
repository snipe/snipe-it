
@extends('layouts/edit-form', [
    'createText' => trans('admin/hardware/form.create'),
    'updateText' => trans('admin/hardware/form.update'),
    'helpTitle' => trans('admin/hardware/general.about_assets_title'),
    'helpText' => trans('admin/hardware/general.about_assets_text'),
    'formAction' => ($item) ? route('hardware.update', ['hardware' => $item->id]) : route('hardware.store'),
])


{{-- Page content --}}

@section('inputFields')

    @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])
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

    @include ('partials.forms.edit.model-select', ['translated_name' => trans('admin/hardware/form.model'), 'fieldname' => 'model_id'])


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
      @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true', 'style' => 'display:none;'])

      @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_user', 'style' => 'display:none;', 'required' => 'false'])

  @include ('partials.forms.edit.asset-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_asset', 'style' => 'display:none;', 'required' => 'false'])

  @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required' => 'false'])
  @endif

  @include ('partials.forms.edit.serial', ['translated_serial' => trans('admin/hardware/form.serial')])
  @include ('partials.forms.edit.name', ['translated_name' => trans('admin/hardware/form.name')])
  @include ('partials.forms.edit.purchase_date')
  @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])
  @include ('partials.forms.edit.order_number')
    <?php
    $currency_type=null;
    if ($item->id && $item->location) {
        $currency_type = $item->location->currency;
    }
    ?>
  @include ('partials.forms.edit.purchase_cost', ['currency_type' => $currency_type])
  @include ('partials.forms.edit.warranty')
  @include ('partials.forms.edit.notes')

  @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.default_location'), 'fieldname' => 'rtd_location_id'])


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
                    $("#selected_status_status").fadeIn();

                    if (data == true) {
                        $("#assignto_selector").show();
                        $("#assigned_user").show();

                        $("#selected_status_status").removeClass('text-danger');
                        $("#selected_status_status").addClass('text-success');
                        $("#selected_status_status").html('<i class="fa fa-check"></i> That status is deployable. This asset can be checked out.');


                    } else {
                        $("#assignto_selector").hide();
                        $("#selected_status_status").removeClass('text-success');
                        $("#selected_status_status").addClass('text-danger');
                        $("#selected_status_status").html('<i class="fa fa-times"></i> That asset status is not deployable. This asset cannot be checked out. ');
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
