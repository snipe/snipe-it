@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/consumables/general.replenish') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">

    <form class="form-horizontal" method="post" action="" autocomplete="off" enctype="multipart/form-data">
      <!-- CSRF Token -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />

      <div class="box box-default">

        @if ($consumable->id)
          <div class="box-header with-border">
            <div class="box-heading">
              <h2 class="box-title">{{ $consumable->name }}   ({{ $consumable->numRemaining()  }} out of {{ $consumable->qty}}  {{ trans('admin/consumables/general.remaining') }}) </h2>
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

          <!-- number of consumables -->         
            <div class="form-group {{ $errors->has('total') ? ' has-error' : '' }}">
              <label for="total" class="col-md-3 control-label">{{ trans('admin/consumables/general.total') }}
                <i class='icon-asterisk'></i></label>
              <div class="col-md-5" >
                    <input class="form-control" type="text" name="totalnum" id="totalnum" style="width: 70px; float:left;" value="{{ old('totalnum') ?? 1 }}" > &nbsp;&nbsp;                    
                    <div style="float:right;" class="col-ld-1">
                    {!! $errors->first('totalnum', '<span class="alert-msg" aria-hidden="true" width=100% position=absolute><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}    
                    </div>
                    </input>               
                             
              </div>
            </div>
          

            @if ($consumable->requireAcceptance() || $consumable->getEula() || ($snipeSettings->slack_endpoint!=''))
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

                    @if ($snipeSettings->slack_endpoint!='')
                        <i class="fab fa-slack"></i>
                        A slack message will be sent
                    @endif
                  </div>
                </div>
              </div>
            @endif

<!--             
            @can('update', \App\Models\Asset::class)
                        <li class="pull-right">
                            <a href="#" data-toggle="modal" data-target="#uploadFileModal">
                                <i class="fas fa-paperclip" aria-hidden="true"></i>
                                {{ trans('button.upload') }}
                            </a>
                        </li>
                    @endcan -->
          <!-- order number -->        
           
          <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
              <label for="order_number" class="col-md-3 control-label">{{ trans('general.order_number') }}
                <i class='icon-asterisk'></i></label>
              <div class="col-md-5" >
                    <input class="form-control" type="text" name="order_number" id="order_number" style="width: 250px; float:left;" value="{{ old('order_number') ?? null }}" > &nbsp;&nbsp;                    
                    <div style="float:right;" class="col-ld-1">
                    {!! $errors->first('order_number', '<span class="alert-msg" aria-hidden="true" width=100% position=absolute><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}    
                    </div>
                    </input>               
                             
              </div>
            </div>  
          <!-- document archive -->         
          <div class="form-group {{ $errors->has('order_number') ? ' has-error' : '' }}">
              <label for="document_archive" class="col-md-3 control-label">{{ trans('general.document_archive') }}
                <i class='icon-asterisk'></i></label>
              <div class="col-md-5" >
              Select file : <input type='file' name='file' id='file' class='form-control' ><br>
              <input type="submit" value="Upload" class="btn btn-primary">
               <!-- <input type='button' class='btn btn-info' value='Upload' id='btn_upload'> -->
                    <div style="float:right;" class="col-ld-1">
                    {!! $errors->first('order_number', '<span class="alert-msg" aria-hidden="true" width=100% position=absolute><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}    
                    </div>
                    <!-- </input>                -->
                             
              </div>
            </div>    
          <!-- Note -->
          <div class="form-group {{ $errors->has('replenishnote') ? 'error' : '' }}">
            <label for="note" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
            <div class="col-md-7">
              <textarea class="col-md-6 form-control" id="replenishnote" name="replenishnote">{{ old('note', $consumable->checkoutnote) }}</textarea>	      
              {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>
        </div> <!-- .box-body -->
        
        <div class="box-footer">
          <a class="btn btn-link" href="{{ route('consumables.index') }}">{{ trans('button.cancel') }}</a>
          <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.update') }}</button>
       </div>
      </div>
    </form>

  </div>
</div>
@stop
