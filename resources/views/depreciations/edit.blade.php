@extends('layouts/default')

{{-- Page title --}}
@section('title')

@if ($item->id)
{{ trans('admin/depreciations/general.update_depreciation') }}
@else
{{ trans('admin/depreciations/general.create_depreciation') }}
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
    <div class="col-md-9">

        <form class="form-horizontal" method="post" autocomplete="off">
            {{ csrf_field() }}

            <div class="box box-default">
                <div class="box-body">
                    @include ('partials.forms.edit.name', ['translated_name' => trans('admin/depreciations/general.depreciation_name')])
                    <!-- Months -->
                    <div class="form-group {{ $errors->has('months') ? ' has-error' : '' }}">
                        <label for="months" class="col-md-3 control-label">{{ trans('admin/depreciations/general.number_of_months') }}
                        </label>
                        <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'months')) ? ' required' : '' }}">
                            <div class="col-md-2" style="padding-left:0px">
                                <input class="form-control" type="text" name="months" id="months" value="{{ Input::old('months', $item->months) }}" style="width: 80px;" />
                            </div>
                        </div>
                        {!! $errors->first('months', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
                </div>
                @include ('partials.forms.edit.submit')
            </div>
        </form>

    </div>
    <!-- side address column -->
    <div class="col-md-3">
        <h4>{{ trans('admin/depreciations/general.about_asset_depreciations') }}</h4>
        <p>{{ trans('admin/depreciations/general.about_depreciations') }} </p>
    </div>
</div>

@stop
