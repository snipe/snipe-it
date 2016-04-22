@extends('layouts/default')

{{-- Page title --}}
@section('title')
Bulk Edit/Delete
@parent
@stop

{{-- Page content --}}
@section('content')


    <div class="row">
      <div class="col-md-12">
            <div class="box box-default">
                 <div class="box-body">

                <form class="form-horizontal" role="form" method="post" action="{{ route('users/bulksave') }}">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />


            <div class="col-md-12">
                <div class="callout callout-danger">
                    <i class="fa fa-exclamation-circle"></i>
                    <strong>WARNING: </strong>
                    You are about to delete the {{ count($users) }} user(s) listed below. Admin names are highlighted in red.
                </div>
            </div>

            @if (config('app.lock_passwords'))
                <div class="col-md-12">
                <div class="callout callout-warning">
                    <p>{{ trans('feature_disabled') }}</p>
                </div>
                </div>
            @endif


                  <div class="col-md-12">
                  <div class="table-responsive">
                      <table class="display table table-hover">
                          <thead>
                              <tr>
                                  <th class="col-md-1"></th>
                                  <th class="col-md-6">Name</th>
                                  <th class="col-md-5">Groups</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <td colspan="3" class="warning">
                                      {{ Form::select('status_id', $statuslabel_list , Input::old('status_id'), array('class'=>'select2', 'style'=>'width:250px')) }}
                                      <label>Update all assets for these users to this status</label>


                              </td>
                              </tr>
                          </tfoot>
                          <tbody>
                              @foreach ($users as $user)
                                  <tr>
                                      <td>
                                          @if (Auth::user()->id!=$user->id)
                                              <input type="checkbox" name="edit_user[]" value="{{ $user->id }}" checked="checked">
                                          @else
                                              <input type="checkbox" name="edit_user[]" value="{{ $user->id }}" disabled>
                                          @endif
                                      </td>
                                      <td>
                                          <span{{ (Auth::user()->id==$user->id ? ' style="text-decoration: line-through"' : '') }}>{{ $user->fullName() }} ({{ $user->username }})</span>

                                          {{ (Auth::user()->id==$user->id ? ' (cannot delete yourself)' : '') }}

                                      </td>
                                      <td>

                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
                  </div>
              </div>
              <div class="box-footer text-right">
                <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('button.submit') }}</button>
              </div><!-- /.box-footer -->
            </div>



    </div>


</form>

@stop
