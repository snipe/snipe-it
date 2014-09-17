@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
        @lang('base.serviceagreementtype') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<form class="form-horizontal" method="post" action="" autocomplete="off">

<div class="row header">
    <div class="col-md-10">
            
            <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
            <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
            
        <h3>
        @if ($serviceagreementtype->id)
            @lang('base.serviceagreementtype_update')
        @else
            @lang('base.serviceagreementtype_create')
        @endif
        </h3>
            
    </div>                            
</div>

<div class="row form-wrapper">
            <!-- left column -->
            <div class="col-md-12 column">

                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                
                                <!-- Name -->
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreementtype, 'name', Lang::get('general.name'), array('class' => 'col-md-2 control-label')) }}
                                        <div class="col-md-7">
                                            {{ Form::text_for($serviceagreementtype, 'name',array('class' => 'form-control'),$errors  ) }}
                                        </div>
                                    </div>
                                <!-- Notes -->
                                    <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                                        {{ Form::label_for($serviceagreementtype, 'notes', Lang::get('general.notes'), array('class' => 'col-md-2 control-label')) }}
                                        <div class="col-md-7">
                                            {{ Form::text_for($serviceagreementtype, 'notes',array('class' => 'form-control'),$errors  ) }}
                                        </div>
                                    </div>
                                                    

            <!-- Form actions -->
                <div class="form-group">
                <label class="col-md-2 control-label"></label>
                    <div class="col-md-7">
                        <a href="{{ URL::previous() }}" class="btn btn-default"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
                        <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>
                    </div>
                </div> 

        </div>
</div>

</form>

@stop
