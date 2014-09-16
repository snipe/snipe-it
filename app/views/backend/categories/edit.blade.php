@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($category->id)
        @lang('base.category_update') ::
    @else
        @lang('base.category_create') ::
    @endif
@parent
@stop

{{-- Page content --}}

@section('content')

<div class="row header">
    <div class="col-md-10">
            
        <button type="submit" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> @lang('actions.save')</button>            
        <a href="{{ URL::previous() }}" class="btn btn-default pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('actions.cancel')</a>
            
        <h3>
        @if ($category->id)
            @lang('base.category_update')
        @elseif(isset($clone_category))
            @lang('base.category_clone')
        @else
            @lang('base.category_create')
        @endif
        </h3>
            
    </div>                            
</div>


<div class="col-md-12">

                        <form class="form-horizontal" method="post" action="" autocomplete="off">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <!-- Name -->
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                             {{ Form::label_for($category, 'name', Lang::get('general.name'), array('class' => 'col-md-2 control-label')); }}

                                <div class="col-md-5">
                                    {{ Form::text_for($category, 'name',array('class' => 'form-control'),$errors  ) }}                                   
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
            
    </form>

</div>


@stop
