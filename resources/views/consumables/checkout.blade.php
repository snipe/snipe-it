@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/consumables/general.checkout') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">

    <form class="form-horizontal" id="checkout_form" method="post" action="" autocomplete="off">
      <!-- CSRF Token -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />

      <div class="box box-default">

        @if ($consumable->id)
          <div class="box-header with-border">
            <div class="box-heading">
              <h2 class="box-title">{{ $consumable->name }} </h2>
            </div>
          </div><!-- /.box-header -->
        @endif

        <div class="box-body">
          @if ($consumable->name)
          <!-- consumable name -->
          <div class="form-group">
            <label class="col-sm-3 control-label">{{ trans('admin/consumables/general.consumable_name') }}</label>
            <div class="col-md-6">
              <p class="form-control-static">{{ $consumable->name }}</p>
            </div>
          </div>
          @endif

          <!-- User -->
            @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.select_user'), 'fieldname' => 'assigned_to', 'required'=> 'true'])

            <div class="form-group {{ $errors->has('assigned_qty') ? ' has-error' : '' }}">
              <label for="assigned_qty" class="col-md-3 control-label">
                {{ trans('general.qty') }}
              </label>
              <div class="col-md-2 col-sm-5 col-xs-5">
                <input class="form-control required col-md-12" type="number" min="1" name="assigned_qty" id="assigned_qty" value="{{ old('assigned_qty') ?? 1 }}" />
              </div>
              @if ($errors->first('assigned_qty'))
                <div class="col-md-9 col-md-offset-3">
                  {!! $errors->first('assigned_qty', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                </div>
              @endif
            </div>

            @if ($consumable->requireAcceptance() || $consumable->getEula() || ($snipeSettings->webhook_endpoint!=''))
              <div class="form-group notification-callout">
                <div class="col-md-8 col-md-offset-3">
                  <div class="callout callout-info">

                    @if ($consumable->category->require_acceptance=='1')
                      <i class="far fa-envelope"></i>
                      {{ trans('admin/categories/general.required_acceptance') }}
                      <br>
                    @endif

                    @if ($consumable->getEula())
                      <i class="far fa-envelope"></i>
                      {{ trans('admin/categories/general.required_eula') }}
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
          <!-- Note -->
          <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
            <label for="note" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
            <div class="col-md-7">
              <textarea class="col-md-6 form-control" name="note">{{ old('note') }}</textarea>
              {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
        </div> <!-- .box-body -->
        <div class="box-footer">
          <a class="btn btn-link" href="{{ route('consumables.show', ['consumable'=> $consumable->id]) }}">{{ trans('button.cancel') }}</a>
          <button type="submit" id="submit_button" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkout') }}</button>
       </div>
      </div>
    </form>

  </div>
</div>
@stop
