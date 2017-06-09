@extends('layouts.default')

{{-- Page title --}}
@section('title')
   Map Import Fields
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
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">

                    </h3>
                    @if (isset($helpText))
                        <div class="box-tools pull-right">
                            <button class="slideout-menu-toggle btn btn-box-tool btn-box-tool-lg" data-toggle="tooltip" title="Help"><i class="fa fa-question"></i></button>
                        </div>
                    @endif
                </div><!-- /.box-header -->

                <div class="box-body">
                    <form id="create-form" class="form-horizontal" method="post" action="{{ (isset($formAction)) ? $formAction : \Request::url()  }}" autocomplete="off" role="form" enctype="multipart/form-data">

                    <!-- CSRF Token -->
                        {{ csrf_field() }}

                        <pre>
                            @php
                            print_r($first_row);
                            @endphp
                        </pre>

                        <div class="col-md-8 col-md-offset-2">
                            <h3>Standard Fields</h3>
                            <hr>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Check out to User (First Last)
                            </label>
                            <div class="col-md-4 required">
                                {!!    Form::header_list($header_rows, 'user_name_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Username
                            </label>
                            <div class="col-md-4 required">
                                {!!    Form::header_list($header_rows, 'username_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Email
                            </label>
                            <div class="col-md-4 required">
                                {!!    Form::header_list($header_rows, 'email_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Item Name
                            </label>
                            <div class="col-md-4 required">
                                {!!    Form::header_list($header_rows, 'item_name_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Asset Tag
                            </label>
                            <div class="col-md-4 required">
                                {!!    Form::header_list($header_rows, 'asset_tag_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Serial Number
                            </label>
                            <div class="col-md-4 required">
                                {!!    Form::header_list($header_rows, 'serial_number_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Model name
                            </label>
                            <div class="col-md-4 required">
                                {!!    Form::header_list($header_rows, 'model_name_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Model Number
                            </label>
                            <div class="col-md-4">
                                {!!    Form::header_list($header_rows, 'model_number_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Category
                            </label>
                            <div class="col-md-4 required">
                                {!!    Form::header_list($header_rows, 'category_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Manufacturer
                            </label>
                            <div class="col-md-4 required">
                                {!!    Form::header_list($header_rows, 'manufacturer_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Company
                            </label>
                            <div class="col-md-4">
                                {!!    Form::header_list($header_rows, 'company_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Location
                            </label>
                            <div class="col-md-4">
                                {!!    Form::header_list($header_rows, 'location_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Purchase Date
                            </label>
                            <div class="col-md-4">
                                {!!    Form::header_list($header_rows, 'purchase_date_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Purchase Cost
                            </label>
                            <div class="col-md-4">
                                {!!    Form::header_list($header_rows, 'purchase_cost_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Status
                            </label>
                            <div class="col-md-4">
                                {!!    Form::header_list($header_rows, 'status_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Notes
                            </label>
                            <div class="col-md-4">
                                {!!    Form::header_list($header_rows, 'notes_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-md-3 control-label">Image Filename
                            </label>
                            <div class="col-md-4">
                                {!!    Form::header_list($header_rows, 'image_header', Input::old('header_row'), 'select2') !!}
                            </div>
                        </div>

                        @if ($custom_fields->count() > 0)
                            <div class="col-md-8 col-md-offset-2">
                                <h3>Custom Fields</h3>
                                <hr>
                            </div>
                            @foreach ($custom_fields as $custom_field)
                                <div class="form-group">
                                    <label for="url" class="col-md-3 control-label">{{ $custom_field->name }}
                                    </label>
                                    <div class="col-md-4">
                                        {!!    Form::header_list($header_rows, 'image_header', Input::old('header_row'), 'select2') !!}
                                    </div>
                                </div>
                            @endforeach
                        @endif



                        <div class="box-footer text-right">
                            <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.process') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        @if ((isset($helpText)) && (isset($helpTitle)))
            <div class="slideout-menu">
                <a href="#" class="slideout-menu-toggle pull-right">×</a>
                <h3>
                    {{ $helpTitle}}
                </h3>
                <p>{{ $helpText }} </p>
            </div>
        @endif
    </div>

@stop

