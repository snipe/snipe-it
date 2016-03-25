@extends('layouts/default')

{{-- Page title --}}
@section('title')
Bulk Edit/Delete 
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
    <h3>
        Bulk Process Users

        <div class="pull-right">
            <a href="{{ route('users') }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-circle-left icon-white"></i>  {{ trans('general.back') }}</a>

        </div>
    </h3>
</div>


<form class="form-horizontal" role="form" method="post" action="{{ route('users/bulksave') }}">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <!-- Tabs Content -->
    <div class="col-md-12 col-sm-12">
        <!-- General tab -->

            <div class="col-md-12">
                <div class="alert alert-danger">
                    <i class="fa fa-exclamation-circle"></i>
                    <strong>WARNING: </strong>
                    You are about to delete the {{ count($users) }} user(s) listed below. Admin names are highlighted in red.
                </div>
            </div>

            @if (config('app.lock_passwords'))
                <p>Note: This feature is disabled on the demo.</p>
            @endif

            <div class="table-responsive">
                <table class="display table table-hover">
                    <thead>
                        <tr>
                            <th class="col-md-1"></th>
                            <th class="col-md-4">Name</th>
                            <th class="col-md-7">Groups</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="2">
                                Update all assets for these users to this status:
                            </td>
                            <td>
                                {{ Form::select('status_id', $statuslabel_list , Input::old('status_id'), array('class'=>'select2', 'style'=>'width:350px')) }}
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
                                    <span{{ (Auth::user()->id==$user->id ? ' style="text-decoration: line-through"' : '') }}>{{ $user->fullName() }}</span>

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

    <!-- Form Actions -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
            <a class="btn btn-link" href="{{ route('users') }}">{{ trans('button.cancel') }}</a>
            <button type="submit" class="btn btn-default">{{ trans('button.submit') }}</button>
        </div>
    </div>

</form>

@stop
