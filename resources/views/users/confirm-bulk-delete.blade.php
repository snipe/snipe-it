@extends('layouts/default')
{{-- Page title --}}
@section('title')
{!! trans('general.bulk_checkin_delete') !!}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="box box-default">
      <form class="form-horizontal" role="form" method="post" action="{{ route('users/bulksave') }}">
        <div class="box-body">
          <!-- CSRF Token -->
          {{csrf_field()}}
          <div class="col-md-12">
            <div class="callout callout-danger">
              <i class="fas fa-exclamation-triangle"></i>
              <strong>{{ trans('admin/users/general.warning_deletion') }} </strong>
              {{ trans('admin/users/general.warning_deletion_information', array('count' => count($users))) }}
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
                    <th class="col-md-6">{{ trans('general.name') }}</th>
                    <th class="col-md-5">{{ trans('general.groups') }}</th>
                    <th class="col-md-5">{{ trans('general.assets') }}</th>
                    <th class="col-md-5">{{ trans('general.accessories') }}</th>
                    <th class="col-md-5">{{ trans('general.licenses') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $user)
                  <tr {!! ($user->isSuperUser() ? ' class="danger"':'') !!}>
                    <td>
                      @if (Auth::id()!=$user->id)
                      <input type="checkbox" name="ids[]" value="{{ $user->id }}" checked="checked">
                      @else
                      <input type="checkbox" name="ids[]" value="{{ $user->id }}" disabled>
                      @endif
                    </td>

                    <td>
                      <span {{ (Auth::user()->id==$user->id ? ' style="text-decoration: line-through"' : '') }}>
                        {{ $user->present()->fullName() }} ({{ $user->username }})
                      </span>
                      {{ (Auth::id()==$user->id ? ' (cannot delete yourself)' : '') }}
                    </td>
                    <td>
                      @foreach ($user->groups as $group)
                      <a href=" {{ route('groups.update', $group->id) }}" class="label  label-default">
                        {{ $group->name  }}
                      </a>&nbsp;
                      @endforeach
                    </td>
                    <td>
                      {{ number_format($user->assets()->count())  }}
                    </td>
                    <td>
                      {{ number_format($user->accessories()->count())  }}
                    </td>
                    <td>
                      {{ number_format($user->licenses()->count())  }}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="6" class="warning">
                      {{ Form::select('status_id', $statuslabel_list , Request::old('status_id'), array('class'=>'select2', 'style'=>'width:250px')) }}
                      <label>{{ trans('admin/users/general.update_user_assets_status') }}</label></label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="6" class="warning">
                      <label><input type="checkbox" name="ids['.e($user->id).']" checked>{{ trans('admin/users/general.checkin_user_properties') }}</label>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div> <!--/table-responsive-->
          </div><!--/col-md-12-->
        </div> <!--/box-body-->
        <div class="box-footer text-right">
          <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
          <button type="submit" class="btn btn-success"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('button.submit') }}</button>
        </div><!-- /.box-footer -->
      </form>
    </div>
  </div>
</div>

@stop
