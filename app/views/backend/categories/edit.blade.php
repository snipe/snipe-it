@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($category->id)
        @lang('admin/categories/general.update') ::
    @else
        @lang('admin/categories/general.create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i> @lang('general.back')</a>
        <h3>
        @if ($category->id)
            @lang('admin/categories/general.update')
        @else
            @lang('admin/categories/general.create')
        @endif
</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

                        <form class="form-horizontal" method="post" action="" autocomplete="off">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <!-- Name -->
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
	                        <div class="col-md-3">
	                        	{{ Form::label('name', Lang::get('admin/categories/general.category_name')) }}
	                        	<i class='fa fa-asterisk'></i>
	                        </div>                        
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $category->name) }}}" />
                                {{ $errors->first('name', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                            </div>
                        </div>
                        
                        <!-- Type -->
			            <div class="form-group {{ $errors->has('category_type') ? ' has-error' : '' }}">
				            <div class="col-md-3">
			               	{{ Form::label('category_type', Lang::get('general.type')) }}
			               	<i class='fa fa-asterisk'></i>
				            </div>
			                <div class="col-md-7">				                
			                    {{ Form::select('category_type', $category_types , Input::old('category_type', $category->category_type), array('class'=>'select2', 'style'=>'min-width:350px')) }}
			                    {{ $errors->first('category_type', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
			                </div>
			            </div>
                        						
						 <!-- EULA text -->
						<div class="form-group {{ $errors->has('eula_text') ? 'error' : '' }}">
	                        <div class="col-md-3">
	                        	{{ Form::label('eula_text', Lang::get('admin/categories/general.eula_text')) }}
	                        </div>
	                        <div class="col-md-9">
								{{ Form::textarea('eula_text', Input::old('eula_text', $category->eula_text), array('class' => 'form-control')) }}
								<p class="help-block">@lang('admin/categories/general.eula_text_help') </p>
								<p class="help-block">@lang('admin/settings/general.eula_markdown') </p>
								
								{{ $errors->first('eula_text', '<br><span class="alert-msg">:message</span>') }}						
	                        </div>
                    	</div>
                        
                         <!-- Use default checkbox -->     	
                    	<div class="checkbox col-md-offset-3">
							<label>
							
								 @if (Setting::getSettings()->default_eula_text!='')
								 	{{ Form::checkbox('use_default_eula', '1', Input::old('use_default_eula', $category->use_default_eula)) }}
								 	@lang('admin/categories/general.use_default_eula')
		                         @else
		                         	{{ Form::checkbox('use_default_eula', '0', Input::old('use_default_eula'), array('disabled' => 'disabled')) }}
		                         	@lang('admin/categories/general.use_default_eula_disabled')
		                         @endif
								 	
							</label>
						</div>
						
						 <!-- Require Acceptance -->
                        <div class="checkbox col-md-offset-3">
							<label>
								{{ Form::checkbox('require_acceptance', '1', Input::old('require_acceptance', $category->require_acceptance)) }}
								@lang('admin/categories/general.require_acceptance')
							</label>
						</div>
						
						<!-- Email on Checkin -->
                        <div class="checkbox col-md-offset-3">
                            <label>
                                {{ Form::checkbox('checkin_email', '1', Input::old('checkin_email', $category->checkin_email)) }}
                                @lang('admin/categories/general.checkin_email')
                            </label>
                        </div>


						<hr>
                        <!-- Form actions -->
                        <div class="form-group">
                       
                            <div class="col-md-7 col-md-offset-3">
                                <a class="btn btn-link" href="{{ URL::previous() }}">@lang('button.cancel')</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
                            </div>
                        </div>
                    </form>
                    <br><br><br><br><br>
                    </div>

                    <!-- side address column -->
                    <div class="col-md-3 col-xs-12 address pull-right">
                        <br /><br />
                        <h6>@lang('admin/categories/general.about_asset_categories')</h6>
                        <p>@lang('admin/categories/general.about_categories') </p>

                    </div>
</div>
</div>

@if (Setting::getSettings()->default_eula_text!='')
<!-- Modal -->
<div class="modal fade" id="eulaModal" tabindex="-1" role="dialog" aria-labelledby="eulaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="eulaModalLabel">@lang('admin/settings/general.default_eula_text')</h4>
      </div>
      <div class="modal-body">
        {{ Setting::getDefaultEula() }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang('button.cancel')</button>
      </div>
    </div>
  </div>
</div>
@endif

@stop
