@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/licenses/general.checkout') }}
@parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
        <!-- left column -->
    <div class="col-md-7">
        <form class="form-horizontal" method="post" action="" autocomplete="off">
            {{csrf_field()}}

            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title"> {{ $license->name }} ({{ trans('admin/licenses/message.seats_available', ['seat_count' => $license->availCount()->count()]) }})</h2>
                </div>
                <div class="box-body">


                    <!-- Asset name -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('admin/hardware/form.name') }}</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $license->name }}</p>
                        </div>
                    </div>
                    <!-- Category -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('general.category') }}</label>
                        <div class="col-md-9">
                            <p class="form-control-static">{{ $license->category->name }}</p>
                        </div>
                    </div>

                    <!-- Serial -->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{ trans('admin/licenses/form.license_key') }}</label>
                        <div class="col-md-9">
                            <p class="form-control-static" style="word-wrap: break-word;">
                                @can('viewKeys', $license)
                                    {{ $license->serial }}
                                @else
                                    ------------
                                @endcan
                            </p>
                        </div>
                    </div>

                    @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true'])

                    @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'fieldname' => 'assigned_to'])

                    @include ('partials.forms.edit.asset-select', ['translated_name' => trans('admin/licenses/form.asset'), 'fieldname' => 'asset_id', 'style' => 'display:none;'])


                    <!-- Note -->
                    <div class="form-group {{ $errors->has('notes') ? 'error' : '' }}">
                        <label for="note" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                        <div class="col-md-8">
                            <textarea class="col-md-6 form-control" id="notes" name="notes" style="width: 100%">{{ old('note') }}</textarea>
                            {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>
                </div>


                @if ($license->requireAcceptance() || $license->getEula() || ($snipeSettings->webhook_endpoint!=''))
                    <div class="form-group notification-callout">
                        <div class="col-md-8 col-md-offset-3">
                            <div class="callout callout-info">

                                @if ($license->requireAcceptance())
                                    <i class="far fa-envelope"></i>
                                    {{ trans('admin/categories/general.required_acceptance') }}
                                    <br>
                                @endif

                                @if ($license->getEula())
                                    <i class="far fa-envelope"></i>
                                    {{ trans('admin/categories/general.required_eula') }}
                                    <br>
                                @endif

                                @if (($license->category) && ($license->category->checkin_email))
                                    <i class="far fa-envelope"></i>
                                    {{ trans('admin/categories/general.checkin_email_notification') }}
                                    <br>
                                @endif

                                @if ($snipeSettings->webhook_endpoint!='')
                                    <i class="fab fa-slack"></i>
                                    {{ trans('general.webhook_msg_note') }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <x-redirect_submit_options
                        index_route="licenses.index"
                        :button_label="trans('general.checkout')"
                        :options="[
                                'index' => trans('admin/hardware/form.redirect_to_all', ['type' => trans('general.licenses')]),
                                'item' => trans('admin/hardware/form.redirect_to_type', ['type' => trans('general.license')]),
                                'target' => trans('admin/hardware/form.redirect_to_checked_out_to'),
                               ]"
                />
            </div> <!-- /.box-->
        </form>
    </div> <!-- /.col-md-7-->
</div>

@stop
