@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($model->id)
        @lang('admin/models/table.update') ::
    @else
        @lang('admin/models/table.create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="row header">
    <div class="col-md-12">
            <!--<a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>-->
        @if(isset($clone_model))
            <a href="{{{ URL::route('view/model', $clone_model->id) }}}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
        @else
            <a href="{{{ URL::route('view/model', $model->id) }}}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
        @endif
        <h3>
        @if ($model->id)
            @lang('admin/models/table.update')
        @elseif(isset($clone_model))
            @lang('admin/models/table.clone')
        @else
            @lang('admin/models/table.create')
        @endif
        </h3>
    </div>
</div>

<div class="row form-wrapper">


{{ Form::open(['method' => 'POST', 'files' => true, 'class' => 'form-horizontal' ]) }}
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />



            <!-- Model name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('admin/models/table.name')
                 <i class='fa fa-asterisk'></i></label>
                 </label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $model->name) }}}" />
                        {{ $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

			 <div class="form-group {{ $errors->has('manufacturer_id') ? ' has-error' : '' }}">
				<label for="manufacturer_id" class="col-md-2 control-label">@lang('general.manufacturer')
				 <i class='fa fa-asterisk'></i></label>
				 </label>
					<div class="col-md-7">
						{{ Form::select('manufacturer_id', $manufacturer_list , Input::old('manufacturer_id', $model->manufacturer_id), array('class'=>'select2', 'style'=>'width:350px')) }}
						{{ $errors->first('manufacturer_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
					</div>
			</div>

			<!-- Category -->
            <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }}">
                <label for="category_id" class="col-md-2 control-label">@lang('general.category')
                 <i class='fa fa-asterisk'></i></label>
                 </label>
                    <div class="col-md-7">
                        {{ Form::select('category_id', $category_list , Input::old('category_id', $model->category_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('category_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>


            <!-- Model No. -->
            <div class="form-group {{ $errors->has('modelno') ? ' has-error' : '' }}">
                <label for="modelno" class="col-md-2 control-label">@lang('general.model_no')</label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="modelno" id="modelno" value="{{{ Input::old('modelno', $model->modelno) }}}" />
                        {{ $errors->first('modelno', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Depreciation -->
            <div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
                <label for="depreciation_id" class="col-md-2 control-label">@lang('general.depreciation')</label>
                    <div class="col-md-7">
                        {{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', $model->depreciation_id), array('class'=>'select2', 'style'=>'width:350px')) }}
                        {{ $errors->first('depreciation_id', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
            </div>

            <!-- EOL -->

            <div class="form-group {{ $errors->has('eol') ? ' has-error' : '' }}">
                <label for="eol" class="col-md-2 control-label">@lang('general.eol')</label>
                <div class="col-md-2">
                    <div class="input-group">
                    <input class="col-md-1 form-control" type="text" name="eol" id="eol" value="{{{ Input::old('eol', isset($model->eol)) ? $model->eol : 0  }}}" />   <span class="input-group-addon">
                    @lang('general.months')

                    </span>
                    {{ $errors->first('eol', '<br><span class="alert-msg"><i class="fa fa-times"></i> :message</span>') }}
                    </div>
                </div>
            </div>

			<div class="form-group {{ $errors->has('eol') ? ' has-error' : '' }}">
				<div class="checkbox col-md-offset-2">
					<label>
						{{ Form::select('custom_fieldset', customFieldsetList(),Input::old('custom_fieldset', $model->fieldset_id)) }}
						@lang('admin/models/general.choose_fieldset')
					</label>
				</div>
			</div>

            <!-- Image -->
            @if ($model->image)
                <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
                    <label class="col-md-2 control-label" for="image_delete">@lang('general.image_delete')</label>
                    <div class="col-md-5">
                        {{ Form::checkbox('image_delete') }}
                        <img src="/uploads/models/{{{ $model->image }}}" />
                        {{ $errors->first('image_delete', '<br><span class="alert-msg">:message</span>') }}
                    </div>
                </div>
            @endif

            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                <label class="col-md-2 control-label" for="image">@lang('general.image_upload')</label>
                <div class="col-md-5">
                    {{ Form::file('image') }}
                    {{ $errors->first('image', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>



            <!-- Form actions -->
            <div class="form-group">
            <label class="col-md-2 control-label"></label>
                <div class="col-md-7">
                    @if(isset($clone_model))
                        <a class="btn btn-link" href="{{ URL::route('view/model', $clone_model->id) }}">@lang('button.cancel')</a>
                    @else
                        <a class="btn btn-link" href="{{ URL::route('view/model', $model->id) }}">@lang('button.cancel')</a>
                    @endif
                    <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> @lang('general.save')</button>
                </div>
            </div>
</form>
</div>
@stop
