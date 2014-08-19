@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')

    @if ($family->id)
        @lang('admin/families/table.update') ::
    @else
        @lang('admin/families/table.create') ::
    @endif

@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="icon-circle-arrow-left icon-white"></i>  @lang('general.back')</a>
        <h3>
        @lang('general.family')
        </h3>
    </div>
</div>

<div class="row form-wrapper">

<form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <!-- Common-Short Name -->
            <div class="form-group {{ $errors->has('common_name') ? ' has-error' : '' }}">
                <label for="common_name" class="col-md-2 control-label">@lang('admin/families/table.common_name')
                 <i class='icon-asterisk'></i></label>
                 </label>
                    <div class="col-md-12">
                        <div class="col-xs-8">
                        <input size="40" maxlength="128" class="form-control" type="text" name="common_name" id="common_name" value="{{{ Input::old('common_name', $family->common_name) }}}" />
                    </div>
                    {{ $errors->first('common_name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Name -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-2 control-label">@lang('admin/families/table.name')
                 <i class='icon-asterisk'></i></label></label>
                    <div class="col-md-12">
                        <div class="col-xs-8">
                        <input size="40" maxlength="128" class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', $family->name) }}}" />
                    </div>
                    {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                <label for="notes" class="col-md-2 control-label">@lang('admin/families/table.notes')</label>
                    <div class="col-md-12">
                        <div class="col-xs-8">
                            <input class="form-control" type="text" name="notes" id="notes" value="{{{ Input::old('notes', $family->notes) }}}" />
                    </div>
                    {{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
            </div>

            <!-- Form actions -->
            <div class="form-group">
            <label class="col-md-2 control-label"></label>
                <div class="col-md-7">
                    <a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
                    <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
                </div>
            </div>

</form>


@stop
