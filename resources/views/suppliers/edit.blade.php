@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($supplier->id)
        {{ trans('admin/suppliers/table.update') }}
    @else
        {{ trans('admin/suppliers/table.create') }}
    @endif
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

  <div class="row">
    <div class="col-md-9 col-md-offset-2">

      {{ Form::open(['method' => 'POST', 'files' => true, 'class' => 'form-horizontal', 'autocomplete' => 'off' ]) }}
           <!-- CSRF Token -->
      {{ Form::token() }}

      <div class="box box-default">

          @if ($supplier->id)
            <div class="box-header with-border">
              <div class="box-heading">
                <h3 class="box-title"> {{ $supplier->name }}</h3>
              </div>
            </div><!-- /.box-header -->
          @endif


        <div class="box-body">
          <!-- Name -->
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
              {{ Form::label('name', trans('admin/suppliers/table.name'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6 required">
                      {{ Form::text('name', Input::old('name', $supplier->name), array('class' => 'form-control')) }}
                      {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
             {{ Form::label('address', trans('admin/suppliers/table.address'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('address', Input::old('address', $supplier->address), array('class' => 'form-control')) }}
                      {!! $errors->first('address', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
              {{ Form::label('address2', ' ', array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('address2', Input::old('address2', $supplier->address2), array('class' => 'form-control')) }}
                      {!! $errors->first('address2', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
              {{ Form::label('city', trans('admin/suppliers/table.city'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('city', Input::old('city', $supplier->city), array('class' => 'form-control')) }}
                      {!! $errors->first('city', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
               {{ Form::label('state', trans('admin/suppliers/table.state'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('state', Input::old('state', $supplier->state), array('class' => 'form-control')) }}
                      {!! $errors->first('state', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
              {{ Form::label('country', trans('admin/suppliers/table.country'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-5">
                      {!! Form::countries('country', Input::old('country', $supplier->country), 'select2') !!}
                      {!! $errors->first('country', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
              {{ Form::label('zip', trans('admin/suppliers/table.zip'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('zip', Input::old('zip', $supplier->zip), array('class' => 'form-control')) }}
                      {!! $errors->first('zip', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>


          <div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
              {{ Form::label('contact', trans('admin/suppliers/table.contact'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('contact', Input::old('contact', $supplier->contact), array('class' => 'form-control')) }}
                      {!! $errors->first('contact', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>


          <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
              {{ Form::label('phone', trans('admin/suppliers/table.phone'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('phone', Input::old('phone', $supplier->phone), array('class' => 'form-control')) }}
                      {!! $errors->first('phone', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
              {{ Form::label('fax', trans('admin/suppliers/table.fax'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('fax', Input::old('fax', $supplier->fax), array('class' => 'form-control')) }}
                      {!! $errors->first('fax', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
              {{ Form::label('email', trans('admin/suppliers/table.email'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('email', Input::old('email', $supplier->email), array('class' => 'form-control')) }}
                      {!! $errors->first('email', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
              {{ Form::label('url', trans('admin/suppliers/table.url'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('url', Input::old('url', $supplier->url), array('class' => 'form-control')) }}
                      {!! $errors->first('url', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>


          <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
              {{ Form::label('notes', trans('admin/suppliers/table.notes'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-6">
                      {{Form::text('notes', Input::old('notes', $supplier->notes), array('class' => 'form-control')) }}
                      {!! $errors->first('notes', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                  </div>
          </div>

          <!-- Image -->
          @if ($supplier->image)
              <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
                  <label class="col-md-3 control-label" for="image_delete">{{ trans('general.image_delete') }}</label>
                  <div class="col-md-5">
                      {{ Form::checkbox('image_delete') }}
                      <img src="{{ config('app.url') }}/uploads/suppliers/{{ $supplier->image }}" />
                  {!! $errors->first('image_delete', '<span class="alert-msg">:message</span>') !!}
                  </div>
              </div>
          @endif

          <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
              <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
              <div class="col-md-5">
                  {{ Form::file('image') }}
                  {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
              </div>
          </div>

        </div>


            </form>
            <div class="box-footer text-right">
                <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
            </div>

        </div>
    </div>
</div>

@stop
