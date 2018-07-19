@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Bulk Edit
    @parent
@stop


@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <form class="form-horizontal" method="post" action="{{ route('models.bulkedit.store') }}" autocomplete="off" role="form">
                {{ csrf_field() }}

                <div class="box box-default">
                    <div class="box-header with-border">
                        @foreach ($models as $model)
                            <span class="box-title"><b>{{ $model->display_name }}</b> ({{ $model->model_number }})</span><br />
                        @endforeach
                    </div>
                    <div class="box-body">
                        <!-- manufacturer -->
                        @include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id'])

                        <!-- category -->
                        @include ('partials.forms.edit.category-select', ['translated_name' => trans('admin/categories/general.category_name'), 'fieldname' => 'category_id', 'required' => 'true', 'category_type' => 'asset'])

                        <!-- custom fields -->
                        <div class="form-group {{ $errors->has('fieldset_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-3 control-label">
                                {{ trans('admin/models/general.fieldset') }}
                            </label>
                            <div class="col-md-7">
                                {{ Form::select('fieldset_id', $fieldset_list , Input::old('fieldset_id', 'NC'), array('class'=>'select2 js-fieldset-field', 'style'=>'width:350px')) }}
                                {!! $errors->first('fieldset_id', '<span class="alert-msg"><br><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- depreciation -->

                        <div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-3 control-label">
                                {{ trans('general.depreciation') }}
                            </label>
                            <div class="col-md-7">
                                {{ Form::select('depreciation_id', $depreciation_list , Input::old('depreciation_id', 'NC'), array('class'=>'select2', 'style'=>'width:350px')) }}
                                {!! $errors->first('depreciation_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>

                        @foreach ($models as $model)
                            <input type="hidden" name="ids[{{ $model->id }}]" value="{{ $model->id }}">
                        @endforeach
                    </div> <!--/.box-body-->

                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
                    </div>
                </div> <!--/.box.box-default-->
            </form>
        </div> <!--/.col-md-8-->
    </div>
@stop
