@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-circle-left icon-white"></i> @lang('general.back')</a>
        <h3>
        Accept {{{ $item->name }}}</h3>
    </div>
</div>


<div class="col-md-9 bio">

                        <form class="form-horizontal" method="post" action="" autocomplete="off">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="logId" value="{{ $findlog->id }}" />

                                               <!-- Form actions -->
                        <div class="form-group">
                       
                            <div class="col-md-7 col-md-offset-3">
                                <a class="btn btn-link" href="{{ route('account') }}">@lang('button.cancel')</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> Accept </button>
                            </div>
                        </div>
                    </form>
                    </div>
</div>

@stop
