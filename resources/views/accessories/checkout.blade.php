@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/accessories/general.checkout') }}
@parent
@stop
@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-9">
    <form class="form-horizontal" id="checkout_form" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <div class="box box-default">
      @if ($accessory->id)
        <div class="box-header with-border">
          <h2 class="box-title">{{ $accessory->name }}</h2>
        </div><!-- /.box-header -->
      @endif

       <div class="box-body">
         @if ($accessory->name)
          <!-- accessory name -->
          <div class="form-group">
            <label class="col-sm-3 control-label">{{ trans('admin/accessories/general.accessory_name') }}</label>
            <div class="col-md-6">
              <p class="form-control-static">{{ $accessory->name }}</p>
            </div>
          </div>
          @endif

          @if ($accessory->category)
          <!-- accessory name -->
          <div class="form-group">
            <label class="col-sm-3 control-label">{{ trans('admin/accessories/general.accessory_category') }}</label>
            <div class="col-md-6">
              <p class="form-control-static">{{ $accessory->category->name }}</p>
            </div>
          </div>
          @endif

          <!-- User -->

          @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.select_user'), 'fieldname' => 'assigned_to'])

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

             @if ($accessory->requireAcceptance() || $accessory->getEula() || ($snipeSettings->webhook_endpoint!=''))
                 <div class="form-group notification-callout">
                     <div class="col-md-8 col-md-offset-3">
                         <div class="callout callout-info">

                             @if ($accessory->requireAcceptance())
                                 <i class="far fa-envelope"></i>
                                 {{ trans('admin/categories/general.required_acceptance') }}
                                 <br>
                             @endif

                             @if ($accessory->getEula())
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
              <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note', $accessory->note) }}</textarea>
              {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
       </div>
       <div class="box-footer">
          <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
          <button type="submit" id="submit_button" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkout') }}</button>
       </div>
    </div> <!-- .box.box-default -->
  </form>
  </div> <!-- .col-md-9-->
</div> <!-- .row -->


@stop
