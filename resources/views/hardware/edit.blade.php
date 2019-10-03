
@extends('layouts/edit-form', [
    'createText' => trans('admin/hardware/form.create'),
    'updateText' => trans('admin/hardware/form.update'),
    'topSubmit' => true,
    'helpText' => trans('help.assets'),
    'helpPosition' => 'right',
    'formAction' => ($item) ? route('hardware.update', ['hardware' => $item->id]) : route('hardware.store'),
])

{{-- Page content --}}

@section('inputFields')
  @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])

  @foreach (old('asset_tags', $item->exists ? [$item->id => $item->asset_tag] : [1 => '']) as $i => $value)
    <div class="form-group form-asset-tag-group {{ (! session()->has('error_index') || session('error_index') == $i) && $errors->has('asset_tag') ? ' has-error' : '' }}">
        <label for="asset_tag" class="col-md-3 control-label">{{ trans('admin/hardware/form.tag') }}</label>
        <div class="col-md-7 col-sm-12{{ (\App\Helpers\Helper::checkIfRequired($item, 'asset_tag')) ? ' required' : '' }}">
            <input class="form-control" type="text" name="asset_tags[{{ $i }}]" id="asset_tag" value="{{ $value }}" data-validation="required">
            @if (! session()->has('error_index') || session('error_index') == $i)
            {!! $errors->first('asset_tags', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            {!! $errors->first('asset_tag', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            @endif
        </div>
        <div class="col-md-2 col-sm-12">
            @if (!$item->exists)
                @if ($loop->first)
                <button class="add_field_button btn btn-default btn-sm"><i class="fa fa-plus"></i></button>
                @else
                <button type="button" class="remove_field btn btn-default btn-sm"><i class="fa fa-minus"></i></button>
                @endif
            @endif
        </div>
    </div>

    @include ('partials.forms.edit.serial', ['fieldname'=> 'serials['.$i.']', 'translated_serial' => trans('admin/hardware/form.serial')])
  @endforeach

  @include ('partials.forms.edit.model-select', ['translated_name' => trans('admin/hardware/form.model'), 'fieldname' => 'model_id', 'required' => 'true'])

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

  @include ('partials.forms.edit.status', [ 'required' => 'true'])

  @if (!$item->id)
      @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true', 'style' => 'display:none;'])

      @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_user', 'style' => 'display:none;', 'required' => 'false'])

  @include ('partials.forms.edit.asset-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_asset', 'style' => 'display:none;', 'required' => 'false'])

  @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required' => 'false'])
  @endif


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
              <img src="{{ Storage::disk('public')->url(app('assets_upload_path').e($item->image)) }}" class="img-responsive" />
          </div>
      </div>
  </div>
  @endif

@include ('partials.forms.edit.image-upload')

@stop

@section('moar_scripts')
<script type="text/template" nonce="{{ csrf_token() }}" data-template="asset_tag">
<div class="form-group form-asset-tag-group">
    <label for="asset_tag" class="col-md-3 control-label">{{ trans('admin/hardware/form.tag') }}</label>
    <div class="col-md-7 col-sm-12{{ (\App\Helpers\Helper::checkIfRequired($item, 'asset_tag')) ? ' required' : '' }}">
        <input class="form-control" type="text" name="asset_tags[%i%]" value="{{ (($snipeSettings->auto_increment_prefix!='') && ($snipeSettings->auto_increment_assets=='1')) ? $snipeSettings->auto_increment_prefix : '' }}%auto_tag%" data-validation="required">
    </div>
    <div class="col-md-2 col-sm-12">
        <button type="button" class="remove_field btn btn-default btn-sm"><i class="fa fa-minus"></i></button>
    </div>
</div>

@include ('partials.forms.edit.serial', ['fieldname'=> 'serials['.$i.']', 'translated_serial' => trans('admin/hardware/form.serial')])
</script>

<script nonce="{{ csrf_token() }}">
    var transformed_oldvals={};

    function fetchCustomFields() {
        //save custom field choices
        var oldvals = $('#custom_fields_content').find('input,select').serializeArray();
        for(var i in oldvals) {
            transformed_oldvals[oldvals[i].name]=oldvals[i].value;
        }

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
                    $('#custom_fields_content').html(data);
                    $('#custom_fields_content select').select2(); //enable select2 on any custom fields that are select-boxes
                    //now re-populate the custom fields based on the previously saved values
                    $('#custom_fields_content').find('input,select').each(function (index,elem) {
                        if(transformed_oldvals[elem.name]) {
                            $(elem).val(transformed_oldvals[elem.name]).trigger('change'); //the trigger is for select2-based objects, if we have any
                        }
                        
                    });
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

                        $("#selected_status_status").removeClass('alert-msg');
                        $("#selected_status_status").addClass('text-success');
                        $("#selected_status_status").html('<i class="fa fa-check"></i> That status is deployable. This asset can be checked out.');


                    } else {
                        $("#assignto_selector").hide();
                        $("#selected_status_status").removeClass('text-success');
                        $("#selected_status_status").addClass('alert-msg');
                        $("#selected_status_status").html('<i class="fa fa-times"></i> That asset status is not deployable. This asset cannot be checked out. ');
                    }
                }
            });
        }
    }


    $(function () {
        //grab custom fields for this model whenever model changes.
        $('#model_select_id').on("change", fetchCustomFields);

        //initialize assigned user/loc/asset based on statuslabel's statustype
        user_add($(".status_id option:selected").val());

        //whenever statuslabel changes, update assigned user/loc/asset
        $(".status_id").on("change", function () {
            user_add($(".status_id").val());
        });

    });


    // Add another asset tag + serial combination if the plus sign is clicked
    $(document).ready(function() {

        var max_fields      = 100; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID

        $(add_button).click(function(e){ //on add input button click

            e.preventDefault();

            var auto_tag        = $('.form-asset-tag-group:first .form-control').val().replace(/[^\d]/g, '');
            var box_html        = '';
            var x               = $('.form-asset-tag-group').length + 1;


            // Check that we haven't exceeded the max number of asset fields
            if (x < max_fields) {

                if (auto_tag!='') {
                    auto_tag = parseInt(auto_tag, 10) + x - 1;
                } else {
                    auto_tag = '';
                }

                box_html = $('[data-template="asset_tag"]').html().replace(/%i%/g, x).replace(/%auto_tag%/g, auto_tag);

                $('.form-serial-group:last').after(box_html);

            // We have reached the maximum number of extra asset fields, so disable the button
            } else {
                add_button.prop('disabled', true).addClass('disabled');
            }
        });

        $(document).on("click", ".form-asset-tag-group .remove_field", function(e){ //user clicks on remove text
            $(".add_field_button").removeAttr('disabled').removeClass('disabled');
            e.preventDefault();

            var asset_tag_group = $(this).closest('.form-asset-tag-group');
            asset_tag_group.next().remove();
            asset_tag_group.remove();
        })
    });


</script>
@stop
