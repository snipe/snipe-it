@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
    @if ($supplier->id)
        @lang('admin/suppliers/table.update') ::
    @else
        @lang('admin/suppliers/table.create') ::
    @endif
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-9">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="icon-circle-arrow-left icon-white"></i>  @lang('general.back')</a>
        <h3>
        @if ($supplier->id)
            @lang('admin/suppliers/table.update')
        @else
            @lang('admin/suppliers/table.create')
        @endif
    </h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9">

            <form class="form-horizontal" method="post" action="" autocomplete="off">
                <!-- CSRF Token -->
                {{ Form::token() }}

                        <!-- Name -->
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            {{ HTML::decode(Form::label('name', Lang::get('admin/suppliers/table.name').' <i class="icon-asterisk"></i>', array('class' => 'col-md-3 control-label'))) }}
                                <div class="col-md-6">
                                    {{Form::text('name', Input::old('name', $supplier->name), array('class' => 'form-control')) }}
                                    {{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                           {{ Form::label('address', Lang::get('admin/suppliers/table.address'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('address', Input::old('address', $supplier->address), array('class' => 'form-control')) }}
                                    {{ $errors->first('address', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                        <div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
                            {{ Form::label('address2', ' ', array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('address2', Input::old('address2', $supplier->address2), array('class' => 'form-control')) }}
                                    {{ $errors->first('address2', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                        <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                            {{ Form::label('city', Lang::get('admin/suppliers/table.city'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('city', Input::old('city', $supplier->city), array('class' => 'form-control')) }}
                                    {{ $errors->first('city', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                        <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                             {{ Form::label('state', Lang::get('admin/suppliers/table.state'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('state', Input::old('state', $supplier->state), array('class' => 'form-control')) }}
                                    {{ $errors->first('state', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                        <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                            {{ Form::label('country', Lang::get('admin/suppliers/table.country'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-5">
                                    {{ Form::countries('country', Input::old('country', $supplier->country), 'select2') }}
                                    {{ $errors->first('country', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                        <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
                            {{ Form::label('zip', Lang::get('admin/suppliers/table.zip'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('zip', Input::old('zip', $supplier->zip), array('class' => 'form-control')) }}
                                    {{ $errors->first('zip', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>


                        <div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
                            {{ Form::label('contact', Lang::get('admin/suppliers/table.contact'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('contact', Input::old('contact', $supplier->contact), array('class' => 'form-control')) }}
                                    {{ $errors->first('contact', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>


                        <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            {{ Form::label('phone', Lang::get('admin/suppliers/table.phone'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('phone', Input::old('phone', $supplier->phone), array('class' => 'form-control')) }}
                                    {{ $errors->first('phone', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                        <div class="form-group {{ $errors->has('fax') ? ' has-error' : '' }}">
                            {{ Form::label('fax', Lang::get('admin/suppliers/table.fax'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('fax', Input::old('fax', $supplier->fax), array('class' => 'form-control')) }}
                                    {{ $errors->first('fax', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            {{ Form::label('email', Lang::get('admin/suppliers/table.email'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('email', Input::old('email', $supplier->email), array('class' => 'form-control')) }}
                                    {{ $errors->first('email', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                        <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
                            {{ Form::label('url', Lang::get('admin/suppliers/table.url'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('url', Input::old('url', $supplier->url), array('class' => 'form-control')) }}
                                    {{ $errors->first('url', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>


                        <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                            {{ Form::label('notes', Lang::get('admin/suppliers/table.notes'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-6">
                                    {{Form::text('notes', Input::old('notes', $supplier->notes), array('class' => 'form-control')) }}
                                    {{ $errors->first('notes', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
                                </div>
                        </div>

                    <!-- Form actions -->
                    <div class="form-group">
                    {{ Form::label('', ' ', array('class' => 'col-md-3 control-label')) }}
                        <div class="col-md-7">
                            @if ($supplier->id)
                            <a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
                            @else
                            <a class="btn btn-link" href="{{ route('suppliers') }}">@lang('general.cancel')</a>
                            @endif
                            <button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
                        </div>
                    </div>

            </form>

        </div>
    </div>
</div>

@stop
