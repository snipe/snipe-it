@extends('layouts/default')

{{-- Page title --}}
@section('title')
  Remplacer des Biens
  @parent
@stop

{{-- Page content --}}
@section('content')
  <style>

    .input-group {
      padding-left: 0px !important;
    }
  </style>


  <div class="row">
    <form class="form-horizontal" method="post"
            action="{{ route('hardware.bulkreplace.store') }}" autocomplete="off">
                  {{csrf_field()}}
    <!-- left column -->
    <div class="col-md-12">

      <!-- show asset to be checkedin -->
      <div class="box box-default">
        <div class="box-header with-border">
          A remplacer
        </div>

        <div class="box-body">
          <table class="table table-striped table-condensed">
            <thead>
              <tr>
                <td style="width: 1%">{{ trans('admin/hardware/table.id') }}</td>
                <td style="width: 19%">{{ trans('admin/hardware/table.asset_tag') }}</td>
                <td style="width: 10%">{{ trans('admin/hardware/table.assigned_to') }}</td>
                <td style="width: 20%">{{ trans('admin/hardware/form.status') }}</td>
                <td style="width: 15%">{{ trans('admin/hardware/form.notes') }}</td>
                <td style="width: 35%">remplacer par </td>
              </tr>
            </thead>
            <tbody>
              @foreach ($assets as $asset_local)
              <!-- List of all assets id to be checkedin -->
              <input type="hidden" name="assets_id[]" value="{{$asset_local->id}}">
              <tr>
                <td>{{ $asset_local->id }}</td>
                <td>{{ $asset_local->present()->name() }}</td>
                <td>
                  @if ($asset_local->assigned_to != null)
                  {{ $asset_local->assigned->name}}
                  @endif
                </td>
                <td>
                  <div class="required">
                    {{ Form::select('status_id[]', $statusLabel_list, '', array('class'=>'select2', 'style'=>'width:100%','id' =>'modal-statuslabel_types_'.$asset_local->id.'', 'aria-label'=>'status_id')) }}
                    {!! $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                  </div>
                </td>
                <td width="200px">
                  <div class="">
                    <textarea class="col-md-6 form-control" id="note" name="note[]">{{ old('note', $asset_local->note) }}</textarea>
                    {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                    </div>
                </td>
                <td>
                  @include ('partials.forms.edit.asset-select-replace', [
                    'translated_name' => trans('general.assets'),
                    'fieldname' => 'selected_assets[]',
                    'multiple' => false,
                    'asset_status_type' => 'RTD',
                    'select_id' => 'assigned_assets_select'.$asset_local->id.'',
                  ])
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- /.box-body -->

      </div><!-- /.box -->



      <div class="box box-default">
        <div class="box-header with-border">
        </div><!-- /.box-header -->

        <div class="box-body">
          <div class="col-md-12">
            
                  @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id', 'help_text' => ($asset_local->defaultLoc) ? 'You can choose to check this asset in to a location other than the default location of '.$asset_local->defaultLoc->name.' if one is set.' : null])

                  <!-- Checkout/Checkin Date -->
                    <div class="form-group{{ $errors->has('checkin_at') ? ' has-error' : '' }}">
                      {{ Form::label('checkin_at', trans('admin/hardware/form.checkin_date'), array('class' => 'col-md-3 control-label')) }}
                      <div class="col-md-8">
                        <div class="input-group col-md-5 required">
                          <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                            <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="checkin_at" id="checkin_at" value="{{ old('checkin_at', date('Y-m-d')) }}">
                            <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                          </div>
                          {!! $errors->first('checkin_at', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                        </div>
                      </div>
                    </div>

                    <h4>Responsable Initial</h4>
                        <!-- checkout responsable name -->
                        <div class="form-group {{ $errors->has('responsable') ? 'error' : '' }}">
                            {{ Form::label('responsable', trans('admin/hardware/form.responsable'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="responsable" id="responsable" value="{{ old('responsable') }}" tabindex="1" data-validation="" >
                                {!! $errors->first('responsable', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- checkout responsable matricule -->
                        <div class="form-group {{ $errors->has('responsable_matricule') ? 'error' : '' }}">
                            {{ Form::label('responsable_matricule', trans('admin/hardware/form.responsable_matricule'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="responsable_matricule" id="responsable_matricule" value="{{ old('responsable_matricule') }}" tabindex="1" data-validation="" >
                                {!! $errors->first('responsable_matricule', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>
                    <div class="box-footer">
                      <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
                      <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkin') }}</button>
                    </div>
                  
          </div> <!--/.col-md-12-->
        </div> <!--/.box-body-->

      </div> <!--/.box.box-default-->
    </form> <!--/form-->
    </div><!--/left column-->
  </div>

@stop