@extends('layouts/default')

{{-- Page title --}}
@section('title')
@if ($item->id)
{{ trans('admin/suppliers/table.update') }}
@else
{{ trans('admin/suppliers/table.create') }}
@endif
@parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}
    </a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-9 col-md-offset-2">

        <form class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="box box-default">

            @if ($item->id)
            <div class="box-header with-border">
                <div class="box-heading">
                    <h3 class="box-title"> {{ $item->name }}</h3>
                </div>
            </div><!-- /.box-header -->
            @endif


            <div class="box-body">
                <!-- Name -->
                @include ('partials.forms.edit.name', ['translated_name' => trans('admin/suppliers/table.name')])
                @include ('partials.forms.edit.address')

                <div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
                    {{ Form::label('contact', trans('admin/suppliers/table.contact'), array('class' => 'col-md-3 control-label')) }}
                    <div class="col-md-7">
                        {{Form::text('contact', Input::old('contact', $item->contact), array('class' => 'form-control')) }}
                        {!! $errors->first('contact', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                </div>

                @include ('partials.forms.edit.phone')

                <div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
                    {{ Form::label('fax', trans('admin/suppliers/table.fax'), array('class' => 'col-md-3 control-label')) }}
                    <div class="col-md-7">
                        {{Form::text('fax', Input::old('fax', $item->fax), array('class' => 'form-control')) }}
                        {!! $errors->first('fax', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                </div>

                @include ('partials.forms.edit.email')

                <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
                    {{ Form::label('url', trans('admin/suppliers/table.url'), array('class' => 'col-md-3 control-label')) }}
                    <div class="col-md-7">
                        {{Form::text('url', Input::old('url', $item->url), array('class' => 'form-control')) }}
                        {!! $errors->first('url', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                </div>

                @include ('partials.forms.edit.notes')

                <!-- Image -->
                @if ($item->image)
                <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
                    <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
                    <div class="col-md-5">
                        {{ Form::checkbox('image_delete') }}
                        <img src="{{ config('app.url') }}/uploads/suppliers/{{ $item->image }}" />
                        {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
                    </div>
                </div>
                @endif

                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
                    <div class="col-md-5">
                        {{ Form::file('image') }}
                        {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
                    </div>
                </div>

            </div>
        </form>
        @include ('partials.forms.edit.submit')
    </div>
</div>

@stop
