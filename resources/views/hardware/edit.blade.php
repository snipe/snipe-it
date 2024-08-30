
@extends('layouts/edit-form', [
    'createText' => trans('admin/hardware/form.create'),
    'updateText' => trans('admin/hardware/form.update'),
    'topSubmit' => true,
    'helpText' => trans('help.assets'),
    'helpPosition' => 'right',
    'formAction' => ($item->id) ? route('hardware.update', ['hardware' => $item->id]) : route('hardware.store'),
    'index_route' => 'hardware.index',
    'options' => [
                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => 'assets']),
                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.asset')]),
               ]
])


{{-- Page content --}}
@section('inputFields')
    
    @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])


  <!-- Asset Tag -->
  <div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
    <label for="asset_tag" class="col-md-3 control-label">{{ trans('admin/hardware/form.tag') }}</label>



      @if  ($item->id)
          <!-- we are editing an existing asset,  there will be only one asset tag -->
          <div class="col-md-7 col-sm-12{{  (Helper::checkIfRequired($item, 'asset_tag')) ? ' required' : '' }}">
          <input class="asset_tag form-control" type="text" name="asset_tags[1]" id="asset_tag_1" value="{{ old('asset_tag', $item->asset_tag) }}" required>
              {!! $errors->first('asset_tags', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
			  {!! $errors->first('asset_tag', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
			  <span id="asset_auto_tag_1-error" style="display:none; color:#a94442;" class="error"> :message</span>
          </div>
      @else
          <!-- we are creating a new asset - let people use more than one asset tag -->
          <div class="col-md-7 col-sm-12{{  (Helper::checkIfRequired($item, 'asset_tag')) ? ' required' : '' }}">
              <input class="asset_tag form-control" type="text" name="asset_tags[1]" id="asset_tag_1" value="{{ old('asset_tags.1', \App\Models\Asset::autoincrement_asset()) }}" required>
              {!! $errors->first('asset_tags', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
			  {!! $errors->first('asset_tag', '<span class="alert-msg"><i class="fas fa-times"></i> :message</span>') !!}
			  <span id="asset_auto_tag_1-error" style="display:none; color:#a94442;" class="error"> :message</span>
          </div>
          <div class="col-md-2 col-sm-12">
              <button class="add_field_button btn btn-default btn-sm">
                  <i class="fas fa-plus"></i>
              </button>
          </div>
      @endif
  </div>

    @include ('partials.forms.edit.serial', ['fieldname'=> 'serials[1]', 'old_val_name' => 'serials.1', 'translated_serial' => trans('admin/hardware/form.serial')])

    <div class="input_fields_wrap">
    </div>

    @include ('partials.forms.edit.model-select', ['translated_name' => trans('admin/hardware/form.model'), 'fieldname' => 'model_id', 'field_req' => true])


    @include ('partials.forms.edit.status', [ 'required' => 'true'])
    @if (!$item->id)
        @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true', 'style' => 'display:none;'])
        @include ('partials.forms.edit.user-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_user', 'style' => 'display:none;', 'required' => 'false'])
        @include ('partials.forms.edit.asset-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_asset', 'style' => 'display:none;', 'required' => 'false'])
        @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.checkout_to'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required' => 'false'])
    @elseif (($item->assignedTo) && ($item->deleted_at == ''))
        <!-- This is an asset and it's currently deployed, so let them edit the expected checkin date -->
        @include ('partials.forms.edit.datepicker', ['translated_name' => trans('admin/hardware/form.expected_checkin'),'fieldname' => 'expected_checkin'])
    @endif

    @include ('partials.forms.edit.notes')
    @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.default_location'), 'fieldname' => 'rtd_location_id', 'help_text' => trans('general.rtd_location_help')])
    @include ('partials.forms.edit.requestable', ['requestable_text' => trans('admin/hardware/general.requestable')])



    @include ('partials.forms.edit.image-upload', ['image_path' => app('assets_upload_path')])


    <div id='custom_fields_content'>
        <!-- Custom Fields -->
        @if ($item->model && $item->model->fieldset)
        <?php $model = $item->model; ?>
        @endif
        @if (old('model_id'))
            @php
                $model = \App\Models\AssetModel::find(old('model_id'));
            @endphp
        @elseif (isset($selected_model))
            @php
                $model = $selected_model;
            @endphp
        @endif
        @if (isset($model) && $model)
        @include("models/custom_fields_form",["model" => $model])
        @endif
    </div>

    <div class="form-group">
    <label class="col-md-3 control-label"></label>

        <div class="col-md-9 col-sm-9 col-md-offset-3">

        <a id="optional_info" class="text-primary">
            <x-icon type="caret-right" class="fa-2x" id="optional_info_icon" />
            <strong>{{ trans('admin/hardware/form.optional_infos') }}</strong>
        </a>

        </div>
        
        <div id="optional_details" class="col-md-12" style="display:none">
        <br>
            @include ('partials.forms.edit.name', ['translated_name' => trans('admin/hardware/form.name')])
            @include ('partials.forms.edit.warranty')

            <!-- Datepicker -->
            <div class="form-group{{ $errors->has('next_audit_date') ? ' has-error' : '' }}">

                <label class="col-md-3 control-label">
                    {{ trans('general.next_audit_date') }}
                </label>

                <div class="input-group col-md-4">
                    <div class="input-group date" data-provide="datepicker" data-date-clear-btn="true" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                        <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="next_audit_date" id="next_audit_date" value="{{ old('next_audit_date', $item->next_audit_date) }}" readonly style="background-color:inherit" maxlength="10">
                        <span class="input-group-addon"><x-icon type="calendar" /></span>
                    </div>
                </div>
                <div class="col-md-8 col-md-offset-3">
                    {!! $errors->first('next_audit_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                    <p class="help-block">{!! trans('general.next_audit_date_help') !!}</p>
                </div>

            </div>


            <!-- byod checkbox -->
            <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                    <label class="form-control">
                        <input type="checkbox" value="1" name="byod" {{ (old('remote', $item->byod)) == '1' ? ' checked="checked"' : '' }} aria-label="byod">
                        {{ trans('general.byod') }}

                    </label>
                    <p class="help-block">{{ trans('general.byod_help') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-9 col-sm-9 col-md-offset-3">
            <a id="order_info" class="text-primary">
                <x-icon type="caret-right" class="fa-2x" id="order_info_icon" />
                <strong>{{ trans('admin/hardware/form.order_details') }}</strong>
            </a>

        </div>

        <div id='order_details' class="col-md-12" style="display:none">
            <br>
            @include ('partials.forms.edit.order_number')
            @include ('partials.forms.edit.purchase_date')
            @include ('partials.forms.edit.eol_date')
            @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier'), 'fieldname' => 'supplier_id'])

                @php
                $currency_type = null;
                if ($item->id && $item->location) {
                    $currency_type = $item->location->currency;
                }
                @endphp

            @include ('partials.forms.edit.purchase_cost', ['currency_type' => $currency_type])

        </div>
    </div>
   
@stop

@section('moar_scripts')



<script nonce="{{ csrf_token() }}">

    @if(Request::has('model_id'))
        //TODO: Refactor custom fields to use Livewire, populate from server on page load when requested with model_id
    $(document).ready(function() {
        fetchCustomFields()
    });
    @endif

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
                url: "{{ config('app.url') }}/models/" + modelid + "/custom_fields",
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
                             {{-- If there already *is* is a previously-input 'transformed_oldvals' handy,
                                  overwrite with that previously-input value *IF* this is an edit of an existing item *OR*
                                  if there is no new default custom field value coming from the model --}}
                            if({{ $item->id ? 'true' : 'false' }} || $(elem).val() == '') {
                                $(elem).val(transformed_oldvals[elem.name]).trigger('change'); //the trigger is for select2-based objects, if we have any
                            }
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
                url: "{{config('app.url') }}/api/v1/statuslabels/" + status_id + "/deployable",
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
                        $("#selected_status_status").html('<x-icon type="checkmark" /> {{ trans('admin/hardware/form.asset_deployable')}}');


                    } else {
                        $("#assignto_selector").hide();
                        $("#selected_status_status").removeClass('text-success');
                        $("#selected_status_status").addClass('text-danger');
                        $("#selected_status_status").html('<x-icon type="warning" /> {{ trans('admin/hardware/form.asset_not_deployable')}} ');
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
		var max_value		= 100000000000; //maximum allowed value
        var wrapper         = $(".input_fields_wrap"); //Fields wrapper
        var add_button      = $(".add_field_button"); //Add button ID
        var x               = 1; //initial text box count
		var auto_increment_enabled = "{{ (($snipeSettings->auto_increment_assets=='1')) ? true : false }}";		
		var auto_tag_prefix = "{{ $snipeSettings->auto_increment_prefix }}";
		var auto_tag_sufix;
		var asset_tag_value;
		var auto_tag_counter = 0;
		var tag_number
		var auto_tag_expected_number;
		const zeroPad 		= (num, places) => String(num).padStart(places, '0');
		
		// Asset Tag validation function - manage error
		function asset_tag_valid(e){
			e.preventDefault();
			
			//console.log("#### validation ####");
			// remove whitespaces
			$(this).val($(this).val().trim());
			asset_tag = $(this);
			
			//console.log("#validation# asset_tag.val(): " + asset_tag.val());
			if ((auto_increment_enabled == true) && (asset_tag.val().toUpperCase().startsWith(auto_tag_prefix.toUpperCase()))) {
				asset_tag_value = asset_tag.val().substr(auto_tag_prefix.length);
				asset_tag_value = parseInt(asset_tag_value.replace(/[^\d]/g, ''));
			} else {
				asset_tag_value = parseInt(asset_tag.val().replace(/[^\d]/g, ''));
			}
			//console.log("#validation# asset_tag_value: " + asset_tag_value);

			// detect NaN
			if (isNaN(asset_tag_value)) {
				asset_tag_value = 0;
				//console.log("#validation NAN# new asset_tag_value: " + asset_tag_value);
			}

			// remove errors before new validation
			$("#asset_auto_tag_" + x + "-error").hide();
			asset_tag.parent('div').removeClass('has-error');
			asset_tag.removeClass('invalid');
			
			// asset tag value must be less then max_value
			if (asset_tag_value >= max_value) {
				$("#asset_auto_tag_" + x + "-error").show();
				asset_tag.parent('div').addClass('has-error');
				asset_tag.addClass('invalid');
				error_msg = "{{ trans('general.asset_tag_error') }} <b>" + max_value + "</b>";
				$("#asset_auto_tag_" + x + "-error").html(error_msg);
				return;
			}
			
			// validation if tag incremental is enabled and value start with tag prefix
			if ((auto_increment_enabled == true) && (asset_tag.val().toUpperCase().startsWith(auto_tag_prefix.toUpperCase()))) {	
				autoincrement_tag  = "{{ \App\Models\Asset::autoincrement_asset() }}".substr(auto_tag_prefix.length).replace(/[^\d]/g, '');
				//console.log("#validation# autoincrement_tag: " + autoincrement_tag);
				
				// rebuild asset tag value with zaro padding
				asset_tag.val(auto_tag_prefix + zeroPad(asset_tag_value,autoincrement_tag.length));
				
				// check if form is in edit or create mode
				if ({{ $item->id ? 'true' : 'false' }}) {
					//console.log("#validation# Item exist, EDIT mode");
					
					// value must be less then autoincrement number
					if (asset_tag_value >= parseInt(autoincrement_tag)) {
						//console.log("#validation error# asset_tag_value: " + asset_tag_value + " ; autoincrement_tag: " + parseInt(autoincrement_tag));
						$("#asset_auto_tag_" + x + "-error").show();
						asset_tag.parent('div').addClass('has-error');
						asset_tag.addClass('invalid');
						error_msg = "{{ trans('general.asset_tag_error') }} <b>" + auto_tag_prefix + autoincrement_tag + "</b>";
						$("#asset_auto_tag_" + x + "-error").html(error_msg);
						return;
					}
				} else {
					//console.log("#validation# Item not exist, CREATE mode");
					
					// if first row when not created additional assets
					if (auto_tag_counter == 0) {
						auto_tag_counter = parseInt(autoincrement_tag);
					}
					
					// validation if tag value has expected number
					if (asset_tag_value != auto_tag_counter) {
						//console.log("#validation error# asset_tag_value: " + asset_tag_value + " ; autoincrement_tag: " + parseInt(autoincrement_tag));
						auto_tag_expected_number = auto_tag_prefix + zeroPad(parseInt(auto_tag_counter),autoincrement_tag.length);
						$("#asset_auto_tag_" + x + "-error").show();
						asset_tag.parent('div').addClass('has-error');
						asset_tag.addClass('invalid');
						error_msg = "{{ trans('general.asset_auto_tag_error') }} <b>" + auto_tag_expected_number + "</b>";
						$("#asset_auto_tag_" + x + "-error").html(error_msg);
						return;
					}
				}
			}
		};	

		// Asset Tag validation on Submit form
		$("#create-form").submit(function(){
			if ($("#asset_tag_" + x).hasClass('invalid')) {
				return false;
			}
		});
		
		// Asset Tag validation on change value
		$(".asset_tag").on("change", asset_tag_valid);
		
		// Asset Tag validation on change value in wrapper sectopm
		$(wrapper).on("change", ".asset_tag", asset_tag_valid);

        $(add_button).click(function(e){ //on add input button click

            e.preventDefault();

			//console.log("#### add new tag ####");
            // Check that we haven't exceeded the max number of asset fields
			if (x < max_fields) {

				var box_html        = '';
				asset_tag = $("#asset_tag_" + x);
				
				if ((auto_increment_enabled == true) && (asset_tag.val().toUpperCase().startsWith(auto_tag_prefix.toUpperCase()))) {
					asset_tag_value = asset_tag.val().substr(auto_tag_prefix.length);
					asset_tag_value = parseInt(asset_tag_value.replace(/[^\d]/g, ''));
				} else {
					asset_tag_value = parseInt(asset_tag.val().replace(/[^\d]/g, ''));
				}

				// detect NaN
				if (isNaN(asset_tag_value)) {
					asset_tag_value = 0;
				}
				
				// asset tag value control
				if (!(asset_tag.val()) || (asset_tag_value >= max_value)) {
					$("#asset_tag_" + x).change();
					$("#asset_tag_" + x).blur();
					//console.log("#add error# asset_tag.val(): " + asset_tag.val() + " ; asset_tag_value: " + asset_tag_value);
					return;
				}

				// Check if incremental asset tag number is enabled
				if (auto_increment_enabled == true) {

					autoincrement_tag  = "{{ \App\Models\Asset::autoincrement_asset() }}".substr(auto_tag_prefix.length).replace(/[^\d]/g, '');

					if (auto_tag_counter == 0) {
						auto_tag_counter = parseInt(autoincrement_tag);
					}

					tag_number = auto_tag_prefix + zeroPad(parseInt(auto_tag_counter),autoincrement_tag.length);

					// Validation if asset tag number start with prefix
					if (asset_tag.val().toUpperCase().startsWith(auto_tag_prefix.toUpperCase())) {
						// Check if asset tag value has expected number
						if (asset_tag_value != auto_tag_counter) {
							$("#asset_tag_" + x).change();
							//console.log("#add error# asset_tag_value: " + asset_tag_value + " ; auto_tag_counter: " + auto_tag_counter);
							return;
						} else {
							auto_tag_counter++; //incremental only if valid tag number
							tag_number = auto_tag_prefix + zeroPad(parseInt(auto_tag_counter),autoincrement_tag.length);
						}
					}
				} else {
					// autoincremental not enabled, user put tag manually
					asset_tag_value = $("#asset_tag_1").val().replace(/[^\d]/g, '');
					auto_tag_prefix = '';
					auto_tag_sufix = '';
					//console.log("#add manually# asset_tag_value: " + asset_tag_value);
					
					// if first tag contains number increment on the base row count (x)
					if (isNaN(parseInt(asset_tag_value))) {
						asset_tag_value = '';
					} else {
						asset_tag_value = zeroPad(parseInt(asset_tag_value) + x, asset_tag_value.length);
						auto_tag_prefix = $("#asset_tag_1").val().replace(/\d.*/g, '');
						auto_tag_sufix = $("#asset_tag_1").val().replace(/.*\d/g, '');	
					}
					//console.log("#add manually# auto_tag_prefix: " + auto_tag_prefix);
					//console.log("#add manually# auto_tag_sufix: " + auto_tag_sufix);

					tag_number = auto_tag_prefix + asset_tag_value + auto_tag_sufix;
				}

				// Lock current Asset Tag field when add new Asset Tag field
				$("#asset_tag_" + x).prop( "readonly", true );
				$("#remove_field_" + x).hide();
				
                x++; //text box increment

                box_html += '<span class="fields_wrapper">';
				box_html += '<!-- Asset Tag ' + x + ' -->';
                box_html += '<div class="form-group{{ $errors->has('asset_tag') ? ' has-error' : '' }}">';
				box_html += '<label for="asset_tag" class="col-md-3 control-label">{{ trans('admin/hardware/form.tag') }} ' + x + '</label>';
                box_html += '<div class="col-md-7 col-sm-12 required">';
                box_html += '<input type="text" class="asset_tag form-control" name="asset_tags[' + x + ']" id="asset_tag_' + x + '" value="' + tag_number +'" required>';
				box_html += '<span id="asset_auto_tag_' + x + '-error" style="display:none; color:#a94442;" class="error"> :message</span>'
				box_html += '</div>';
                box_html += '<div class="col-md-2 col-sm-12">';
                box_html += '<a href="#" class="remove_field btn btn-default btn-sm" id="remove_field_' + x +'"><i class="fas fa-minus"></i></a>';
                box_html += '</div>';
                box_html += '</div>';
                box_html += '</div>';
				box_html += '<!-- Serial ' + x + ' -->';
                box_html += '<div class="form-group">';
				box_html += '<label for="serial" class="col-md-3 control-label">{{ trans('admin/hardware/form.serial') }} ' + x + '</label>';
                box_html += '<div class="col-md-7 col-sm-12">';
                box_html += '<input type="text"  class="form-control" name="serials[' + x + ']">';
                box_html += '</div>';
                box_html += '</div>';
                box_html += '</span>';
                $(wrapper).append(box_html);

            // We have reached the maximum number of extra asset fields, so disable the button
            } else {
                $(".add_field_button").attr('disabled');
                $(".add_field_button").addClass('disabled');
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user clicks on remove text
            //console.log("#### remove tag ####");
			
			$(".add_field_button").removeAttr('disabled');
            $(".add_field_button").removeClass('disabled');
            e.preventDefault();
            //console.log("#remove# x: " + x);

            $(this).parent('div').parent('div').parent('span').remove();
			x--;

			asset_tag_value = $("#asset_tag_" + x).val();

			if ((auto_increment_enabled == true) && (asset_tag_value.toUpperCase().startsWith(auto_tag_prefix.toUpperCase()))) {
				auto_tag_counter--; // deincremental auto tag number
			}

			// Unlock Asset Tag field when last one removed
			$("#asset_tag_" + x).prop( "readonly", false );
			$("#remove_field_" + x).show();
        });


        $('.expand').click(function(){
            id = $(this).attr('id');
            fields = $(this).text();
            if (txt == '+'){
                $(this).text('-');
            }
            else{
                $(this).text('+');
            }
            $("#"+id).toggle();

        });

        {{-- TODO: Clean up some of the duplication in here. Not too high of a priority since we only copied it once. --}}
        $("#optional_info").on("click",function(){
            $('#optional_details').fadeToggle(100);
            $('#optional_info_icon').toggleClass('fa-caret-right fa-caret-down');
            var optional_info_open = $('#optional_info_icon').hasClass('fa-caret-down');
            document.cookie = "optional_info_open="+optional_info_open+'; path=/';
        });

        $("#order_info").on("click",function(){
            $('#order_details').fadeToggle(100);
            $("#order_info_icon").toggleClass('fa-caret-right fa-caret-down');
            var order_info_open = $('#order_info_icon').hasClass('fa-caret-down');
            document.cookie = "order_info_open="+order_info_open+'; path=/';
        });

        var all_cookies = document.cookie.split(';')
        for(var i in all_cookies) {
            var trimmed_cookie = all_cookies[i].trim(' ')
            if (trimmed_cookie.startsWith('optional_info_open=')) {
                elems = all_cookies[i].split('=', 2)
                if (elems[1] == 'true') {
                    $('#optional_info').trigger('click')
                }
            }
            if (trimmed_cookie.startsWith('order_info_open=')) {
                elems = all_cookies[i].split('=', 2)
                if (elems[1] == 'true') {
                    $('#order_info').trigger('click')
                }
            }
        }

    });




</script>
@stop
