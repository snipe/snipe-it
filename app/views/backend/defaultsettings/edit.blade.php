@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($defaultsetting->id)
        @lang('admin/defaultsettings/table.update') ::
    @else
        @lang('admin/defaultsettings/table.create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.back')</a>
        <h3>
        @if ($defaultsetting->id)
            @lang('admin/defaultsettings/table.update')
        @else
            @lang('admin/defaultsettings/table.create')
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
                <label for="name" class="col-md-3 control-label">@lang('admin/defaultsettings/table.name')
                 </label>
                 </label>
                    <div class="col-md-6">
                        <label class="control-label" type="text" name="name" id="name">@lang('admin/defaultsettings/table.values.' . $defaultsetting->name)</label>
                        {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                    </div>
                 
            </div>
            <div class="form-group {{ $errors->has('value') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">@lang('admin/defaultsettings/table.value')</label>
                <div class="col-md-6">
                    {{ Form::select('value', $option_list, $defaultsetting->value, array('class'=>'select2', 'style'=>'min-width:350px')) }}
                </div>
            </div>
        <!-- Form actions -->
        <div class="form-group">
        <label class="col-md-2 control-label"></label>
            <div class="col-md-7">
                @if ($defaultsetting->id)
                <a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
                @else
                <a class="btn btn-link" href="{{ route('defaultsettings') }}">@lang('general.cancel')</a>
                @endif
                <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
            </div>
        </div>

</form>
<br><br><br><br>

</div>

    <!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
        <br /><br />
        <h6>Have Some Haiku</h6>
        <p>Serious error.<br>
        All shortcuts have disappeared.<br>
        Screen. Mind. Both are blank.</p>


    </div>

</div>

@stop
