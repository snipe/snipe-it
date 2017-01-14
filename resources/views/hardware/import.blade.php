@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.import') }}
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="app">
@if (session()->has('import_errors'))
<div class="box">
  <div class="box-body">
    <div class="alert alert-warning">
      <strong>Warning</strong> {{trans('admin/hardware/message.import.errorDetail')}}
    </div>

    <div class="errors-table">
      <table class="table table-striped table-bordered" id="errors-table">
        <thead>
          <th>Asset</th>
          <th>Errors</th>
        </thead>
        <tbody>
          @foreach (session('import_errors') as $asset => $itemErrors)
          <tr>
            <td> {{ $asset }}</td>
            <td>
              @foreach ($itemErrors as $field => $values )
                <b>{{ $field }}:</b>
                @foreach( $values as $errorString)
                <span>{{$errorString[0]}} </span>
                @endforeach
              <br />
              @endforeach
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endif

{{-- Modal import dialog --}}
<div class="modal fade" id="importModal">
  <form id="import-modal-form" class="form-horizontal" method="post" action="{{ route('assets/import/process-file') }}" autocomplete="off" role="form">
    {{ csrf_field()}}
    <input type="hidden" id="modal-filename" name="filename" value="">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Import File:</h4>
        </div>
        <div class="modal-body">

          <div class="dynamic-form-row">
            <div class="col-md-4 col-xs-12">
              <label for="import-type">Import Type:</label>
            </div>
            <div class="col-md-8 col-xs-12">
              {{ Form::select('import-type', array('asset' => 'Assets', 'accessory' => "Accessories", 'consumable' => "Consumables", 'component' => "Components") , 'asset', array('class'=>'select2 parent', 'style'=>'width:100%','id' =>'import-type')) }}
            </div>
          </div>
          <div class="dynamic-form-row">
            <div class="col-md-4 col-xs-12">
              <label for="import-update">Update Existing Values?:</label>
            </div>
            <div class="col-md-8 col-xs-12">
              {{ Form::checkbox('import-update') }}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
          <!-- <button type="button" class="btn btn-primary" id="modal-save">{{ trans('general.save') }}</button> -->
          {{Form::submit(trans('general.save'), ['class' => 'btn btn-primary'])}}
        </div>
      </div>
    </div>
  </form>
</div>


<importer>
</div>
@stop
