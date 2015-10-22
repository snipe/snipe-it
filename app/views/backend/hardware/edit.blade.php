@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($asset->id)
    	@lang('admin/hardware/form.update') ::
    @else
    	@lang('admin/hardware/form.create') ::
    @endif
@parent
@stop
{{-- Some room for the modals --}}
<div class="modal fade" id="createModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-name">@lang('general.name')*:
          </label></div>
          <div class="col-md-9 col-xs-12"><input type='text' id='modal-name' class="form-control"></div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-manufacturer_id">@lang('general.manufacturer')*:
          </label></div>
          <div class="col-md-9 col-xs-12">{{ Form::select('modal-manufacturer', $manufacturer , '', array('class'=>'select2 parent', 'style'=>'width:350px','id' =>'modal-manufacturer_id')) }}</div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-category_id">@lang('general.category')*:
          </label></div>
          <div class="col-md-9 col-xs-12">{{ Form::select('modal-category', $category ,'', array('class'=>'select2 parent', 'style'=>'width:350px','id' => 'modal-category_id')) }}</div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-modelno">@lang('general.model_no')*:</label></div>
          <div class="col-md-9 col-xs-12"><input type='text' id='modal-modelno' class="form-control"></div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-statuslabel_types">@lang('admin/statuslabels/table.status_type')*:
          </label></div>
          <div class="col-md-9 col-xs-12">{{ Form::select('modal-statuslabel_types', $statuslabel_types, '', array('class'=>'select2', 'style'=>'width:350px','id' =>'modal-statuslabel_types')) }}</div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-city">@lang('general.city')*:</label></div>
          <div class="col-md-9 col-xs-12"><input type='text' id='modal-city' class="form-control"></div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-country">@lang('general.country')*:</label></div>
          <div class="col-md-9 col-xs-12">{{ Form::countries('country', Input::old('country'), 'select2 country',"modal-country") }}</div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-first_name">@lang('general.first_name')*:</label></div>
          <div class="col-md-9 col-xs-12"><input type='text' id='modal-first_name' class="form-control"></div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-last_name">@lang('general.last_name')*:</label></div>
          <div class="col-md-9 col-xs-12"><input type='text' id='modal-last_name' class="form-control"></div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-username">@lang('admin/users/table.username')*:</label></div>
          <div class="col-md-9 col-xs-12"><input type='text' id='modal-username' class="form-control"></div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-password">@lang('admin/users/table.password')*:</label></div>
          <div class="col-md-9 col-xs-12"><input type='password' id='modal-password' class="form-control"></div>
        </div>

        <div class="dynamic-form-row">
          <div class="col-md-3 col-xs-12"><label for="modal-password_confirm">@lang('admin/users/table.password_confirm')*:</label></div>
          <div class="col-md-9 col-xs-12"><input type='password' id='modal-password_confirm' class="form-control"></div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('button.cancel')</button>
        <button type="button" class="btn btn-primary" id="modal-save">@lang('general.save')</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- Page content --}}

@section('content')

<div class="row header">
    <div class="col-md-12">
            <a href="{{ URL::previous() }}" class="btn-flat gray pull-right right"><i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3>
        @if ($asset->id)
        	@lang('admin/hardware/form.update')
        @else
            @lang('admin/hardware/form.create')
        @endif
        </h3>
    </div>
</div>

