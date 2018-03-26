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
    <form class="form-horizontal" method="post" action="" autocomplete="off">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <div class="box box-default">
      @if ($accessory->id)
        <div class="box-header with-border">
          <h3 class="box-title">{{ $accessory->name }}</h3>
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


             @if ($accessory->requireAcceptance() || $accessory->getEula() || ($snipeSettings->slack_endpoint!=''))
                 <div class="form-group notification-callout">
                     <div class="col-md-8 col-md-offset-3">
                         <div class="callout callout-info">

                             @if ($accessory->requireAcceptance())
                                 <i class="fa fa-envelope"></i>
                                 {{ trans('admin/categories/general.required_acceptance') }}
                                 <br>
                             @endif

                             @if ($accessory->getEula())
                                 <i class="fa fa-envelope"></i>
                                 {{ trans('admin/categories/general.required_eula') }}
                                 <br>
                             @endif

                             @if ($snipeSettings->slack_endpoint!='')
                                 <i class="fa fa-slack"></i>
                                 A slack message will be sent
                             @endif
                         </div>
                     </div>
                 </div>
             @endif
       </div>
       <div class="box-footer">
          <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkout') }}</button>
       </div>
    </div> <!-- .box.box-default -->
  </form>
  </div> <!-- .col-md-9-->
</div> <!-- .row -->


@stop