<div class="row form-wrapper">
            <!-- left column -->
            <div class="col-md-12 column">

			 @if ($asset->id)
				 <form class="form-horizontal" method="post" action="{{ route('update/hardware',$asset->id) }}" autocomplete="off" role="form">
			 @else
				 <form class="form-horizontal" method="post" action="{{ route('savenew/hardware') }}" autocomplete="off" role="form">
			 @endif

            <!-- CSRF Token -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Asset Tag -->
            <div class="form-group {{ $errors->has('asset_tag') ? ' has-error' : '' }}">
                <label for="asset_tag" class="col-md-2 control-label">@lang('admin/hardware/form.tag')
                 *</label>
                 </label>
                    <div class="col-md-7 col-sm-12">
                    	@if  ($asset->id)
							<input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{{ Input::old('asset_tag', $asset->asset_tag) }}}" />
						@else
							<input class="form-control" type="text" name="asset_tag" id="asset_tag" value="{{{ Input::old('asset_tag', Asset::autoincrement_asset()) }}}" />
						@endif

                        {{ $errors->first('asset_tag', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Serial -->
            <div class="form-group {{ $errors->has('serial') ? ' has-error' : '' }}">
                <label for="serial" class="col-md-2 control-label">@lang('admin/hardware/form.serial') </label>
                <div class="col-md-7 col-sm-12">
                    <input class="form-control" type="text" name="serial" id="serial" value="{{{ Input::old('serial', $asset->serial) }}}" />
                    {{ $errors->first('serial', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Asset Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('admin/hardware/form.name')</label>
                    <div class="col-md-7 col-sm-12">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $asset->name) }}}" />
                        {{ $errors->first('name', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Model -->
            <div class="form-group {{ $errors->has('model_id') ? ' has-error' : '' }}">
                <label for="parent" class="col-md-2 control-label">@lang('admin/hardware/form.model')
                 *</label>
                 </label>
                <div class="col-md-7 col-sm-12">
                    @if (isset($selected_model))
                        {{ Form::select('model_id', $model_list , $selected_model->id, array('class'=>'select2 model', 'style'=>'min-width:400px','id' =>'model_select_id')) }}

                    @else
                        {{ Form::select('model_id', $model_list , Input::old('model_id', $asset->model_id), array('class'=>'select2 model', 'style'=>'min-width:400px','id' =>'model_select_id')) }}
                    @endif

                    <span class="mac_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin"></i> </span>
                    <a href='#' data-toggle="modal" data-target="#createModal" data-dependency="model" data-select="model_select_id"><i class="verticon fa fa-plus-square-o fa-2x"></i></a> <!-- onclick="return dependency('model')" -->
                    {{ $errors->first('model_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- MAC Address -->
            <div id="mac_address" class="form-group {{ $errors->has('mac_address') ? ' has-error' : '' }}" > <!-- style="display:none;" -->
                <label for="mac_address" class="col-md-2 control-label">@lang('admin/hardware/form.mac_address')</label>
                    <div class="col-md-7 col-sm-12">
                        <input class="form-control" type="text" name="mac_address" id="mac_address" value="{{{ Input::old('mac_address', $asset->mac_address) }}}" />
                        {{ $errors->first('mac_address', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Purchase Date -->
            <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                <label for="purchase_date" class="col-md-2 control-label">@lang('admin/hardware/form.date')</label>
                <div class="input-group col-md-3">
                    <input type="date" class="datepicker form-control" data-date-format="yyyy-mm-dd" placeholder="@lang('general.select_date')" name="purchase_date" id="purchase_date" value="{{{ Input::old('purchase_date', $asset->purchase_date) }}}">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                {{ $errors->first('purchase_date', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Supplier -->
            <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                <label for="supplier_id" class="col-md-2 control-label">@lang('admin/hardware/form.supplier')</label>
                <div class="col-md-7 col-sm-12">
                    {{ Form::select('supplier_id', $supplier_list , Input::old('supplier_id', $asset->supplier_id), array('class'=>'select2', 'style'=>'min-width:350px','id'=>'supplier_select_id')) }}
                    <a href='#' data-toggle="modal"  data-target="#createModal" data-dependency="supplier" data-select='supplier_select_id'><i class="verticon fa fa-plus-square-o fa-2x"></i></a>
                    {{ $errors->first('supplier_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Order Number -->
            <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
                <label for="order_number" class="col-md-2 control-label">@lang('admin/hardware/form.order')</label>
                <div class="col-md-7 col-sm-12">
                    <input class="form-control" type="text" name="order_number" id="order_number" value="{{{ Input::old('order_number', $asset->order_number) }}}" />
                    {{ $errors->first('order_number', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Purchase Cost -->
            <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
                    <label for="purchase_cost" class="col-md-2 control-label">@lang('admin/hardware/form.cost') </label>
                    <div class="col-md-2">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        @if (($asset->id) && ($asset->assetloc))
                                            {{{ $asset->assetloc->currency }}}
                                        @else
                                            {{{ Setting::first()->default_currency }}}
                                        @endif


                                    </span>
                                    <input class="col-md-2 form-control" type="text" name="purchase_cost" id="purchase_cost" value="{{ Input::old('purchase_cost', number_format($asset->purchase_cost,2)) }}" />
                                    {{ $errors->first('purchase_cost', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                             </div>
                     </div>
            </div>

            <!-- Warranty -->
            <div class="form-group {{ $errors->has('warranty_months') ? ' has-error' : '' }}">
                <label for="warranty_months" class="col-md-2 control-label">@lang('admin/hardware/form.warranty')</label>
                <div class="col-md-2">
                    <div class="input-group">
                    <input class="col-md-2 form-control" type="text" name="warranty_months" id="warranty_months" value="{{{ Input::old('warranty_months', $asset->warranty_months) }}}" />   <span class="input-group-addon">@lang('admin/hardware/form.months')</span>
                    {{ $errors->first('warranty_months', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
                <label for="status_id" class="col-md-2 control-label">@lang('admin/hardware/form.status') *</label>
                    <div class="col-md-7 col-sm-12 col-sm-12">
                        {{ Form::select('status_id', $statuslabel_list , Input::old('status_id', $asset->status_id), array('class'=>'select2 status_id', 'style'=>'width:350px','id'=>'status_select_id')) }}
                        <a href='#' data-toggle="modal"  data-target="#createModal" data-dependency='statuslabel' data-select='status_select_id'><i class="verticon fa fa-plus-square-o fa-2x"></i></a>
                        <span class="status_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;"><i class="fa fa-spinner fa-spin"></i> </span>

                        <p class="help-block">@lang('admin/hardware/form.help_checkout')</p>
                        {{ $errors->first('status_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            @if (!$asset->id)
             <!-- Assigned To -->
            <div id="assigned_user" style="display: none;" class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
                <label for="parent" class="col-md-2 control-label">@lang('admin/hardware/form.checkout_to')
                 </label>
                <div class="col-md-7 col-sm-12">
                    {{ Form::select('assigned_to', $assigned_to , Input::old('assigned_to', $asset->assigned_to), array('class'=>'select2', 'id'=>'assigned_to', 'style'=>'min-width:350px')) }}
                    <a href='#' data-toggle="modal"  data-target="#createModal" data-dependency="user" data-select='assigned_to'><i class="verticon fa fa-plus-square-o fa-2x"></i></a>
                    {{ $errors->first('assigned_to', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>
            @endif

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-2 control-label">@lang('admin/hardware/form.notes')</label>
                <div class="col-md-7 col-sm-12">
                    <textarea class="col-md-6 form-control" id="notes" name="notes">{{{ Input::old('notes', $asset->notes) }}}</textarea>
                    {{ $errors->first('notes', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                </div>
            </div>

            <!-- Default Location -->
            <div class="form-group {{ $errors->has('rtd_location_id') ? ' has-error' : '' }}">
                <label for="rtd_location_id" class="col-md-2 control-label">@lang('admin/hardware/form.default_location')</label>
                    <div class="col-md-7 col-sm-12">
                        {{ Form::select('rtd_location_id', $location_list , Input::old('rtd_location_id', $asset->rtd_location_id), array('class'=>'select2', 'style'=>'width:350px','id'=>'rtd_location_select')) }}
                         <a href='#' data-toggle="modal" data-target="#createModal" data-dependency='location' data-select='rtd_location_select'><i class="verticon fa fa-plus-square-o fa-2x"></i></a>
                        {{ $errors->first('rtd_location_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

			<!-- Requestable -->
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
				  <div class="checkbox">
					<label>
					  <input type="checkbox" value="1" name="requestable" id="requestable" {{ Input::old('requestable', $asset->requestable) == '1' ? ' checked="checked"' : '' }}> @lang('admin/hardware/form.requestable')
					</label>
				  </div>
				</div>
		  	</div>
        
        <!-- Custom Fields -->
        @if($asset->model->fieldset)
          <h1>Custom Fields</h1>
          @foreach($asset->model->fieldset->fields AS $field)
            <div class="form-group">
              <label for="idunno" class="col-md-2 control-label">{{{ $field->name }}}</label>
              <div class="col-md-7 col-sm-12">
                  <input type="text" value="{{{ Input::old('fields[{{$field->db_column_name()}}]',$asset->{$field->db_column_name()}) }}}" name="fields[{{{ $field->db_column_name() }}}]">
              </div>
            </div>
          @endforeach
        @endif


            <!-- Form actions -->
                <div class="form-group">
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7 col-sm-12">
                        <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
                    </div>
                </div>

        </form>
    </div>
</div>
<script>

	var $eventSelect = $(".model");
	$eventSelect.on("change", function () {
        mac_add($(".model option:selected").val());
    });
	$(function() {
        var mac = $(".model option:selected").val();
	       mac_add(mac);
	});
	function mac_add(id) {
        if(id==''){
            return;
        }
	    $.ajax({
	        url: "{{Config::get('app.url')}}/api/models/"+id+"/check",
	        success: function(data) {
	            if(data == true){
	                 $("#mac_address").css("display", "block");
	            } else {
	                 $("#mac_address").css("display", "none");
	            }
	        }
	    });
	};




    $(function() {
        user_add($(".status_id option:selected").val());
    });

	var $statusSelect = $(".status_id");
	$statusSelect.on("change", function () {
        user_add($statusSelect.val());
    });

	function user_add(status_id) {
        console.log(status_id);

        if(status_id!=''){
            $(".status_spinner").css("display", "inline");
    	    $.ajax({
    	        url: "{{Config::get('app.url')}}/api/statuslabels/"+status_id+"/deployable",
    	        success: function(data) {
                    console.log(data);
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
    // data-dependency="model" data-select="model_select_id"
    model=link.data("dependency");
    select=link.data("select");

    var modal = $(this);
    modal.find('.modal-title').text('Add a new ' + model);
    //modal.find('.modal-body').text("This is where I should be AJAX'ing in the contents for the new " +model+" that you'are about to add!");
    //use a spinner instead?
    //$('.dynamic-form-element').hide();
    //$('.modal-body input').parent().parent().hide();
    //$('.modal-body select').parent().parent().hide();
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

    //console.dir(data);

    $.post("{{Config::get('app.url')}}/api/"+model+"s",data,function (result) {
      var id=result.id;
      var name=result.name || (result.first_name+" "+result.last_name);
      $('.modal-body input:visible').val("");
      $('#createModal').modal('hide');

      //console.warn("The select ID thing we're going for is: "+select);
      var selector=document.getElementById(select);
      selector.options[selector.length]=new Option(name,id);
      selector.selectedIndex=selector.length-1;
      $(selector).trigger("change");
    }).fail(function (result) {
      //console.dir(result.responseJSON);
      msg=result.responseJSON.error.message || result.responseJSON.error;
      window.alert("Unable to add new "+model+" - error: "+msg);
    });

  });
});
</script>

@stop
